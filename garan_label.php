<?
	require_once("top.php");
	require_once("clase/garanLabel.php");
	require_once("functii/f_garan.php");

	$id_produs=isset($_GET["id_produs"]) ? $_GET["id_produs"] : "";
	$varianta=(isset($_GET["varianta"]) && $_GET["varianta"]=="complet")?"complet":"nested";

	if(!is_numeric($id_produs))
	{
		header("HTTP/1.0 404 Not Found");
		exit;
	}

	$arr=arrayFromDB(array("t_produse.warranty_months",
						   "t_produse.garan_eligible",
						   "t_produse.cod_produs",
						   "t_produse.id_prod",
						   "t_categorii.nume_cat"),
					 "t_produse LEFT JOIN t_categorii ON t_produse.id_prod=t_categorii.id_cat",
					 "WHERE t_produse.id_produs='".prepareStringToDB($id_produs)."'");

	$date_garan=garanPentruProdus($id_produs);
	$brand=(count($arr)==1 && trim($arr[0]["nume_cat"])!=="")?$arr[0]["nume_cat"]:(($date_garan!==null)?$date_garan["brand"]:"");
	$model=($date_garan!==null)?$date_garan["model"]:((count($arr)==1)?trim($arr[0]["cod_produs"]):"");

	if(count($arr)!=1 || (int)$arr[0]["garan_eligible"]!=1 || (int)$arr[0]["warranty_months"]<=24 || $brand==="" || $model==="")
	{
		header("HTTP/1.0 404 Not Found");
		exit;
	}

	$eticheta=new garanLabel();
	$produs=array("warranty_months"=>$arr[0]["warranty_months"],
				  "brand"=>$brand,
				  "model"=>$model);
	$svg=($varianta=="complet")?$eticheta->generatePrintSvg($produs):$eticheta->generateWebSvg($produs);

	if($svg===false)
	{
		header("HTTP/1.0 404 Not Found");
		exit;
	}

	header("Content-Type: image/svg+xml; charset=UTF-8");
	echo $svg;
	exit;
?>
