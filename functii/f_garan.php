<?
	//@produse cu date fixe pentru eticheta GARAN (marca + model afisat)
	function produseGaran()
	{
		return array(
			array("id_produs"=>2, "denumire"=>"SUPORT LCD 01 237", "model"=>"Suport LCD 01 237", "brand"=>"Serend", "ean"=>"8693640000237"),
			array("id_produs"=>165, "denumire"=>"SUPORT ARAGAZ/FRIGIDER BT 02", "model"=>"Suport aragaz frigider BT02", "brand"=>"Serend", "ean"=>"8693640000718"),
			array("id_produs"=>0, "denumire"=>"SUPORT ARAGAZ/FRIGIDER WMS-02M", "model"=>"Suport aragaz frigider WMS-02M", "brand"=>"STAR-LINE", "ean"=>"6956745153270"),
			array("id_produs"=>34, "denumire"=>"SUPORT CUPTOR MICROUNDE DK503", "model"=>"Suport cuptor microunde DK503", "brand"=>"Serend", "ean"=>"8693640000503"),
			array("id_produs"=>4, "denumire"=>"SUPORT LCD 251 DL", "model"=>"Suport LCD 251", "brand"=>"Serend", "ean"=>"8010593"),
			array("id_produs"=>33, "denumire"=>"SUPORT RECEIVER / DVD RS 428", "model"=>"Suport receiver RS 428", "brand"=>"Serend", "ean"=>"8693640000428"),
			array("id_produs"=>173, "denumire"=>"SUPORT LCD PLASMA PLZ 909", "model"=>"Suport LCD plasma PLZ 909", "brand"=>"Serend", "ean"=>"8693640000909"),
			array("id_produs"=>1, "denumire"=>"SUPORT LCD 220 25-68CM", "model"=>"Suport LCD 220", "brand"=>"Serend", "ean"=>"8013756"),
			array("id_produs"=>106, "denumire"=>"SUPORT LCD H 480", "model"=>"Suport LCD H 480", "brand"=>"Serend", "ean"=>"8693640005379"),
			array("id_produs"=>104, "denumire"=>"SUPORT LCD H 190", "model"=>"Suport LCD H 190", "brand"=>"Serend", "ean"=>"8693640005355"),
			array("id_produs"=>105, "denumire"=>"SUPORT LCD H 260", "model"=>"Suport LCD H 260", "brand"=>"Serend", "ean"=>"8693640005362"),
			array("id_produs"=>164, "denumire"=>"SUPORT LCD S 200 ZZ", "model"=>"Suport LCD S 200", "brand"=>"Serend", "ean"=>"8693640005300"),
			array("id_produs"=>83, "denumire"=>"SUPORT LCD 113 DL", "model"=>"Suport LCD 113", "brand"=>"Serend", "ean"=>"8030413"),
			array("id_produs"=>84, "denumire"=>"SUPORT LCD 114 DL", "model"=>"Suport LCD 114", "brand"=>"Serend", "ean"=>"8030414"),
			array("id_produs"=>96, "denumire"=>"SUPORT LCD COD PLZ 360", "model"=>"Suport LCD PLZ 360", "brand"=>"Serend", "ean"=>"8693640000367"),
			array("id_produs"=>97, "denumire"=>"SUPORT LCD 2231", "model"=>"Suport LCD 2231", "brand"=>"Serend", "ean"=>"8693640002231"),
			array("id_produs"=>98, "denumire"=>"SUPORT LCD SD 740", "model"=>"Suport LCD SD 740", "brand"=>"Serend", "ean"=>"8693640000886"),
			array("id_produs"=>99, "denumire"=>"SUPORT LCD PLZ-923", "model"=>"Suport LCD 923", "brand"=>"Serend", "ean"=>"8693640000923"),
			array("id_produs"=>121, "denumire"=>"SUPORT LCD 2316", "model"=>"Suport LCD 2316", "brand"=>"Serend", "ean"=>"8693640002316"),
			array("id_produs"=>120, "denumire"=>"SUPORT LCD 2323", "model"=>"Suport LCD 2323", "brand"=>"Serend", "ean"=>"8693640002323"),
			array("id_produs"=>0, "denumire"=>"SUPORT LCD 115", "model"=>"Suport LCD 115", "brand"=>"STAR-LINE", "ean"=>"6956745154932"),
			array("id_produs"=>134, "denumire"=>"SUPORT LCD 116 DL", "model"=>"Suport LCD 116", "brand"=>"STAR-LINE", "ean"=>"6956745154925"),
			array("id_produs"=>167, "denumire"=>"SUPORT TV LED 216", "model"=>"Suport TV LED 216", "brand"=>"STAR-LINE", "ean"=>"6974215089782"),
			array("id_produs"=>160, "denumire"=>"SUPORT TV LED 215", "model"=>"Suport TV LED 215", "brand"=>"STAR-LINE", "ean"=>"6974215089799"),
			array("id_produs"=>166, "denumire"=>"SUPORT LCD CU PRINDERE DE TAVAN TA6095", "model"=>"Suport cu prindere de tavan TA6095", "brand"=>"Serend", "ean"=>"8693640000848"),
			array("id_produs"=>0, "denumire"=>"SUPORT LCD LED 200", "model"=>"Suport TV LED 200", "brand"=>"Serend", "ean"=>"6974215089997")
		);
	}

	function garanPentruProdus($id_produs)
	{
		$id_produs=(int)$id_produs;
		if($id_produs<=0)
			return null;

		foreach(produseGaran() as $eticheta)
		{
			if((int)$eticheta["id_produs"]===$id_produs)
				return $eticheta;
		}

		return null;
	}

	function modelGaranProdus($id_produs)
	{
		$eticheta=garanPentruProdus($id_produs);
		return ($eticheta!==null)?$eticheta["model"]:"";
	}
?>
