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
	require_once("left.php");
	require_once("../functii/f_admin.php");
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@autorizare user logat
	require_once("autentificare.php");
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//template-ul care va fi folosit de smarty - variabila e folosita in bottom.php ($smarty->display($display_page);)
	$display_page="admin/tools.tpl";	
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@update nr_poze
	if(isset($_POST["update_nr_poze"]))
	{
		$arr_produse=arrayFromDB("*", "t_produse");
			
		foreach ($arr_produse as $k=>$v)
		{
			$nr_poze_produs=count(citesteDir(URL_BASE_ABS."poze_produse/".$v["id_produs"]."/mici/"));
			
			arrayUpdateToDB("t_produse", array("nr_poze"), array($nr_poze_produs), array("id"=>"id_produs", "valoare"=>$v["id_produs"]));
			unset($nr_poze_produs);
		}		
		
		$mesaj="Numarul de poze pentru fiecare produs a fost actualizat cu succes!";
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@update nr_produse
	if(isset($_POST["update_nr_produse"]))
	{
		$arr_categorii=arrayFromDB("*", "t_categorii", "WHERE producator='0'");
		
		foreach($arr_categorii as $key=>$value)
		{
			$copii=new arboreComplet($value["id_cat"], 0, $arr_toate_cat);
			$arr_copii=$copii->getArboreComplet();
		
			$nr_produse=0;
			
			if(is_array($arr_copii))
			{
				foreach($arr_copii as $k=>$v)
				{
					$arr_nr_produse=arrayFromDB(array("COUNT(*) as nr_produse"), "t_produse", "WHERE id_cat='".$v["id_cat"]."'");
					$nr_produse+=$arr_nr_produse[0]["nr_produse"];
				}
			}
			
			$arr_nr_produse=arrayFromDB(array("COUNT(*) as nr_produse"), "t_produse", "WHERE id_cat='".$value["id_cat"]."'");
			$nr_produse+=$arr_nr_produse[0]["nr_produse"];
						
			arrayUpdateToDB("t_categorii", array("nr_produse"), array($nr_produse), array("id"=>"id_cat", "valoare"=>$value["id_cat"]));
		}
		
		$arr_producatori=arrayFromDB("*", "t_categorii", "WHERE producator='1'");
		
		foreach($arr_producatori as $key=>$value)
		{
			$arr_nr_produse=arrayFromDB(array("COUNT(*) as nr_produse"), "t_produse", "WHERE id_prod='".$value["id_cat"]."'");			
			arrayUpdateToDB("t_categorii", array("nr_produse"), array($arr_nr_produse[0]["nr_produse"]), array("id"=>"id_cat", "valoare"=>$value["id_cat"]));
		}
		
		$mesaj="Numarul de produse pentru fiecare categorie a fost actualizat cu succes!";
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@update top vanzari
	if(isset($_POST["update_top_vanzari"]))
	{
		$arr_produse=arrayFromDB(array("id_produs"), "t_produse");
		
		foreach($arr_produse as $key=>$value)
		{
			$arr_nr_vanzari=arrayFromDB(array("SUM(cantitate) AS cantitate"), "t_produse_comenzi", "WHERE id_produs='".$value["id_produs"]."'");
			(empty($arr_nr_vanzari[0]["cantitate"]))?$arr_nr_vanzari[0]["cantitate"]=0:"";
			arrayUpdateToDB("t_produse", array("bestseller"), array($arr_nr_vanzari[0]["cantitate"]), array("id"=>"id_produs", "valoare"=>$value["id_produs"]));
		}
		
		$mesaj="Top vanzari a fost actualizat cu succes!";
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@actiuni de reparare si optimizare
	if(isset($_GET["actiune"]) && $_GET["actiune"]=="repara" && !empty($_GET["tabel"]))
	{
		$sql="REPAIR TABLE ".$_GET["tabel"];
		mysql_query($sql);
		
		$mesaj="Tabelul ".$_GET["tabel"]." a fost reparat!";
	}
	
	if(isset($_GET["actiune"]) && $_GET["actiune"]=="optimizeaza" && !empty($_GET["tabel"]))
	{
		$sql="OPTIMIZE TABLE ".$_GET["tabel"];
		mysql_query($sql);
		
		$mesaj="Tabelul ".$_GET["tabel"]." a fost optimizat!";
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@toate tabele din baza de date
	$sql="SHOW TABLES";
	$result=mysql_query($sql);
	
	$arr_tabele=array();
	
	while($row=mysql_fetch_array($result))
	{		
		$sql_check="CHECK TABLE ".$row[0];
		$result_check=mysql_query($sql_check);
		$row_check=mysql_fetch_array($result_check);
		
		$arr_tabele[]=array("nume_tabel"=>$row[0],
							"op"=>$row_check["Op"],
							"msg_type"=>$row_check["Msg_type"],
							"msg_text"=>$row_check["Msg_text"]);
	}

	//---------------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	$smarty->assign("mesaj", $mesaj);
	$smarty->assign("tabele", $arr_tabele);

	require_once("right.php");
	require_once("bottom.php");
?>