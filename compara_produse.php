<?
	/*
	 *****************************************************************************
	 *****************************************************************************
	 **                                                                         **
	 **          CIUCA VALERIU (BUTCHER) - GOGO PROMOTIONS - 2007       		**
	 **                                                                         **
	 *****************************************************************************
	 *****************************************************************************
	*/
	//--------------------------------------------------------------------------------------------------------------------------
	//@include-uri
	require_once("conectare.php");
	require_once("configurare.php");	
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@include-uri functii
	require_once("functii/f_securitate.php");
	require_once("functii/f_bd.php");
	require_once("functii/f_catalog.php");
	require_once("functii/f_generale.php");
	require_once("functii/f_links.php");
		
	//--------------------------------------------------------------------------------------------------------------------------
	//@incarc configurari aditionale
	require_once("init.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@smarty
	require_once("smarty_connect.php");
	
	//@include-uri clase	
	require_once("clase/cursValutar.php");	
	
	//@cursul valutar pt ziua curenta
	$curs=new cursValutar();
	$arr_curs=$curs->getCurs();		
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@actiune stergere produs din lista de comparare
	foreach($_GET as $key=>$value)
	{
		if(strpos($key, "sterge")!==false)
		{
			$id=str_replace("sterge", "", $key);
			
			if(is_numeric($id) && $id!="")
			{
				$id_produs_de_sters=$id;
			}
		}
	}

	//--------------------------------------------------------------------------------------------------------------------------
	//@filtre (caracteristici produs)
	$arr_filtre=arrayFromDB("*", "t_filtre", "WHERE id_cat=".$_GET["id_cat"]." ORDER BY id_filtru ASC"); 
	$nr_filtre=count($arr_filtre);
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@select producatori
	$arr_producatori=arrayFromDB(array("DISTINCT(t_produse.id_prod)", "nume_cat", "link_cat"),
								 "t_produse LEFT JOIN t_categorii ON t_produse.id_prod=t_categorii.id_cat",
								 "WHERE t_produse.id_cat='".$_GET["id_cat"]."' AND nume_cat!='' GROUP BY t_produse.id_prod");
							
	//@array smarty friendly cu producatorii
	$producatori_combo[0]="Oricare";
	$nr_producatori=count($arr_producatori);
	
    for($i=0;$i<$nr_producatori;$i++)
    {							 
		$producatori_combo[$arr_producatori[$i]["id_prod"]]=$arr_producatori[$i]["nume_cat"];
    }
    
    //--------------------------------------------------------------------------------------------------------------------------
    //@produse din get pe masura ce se adauga/sterg
    $k=0;
    $id_produse=$id_producatori=array();
    
    for($i=0;$i<NR_PRODUSE_DE_COMPARAT;$i++)
    {
    	if(is_numeric($_GET["id_produs".$i]) && $_GET["id_produs".$i]!="")
    	{
    		//nu mai adauga produsul in array daca este egal cu id-ul de stergere
    		if((is_numeric($id_produs_de_sters) && $id_produs_de_sters!=$i) || !isset($id_produs_de_sters))
    		{
    			$id_produse[$k]=$_GET["id_produs".$i];
				$id_producatori[$k]=$_GET["id_producator".$i];
				
				$form_action.="&id_produs".$k."=".$_GET["id_produs".$i]."&id_producator".$k."=".$_GET["id_producator".$i];
				$k++;
    		}
    	}
    }
	
    //--------------------------------------------------------------------------------------------------------------------------
    //LOOP PRIN PRODUSELE CE TREBUIESC COMPARATE        
    for($i=0;$i<count($id_produse);$i++)
    {
    	//----------------------------------------------------------------------------------------------------------------------
    	//@produse pt fiecare combobox filtrate in fct de producator
    	$sql_where_producator=((is_numeric($id_producatori[$i]) && !empty($id_producatori[$i])))?" AND id_prod='".$id_producatori[$i]."'":"";
    	
    	$arr_produse=arrayFromDB(array("id_produs", "nume_produs"),
    				 		     "t_produse",
    							 "WHERE t_produse.id_cat='".$_GET["id_cat"]."'".$sql_where_producator);
		    	
    	unset($arr_produse_combo);
    	$nr_produse=count($arr_produse);
    	
    	for($k=0;$k<$nr_produse;$k++)
    	{
    		$arr_produse_combo[$arr_produse[$k]["id_produs"]]=stringLimit($arr_produse[$k]["nume_produs"], 40);
    	}
    	
    	//----------------------------------------------------------------------------------------------------------------------
    	//@produs
    	$arr_produs=arrayFromDB("*",
    							"t_produse LEFT JOIN t_categorii ON t_produse.id_cat=t_categorii.id_cat",
    							"WHERE id_produs='".$id_produse[$i]."'");
    							
		//----------------------------------------------------------------------------------------------------------------------
		//@caracteristici produs
		unset($caracteristici);
		$val_carac=explode(";", $arr_produs[0]["caracteristici"]);
		
		for($j=0;$j<$nr_filtre;$j++)
		{
			$caracteristici[$j]=array("nume_carac"=>$arr_filtre[$j]["nume_filtru"],
									  "val_carac"=>(empty($val_carac[$j+1]))?"-":$val_carac[$j+1]);
		}    							

		//-------------------------------------------------------------------------------------------------------------------------
		//@array asociativ cu detaliile produsului	   
		$produse_de_comparat[$i]=array("produse_combo"=>$arr_produse_combo,
									   "producator_selectat"=>$id_producatori[$i],									   
									   "produs_selectat"=>$id_produse[$i],
									   "nume_produs"=>$arr_produs[0]["nume_produs"],
									   "adresa_poza_produs"=>getPozaPrincipalaProdus($id_produse[$i])."?".time(),
									   "pret_produs"=>formateazaNr($arr_produs[0]["pret"]*TVA),
									   "pret_vechi"=>($arr_produs[0]["pret_vechi"]!="")?formateazaNr($arr_produs[0]["pret_vechi"]*TVA):"",
									   "popup_js"=>getConvertorValutar($arr_produs[0]["pret"]),
									   "link_produs"=>getLinkProdus($arr_produs[0]["link_cat"], $arr_produs[0]["nume_produs"], $arr_produs[0]["id_produs"]),
									   "caracteristici"=>$caracteristici);    								   
    }
    
    
    //--------------------------------------------------------------------------------------------------------------------------
    //ADAUGARE PRODUS NOU PT COMPARARE
    
    //@id producator selectat pt combobox-ul de adaugare produs nou
    $id_producator_selectat_combo_nou=$_GET["id_producator".count($id_produse)];
    
    //----------------------------------------------------------------------------------------------------------------------
    //@produse pt combobox-ul de adaugare produs nou, filtrate in fct de producator
    $sql_where_producator=((is_numeric( $id_producator_selectat_combo_nou) && !empty($id_producator_selectat_combo_nou)))?" AND id_prod='". $id_producator_selectat_combo_nou."'":"";
    
    $arr_produse=arrayFromDB(array("id_produs", "nume_produs"),
    				 		 "t_produse",
    						 "WHERE t_produse.id_cat='".$_GET["id_cat"]."'".$sql_where_producator);
		
    $nr_produse=count($arr_produse);
    	
    for($k=0;$k<$nr_produse;$k++)
    	$arr_produse_combo_nou[$arr_produse[$k]["id_produs"]]=stringLimit($arr_produse[$k]["nume_produs"], 40);  
   
    //--------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY

	//@producatori combobox
    $smarty->assign("producatori", (count($producatori_combo)>1)?$producatori_combo:"");
    
    //@produse de comparat
    $smarty->assign("produse", $produse_de_comparat);
    
    //@categorie din care o sa fie afisate produsele in combo
    $smarty->assign("id_cat", $_GET["id_cat"]);
    
    //@filtre(caracteristici)
    $smarty->assign("filtre", $arr_filtre);
    
    //@nr max de produse de comparat
    $smarty->assign("nr_produse_de_comparat", NR_PRODUSE_DE_COMPARAT);
    
    //@produse combobox pt adaugare de produs nou
    $smarty->assign("produse_combo_nou", $arr_produse_combo_nou);
    
    //@producatorul selectat din combobox-ul pt adaugarea unui produs nou
    $smarty->assign("producator_selectat_combo_nou", $id_producator_selectat_combo_nou);
    
    //@actiune formular
    $smarty->assign("form_action", URL_BASE."compara_produse.php?id_cat=".$_GET["id_cat"].$form_action);
    
    //@nume firma
    $smarty->assign("NUME_FIRMA", NUME_FIRMA);

	$smarty->display("compara_produse.tpl");
?>