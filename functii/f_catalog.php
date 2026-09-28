<?
	/*
    *****************************************************************************
	*****************************************************************************
	**                                                                         **
	**          CIUCA VALERIU (BUTCHER) - GOGO PROMOTIONS - 2007       		   **
	**                                                                         **
	*****************************************************************************
	*****************************************************************************
	*/
	//-------------------------------------------------------------------------------------------------------------
	//@functii folosite cu precadere in catalogul de produse
	function getSubcategoriiDupaProducator($id_prod, $link_cat, $nu_afis_inactive=true)
	{
	    global $mysqli;

		$sql="SELECT DISTINCT(t_produse.id_cat) AS id_cat, t_categorii.*
				FROM t_produse LEFT JOIN t_categorii ON t_produse.id_cat=t_categorii.id_cat
			  WHERE t_produse.id_prod='".$id_prod."' ".(($nu_afis_inactive)?" AND activ='1'":"")." ORDER BY nr_ordine ASC";
		$result=$mysqli->query($sql);
		$arr=array();
			
		while($row=$result->fetch_assoc())
		{
			if(file_exists(URL_BASE_ABS."poze_categorii/".$row["id_cat"].".jpg"))
				$adresa_poza=URL_BASE."poze_categorii/".$row["id_cat"].".jpg";
			else $adresa_poza=DIR_TEMPLATE."img/fara_imagine.jpg";	
	
			$arr[]=array("id_cat"=>$row["id_cat"],
						 "poza_cat"=>$adresa_poza,
				 	     "nume_cat"=>$row["nume_cat"],
				 	     "nr_produse"=>"",
						 "link_cat"=>URL_BASE.strtolower($row["link_cat"])."/".strtolower($link_cat),
						 "link_cat_admin"=>URL_ADMIN."catalog.php?cat=".$row["id_cat"],
						 "activ"=>$row["activ"]);
		}
		return $arr;
	}
	
	//-------------------------------------------------------------------------------------------------------------
	//parametrul $where a fost adaugat pt admin ca sa pot folosi functia asta cand editez producatorii sau subcategoriile
	function getSubcategorii($id_parinte, $cu_poza=true, $ordoneaza_dupa="nr_ordine", $where="", $nu_afis_inactive=true) 
	{
        global $mysqli;

		$sql="SELECT * FROM t_categorii 
				WHERE id_parinte='".$id_parinte."' ".$where.(($nu_afis_inactive)?" AND activ='1'":"").
			 "    ORDER BY ".$ordoneaza_dupa." ASC";
		$result=$mysqli->query($sql);
		$arr=array();
		$adresa_poza="";
		
		while($row=$result->fetch_assoc())
		{
			if($cu_poza)
			{
				if(file_exists(URL_BASE_ABS."poze_categorii/".$row["id_cat"].".jpg"))
					$adresa_poza=URL_BASE."poze_categorii/".$row["id_cat"].".jpg";
				else $adresa_poza=DIR_TEMPLATE."img/fara_imagine.jpg";	
			}
	
			$arr[]=array("id_cat"=>$row["id_cat"],
						 "poza_cat"=>$adresa_poza,
						 "nume_cat"=>$row["nume_cat"],
						 "nr_produse"=>$row["nr_produse"],
						 "link_cat"=>URL_BASE.strtolower($row["link_cat"]),
						 "link_cat_admin"=>URL_ADMIN."catalog.php?cat=".$row["id_cat"],
						 "activ"=>$row["activ"]);
		}
		return $arr;
	}
	
	//-------------------------------------------------------------------------------------------------------------
	function getTotiProducatorii($cu_poza=true, $ordoneaza_dupa="nr_ordine")
	{
        global $mysqli;

		$sql="SELECT * FROM t_categorii WHERE producator='1' ORDER BY ".$ordoneaza_dupa." ASC";
		$result=$mysqli->query($sql);
			
		while($row=$result->fetch_assoc())
		{
			if($cu_poza)
			{
				if(file_exists(URL_BASE_ABS."poze_categorii/".$row["id_cat"].".jpg"))
					$adresa_poza=URL_BASE."poze_categorii/".$row["id_cat"].".jpg";
				else $adresa_poza=DIR_TEMPLATE."img/fara_imagine.jpg";
			}	
	
			$arr[]=array("id_cat"=>$row["id_cat"],
						 "poza_cat"=>$adresa_poza,
				 	     "nume_cat"=>$row["nume_cat"],
				 	     "nr_produse"=>$row["nr_produse"],
						 "link_cat"=>URL_BASE.strtolower($row["link_cat"]),
						 "activ"=>$row["activ"]);
		}
		return $arr;
	}
	
	//-------------------------------------------------------------------------------------------------------------
	//@citeste pozele din folderul cu id-ul specificat
	function genereazaGalerie($id, $fara_poza_principala=false)
	{
		$url=URL_BASE_ABS."poze_produse/".$id."/mici";
		
		//scriptul de sincronizare prin ftp genereaza niste error_logs - le sterg pe masura ce se navigheaza prin site
		if(is_numeric($id))
		{
			@unlink(URL_BASE_ABS."poze_produse/".$id."/error_log");
			@unlink(URL_BASE_ABS."poze_produse/".$id."/mici/error_log");
			@unlink(URL_BASE_ABS."poze_produse/".$id."/medii/error_log");
			@unlink(URL_BASE_ABS."poze_produse/".$id."/mari/error_log");
			@unlink(URL_BASE_ABS."poze_produse/".$id."/supermari/error_log");
		}
		
		$poze=array();
		$poze_sec_mici=array();
		$poze_sec_medii=array();
		$poze_sec_mari=array();
		$poze_sec_supermari=array();
		$nr_poze=array();

		if($handle=@opendir($url))
		{			   
		   while(false!==($file=readdir($handle))) 
		   {
		       if($file!="." && $file!=".." && $file!="Thumbs.db")
		       {		
					if($fara_poza_principala && $file=="0.jpg")
						continue;		       	
		       	
		       		$adresa_poza=URL_BASE."poze_produse/".$id."/%s/".$file;
		       		     		
		       		$poze_sec_mici[]=sprintf($adresa_poza, "mici");
		       		$poze_sec_medii[]=sprintf($adresa_poza, "medii");
		       		$poze_sec_mari[]=sprintf($adresa_poza, "mari");
		       		$poze_sec_supermari[]=sprintf($adresa_poza, "supermari");
		       		$poze[]=$file; //pastrez numele pozei pt a construi link-ul de stergere
		       		
		       		$bucati=explode(".", $file);
		       		$nr_poze[]=$bucati[0]; //pastrez nr poza pt a afla numarul ultimei poze	
		       		unset($bucati);			       				       		
		       }
		   }
		}
		
		return array("poze"=>$poze, "mici"=>$poze_sec_mici, "medii"=>$poze_sec_medii, "mari"=>$poze_sec_mari, "supermari"=>$poze_sec_supermari, "ultima_poza"=>@max($nr_poze));
	}
	
	//-------------------------------------------------------------------------------------------------------------
	//@verificari poze daca exista si obtinere adresa poza in caz ca exista
	function getPozaPrincipalaProdus($id_produs, $nume_produs="")
	{
		if(file_exists(URL_BASE_ABS."poze_produse/".$id_produs."/medii/0.jpg"))
			$adresa_poza=URL_BASE."poze_produse/".$id_produs."/medii/".prepareLink($nume_produs)."_0.jpg";
		else $adresa_poza=DIR_TEMPLATE."img/fara_imagine.jpg";
		
		return $adresa_poza;
	}
	
	function getPozaPrincipalaMareProdus($id_produs, $nume_produs="")
	{
		if(file_exists(URL_BASE_ABS."poze_produse/".$id_produs."/mari/0.jpg"))
			$adresa_poza=URL_BASE."poze_produse/".$id_produs."/mari/".prepareLink($nume_produs)."_0.jpg";
		else $adresa_poza=DIR_TEMPLATE."img/fara_imagine.jpg";
		
		return $adresa_poza;
	}
	
	function getPozaPrincipalaMicaProdus($id_produs, $nume_produs="")
	{
		if(file_exists(URL_BASE_ABS."poze_produse/".$id_produs."/mici/0.jpg"))
			$adresa_poza=URL_BASE."poze_produse/".$id_produs."/mici/".prepareLink($nume_produs)."_0.jpg";
		else $adresa_poza=DIR_TEMPLATE."img/fara_imagine_mica.jpg";
		
		return $adresa_poza;
	}
	
	function getPozaMicaProducator($id_producator, $nume_produs="")
	{
		if(file_exists(URL_BASE_ABS."poze_categorii/mici/".$id_producator.".jpg"))
			$adresa_poza_producator=URL_BASE."poze_categorii/mici/".prepareLink($nume_produs)."_0.jpg";
		else $adresa_poza_producator="";	
			
		return $adresa_poza_producator;	
	}
	
	function getPozaMareProducator($id_producator, $nume_produs="")
	{
		if(file_exists(URL_BASE_ABS."poze_categorii/".$id_producator.".jpg"))
			$adresa_poza_producator=URL_BASE."poze_categorii/".prepareLink($nume_produs)."_0.jpg";
		else $adresa_poza_producator="";	
			
		return $adresa_poza_producator;	
	}
	
	//-------------------------------------------------------------------------------------------------------------
	//@convertor valutar
	function getConvertorValutar($pret)
	{
		global $arr_curs;
		
		//$popup_js="<b>CONVERTOR VALUTAR</b><br />".
		//$popup_js.=(formateazaNr($pret * TVA / $arr_curs["usd"]))." USD <br />";
		//$popup_js.=(formateazaNr($pret * TVA / $arr_curs["euro"]))." EURO";
		
		return "";
	}

	//-------------------------------------------------------------------------------------------------------------
	//@valori stocuri posibile
	function getStocuri()
	{
		$arr_stoc=arrayFromDB("*", "t_stoc", "ORDER BY id_stoc ASC");
		
		foreach($arr_stoc as $k=>$v)
			$arr_stoc[$v["id_stoc"]]=$v["stoc"];
			
		return $arr_stoc;	
	}
	
	//-------------------------------------------------------------------------------------------------------------
	//@categoriile secundare de care apartine un produs
	function getCategoriiSecundare($id_produs)
	{
		$arr_cat_sec=arrayFromDB(array("b.id_cat_sec", "b.nume_cat_sec", "b.link_cat_sec"),
								 "t_relatii_cat_sec_produse AS a LEFT JOIN t_categorii_secundare AS b ON a.id_cat_sec=b.id_cat_sec",
								 "WHERE a.id_produs='".$id_produs."'");

		$cat_sec=array();						 	 
		foreach($arr_cat_sec as $k=>$v)
		{
			$cat_sec[$k]["id_cat_sec"]=$v["id_cat_sec"];
			$cat_sec[$k]["nume_cat_sec"]=$v["nume_cat_sec"];
			$cat_sec[$k]["link_cat_sec"]=getLinkCatSec($v["link_cat_sec"]);
		}
								  
		return $cat_sec;						 
	}
?>