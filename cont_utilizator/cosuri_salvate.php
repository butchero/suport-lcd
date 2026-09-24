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
	require_once("../top.php");
	require_once("../left.php");
	require_once("../right.php");
	require_once("../functii/f_catalog.php");		
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@autorizare user logat
	require_once("autentificare.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//template-ul care va fi folosit de smarty - variabila e folosita in bottom.php ($smarty->display($display_page))
	$display_page="cont_utilizator/cosuri_salvate.tpl";
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@titlu pagina
	$titlu_pagina="Cosuri salvate";
		
	//--------------------------------------------------------------------------------------------------------------------------
	//@daca nu am produse in cos, butonul de salveaza cos este dezactivat
	(count($_SESSION["cos_cumparaturi"])>0)?$salveaza_cos=1:$salveaza_cos=0;
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@actiune salvare cos
	if(isset($_POST["nume_cos"]) && !empty($_POST["nume_cos"]))
	{
		$arr_cos_salvat=arrayFromDB(array("id_cos"), "t_cosuri_salvate", "WHERE nume_cos='".prepareStringToDB($_POST["nume_cos"])."'");
		
		//@verific daca mai exista vreun cos cu numele dat pt userul logat
		if(count($arr_cos_salvat)==1)
		{
			$cos_check=array("valid"=>0, "eroare"=>"Exista deja un cos cu numele acesta!", "camp"=>$_POST["nume_cos"]);
		}
		else 
		{
			//@salveaza cos
			$id_cos_salvat=arrayInsertToDB("t_cosuri_salvate",
										   array("id_user", "nume_cos", "data_salvarii"),
										   array($_SESSION["id_user"], $_POST["nume_cos"], time()));
			
			//@salveaza produsele din cos (produse e definit in right.php)					   
			foreach($produse as $value)
			{
				arrayInsertToDB("t_produse_cos_salvat",
								 array("id_produs", "cantitate", "id_cos"),
								 array($value["id_produs"], $value["cantitate"], $id_cos_salvat));
			}
			
			$cos_check=array("valid"=>1, "eroare"=>"Cosul a fost salvat!", "camp"=>"");
		}
	}
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@actiune stergere cos salvat
	if(isset($_POST["sterge_cos"]) && is_numeric($_POST["id_cos"]))
	{
		$stergere_cos_check=arrayFromDB(array("id_cos"),
									    "t_cosuri_salvate",
									    "WHERE id_cos='".$_POST["id_cos"]."' AND id_user='".$_SESSION["id_user"]."'");
		
		//@verific daca cosul apartine utilizatorului logat
		if(count($stergere_cos_check)==1)
		{									    			
			arrayDeleteFromDB("t_cosuri_salvate", array("id_cos", "id_user"), array($_POST["id_cos"], $_SESSION["id_user"]));
			arrayDeleteFromDB("t_produse_cos_salvat", array("id_cos"), array($_POST["id_cos"]));
			
			$cos_check=array("valid"=>1, "eroare"=>"Cosul a fost sters!", "camp"=>"");
		}
		else 
		{
			$cos_check=array("valid"=>1, "eroare"=>"Cosul nu a putut fi sters!", "camp"=>"");
		}
	}
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@actiune incarcare cos salvat
	if(isset($_POST["incarca_cos"]) && is_numeric($_POST["id_cos"]))
	{
		$incarca_cos_check=arrayFromDB(array("id_cos"),
									    "t_cosuri_salvate",
									    "WHERE id_cos='".$_POST["id_cos"]."' AND id_user='".$_SESSION["id_user"]."'");
		
		//@verific daca cosul apartine utilizatorului logat
		if(count($incarca_cos_check)==1)
		{									    									
			$arr_produse_cos_salvat=arrayFromDB(array("t_produse.id_produs", "t_produse_cos_salvat.cantitate", "t_produse.pret"),
												"t_produse_cos_salvat INNER JOIN t_produse ON t_produse_cos_salvat.id_produs=t_produse.id_produs",
					 							"WHERE id_cos='".prepareStringToDB($_POST["id_cos"])."'");
			
			$cos->golesteCos();
				 							
			foreach($arr_produse_cos_salvat as $key=>$value)
			{
				$cos->adaugaProdus($value["id_produs"], $value["cantitate"], $value["pret"]);				
			}
			
			header("Location:".URL_BASE."contul-meu/cosuri-salvate?cos_incarcat=1");
		}
		else 
		{
			$cos_check=array("valid"=>1, "eroare"=>"Cosul nu a putut fi incarcat!", "camp"=>"");
		}
	}	
	($_GET["cos_incarcat"]==1)?$cos_check=array("valid"=>1, "eroare"=>"Cosul a fost incarcat!", "camp"=>""):"";
		
	//--------------------------------------------------------------------------------------------------------------------------
	//@afisare cosuri existente	
	$arr_cosuri=arrayFromDB(array("id_cos", "nume_cos", "data_salvarii"),
						    "t_cosuri_salvate",
						    "WHERE id_user='".$_SESSION["id_user"]."' ORDER BY id_cos DESC");
	
	$j=0;	
	if(is_array($arr_cosuri))
	{				    
		foreach($arr_cosuri as $key=>$value)
		{
			$arr_produse_cos_salvat=arrayFromDB(array("t_produse.id_produs", "cantitate", "nume_produs", "pret", "link_cat"),
										 		"t_produse_cos_salvat LEFT JOIN t_produse ON t_produse_cos_salvat.id_produs=t_produse.id_produs
														  	   		  LEFT JOIN t_categorii ON t_produse.id_cat=t_categorii.id_cat",
										 		"WHERE t_produse_cos_salvat.id_cos='".$value["id_cos"]."' AND t_categorii.activ='1'");
			
			$nr_produse_cos_salvat=count($arr_produse_cos_salvat);
			
			for($i=0;$i<$nr_produse_cos_salvat;$i++)
			{					
				//@poza produs
				$adresa_poza=getPozaPrincipalaMicaProdus($arr_produse_cos_salvat[$i]["id_produs"]);
						
				//@produsele din cos
				$produse_cos_salvat[$i]=array("nume_produs"=>$arr_produse_cos_salvat[$i]["nume_produs"],
									   		  "link_produs"=>getLinkProdus($arr_produse_cos_salvat[$i]["link_cat"], $arr_produse_cos_salvat[$i]["nume_produs"], $arr_produse_cos_salvat[$i]["id_produs"]),
									   		  "poza_produs"=>$adresa_poza,
									   		  "cantitate"=>$arr_produse_cos_salvat[$i]["cantitate"],
									   		  "pret_unitar"=>formateazaNr($arr_produse_cos_salvat[$i]["pret"]),
									   		  "pret_total"=>formateazaNr($arr_produse_cos_salvat[$i]["pret"]*$arr_produse_cos_salvat[$i]["cantitate"]*TVA));
			}
		
			//@array cu numele cosului, data salvarii si produsele asociate acestuia	
			$cosuri[$j]=array("id_cos"=>$value["id_cos"],
							  "nume_cos"=>$value["nume_cos"],
							  "data_salvarii"=>date(DATA_FORMAT, $value["data_salvarii"]),
							  "produse"=>$produse_cos_salvat);
							
			unset($arr_produse_cos_salvat, $produse_cos_salvat, $adresa_poza);				
			$j++;		
		}
	}
	
	//--------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	
	//@daca nu am produse in cos, butonul de salveaza cos este dezactivat
	$smarty->assign("salveaza_cos", $salveaza_cos);

	//@verificari pt formularul de salvare cos
	$smarty->assign("cos_check", $cos_check);
		
	//@afisare cosuri salvate
	$smarty->assign("cosuri", $cosuri);
	
	require_once("../bottom.php");
?>