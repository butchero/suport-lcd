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
	session_name("admin");
	session_start();
	
	//@include-uri
	require_once("../conectare.php");	
	require_once("../configurare.php");
	require_once("../functii/f_bd.php");
	require_once("../functii/f_admin.php");	
	require_once("../functii/f_catalog.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@autorizare user logat
	require_once("autentificare.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@print la 2 combobox-uri multiple: unul cu filtre grupate in grupul $id_grup, celalalt cu filtrele ramase negrupate
	if(!empty($_GET["id_grup"]) && is_numeric($_GET["id_grup"]) && !empty($_GET["id_cat"]) && is_numeric($_GET["id_cat"]))
	{
		$id_grup=$_GET["id_grup"];
		$id_cat=$_GET["id_cat"];
	
		//----------------------------------------------------------------------------------------------------------------------	
		//@selectez filtrele care sunt deja grupate in grupul $id_grup
		$arr_filtre_grupate=arrayFromDB(array("c.id_filtru AS id_filtru", "c.nume_filtru AS nume_filtru"),
										"t_relatii_cat_filtre AS a INNER JOIN t_categorii_filtre AS b ON a.id_cat_filtru=b.id_cat_filtru
																   INNER JOIN t_filtre AS c ON a.id_filtru=c.id_filtru",
										"WHERE b.id_cat_filtru='".$id_grup."' ORDER BY a.id_relatie ASC");
										
		$block1="<select name='filtre_grupate[]' id='filtre_grupate' class='select' size='15' multiple style='width:250px'>";
		
		if(is_array($arr_filtre_grupate))
		{
			foreach($arr_filtre_grupate as $key=>$value)
				$block1.="<option value='".$value["id_filtru"]."'>".$value["nume_filtru"]."</option>";
		}
		
		$block1.="</select>";
		
		//----------------------------------------------------------------------------------------------------------------------	
		//@selectez filtrele care au ramas negrupate
		$arr_filtre_negrupate=arrayFromDB(array("a.id_filtru AS id_filtru", "a.nume_filtru AS nume_filtru"),
										  "t_filtre AS a LEFT JOIN t_relatii_cat_filtre AS b ON a.id_filtru=b.id_filtru",
										  "WHERE id_relatie IS NULL  AND a.id_cat='".$id_cat."'");
										
		$block2="<select name='filtre_disponibile[]' id='filtre_disponibile' class='select' size='15' multiple style='width:250px'>";
		
		if(is_array($arr_filtre_negrupate))
		{
			foreach($arr_filtre_negrupate as $key=>$value)
				$block2.="<option value='".$value["id_filtru"]."'>".$value["nume_filtru"]."</option>";
		}
		
		$block2.="</select>";
		
		print $block1.PATTERN.$block2;
	}
?>