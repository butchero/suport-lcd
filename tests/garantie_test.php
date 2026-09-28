<?php
	if(!function_exists("get_magic_quotes_gpc"))
	{
		function get_magic_quotes_gpc()
		{
			return false;
		}
	}

	require_once(__DIR__."/../functii/f_generale.php");
	require_once(__DIR__."/../clase/valideazaProdus.php");
	require_once(__DIR__."/../clase/garanLabel.php");

	$erori=0;

	function verifica($conditie, $mesaj)
	{
		global $erori;

		if(!$conditie)
		{
			echo "FAIL: ".$mesaj.PHP_EOL;
			$erori++;
		}
	}

	verifica(formateazaGarantie(24)=="2 ani", "24 luni -> 2 ani");
	verifica(formateazaGarantie(12)=="1 an", "12 luni -> 1 an");
	verifica(formateazaGarantie(60)=="5 ani", "60 luni -> 5 ani");
	verifica(formateazaGarantie(36)=="3 ani", "36 luni -> 3 ani");
	verifica(formateazaGarantie(30)=="30 luni", "30 luni ramane in luni");
	verifica(formateazaGarantie(1)=="1 lună", "1 luna");
	verifica(formateazaGarantie(18)=="18 luni", "18 luni");
	verifica(formateazaAniGaran(60)=="5", "ani GARAN 60");
	verifica(formateazaAniGaran(30)=="2,5", "ani GARAN 30");

	$validare=new valideazaProdus();
	$respins=$validare->valideazaGarantie(24, 1, 5, "PLB-123");
	verifica($validare->getErori()>0 && $respins["warranty"]["valid"]==0, "GARAN respins la 24 luni");

	$validare=new valideazaProdus();
	$acceptat=$validare->valideazaGarantie(60, 1, 5, "PLB-123");
	verifica($validare->getErori()==0 && $acceptat["eligible"]==1, "GARAN acceptat la 60 luni");

	$validare=new valideazaProdus();
	$fara_model=$validare->valideazaGarantie(60, 1, 5, "");
	verifica($validare->getErori()>0, "GARAN respins fara model");

	$validare=new valideazaProdus();
	$neeligibil=$validare->valideazaGarantie(24, 0, 0, "");
	verifica($validare->getErori()==0 && $neeligibil["eligible"]==0, "produs non-GARAN la 24 luni");

	$eticheta=new garanLabel();
	$svg=$eticheta->generatePrintSvg(array("warranty_months"=>60, "brand"=>"SEREND", "model"=>"PLB-123"));
	verifica(strpos($svg, ">5<")!==false, "SVG contine 5");
	verifica(strpos($svg, ">SEREND<")!==false, "SVG contine brand");
	verifica(strpos($svg, ">PLB-123<")!==false, "SVG contine model");
	verifica(strpos($svg, "{{")===false, "SVG fara placeholder");
	verifica(strpos($svg, "Brand/")===false && strpos($svg, "Model identifier")===false, "etichetele goale au fost inlocuite");
	verifica(strpos($svg, "width=\"95mm\"")!==false && strpos($svg, "height=\"100mm\"")!==false, "tipar 95x100 mm");
	verifica(strpos($svg, "data:font/ttf;base64,")!==false, "font inglobat la tipar");

	$svg_rau=$eticheta->generatePrintSvg(array("warranty_months"=>60, "brand"=>"<script>", "model"=>"A&B"));
	verifica(strpos($svg_rau, "<script>")===false, "fara script");
	verifica(strpos($svg_rau, "&lt;script&gt;")!==false, "brand escapat");
	verifica(strpos($svg_rau, "A&amp;B")!==false, "model escapat");

	$nested=$eticheta->generateWebSvg(array("warranty_months"=>60, "brand"=>"SEREND", "model"=>"PLB-123"));
	verifica(strpos($nested, ">5<")!==false, "nested contine 5");
	verifica(strpos($nested, "SEREND")===false, "nested nu contine brand");
	verifica(strpos($nested, "width=\"95mm\"")===false, "nested fara dimensiune de raft");

	verifica($eticheta->numeFisier("PLB-123", 60)=="garan-PLB-123-5-ani.svg", "nume fisier");

	$original=file_get_contents(__DIR__."/../GARAN label for website/GARAN Label_colour.svg");
	verifica(strpos($original, ">XX<")!==false, "originalul pastreaza XX");
	verifica(strpos($original, "Brand/")!==false, "originalul pastreaza Brand");

	$admin=file_get_contents(__DIR__."/../admin/descarca_eticheta_garan.php");
	verifica(strpos($admin, "autentificare.php")!==false, "download admin cere autentificare");
	verifica(strpos($admin, "Content-Disposition: attachment")!==false, "download are header de atasament");

	if($erori==0)
		echo "OK".PHP_EOL;
	else
		echo $erori." erori".PHP_EOL;

	exit($erori==0 ? 0 : 1);
?>
