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
	require_once("../clase/epayment/LiveUpdate.class.php");
	
	//------------------------------------------------------------------------------------------------------------------
	//@cheie secret pt tranzactii
	$myKey=SECRET_KEY;						
	$myLiveUpdate=new LiveUpdate($myKey);			

	//------------------------------------------------------------------------------------------------------------------
	//@cheie comerciant
	$myId=MERCHANT_ID;						
	$myLiveUpdate->setMerchant($myId);

	//------------------------------------------------------------------------------------------------------------------
	//@id comanda
	$myOrderRef=$id_comanda;
	$myLiveUpdate->setOrderRef($myOrderRef);
	
	//------------------------------------------------------------------------------------------------------------------
	//@data comenzii
	$myOrderDate=date("Y-m-d H:i:s");					
	$myLiveUpdate->setOrderDate($myOrderDate);

	//------------------------------------------------------------------------------------------------------------------
	//@adaugare produse
	
	//@nume produse
	$PName=array();
	
	//@cod produse (id-uri produse)
	$PCode=array();
	
	//@preturi produse
	$PPrice=array();
	
	//@cantitati produse
	$PQTY=array();
	
	//@tva produse
	$PVAT=array();
	
	foreach($produse as $produs)
	{
		$PName[]=$produs["nume_produs"];
		$PCode[]=$produs["id_produs"];
		$PPrice[]=($produs["pret"]*100)/109;
		$PQTY[]=$produs["cantitate"];
		$PVAT[]=(TVA==0)?19:TVA;
	}
	
	$myLiveUpdate->setOrderPName($PName);
	$myLiveUpdate->setOrderPCode($PCode);
	$myLiveUpdate->setOrderPrice($PPrice);
	$myLiveUpdate->setOrderQTY($PQTY);
	$myLiveUpdate->setOrderVAT($PVAT);
	
	//------------------------------------------------------------------------------------------------------------------
	//@transport
	$PShipping=$transport_cost;
	$myLiveUpdate->setOrderShipping($PShipping);
	
	//------------------------------------------------------------------------------------------------------------------
	//@test mode
	$myLiveUpdate->setTestMode(true);
	
	//------------------------------------------------------------------------------------------------------------------
	//@moneda
	$PCurrency="RON";
	$myLiveUpdate->setPricesCurrency($PCurrency);
	
	//------------------------------------------------------------------------------------------------------------------
	//@nu stiu
	$PPayMethod="CCVISAMC";
	$myLiveUpdate->setPayMethod($PPayMethod);
	
	//------------------------------------------------------------------------------------------------------------------
	//@adresa de facturare
	$billing=array(
		"billFName"=>$arr_user[0]["nume"],
		"billLName"=>$arr_user[0]["prenume"],
		"billCISerial"=>"",
		"billCINumber"=>"",
		"billCIIssuer"=>"",
		"billCNP"=>$arr_user[0]["cnp"],
		"billCompany"=>"",
		"billFiscalCode"=>"",
		"billRegNumber"=>"",
		"billBank"=>"",
		"billBankAccount"=>"",
		"billEmail"=>$arr_user[0]["email"],
		"billPhone"=>$arr_user[0]["telefon"],
		"billFax"=>$arr_user[0]["fax"],
		"billAddress1"=>$user_adresa_livrare["adresa"],
		"billAddress2"=>'',
		"billZipCode"=>$arr_user[0]["cod_postal"],
		"billCity"=>$arr_user[0]["localitate"],
		"billState"=>$arr_judete[$arr_user[0]["id_jud"]],
		"billCountryCode"=>"RO"
	);
	
	$myLiveUpdate->setBilling($billing);
	
	//------------------------------------------------------------------------------------------------------------------
	//@adresa de livrare	
	$delivery=array(
		"deliveryFName"=>"",
		"deliveryLName"=>"",
		"deliveryCompany"=>"",
		"deliveryPhone"=>$arr_user[0]["telefon"],
		"deliveryAddress1"=>$user_adresa_livrare["adresa"],
		"deliveryAddress2"=>"",
		"deliveryZipCode"=>$user_adresa_livrare["cod_postal"],
		"deliveryCity"=>$user_adresa_livrare["localitate"],
		"deliveryState"=>$arr_judete[$user_adresa_livrare["id_jud"]],
		"deliveryCountryCode"=>"RO"
	);
	
	$myLiveUpdate->setDelivery($delivery);
	
	//------------------------------------------------------------------------------------------------------------------
	//@limba
	$PLanguage="ro";
	$myLiveUpdate->setLanguage($PLanguage);

	$formular="<form name='f_online_payment' id='f_online_payment' action='".$myLiveUpdate->liveUpdateURL."' method='POST'>".
				$myLiveUpdate->getLiveUpdateHTML().
				"<input type='submit'>".
			  "</form>";
			  
	$smarty->assign("formular", $formular);		  
?>