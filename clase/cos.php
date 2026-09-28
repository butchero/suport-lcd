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
	//--------------------------------------------------------------------------------------------------------------------------
	/*
		@Class: cos cumparaturi		
		-vars: 
		-metode: adaugaProdus($id, cantitate, pret) 
		                     (adauga/actualizeaza sesiunea cu produsul adaugat si returneaza un array 
		                      daca produsul este nou si cantitatea actualizata)
		         scoateProdus($id) (scoate produs din cos(sesiune) dupa id)
		         getProduseCos() (returneaza un array cu toate produsele din cos(sesiune) si caracteristici: 
		         					- id_produs,
		         					- nume_produs,
		         					- pret+tva,
		         					- cantitate)  
		         golesteCos() (sterge cosul(sesiune))		
		         getSubTotal($id) (get subtotal produs (pret*cantitate))
		         getTotal() (get cos total)			        
	*/	
	//--------------------------------------------------------------------------------------------------------------------------
	class Cos 
	{
		//@constructor
		function __construct()
		{
			if(!isset($_SESSION["cos_cumparaturi"]))
				$_SESSION["cos_cumparaturi"]=array();			
		} 
		
		//@adaug un produs in cos
		function adaugaProdus($id, $qty, $price)
		{
			//@daca exista deja incrementez cantitatea
			if(array_key_exists($id, $_SESSION["cos_cumparaturi"]))
			{
				//@produsul exista deja in cos
				$produs_nou=0;						

				//@cantitatea existenta + $qty			
				$cantitate=$_SESSION["cos_cumparaturi"][$id]["cantitate"]+$qty;
				
				$_SESSION["cos_cumparaturi"][$id]["cantitate"]=$cantitate;
			}
			else
			{
				//@produsul e adaugat prima data in cos
				$produs_nou=1;
				
				//@cantitate	
				$cantitate=$qty;	
								
				$_SESSION["cos_cumparaturi"][$id]["cantitate"]=$cantitate;
				$_SESSION["cos_cumparaturi"][$id]["pret"]=$price*$_SESSION["tva"];
				$_SESSION["cos_cumparaturi"][$id]["data_adaugarii"]=time();							
			}
			
			$output=array("produs_nou"=>$produs_nou, "cantitate"=>$cantitate);
			return $output;
		}
		
		//@scot un produs din cos
		function scoateProdus($id)
		{
			if(array_key_exists($id, $_SESSION["cos_cumparaturi"]))
			{					
				unset($_SESSION["cos_cumparaturi"][$id]["cantitate"]);
				unset($_SESSION["cos_cumparaturi"][$id]["pret"]);					
				unset($_SESSION["cos_cumparaturi"][$id]);	
					
				return true;
			}
			else
			{
				return false;
			}
		}
		
		//@modifica produs (cantitatea, daca cantitate = 0, scoate produsul din cos)
		function modificaProdus($id, $cantitate)
		{
			if(array_key_exists($id, $_SESSION["cos_cumparaturi"]))
			{					
				if($cantitate==0)
				{
					unset($_SESSION["cos_cumparaturi"][$id]["cantitate"]);
					unset($_SESSION["cos_cumparaturi"][$id]["pret"]);					
					unset($_SESSION["cos_cumparaturi"][$id]);
				}
				else
				{
					$_SESSION["cos_cumparaturi"][$id]["cantitate"]=$cantitate;
				}
									
				return true;
			}
			else
			{
				return false;
			}
		}
		
		//@get info stoc
		function getStoc($id)
		{
			$arr_stoc=arrayFromDB(array("stoc"), "t_produse", "WHERE id_produs='".$id."'");
			
			return $arr_stoc[0]["stoc"];
		}
		
		//@extrag toate produsele din cos si le pun intr-un array asociativ
		function getProduseCos()
		{			
			$ids=array();

			foreach($_SESSION["cos_cumparaturi"] as $key=>$value)
				$ids[]=$key;
			
			if(count($ids)==0) return NULL;
			
			$arr_produse=arrayFromDB("*", 
									 "t_produse LEFT JOIN t_categorii ON t_produse.id_cat=t_categorii.id_cat",
									 "WHERE id_produs IN (".implode(",", $ids).")");
									
			if(count($arr_produse>0))
			{
				$produse=array();
				
				foreach($arr_produse as $key=>$value)
				{
					$produse[]=array("id_produs"=>$value["id_produs"],
									 "nume_produs"=>$value["nume_produs"],
									 "link_categorie_produs"=>$value["link_cat"],
									 "pret"=>$value["pret"]*$_SESSION["tva"],
									 "pret_unitar"=>$value["pret"],
									 "cantitate"=>$_SESSION["cos_cumparaturi"][$value["id_produs"]]["cantitate"],
									 "data_adaugarii"=>$_SESSION["cos_cumparaturi"][$value["id_produs"]]["data_adaugarii"]);
				}
				
				return $produse;
			}
			else
			{
				return NULL;
			}
		}
		
		//@golesc cosul
		function golesteCos()
		{
			$_SESSION["cos_cumparaturi"]=array();		
			return true;			
		}
		
		//@subtotalul pt un produs
		function getSubTotal($id)
		{
			return $_SESSION["cos_cumparaturi"][$id]["cantitate"]*$_SESSION["cos_cumparaturi"][$id]["pret"];
		}
		
		//@total produse cos
		function getTotal()
		{
			$total=0;
			
			foreach($_SESSION["cos_cumparaturi"] as $key=>$value)
				$total+=$_SESSION["cos_cumparaturi"][$key]["cantitate"]*$_SESSION["cos_cumparaturi"][$key]["pret"];
			
			return $total;
		}
	}
?>