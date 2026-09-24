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
	$result=mysql_query($sql) or die(mysql_error());
	
	$file1=URL_BASE_ABS."export_bd_pt_altemagazine/categorii.csv";
	$fisier1=fopen($file1, "w");
	
	while($row=mysql_fetch_array($result))
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
	$result=mysql_query($sql);
	
	$file2=URL_BASE_ABS."export_bd_pt_altemagazine/producatori.csv";
	$fisier2=fopen($file2, "w");
	
	while($row=mysql_fetch_array($result))
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
	$result=mysql_query($sql);
	
	$file3=URL_BASE_ABS."export_bd_pt_altemagazine/produse.csv";
	$fisier3=fopen($file3, "w");
	
	while($row=mysql_fetch_array($result))
	{
		if(file_exists(URL_BASE_ABS."poze_produse/".$row["id_produs"]."/supermari/0.jpg"))
			$poza=URL_BASE."poze_produse/".$row["id_produs"]."/supermari/0.jpg";
		else $poza="";	
		
		//@caracteristici
		$caracteristici=explode(";", $row["caracteristici"]);
		
		//@detalii
		$sql1="SELECT * FROM t_filtre WHERE id_cat='".$row["id_cat"]."' ORDER BY id_filtru ASC";
		$result1=mysql_query($sql1);
				
		$i=1;
		
		$table="";
		while($r=mysql_fetch_array($result1))
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