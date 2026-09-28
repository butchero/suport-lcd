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
	
	//@include-uri
	require_once("conectare.php");	
	require_once("functii/f_generale.php");
	require_once("clase/cos.php");
	
	$action=(isset($_GET['action'])?$_GET['action']:'');

	switch($action)
	{		
		//@adauga in cos
		case "addToCart":
			
			$id=$_POST['id'];
			
			if(!is_numeric($id))
			{
				echo "";
				break; 
			}			
						
			$sql="SELECT nume_produs, pret, descriere_produs FROM t_produse WHERE id_produs='".$id."'";
			$result=$mysqli->query($sql);
			$row=$result->fetch_array();
						
			$cos=new Cos();
			$adaugare=$cos->adaugaProdus($id, 1, $row['pret']);
			
			if(isAjax())
			{
				($adaugare['produs_nou']==1)?$esteNou=1:$esteNou=0;
			
				$subTotal=formateazaNr($cos->getSubTotal($id));
				$total=formateazaNr($cos->getTotal());
					
				$response= '{ "cartItemDetails" : [ 
							{ "title" : "'.$row['nume_produs'].'", 
							  "id" : "'.$id.'", 
							  "newPrice" : "'.$subTotal.'", 
							  "newQty" : "'.$adaugare['cantitate'].'", 
							  "total" : "'.$total.'", 
							  "isNew" : "'.$esteNou.'" } ]}';
				echo $response;
			}
			else
			{
				header("Location:".$_SERVER['HTTP_REFERER']);
			}
			
			break;
			
		//@scoate din cos
		case "removeFromCart":
		
			$id=(isset($_GET['id'])?$_GET['id']:$_POST['id']);
			
			$cos=new Cos();
			$cos->scoateProdus($id);

			if(isAjax())
				echo formateazaNr($cos->getTotal());
			else
				header("Location:".$_SERVER['HTTP_REFERER']);

			break;
		
		//@goleste cosul
		case "emptyCart":
		
			$cos=new Cos();
			$empty=$cos->golesteCos();

			if(isAjax())
				echo $empty;
			else
				header("Location:".$_SERVER['HTTP_REFERER']);

			break;				
	}
?>