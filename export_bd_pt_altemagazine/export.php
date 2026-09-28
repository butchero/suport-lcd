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
	require_once("../conectare.php");
	require_once("../configurare.php");
	require_once("../init.php");
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@export categorii
	$sql="SELECT id_cat, nume_cat, id_parinte 
			FROM t_categorii 
		  WHERE activ='1' AND producator='0'";
	$result=$mysqli->query($sql) or die($mysqli->error);
	
	$file1=URL_BASE_ABS."export_bd_pt_altemagazine/categorii.csv";
	$fisier1=fopen($file1, "w");
	
	while($row=$result->fetch_array())
	{
		$text=$row["id_cat"].",\"".$row["nume_cat"]."\",".(int)$row["id_parinte"]."\r\n";
		fwrite($fisier1, $text);
	}
	
	fclose($fisier1);

	//---------------------------------------------------------------------------------------------------------------------------------
	//@export producatori
	$sql="SELECT id_cat, nume_cat
			FROM t_categorii 
		  WHERE activ='1' AND producator='1'";
	$result=$mysqli->query($sql);
	
	$file2=URL_BASE_ABS."export_bd_pt_altemagazine/producatori.csv";
	$fisier2=fopen($file2, "w");
	
	while($row=$result->fetch_array())
	{
		$text=$row["id_cat"].",\"".$row["nume_cat"]."\"\r\n";
		fwrite($fisier2, $text);
	}
	
	fclose($fisier2);
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@export produse
	$sql="SELECT * FROM t_produse 
			INNER JOIN t_categorii ON t_produse.id_cat=t_categorii.id_cat 
		  WHERE t_categorii.activ='1'"; // AND stoc='2' - pt gsmnet, gsmaccesorii
	$result=$mysqli->query($sql);
	
	$file3=URL_BASE_ABS."export_bd_pt_altemagazine/produse.csv";
	$fisier3=fopen($file3, "w");
	
	while($row=$result->fetch_array())
	{
		if(file_exists(URL_BASE_ABS."poze_produse/".$row["id_produs"]."/supermari/0.jpg"))
			$poza=URL_BASE."poze_produse/".$row["id_produs"]."/supermari/0.jpg";
		else $poza="";	
		
		//@caracteristici
		$caracteristici=explode(";", $row["caracteristici"]);
		
		//@detalii
		$sql1="SELECT * FROM t_filtre WHERE id_cat='".$row["id_cat"]."' ORDER BY id_filtru ASC";
		$result1=$mysqli->query($sql1);
				
		$i=1;
		
		$table="";
		while($r=$result1->fetch_array())
		{
			$table.="<b>".strtoupper($r["nume_filtru"]).":</b> ".$caracteristici[$i]."<br />";
			$i++;
		}
		
		$detalii=$table."<br /><br />".str_replace("\"", "", $row["descriere_produs"]);
		
		$text=$row["id_produs"].",\"".addslashes($row["nume_produs"])."\",".$row["id_cat"].",\"".addslashes($detalii)."\",\"".($row["pret"]*TVA)."\",".$row["id_prod"].",1,".$row["tip"].",\"".$poza."\"\n";
		fwrite($fisier3, $text);
	}
	
	fclose($fisier3);
?>