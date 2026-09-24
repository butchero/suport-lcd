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
	require_once("../functii/f_catalog.php");
	require_once("../functii/f_links.php");
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@autorizare user logat
	require_once("autentificare.php");
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//template-ul care va fi folosit de smarty - variabila e folosita in bottom.php ($smarty->display($display_page);)
	$display_page="admin/utilizatori.tpl";	
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@toate judetele
	$arr_judete=arrayFromDBtoCombo("t_judete", "id_jud", "judet");

	//---------------------------------------------------------------------------------------------------------------------------------
	//@link inapoi pt editare user
	$_SESSION["link_inapoi_useri"]=$_SERVER["REQUEST_URI"];
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@mesaj confirmare stergere dupa executarea fisierului sterge_utilizator.php
	if($_GET["user_sters"]=="true")
		$mesaj="Utilizatorul a fost sters cu succes!";
	elseif($_GET["user_sters"]=="false")
		$mesaj="Utilizatorul nu a putut fi sters!";
		
	unset($_GET["user_sters"]);	
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@cautare
	if(isset($_REQUEST["cauta"]) || isset($_REQUEST["nume"]) || isset($_REQUEST["utilizator"]) || isset($_REQUEST["prenume"]) || isset($_REQUEST["judet"]))
	{		
		$nume=$_REQUEST["nume"];
		$prenume=$_REQUEST["prenume"];
		$utilizator=$_REQUEST["utilizator"];
		$judet=$_REQUEST["judet"];
		
		$sql_where="AND nume LIKE '%".prepareStringToDB($nume)."%' AND prenume LIKE '%".prepareStringToDB($prenume)."%' AND username LIKE '%".$utilizator."%'";
		
		if(is_numeric($judet) && !empty($judet))
			$sql_where.=" AND id_jud='".$judet."'";
			
		$link_sufix="&nume=".$nume."&prenume=".$prenume."&judet=".$judet."&utilizator=".$utilizator;
		
		if(isset($_REQUEST["flag"]) && $_REQUEST["flag"]==1)
		{
			$sql_where.=" AND flag='1'";
			$link_sufix.="&flag=1";
		}
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@paginare
	require_once("../clase/paginare.php");
		
	$paginare=new paginare("pag", 
						   "SELECT COUNT(id_user) AS nr FROM t_useri WHERE 1 ".$sql_where, 
						    URL_ADMIN."utilizatori.php?pag=".PATTERN.$link_sufix); 
	$paginare_string=$paginare->doPaginare();
	$nr_rezultate=$paginare->getNrRezultate(); 
	
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@selectare tranzactii (comenzi)
	$arr_useri=arrayFromDB(array("COUNT(id_comanda) AS nr_comenzi", "t_useri.*"),
						   "t_useri LEFT JOIN t_comenzi ON t_useri.id_user=t_comenzi.id_user",
						   "WHERE 1 ".$sql_where." GROUP BY id_user ORDER BY nr_comenzi DESC LIMIT ".$paginare->getLimitStart().", ".AFISARI_PE_PAG);
	
	if(is_array($arr_useri))
	{				    
		foreach($arr_useri as $key=>$value)
		{
			$useri[$key]["id_user"]=$value["id_user"];
			$useri[$key]["nume"]=$value["nume"];
			$useri[$key]["prenume"]=$value["prenume"];
			$useri[$key]["username"]=$value["username"];
			$useri[$key]["data_inregistrarii"]=date(DATA_FORMAT, $value["data_inregistrarii"]);
			$useri[$key]["nr_comenzi"]=$value["nr_comenzi"];
		}
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
		
	//@afisare erori/mesaje
	$smarty->assign("mesaj", $mesaj);
	
	//@judet selectat
	$smarty->assign("judet_selectat", $_REQUEST["judet"]);
	
	//@judete
	$smarty->assign("judete", $arr_judete);
	
	//@flag
	$smarty->assign("flag", $_REQUEST["flag"]);

	//@nume cautare
	$smarty->assign("nume", $nume);
	
	//@prenume cautare
	$smarty->assign("prenume", $prenume);
	
	//@username cautare
	$smarty->assign("utilizator", $utilizator);
	
	//@nr rezultate
	$smarty->assign("nr_rezultate", $nr_rezultate);
	
	//@useri
	$smarty->assign("useri", $useri);
	
	//@afisare paginare
	$smarty->assign("paginare", $paginare_string);
	
	//@parola acces admin -> user
	$smarty->assign("parola_admin_user", PAROLA_ADMIN_USER);

	require_once("right.php");
	require_once("bottom.php");
?>