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
	require_once("../configurare.php");
	require_once("../conectare.php");

	/* Internet Payment Notification */
	
	$pass		= SECRET_KEY;	/* pass to compute HASH */
	$result		= ""; 				/* string for compute HASH for received data */
	$return		= ""; 				/* string to compute HASH for return result */
	$signature	= $_POST["HASH"];	/* HASH received */
	$body		= "";

	/* read info received */
	ob_start();
	
	foreach($_POST as $key => $val)
	{
		$$key=$val;
	
		/* get values */
		if($key != "HASH")
		{
			if(is_array($val))
			{
				$result .= ArrayExpand($val);
			}
			else
			{
				$size		= strlen(StripSlashes($val));
				$result	.= $size.StripSlashes($val);
			}
		}
	}
	
	$body = ob_get_contents();
	ob_end_flush();
	
	$date_return = date("YmdGis");
	
	$return = strlen($_POST["IPN_PID"][0]).$_POST["IPN_PID"][0].strlen($_POST["IPN_PNAME"][0]).$_POST["IPN_PNAME"][0];
	$return .= strlen($_POST["IPN_DATE"]).$_POST["IPN_DATE"].strlen($date_return).$date_return;
	
	function ArrayExpand($array)
	{
		$retval = "";
		
		for($i = 0; $i < sizeof($array); $i++)
		{
			$size		= strlen(StripSlashes($array[$i]));
			$retval	.= $size.StripSlashes($array[$i]);
		}
	
		return $retval;
	}
	
	function hmac ($key, $data)
	{
	   $b = 64; // byte length for md5
	   if (strlen($key) > $b) 
	   {
	       $key = pack("H*", md5($key));
	   }
	   $key  = str_pad($key, $b, chr(0x00));
	   $ipad = str_pad('', $b, chr(0x36));
	   $opad = str_pad('', $b, chr(0x5c));
	   $k_ipad = $key ^ $ipad ;
	   $k_opad = $key ^ $opad;
	   
	   return md5($k_opad  . pack("H*",md5($k_ipad . $data)));
	}
	
	$hash =  hmac($pass, $result); /* HASH for data received */
	
	$body .= $result."\r\n\r\nHash: ".$hash."\r\n\r\nSignature: ".$signature."\r\n\r\nReturnSTR: ".$return;
	
	if($hash == $signature)
	{
		echo "Verified OK!";
	
	    /* ePayment response */
	    $result_hash =  hmac($pass, $return);
		echo "<EPAYMENT>".$date_return."|".$result_hash."</EPAYMENT>";
	
	    /* Begin automated procedures (START YOUR CODE)*/
	    $mysqli->query("UPDATE t_comenzi SET comanda_achitata='1' WHERE id_comanda='".$_POST['REFNOEXT']."'");
	}
	else
	{
	    /* warning email */
		mail("valeriuciuca@gogo.ro", "BAD IPN Signature", $body, "");
	}
?>