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
	//----------------------------------------------------------------------------------------------------------------------
	//@tab selectat
	$tab_selectat="comentarii";
		
	$insert_ok=0;
	
	//----------------------------------------------------------------------------------------------------------------------
	//@verific daca user-ul logat nu are deja un comentariu/rating pt produs
	if(isset($_SESSION["id_user"]) && is_numeric($_SESSION["id_user"]))
	{
		$arr_check_comentariu=arrayFromDB(array("id_comentariu"),
										  "t_comentarii",
										  "WHERE id_user='".$_SESSION["id_user"]."' AND id_produs='".$id_produs."'");
		$nr_user_comentarii=count($arr_check_comentariu);								
	}

	//----------------------------------------------------------------------------------------------------------------------
	//@adaugare comentariu
	if($_POST["comentariu"]!="" && is_numeric($_POST["rating"]) && $_POST["titlu"]!="" && is_numeric($_SESSION["id_user"]) && $nr_user_comentarii==0)
	{
		arrayInsertToDB("t_comentarii", 
					    array("id_produs", "id_user", "titlu_comentariu", "comentariu", "rating", "data_adaugarii", "activ"),
						array($id_produs, $_SESSION["id_user"], strip_tags($_POST["titlu"]), nl2br(strip_tags($_POST["comentariu"])), $_POST["rating"], time(), 0));

		$insert_ok=1;					
	}
	
	//----------------------------------------------------------------------------------------------------------------------
	//@paginare comentarii		  
	require_once("clase/paginare.php");
	
	$paginare=new paginare("pag",
						   "SELECT COUNT(*) AS nr FROM t_comentarii WHERE id_produs='".$arr_produs[0]["id_produs"]."' AND activ='1'",
						   $link_produs."/comentarii/p".PATTERN."#down",
						   COMENTARII_PRODUS_PE_PAG);
				
	$paginare_string_comentarii=$paginare->doPaginare();
	
	$arr_comentarii_temp=arrayFromDB(array("id_comentariu", "titlu_comentariu", "comentariu", "rating", "data_adaugarii", "username"),
									 "t_comentarii LEFT JOIN t_useri ON t_comentarii.id_user=t_useri.id_user",
									 "WHERE id_produs='".$id_produs."' AND activ='1' ORDER BY id_comentariu DESC LIMIT ".$paginare->getLimitStart().", ".COMENTARII_PRODUS_PE_PAG);
	
	$nr_comentarii=count($arr_comentarii_temp);
									 
	for($i=0;$i<$nr_comentarii;$i++)
	{												
		$arr_comentarii[$i]=array("id_comentariu"=>$arr_comentarii_temp[$i]["id_comentariu"],
								  "titlu_comentariu"=>$arr_comentarii_temp[$i]["titlu_comentariu"],
								  "comentariu"=>$arr_comentarii_temp[$i]["comentariu"],
								  "rating"=>array("1"=>$arr_comentarii_temp[$i]["rating"], "2"=>RATING_MAX-$arr_comentarii_temp[$i]["rating"]),
								  "autor"=>$arr_comentarii_temp[$i]["username"],
								  "data_adaugarii"=>date(DATA_FORMAT, $arr_comentarii_temp[$i]["data_adaugarii"]));
	}
	
	//----------------------------------------------------------------------------------------------------------------------
	//@array pt combobox rating
	for($i=1;$i<=RATING_MAX;$i++)
		$arr_rating[$i]=$i;	
?>