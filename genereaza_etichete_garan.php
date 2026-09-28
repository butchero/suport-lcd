<?php
	if(php_sapi_name()!=="cli")
	{
		header("HTTP/1.0 404 Not Found");
		exit;
	}

	require_once(__DIR__."/clase/garanLabel.php");
	require_once(__DIR__."/functii/f_garan.php");

	if(!function_exists("formateazaAniGaran"))
	{
		function formateazaAniGaran($luni)
		{
			$luni=(int)$luni;

			if($luni%12==0)
				return (string)(int)($luni/12);

			if($luni%6==0)
				return (int)floor($luni/12).",5";

			return "";
		}
	}

	$produse=produseGaran();

	$latime=1122;
	$inaltime=1181;
	$dpi=300;
	$radacina=__DIR__."/private/etichete-garan";
	$svgDir=$radacina."/svg";
	$pngDir=$radacina."/png";
	$chrome=chromeExecutabil();

	if($chrome==="")
	{
		fwrite(STDERR, "Nu am gasit Chrome pentru PNG.\n");
		exit(1);
	}

	pregatescDirector($svgDir);
	pregatescDirector($pngDir);

	$eticheta=new garanLabel();
	$index=array();
	$profil=$radacina."/chrome-profile";
	if(is_dir($profil))
		stergeDirector($profil);

	foreach($produse as $produs)
	{
		$svg=$eticheta->generatePrintSvg(array("warranty_months"=>60,
											   "brand"=>$produs["brand"],
											   "model"=>$produs["model"]));
		if($svg===false || strpos($svg, ">5<")===false || strpos($svg, "{{MODEL}}")!==false || strpos($svg, "{{BRAND}}")!==false)
		{
			fwrite(STDERR, "Eticheta SVG a esuat pentru ".$produs["denumire"]."\n");
			exit(1);
		}

		$nume=numeEticheta($produs["denumire"], $produs["ean"]);
		file_put_contents($svgDir."/".$nume.".svg", $svg);

		$html=$radacina."/previzualizare.html";
		file_put_contents($html, htmlPentruPng($svg, $latime, $inaltime));
		$png=$pngDir."/".$nume.".png";
		if(is_file($png))
			unlink($png);

		$comanda="\"".$chrome."\" --headless=new --disable-gpu --hide-scrollbars --no-first-run --disable-extensions --force-device-scale-factor=1 --window-size=".$latime.",".$inaltime." --default-background-color=FFFFFFFF --user-data-dir=\"".str_replace("\\", "/", $profil)."\" --screenshot=\"".str_replace("\\", "/", $png)."\" \"".caleFisier($html)."\"";
		exec($comanda." > NUL 2>&1", $iesire, $cod);
		if($cod!==0 || !is_file($png))
		{
			fwrite(STDERR, "PNG a esuat pentru ".$produs["denumire"]."\n");
			exit(1);
		}

		fixeazaPng($png, $latime, $inaltime, $dpi);
		$info=getimagesize($png);
		if($info[0]!=$latime || $info[1]!=$inaltime)
		{
			fwrite(STDERR, "PNG ".$nume." are ".$info[0]."x".$info[1].", asteptat ".$latime."x".$inaltime."\n");
			exit(1);
		}

		$index[]=array($nume, $produs["denumire"], $produs["brand"], $produs["model"], $produs["ean"]);
		echo $nume.PHP_EOL;
	}

	if(is_file($radacina."/previzualizare.html"))
		unlink($radacina."/previzualizare.html");
	if(is_dir($profil))
		stergeDirector($profil);

	$csv=$radacina."/index.csv";
	$fp=fopen($csv, "wb");
	fwrite($fp, "\xEF\xBB\xBF");
	fputcsv($fp, array("fisier", "denumire_raft", "brand", "model_eticheta", "ean"), ",", "\"", "\\");
	foreach($index as $rand)
		fputcsv($fp, $rand, ",", "\"", "\\");
	fclose($fp);

	$zipCale=$radacina."/etichete-garan.zip";
	if(is_file($zipCale))
		unlink($zipCale);

	$zip=new ZipArchive();
	if($zip->open($zipCale, ZipArchive::CREATE)!==true)
	{
		fwrite(STDERR, "Nu am putut crea arhiva.\n");
		exit(1);
	}

	$zip->addFile($csv, "index.csv");
	foreach($index as $rand)
	{
		$zip->addFile($svgDir."/".$rand[0].".svg", "svg/".$rand[0].".svg");
		$zip->addFile($pngDir."/".$rand[0].".png", "png/".$rand[0].".png");
	}
	$zip->close();

	echo count($index)." etichete in ".$zipCale.PHP_EOL;
	exit(0);

	function numeEticheta($denumire, $ean)
	{
		$nume=strtoupper($denumire);
		$nume=str_replace(array("/", "\\"), " ", $nume);
		$nume=preg_replace("/[^A-Z0-9]+/", "-", $nume);
		$nume=trim($nume, "-");
		return $nume."_".$ean;
	}

	function htmlPentruPng($svg, $latime, $inaltime)
	{
		$svg=preg_replace("/<svg width=\"95mm\" height=\"100mm\" /", "<svg width=\"".$latime."\" height=\"".$inaltime."\" ", $svg, 1);
		return "<!DOCTYPE html><html><head><meta charset=\"utf-8\"><style>html,body{margin:0;padding:0;overflow:hidden;background:#fff}svg{display:block;width:".$latime."px;height:".$inaltime."px}</style></head><body>".$svg."</body></html>";
	}

	function fixeazaPng($cale, $latime, $inaltime, $dpi)
	{
		$imagine=imagecreatefrompng($cale);
		$w=imagesx($imagine);
		$h=imagesy($imagine);
		if($w!=$latime || $h!=$inaltime)
		{
			$decupat=imagecreatetruecolor($latime, $inaltime);
			$alb=imagecolorallocate($decupat, 255, 255, 255);
			imagefilledrectangle($decupat, 0, 0, $latime, $inaltime, $alb);
			imagecopy($decupat, $imagine, 0, 0, 0, 0, min($w, $latime), min($h, $inaltime));
			imagepng($decupat, $cale);
		}
		seteazaDpi($cale, $dpi);
	}

	function seteazaDpi($cale, $dpi)
	{
		$ppm=(int)round($dpi/0.0254);
		$data=file_get_contents($cale);
		$poz=strpos($data, "pHYs");
		if($poz!==false)
		{
			$start=$poz-4;
			$lungime=unpack("N", substr($data, $start, 4));
			$data=substr($data, 0, $start).substr($data, $start+8+$lungime[1]+4);
		}

		$continut="pHYs".pack("N", $ppm).pack("N", $ppm)."\x01";
		$chunk=pack("N", 9).$continut.pack("N", crc32($continut));
		$idat=strpos($data, "IDAT");
		if($idat===false)
			return;

		$data=substr($data, 0, $idat-4).$chunk.substr($data, $idat-4);
		file_put_contents($cale, $data);
	}

	function chromeExecutabil()
	{
		$cai=array("C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe",
				   "C:\\Program Files (x86)\\Microsoft\\Edge\\Application\\msedge.exe");
		foreach($cai as $cale)
		{
			if(is_file($cale))
				return $cale;
		}
		return "";
	}

	function caleFisier($cale)
	{
		return "file:///".str_replace("\\", "/", $cale);
	}

	function pregatescDirector($cale)
	{
		if(!is_dir($cale))
			mkdir($cale, 0777, true);

		foreach(glob($cale."/*") as $fisier)
		{
			if(is_file($fisier))
				unlink($fisier);
		}
	}

	function stergeDirector($cale)
	{
		$elemente=scandir($cale);
		foreach($elemente as $element)
		{
			if($element==="." || $element==="..")
				continue;

			$complet=$cale."/".$element;
			if(is_dir($complet))
				stergeDirector($complet);
			else
				unlink($complet);
		}
		rmdir($cale);
	}
?>
