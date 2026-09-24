<?		
	/*
    *****************************************************************************
	*****************************************************************************
	**                                                                         **
	**          CIUCA VALERIU (BUTCHER) - GOGO PROMOTIONS - 2006       		   **
	**                                                                         **
	*****************************************************************************
	*****************************************************************************
	*/
	//@ca multe sql-uri, trebuiesc rescris cu un singur sql si grupare pe array <- e temporar
	$arr_cat_secundare=arrayFromDB("*", "t_categorii_secundare", "WHERE id_parinte='0' ORDER BY nr_ordine ASC");
	
	foreach($arr_cat_secundare as $key=>$value)
	{
		$arr_subcat_secundare=arrayFromDB("*", "t_categorii_secundare", "WHERE id_parinte='".$value["id_cat_sec"]."' ORDER BY nr_ordine ASC");
		
		$subcat_secundare=array();	
			
		foreach($arr_subcat_secundare as $k=>$v)
		{
			$subcat_secundare[]=array("id_cat"=>$v["id_cat_sec"],
									  "nume_cat"=>$v["nume_cat_sec"],
									  "link_cat"=>getLinkCatSec($v["link_cat_sec"]));
		}
		
		$cat_secundare[]=array("id_cat"=>$value["id_cat_sec"],
							   "nume_cat"=>$value["nume_cat_sec"],
							   "link_cat"=>getLinkCatSec($value["link_cat_sec"]),
							   "subcat"=>$subcat_secundare,
							   "nr_subcat"=>count($subcat_secundare));
	}
	
	$smarty->assign("cat_secundare", $cat_secundare);
?>		