<?		
	/*
    *****************************************************************************
	*****************************************************************************
	**                                                                         **
	**          CIUCA VALERIU (BUTCHER) - GOGO PROMOTIONS - 2008       		   **
	**                                                                         **
	*****************************************************************************
	*****************************************************************************
	*/
	$id_comanda=$_GET["id_comanda"];
	
	$arr_comanda=arrayFromDB("*", "t_comenzi LEFT JOIN t_useri ON t_comenzi.id_user=t_useri.id_user", "WHERE t_comenzi.id_comanda='".$id_comanda."'");
	$arr_judete=arrayFromDBtoCombo("t_judete", "id_jud", "judet");			
	$arr_transport=arrayFromDB("*", "t_transport", "WHERE id_transport='".$arr_comanda[0]["id_transport"]."'");
	
	$transport=$arr_transport[0]["cost"];

	if(!empty($arr_comanda[0]["alta_adresa_livrare"]))
	{
		$mesaj="<br /><span style='color:red'>Clientul a ales alta adresa de livrare. Va rugam sa editati buletinul manual cu datele corecte!</span>";
	}
	
	$valoare_lei=1;
	$ramburs_lei=$arr_comanda[0]["total_comanda"]+$transport;
	$destinatar=$arr_comanda[0]["nume"]." ".$arr_comanda[0]["prenume"];
	$telefon=$arr_comanda[0]["telefon"];
	$strada=$arr_comanda[0]["strada"];
	$nr=$arr_comanda[0]["strada_nr"];
	$bloc=$arr_comanda[0]["bloc"];
	$scara=$arr_comanda[0]["scara"];
	$etaj=$arr_comanda[0]["etaj"];
	$apartament=$arr_comanda[0]["apartament"];
	$cod_postal=$arr_comanda[0]["cod_postal"];
	$localitate=$arr_comanda[0]["localitate"];
	$judet=$arr_judete[$arr_comanda[0]["id_jud"]];		
	
	$expeditor="SC Nemira & CO SRL";
	$telefon_exp="0212241428";
	$strada_exp="C.P. 23 O.P. 83";
	$nr_strada_exp="";
	$bloc_exp="";
	$scara_exp="";
	$et_exp="";
	$ap_exp="";
	$sector_exp="1";
	$cod_postal_exp="";
	$localitate_exp="Constanta";
	$judet_exp="Bucuresti";
	$mail_exp="office@nemira.ro";
?>		