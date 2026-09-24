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
	require_once("../functii/f_catalog.php");
	
	//-------------------------------------------------------------------------------------------------------------------------------------
	//@autorizare user logat
	require_once("autentificare.php");
	
	//-------------------------------------------------------------------------------------------------------------------------------------
	//@modul activat/dezactivat check
	if(!CHILIPIR)
		die("Aceasta sectiune este dezactivata! <br /><a href='".URL_ADMIN."'>Prima pagina din administrare.</a>");
	
	//-------------------------------------------------------------------------------------------------------------------------------------
	//@restrictionare acces pt subadmini
	restrictioneazaAccesSubadmini();
	
	//-------------------------------------------------------------------------------------------------------------------------------------
	//template-ul care va fi folosit de smarty - variabila e folosita in bottom.php ($smarty->display($display_page);)
	$display_page="admin/chilipirul_zilei.tpl";
	
	//-------------------------------------------------------------------------------------------------------------------------------------
	//@id produs
	if(isset($_REQUEST["id_produs"]) && is_numeric($_REQUEST["id_produs"]) && !empty($_REQUEST["id_produs"]))
		$id_produs=$_REQUEST["id_produs"];
	
	//-------------------------------------------------------------------------------------------------------------------------------------
	//@anul
	if(isset($_GET["calendar_year"]) && is_numeric($_GET["calendar_year"]))
		$an=$_GET["calendar_year"];
	else
	{
		$an=date("Y");
		$_GET["calendar_year"]=date("Y");
	}

	//-------------------------------------------------------------------------------------------------------------------------------------	
	//@luna	
	if(isset($_GET["calendar_month"]) && is_numeric($_GET["calendar_month"]))	
		$luna=(strlen($_GET["calendar_month"])==1)?"0".$_GET["calendar_month"]:$_GET["calendar_month"];
	else
	{
		$luna=date("m");
		$_GET["calendar_month"]=date("n");
	}
	
	//-------------------------------------------------------------------------------------------------------------------------------------	
	//@luna	
	if(isset($_GET["calendar_Day"]) && is_numeric($_GET["calendar_Day"]))	
		$ziua=(strlen($_GET["calendar_Day"])==1)?"0".$_GET["calendar_Day"]:$_GET["calendar_Day"];
	else
	{
		$ziua=date("d");
		$_GET['calendar_Day']=date("j");
	}

	//-------------------------------------------------------------------------------------------------------------------------------------	
	//@actiune stergere chilipir
	if(isset($_POST["sterge_chilipir"]) && is_numeric($_GET["id_chilipir"]) && !empty($_GET["id_chilipir"]))
	{
		$id_chilipir=$_GET["id_chilipir"];
		
		$arr_check=arrayFromDB("*", "t_chilipirul_zilei", "WHERE id_produs='".$id_chilipir."'");

		if($arr_check[0]["data_chilipir"]>date("Ymd"))
		{
			arrayDeleteFromDB("t_chilipirul_zilei", array("id_produs"), array($id_chilipir));
			$mesaj="\"Chilipirul\" pentru data selectata a fost sters cu succes!";
		}
		else 
		{
			$mesaj="\"Chilipirul\" nu a putut fi sters, data chilipir < data curenta!";
		}
	}
	
	//-------------------------------------------------------------------------------------------------------------------------------------	
	//@actiune setare chilipir pentru ziua selectata
	if(isset($_POST["seteaza_chilipir"]))
	{
		$pret_chilipir=trim(str_replace(",", ".", $_POST["pret_chilipir"]));
		
		$arr_produs=arrayFromDB("*", "t_produse", "WHERE id_produs='".$id_produs."'");
		
		//@chilipir verificare
		$arr_chilipir=arrayFromDB("*", "t_chilipirul_zilei", "WHERE id_produs='".$id_produs."' OR data_chilipir='".$an.$luna.$ziua."'");
		
		$erori=0;
		
		if(!is_numeric($pret_chilipir))
		{
			$mesaj="Pretul chilipirului nu este numeric!";
			$erori++;
		}
		if(count($arr_chilipir)>0)
		{
			$mesaj="Este deja setat un chilipir pentru ziua selectata sau produsul cu ID-ul <b>".$id_produs."</b> a mai fost setat chilipir inainte!";
			$erori++;
		}
		if($erori==0)
		{
			$mesaj="Produsul <b>".$arr_produs[0]["nume_produs"]."</b> a fost setat \"chilipir\" pentru ziua <b>".$ziua.".".$luna.".".$an."</b>";
			
			arrayInsertToDB("t_chilipirul_zilei",
							 array("data_chilipir", "nume_produs", "pret_curent", "pret_chilipir", "id_produs"),
							 array($an.$luna.$ziua, $arr_produs[0]["nume_produs"], $arr_produs[0]["pret"], $pret_chilipir, $id_produs));				 
		}
	}
	
	//-------------------------------------------------------------------------------------------------------------------------------------
	//@stochez intr-un array zilele care au deja un chilipir setat din luna si anul selectat
	$arr_zile_chilipir=arrayFromDB("*", "t_chilipirul_zilei", "WHERE data_chilipir LIKE '".$an.$luna."%'");
	
	$zile_chilipir=array();
	
	foreach($arr_zile_chilipir as $key=>$value)
		$zile_chilipir[]=substr($value["data_chilipir"], 6, 2);	
	
	
	//-------------------------------------------------------------------------------------------------------------------------------------
	//@calendar
	require_once("../clase/calendar/PHP4/calendar.php");
	
	$calendar=new Calendar("calendar", NULL, $zile_chilipir);
	$output=$calendar->output();	
		
	//-------------------------------------------------------------------------------------------------------------------------------------
	//@chilipir pentru ziua selectata	
	$arr_chilipir=arrayFromDB("*",
							  "t_chilipirul_zilei AS a INNER JOIN t_produse AS b ON a.id_produs=b.id_produs",
							  "WHERE a.data_chilipir='".$an.$luna.$ziua."'");
	$chilipir_setat=0;
	
	if(count($arr_chilipir)==1)
	{
		$chilipir_setat=1;
		$id_chilipir=$arr_chilipir[0]["id_produs"];
		$nume_chilipir=$arr_chilipir[0]["nume_produs"]." - <b>ID: ".$id_chilipir."</b>";
		$pret_chilipir=$arr_chilipir[0]["pret_chilipir"];
		$pret_curent=$arr_chilipir[0]["pret_curent"];
		$atribut_camp=((int)$an.$luna.$ziua<=(int)(date("Ymd")))?"disabled":"";
		
		//---------------------------------------------------------------------------------------------------------------------------------
		//@poze produs
		$poza_chilipir=getPozaPrincipalaProdus($id_chilipir);
	}
	
	//-------------------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY	
	$smarty->assign("mesaj", $mesaj);
	$smarty->assign("calendar", $output);
	$smarty->assign("an", $_GET["calendar_year"]);
	$smarty->assign("luna", $_GET["calendar_month"]);
	$smarty->assign("ziua", $_GET["calendar_Day"]);
	
	$smarty->assign("chilipir_setat", $chilipir_setat);
	$smarty->assign("id_chilipir", $id_chilipir);
	$smarty->assign("nume_chilipir", $nume_chilipir);
	$smarty->assign("pret_chilipir", $pret_chilipir);
	$smarty->assign("pret_curent", $pret_curent);
	$smarty->assign("poza_chilipir", $poza_chilipir);
	$smarty->assign("atribut_camp", $atribut_camp);
	
	require_once("right.php");
	require_once("bottom.php");
?>