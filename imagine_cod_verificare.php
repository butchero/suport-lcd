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
	session_name("shop");
	session_start();
	
	header("Content-type: image/png");
	
	require_once("configurare.php");
	
	$string=$_SESSION['cod_verificare'];
	
	$im=imagecreatefrompng(DIR_TEMPLATE_ABS."img/cod_verificare.png");
	$orange=imagecolorallocate($im, 234, 0, 0);
	$px=(imagesx($im)-7.5*strlen($string))/2;
	
	imagestring($im, 5, $px, 15, $string, $orange);
	
	imagepng($im);
	imagedestroy($im);
?>