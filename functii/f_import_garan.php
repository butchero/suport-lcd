<?
	function caleGaranXlsx()
	{
		$root=dirname(__FILE__)."/..";

		if(is_file($root."/GARAN.xlsx"))
			return $root."/GARAN.xlsx";

		if(is_file($root."/private/GARAN.xlsx"))
			return $root."/private/GARAN.xlsx";

		return "";
	}

	function normGaran($text)
	{
		return strtoupper(preg_replace("/[^A-Z0-9]/i", "", $text));
	}

	function contineTokenGaran($text, $token)
	{
		$text=normGaran($text);
		$token=normGaran($token);

		if($text==="" || $token==="")
			return false;

		return preg_match("/(?<![0-9])".preg_quote($token, "/")."(?![0-9])/", $text)==1;
	}

	function tokenuriModelGaran($nume)
	{
		$nume=strtoupper($nume);
		$nume=preg_replace("/\d+\s*-\s*\d+\s*CM/", " ", $nume);
		$stop=array("SUPORT", "LCD", "LED", "TV", "PLASMA", "COD", "CU", "PRINDERE", "DE", "TAVAN", "ARAGAZ", "FRIGIDER", "CUPTOR", "MICROUNDE", "RECEIVER", "DVD", "STAND", "DL", "ZZ", "CM", "PENTRU", "SI", "PT");
		$parti=preg_split("/[^A-Z0-9]+/", $nume, -1, PREG_SPLIT_NO_EMPTY);
		$parti=array_values(array_filter($parti, function($parte) use ($stop){
			return !in_array($parte, $stop, true);
		}));

		$tokenuri=array();

		foreach($parti as $parte)
		{
			if(preg_match("/\d/", $parte) && strlen($parte)>=2)
				$tokenuri[]=$parte;
		}

		for($i=0;$i<count($parti)-1;$i++)
		{
			if(preg_match("/^[A-Z]{1,4}$/", $parti[$i]) && preg_match("/\d/", $parti[$i+1]))
				$tokenuri[]=$parti[$i].$parti[$i+1];
		}

		$tokenuri=array_values(array_unique($tokenuri));
		usort($tokenuri, function($a, $b){
			return strlen($b)-strlen($a);
		});

		return $tokenuri;
	}

	function citesteRanduriGaran($cale)
	{
		$zip=new ZipArchive();

		if($zip->open($cale)!==true)
			return array();

		$shared=$zip->getFromName("xl/sharedStrings.xml");
		$sheet=$zip->getFromName("xl/worksheets/sheet1.xml");
		$zip->close();

		$siruri=array();
		if(preg_match_all("/<si>(.*?)<\\/si>/s", $shared, $blocuri))
		{
			foreach($blocuri[1] as $bloc)
			{
				preg_match_all("/<t[^>]*>([^<]*)<\\/t>/", $bloc, $texte);
				$siruri[]=implode("", $texte[1]);
			}
		}

		$randuri=array();

		if(!preg_match_all("/<row[^>]*>(.*?)<\\/row>/s", $sheet, $xml_randuri))
			return $randuri;

		foreach($xml_randuri[1] as $index=>$xml)
		{
			if($index==0)
				continue;

			preg_match_all('/<c r="([A-Z]+)(\d+)"([^>]*)>(?:<v>([^<]*)<\\/v>)?/', $xml, $celule, PREG_SET_ORDER);
			$coloane=array();

			foreach($celule as $celula)
			{
				$valoare=isset($celula[4]) ? $celula[4] : "";

				if(strpos($celula[3], 't="s"')!==false && $valoare!=="")
					$valoare=$siruri[(int)$valoare];

				$coloane[$celula[1]]=$valoare;
			}

			$randuri[]=array("nume"=>isset($coloane["D"]) ? trim($coloane["D"]) : "",
							 "ean"=>isset($coloane["E"]) ? trim($coloane["E"]) : "");
		}

		return $randuri;
	}

	function potrivesteProduseGaran($randuri, $produse)
	{
		$rezultat=array("gasite"=>array(),
						"negasite"=>array(),
						"ambigue"=>array(),
						"duplicate"=>array(),
						"goale"=>0);
		$vazute=array();

		foreach($randuri as $rand)
		{
			if($rand["nume"]==="")
			{
				$rezultat["goale"]++;
				continue;
			}

			$potrivire=null;
			$ambiguu=null;

			foreach(tokenuriModelGaran($rand["nume"]) as $token)
			{
				$pe_cod=array();
				$pe_nume=array();

				foreach($produse as $produs)
				{
					if(!contineTokenGaran($produs["nume_produs"], $token))
						continue;

					$pe_nume[]=$produs;

					if(trim($produs["cod_produs"])!="" && normGaran($produs["cod_produs"])==normGaran($token))
						$pe_cod[]=$produs;
				}

				if(count($pe_cod)==1)
				{
					$potrivire=array("produs"=>$pe_cod[0], "token"=>$token, "cheie"=>"cod_produs");
					break;
				}

				if(count($pe_cod)>1)
				{
					$ambiguu=array("nume"=>$rand["nume"], "token"=>$token, "produse"=>$pe_cod);
					break;
				}

				if(count($pe_nume)==1)
				{
					$potrivire=array("produs"=>$pe_nume[0], "token"=>$token, "cheie"=>"nume_produs");
					break;
				}

				if(count($pe_nume)>1)
				{
					$ambiguu=array("nume"=>$rand["nume"], "token"=>$token, "produse"=>$pe_nume);
					break;
				}
			}

			if($ambiguu!==null)
			{
				$rezultat["ambigue"][]=$ambiguu;
				continue;
			}

			if($potrivire===null)
			{
				$rezultat["negasite"][]=$rand["nume"];
				continue;
			}

			$id=$potrivire["produs"]["id_produs"];

			if(isset($vazute[$id]))
			{
				$rezultat["duplicate"][]=$rand["nume"]." -> #".$id;
				continue;
			}

			$vazute[$id]=1;
			$rezultat["gasite"][]=array("id_produs"=>$id,
										"nume_xlsx"=>$rand["nume"],
										"nume_produs"=>$potrivire["produs"]["nume_produs"],
										"cod_produs"=>$potrivire["produs"]["cod_produs"],
										"token"=>$potrivire["token"],
										"cheie"=>$potrivire["cheie"]);
		}

		return $rezultat;
	}
?>
