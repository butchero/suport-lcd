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
	require_once("../conectare.php");
	require_once("../configurare.php");	
	require_once("../init.php");	
	require_once("../functii/f_links.php");
	require_once("../functii/f_generale.php");
	
	if(isset($_GET["download"]) && $_GET["download"]==1)
	{
		header("Content-Type: text/plain");
		header("Content-Disposition: attachment; filename=\"export_price.txt\"");		
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@categorii
	$arr_categorii=arrayFromDBtoCombo("t_categorii", "id_cat", "nume_cat", "WHERE producator='0' AND activ='1'");

	//---------------------------------------------------------------------------------------------------------------------------------
	//@producatori
	$arr_producatori=arrayFromDBtoCombo("t_categorii", "id_cat", "nume_cat", "WHERE producator='1'");
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@stoc
	$arr_stoc=arrayFromDBtoCombo("t_stoc", "id_stoc", "stoc");
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@produse
	$arr_produse=arrayFromDB("*", "t_produse AS a INNER JOIN t_categorii AS b ON a.id_cat=b.id_cat");
	
	foreach($arr_produse as $key=>$value)
	{
		if(file_exists(URL_BASE_ABS."poze_produse/".$value["id_produs"]."/mari/0.jpg"))
			$poza=URL_BASE."poze_produse/".$value["id_produs"]."/mari/0.jpg";
		else $poza="";	
		
		//@caracteristici
		$caracteristici=explode(";", $value["caracteristici"]);
		
		//@nume caracteristici
		$arr_filtre=arrayFromDB("*", "t_filtre", "WHERE id_cat='".$value["id_cat"]."' ORDER BY id_filtru ASC");
			
		$i=1;
		
		$descriere="";
		
		foreach($arr_filtre as $k=>$v)
		{
			$descriere.=strtoupper($v["nume_filtru"]).": <b>".$caracteristici[$i]."</b><br />";
			$i++;
		}
		
		(!empty($descriere))?$descriere.="<br />":"";
		
		$descriere.=str_replace(array("\r\n", "\n"), array("", ""), trim($value["descriere_produs"]));
		
		$output=$value["id_produs"]."|";
		$output.=$arr_categorii[$value["id_cat"]]."|";
		$output.=((empty($arr_producatori[$value["id_prod"]]))?"generic":$arr_producatori[$value["id_prod"]])."|";
		$output.=$value["nume_produs"]."|";
		$output.=$descriere."|";
		$output.=$value["pret"]*TVA."|";
		$output.="RON cu TVA"."|";
		$output.=$arr_stoc[$value["stoc"]]."|";
		$output.="0"."|";
		$output.=getLinkProdus($value["link_cat"], $value["nume_produs"], $value["id_produs"])."|";
		$output.=$poza;

		print $output."\n";
	}
?>