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
	//-----------------------------------------------------------------------------------------------------------------------------
	$pdf_factura_fiscala=new PDF("P", "mm", "A4");
	$pdf_factura_fiscala->AliasNbPages();
	$pdf_factura_fiscala->AddPage();
							
	//-----------------------------------------------------------------------------------------------------------------------------
	//@date cumparator			
	if($arr_comanda[0]["tip_factura"]==1) //facturare pe persoana juridica
	{
		$pdf_factura_fiscala->cumparator=$arr_user[0]["societate"];
		$pdf_factura_fiscala->nr_reg_comert=$arr_user[0]["nr_reg_comert"];
		$pdf_factura_fiscala->cui=$arr_user[0]["cod_fiscal"];
		$pdf_factura_fiscala->contul=$arr_user[0]["cod_iban"];
		$pdf_factura_fiscala->banca=$arr_user[0]["banca"];
		$pdf_factura_fiscala->tip_facturare=1;
	}
	else //facturare pe persoana fizica
	{	
		$pdf_factura_fiscala->cumparator=$arr_user[0]["nume"]." ".$arr_user[0]["prenume"];
		$pdf_factura_fiscala->nr_reg_comert="-";
		$pdf_factura_fiscala->cui="CNP: ".$arr_user[0]["cnp"];
		$pdf_factura_fiscala->contul="-";
		$pdf_factura_fiscala->banca="-";
		$pdf_factura_fiscala->tip_facturare=0;
	}
	
	$pdf_factura_fiscala->adresa=$arr_user[0]["localitate"]." ".$arr_user[0]["adresa"];
	$pdf_factura_fiscala->judetul=$arr_judete[$arr_user[0]["id_jud"]];
	
	//@info client
	$pdf_factura_fiscala->nume_prenume=$arr_user[0]["nume"]." ".$arr_user[0]["prenume"];
	$pdf_factura_fiscala->societate=$arr_user[0]["societate"];
	$pdf_factura_fiscala->telefon=$arr_user[0]["telefon"];
	$pdf_factura_fiscala->telefon_mobil=$arr_user[0]["telefon_mobil"];
	$pdf_factura_fiscala->fax=$arr_user[0]["fax"];
	$pdf_factura_fiscala->email=$arr_user[0]["email"];
	$pdf_factura_fiscala->cod_postal=$arr_user[0]["cod_postal"];
	$pdf_factura_fiscala->localitate=$arr_user[0]["localitate"];
	
	$user_adresa_livrare=unserialize($arr_comanda[0]["alta_adresa_livrare"]);
	
	$pdf_factura_fiscala->alta_adresa=array("adresa"=>$user_adresa_livrare["adresa"], 
							"cod_postal"=>$user_adresa_livrare["cod_postal"],
							"localitate"=>$user_adresa_livrare["localitate"],
							"judet"=>$arr_judete[$user_adresa_livrare["id_jud"]]);
							
	$pdf_factura_fiscala->comentariu_comanda=$arr_comanda[0]["comentariu_comanda"];						
				
	foreach($arr_produse as $key=>$value)
	{
		$nume_produs=$value["nume_produs"];
		$pret_produs=$value["pret"];
		
		//@adaug produs in pdf
		$pdf_factura_fiscala->adaugaProdus($nume_produs, $value["cantitate"], $pret_produs, $value["id_produs"]); //(nume_produs, cantitate, pret_unitar_fara_tva, id_produs)
		
		//@adaug discount produs in pdf
		if(!empty($value["discount"]) && $value["discount"]!=0 && $discount==1) //am facut verificare cu !=0, pt ca 0.000 nu e considerat empty()
		{
			$nume_produs="X - Discount ".$value["discount"]."% - ".$value["nume_produs"];
			$pret_produs=-(($value["pret"] * $value["discount"])/100);
			
			$pdf_factura_fiscala->adaugaProdus($nume_produs, $value["cantitate"], $pret_produs, $value["id_produs"]); //(nume_produs, cantitate, pret_unitar_fara_tva, id_produs)
		}
	}
	
	//-----------------------------------------------------------------------------------------------------------------------------
	//@adaug transportul
	$arr_transport=arrayFromDB("*", "t_transport", "WHERE id_transport='".$arr_comanda[0]["id_transport"]."'");
		
	$transport_cost=$arr_transport[0]["cost"];
	$transport=$arr_transport[0]["nume_transport"];
	
	$pdf_factura_fiscala->transport=$transport;
	$pdf_factura_fiscala->transport_cost=$transport_cost;
		
	$pdf_factura_fiscala->genereazaHeaderProforma(true);	
	$pdf_factura_fiscala->genereazaTabel();
	//$pdf_factura_fiscala->genereazaInfoClient();

	//-----------------------------------------------------------------------------------------------------------------------------
	//@salvez factura_fiscala
	$factura_fiscala_pdf=URL_BASE_ABS."proforme/".md5($arr_user[0]["data_inregistrarii"].$arr_user[0]["id_user"])."/factura_fiscala_".$id_comanda.".pdf";
	$pdf_factura_fiscala->Output($factura_fiscala_pdf);
?>