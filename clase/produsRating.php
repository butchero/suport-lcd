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
		- vars: 	 id_produs
		- metode: produsRating($id_produs) (constructor)
		          getRating() (average rating)	
		          getNrComentarii() (nr total comentarii(voturi) pt produsul x)
		          getProcente() (procent voturi pt fiecare "rating" in parte)			                 	       
	*/	
	//--------------------------------------------------------------------------------------------------------------------------
	class produsRating
	{
		var $id_produs;
		
		function produsRating($id_produs)
		{
			$this->id_produs=$id_produs;			
		} 
		
		function getRating()
		{					
			$arr=arrayFromDB(array("AVG(rating) AS rating"),
							 "t_comentarii",
							 "WHERE id_produs='".$this->id_produs."' AND activ='1'");
			
			return $arr[0]["rating"];
		}
		
		function getNrComentarii()
		{
			$arr=arrayFromDB(array("COUNT(*) AS nr"),
							 "t_comentarii",
							 "WHERE id_produs='".$this->id_produs."' AND activ='1'");
			
			return $arr[0]["nr"];
		}
		
		function getProcente()
		{
			$nr_total_comentarii=$this->getNrComentarii();
			
			for($i=RATING_MAX;$i>=1;$i--)
			{				
				$arr=arrayFromDB(array("COUNT(*) AS nr"),
								 "t_comentarii",
								 "WHERE id_produs='".$this->id_produs."' AND activ='1' AND rating='".$i."'");
				
				$procente[]=array("rating"=>$i, "procent"=>($nr_total_comentarii==0)?0:round(($arr[0]["nr"]/$nr_total_comentarii)*100));
			}
			
			return $procente;
		}
	}
?>