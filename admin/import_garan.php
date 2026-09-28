<?
	if(php_sapi_name()!="cli")
	{
		require_once("top.php");
		require_once("autentificare.php");
	}
	else
	{
		if(!function_exists("get_magic_quotes_gpc"))
		{
			function get_magic_quotes_gpc()
			{
				return false;
			}
		}

		$_SERVER["HTTP_HOST"]=isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : "localhost";
		$_SERVER["DOCUMENT_ROOT"]=isset($_SERVER["DOCUMENT_ROOT"]) ? $_SERVER["DOCUMENT_ROOT"] : "d:/Laragon/www";
		require_once(__DIR__."/../conectare.php");
		require_once(__DIR__."/../functii/f_securitate.php");
		require_once(__DIR__."/../functii/f_bd.php");
	}

	require_once(__DIR__."/../functii/f_import_garan.php");

	$cale=caleGaranXlsx();
	$linii=array();

	if($cale==="")
	{
		$linii[]="Fisierul GARAN.xlsx nu a fost gasit.";
	}
	else
	{
		$randuri=citesteRanduriGaran($cale);
		$produse=arrayFromDB(array("id_produs", "cod_produs", "nume_produs"), "t_produse", "");
		$potrivire=potrivesteProduseGaran($randuri, $produse);
		$actualizate=0;

		foreach($potrivire["gasite"] as $gasit)
		{
			arrayUpdateToDB("t_produse",
							array("warranty_months", "garan_eligible"),
							array(60, 1),
							array("id"=>"id_produs", "valoare"=>$gasit["id_produs"]));
			$actualizate++;
		}

		$ramase=arrayFromDB(array("COUNT(id_produs) AS nr"), "t_produse", "WHERE warranty_months='24' AND garan_eligible='0'");
		$trecute=arrayFromDB(array("COUNT(id_produs) AS nr"), "t_produse", "WHERE warranty_months='60' AND garan_eligible='1'");

		$linii[]="Cheie: token de model din Denumire produs, intai cod_produs normalizat, apoi nume_produs daca potrivirea este unica.";
		$linii[]="Fisier: ".$cale;
		$linii[]="Total randuri: ".count($randuri);
		$linii[]="Randuri goale: ".$potrivire["goale"];
		$linii[]="Produse gasite: ".count($potrivire["gasite"]);
		$linii[]="Produse actualizate la 60 luni: ".$actualizate;
		$linii[]="Produse la 60 luni dupa import: ".$trecute[0]["nr"];
		$linii[]="Produse ramase la 24 luni: ".$ramase[0]["nr"];
		$linii[]="Negasite: ".count($potrivire["negasite"]);

		foreach($potrivire["negasite"] as $nume)
			$linii[]="  - ".$nume;

		$linii[]="Ambigue: ".count($potrivire["ambigue"]);

		foreach($potrivire["ambigue"] as $ambiguu)
		{
			$nume_produse=array();

			foreach($ambiguu["produse"] as $produs)
				$nume_produse[]="#".$produs["id_produs"]." [".$produs["cod_produs"]."] ".$produs["nume_produs"];

			$linii[]="  - ".$ambiguu["nume"]." (token ".$ambiguu["token"].") => ".implode(" | ", $nume_produse);
		}

		$linii[]="Duplicate: ".count($potrivire["duplicate"]);

		foreach($potrivire["duplicate"] as $duplicat)
			$linii[]="  - ".$duplicat;

		$linii[]="Potriviri:";

		foreach($potrivire["gasite"] as $gasit)
			$linii[]="  - ".$gasit["nume_xlsx"]." => #".$gasit["id_produs"]." [".$gasit["cod_produs"]."] ".$gasit["nume_produs"]." (".$gasit["cheie"]." ".$gasit["token"].")";

		$destinatie=dirname(__DIR__)."/private/GARAN.xlsx";

		if(realpath($cale)!=realpath($destinatie))
		{
			if(!is_dir(dirname($destinatie)))
				mkdir(dirname($destinatie), 0777, true);

			rename($cale, $destinatie);
			$linii[]="Fisierul a fost mutat in private/GARAN.xlsx.";
		}
	}

	if(php_sapi_name()=="cli")
	{
		echo implode(PHP_EOL, $linii).PHP_EOL;
		exit;
	}

	header("Content-Type: text/html; charset=UTF-8");
	echo "<pre>".htmlspecialchars(implode("\n", $linii), ENT_QUOTES, "UTF-8")."</pre>";
	exit;
?>
