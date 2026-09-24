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
	require_once("top.php");	
	require_once("functii/f_links.php");

	//----------------------------------------------------------------------------------------------------------------------------
	//@toate categoriile
	$arr_toate_cat=arrayFromDB("*", "t_categorii", "WHERE producator='0' ORDER BY nr_ordine ASC");
	
	//----------------------------------------------------------------------------------------------------------------------------	
	if(isset($_GET["id_disponibilitate"]) && is_numeric($_GET["id_disponibilitate"]) && !empty($_GET["id_disponibilitate"]))
	{
		$arr_stoc=arrayFromDB("*", "t_stoc", "WHERE id_stoc='".$_GET["id_disponibilitate"]."'");
				
		if(count($arr_stoc)>0)
		{
			$sql_where=" AND stoc='".$_GET["id_disponibilitate"]."'";
			$nume_disponibilitate=str_replace(array(" ", "."), array("_", ""), $arr_stoc[0]["stoc"]);
		}
	}
	
	//----------------------------------------------------------------------------------------------------------------------------
	//@headere pt excel
	header("Content-Type: application/vnd.ms-excel"); 
    header("Content-Disposition: attachment; filename=\"oferta_excel".((!empty($nume_disponibilitate))?"_".$nume_disponibilitate:"").".xls\"");
	
    //----------------------------------------------------------------------------------------------------------------------------
    //@generare oferte produse
	$sitemap=new arboreComplet(0, 0, $arr_toate_cat);
	$arr_sitemap=$sitemap->getArboreComplet();

	print "<table border='1'>";
	
	foreach($arr_sitemap as $key=>$value)
	{
		//@categorie
		print "<tr><td colspan='3'>".$value["indent"]." <font color='#14A214'><b>".$value["nume_cat"]."</b></font></td></tr>";
		
		//@selectare produse
		$arr_produse=arrayFromDB(array("id_produs", "nume_produs", "pret", "descriere_produs"),
								 "t_produse",
								 "WHERE id_cat='".$value["id_cat"]."' ".$sql_where." ORDER BY nume_produs ASC");
		$nr_linii=count($arr_produse);
		
		//@afisez header produse doar daca categoria are produse
		if($nr_linii>0)
		{
			//@header produse
			print "<tr><td><b>Nume produs</b></td><td><b>Descriere</b></td><td><b>Pret (".MONEDA." cu TVA)</b></td></tr>";
		}
		
		//@produse
		for($i=0;$i<$nr_linii;$i++)
		{
			print "<tr>
						<td valign='top'>							
							<u>".ucfirst($arr_produse[$i]["nume_produs"])."</u>".((!empty($arr_produse[$i]["nume_produs"]))?$arr_produse[$i]["cod_produs"]:"")."
						</td>
						<td valign='top'>".$arr_produse[$i]["descriere_produs"]."</td>
						<td valign='top'>".$arr_produse[$i]["pret"] * TVA."</td>
				   </tr>";		
		}
	}
	
	print "</table>";
?>