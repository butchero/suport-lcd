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
	//adaptat de la graficul pe care l-am facut la www.interfinbrok.ro
	session_name("admin");
	session_start();
	
	require_once("../configurare.php");
	require_once("../conectare.php");
	require_once("../init.php");
	require_once("../functii/f_generale.php");
	require_once("../functii/f_bd.php");
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@autorizare user logat
	require_once("autentificare.php");
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@verificare id produs
	if(!isset($_GET["id_produs"]) || !is_numeric($_GET["id_produs"]) || empty($_GET["id_produs"]))
		die("Produs invalid!");
	else $id_produs=$_GET["id_produs"];	
	
	$culoare_axe="#263B64";
	$culoare_margine="white";
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@jpggraph cache
	define("IMG_DIR", "jpgraph_cache/");
	
	error_reporting(E_ALL & ~E_DEPRECATED & ~E_WARNING);
	require_once("jpgraph/src/jpgraph.php");
	require_once("jpgraph/src/jpgraph_bar.php");
	require_once("jpgraph/src/jpgraph_line.php");
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@filtrari
	$titlu_grafic="Statistici incasari produs";
	$date_format="d/M";	
	
	if(!empty($_REQUEST["luna"]) && is_numeric($_REQUEST["an"]))
	{
		$sql_where=" HAVING (data_comanda > '".$_REQUEST["an"].$_REQUEST["luna"]."00' AND data_comanda < '".$_REQUEST["an"].$_REQUEST["luna"]."31')";
		$titlu_grafic.=" ".$luni[$_GET["luna"]]." ".$_GET["an"];
	}
	elseif(empty($_REQUEST["luna"]) && is_numeric($_REQUEST["an"]))
	{
		$sql_where=" HAVING (data_comanda > '".$_REQUEST["an"]."0000' AND data_comanda < '".$_REQUEST["an"]."1231')";
		$titlu_grafic.=" ".$_REQUEST["an"];
	}
	else
	{
		$sql_where=" HAVING (data_comanda > '".date("Ymd", strtotime("12 month ago"))."')";	
	}	

	//---------------------------------------------------------------------------------------------------------------------------------
	//@selectez datele
	$arr_result=arrayFromDB(array("SUM(pret_produs*cantitate) AS total", "FROM_UNIXTIME(data_comanda, '%Y%m%d') AS data_comanda"),
							"t_produse_comenzi AS a INNER JOIN t_comenzi AS b ON a.id_comanda=b.id_comanda",
							"WHERE stare='2' AND id_produs='".$id_produs."' GROUP BY FROM_UNIXTIME(data_comanda, '%Y%m%d') ".$sql_where." ORDER BY data_comanda ASC");	
	$j=0;
	$valori_y=array();
				
	foreach($arr_result as $key=>$value)
	{
		$valori_y[$j]=$value["total"];
		$xTickLabels[$j]=date($date_format, strtotime($value["data_comanda"]));
		$arr_date_complete[$j]=date("d M Y", strtotime($value["data_comanda"]))." (".date("l", strtotime($value["data_comanda"])).")";
		$alt[$j]="";
		$targ[$j]="#";
		
		$j++;
	}
	
	$nr_linii=$j;
	($j==0)?$j=1:"";
	$total_comanda_medie=array_sum($valori_y)/$j;
	
	for($k=0;$k<$j;$k++)
		$arr_total_comanda_medie[$k]=$total_comanda_medie;

	$graph = new Graph(470, 130, "auto");
	$graph->SetFrame(true, "darkblue", 0); 
	$graph->SetMarginColor($culoare_margine);
	$graph->SetScale("textlin");
	
	$graph->xaxis->SetColor($culoare_axe); 
	$graph->yaxis->SetColor($culoare_axe);
	
	$graph->img->SetMargin(40, 15 , 15, 25);
	
	$dplot[] = new LinePLot($valori_y);

	$dplot[0]->SetFillColor("#6899FD");
	
	$accplot = new AccLinePlot($dplot);
	$b1=new BarPlot($valori_y); 
	
	$arrVal=$valori_y;
	
	$b1->SetYBase($arrVal[0]);
			
	$b1->SetColor("white@1"); 
	$b1->SetFillColor("white@1"); 
	$b1->SetWidth(1); 
	$b1->SetCSIMTargets($targ, $alt); 
	
	$c1=new LinePlot($arr_total_comanda_medie);
	$c1->SetLegend("Media incasari/zi = ".formateazaNr($total_comanda_medie)." ".MONEDA);
	$c1->SetColor("red");
	
	$graph->Add($b1);
	$graph->Add($accplot);
	$graph->Add($c1);
	
	$graph->title->SetFont(FF_ARIAL,FS_BOLD, 7);
	$graph->yaxis->title->SetFont(FF_ARIAL, FS_NORMAL, 8);
	$graph->xaxis->title->SetFont(FF_ARIAL, FS_NORMAL, 8);
	
	$graph->title->Set($titlu_grafic);
	
	$graph->xaxis->title->Set($interval);
	
	$graph->xaxis->SetTextTickInterval((5*$nr_linii)/30);
	$graph->xaxis->SetTickLabels($xTickLabels);
	
	$graph_name=IMG_DIR."statistici_incasari.png";
	$graph->Stroke($graph_name);
	
	$mapName="harta_grafic";
	$imgMap=$graph->GetHTMLImageMap($mapName);
	
	$arrImgMap=explode("<area", str_replace("<map name=\"harta_grafic\">", "" , $imgMap));	
	$arrImgMap=explode("<area", trim(substr($imgMap, strpos($imgMap, "<area")+5, strlen($imgMap)-5)));
		
	$imgMap1='<map name="harta_grafic">';
	
	for($i=0;$i<count($arrImgMap);$i++)
	{
		if($arrImgMap!="")
			$imgMap1.="<area ".str_replace('shape="poly"','shape="poly" onmouseover="return overlib(\'<b>'.formateazaNr($valori_y[$i]).' '.MONEDA.'</b> - '.$arr_date_complete[$i].'\');" onmouseout="return nd();"', $arrImgMap[$i]);
	}
?>
<html>
	<head>
		<script type="text/javascript" src="<?=URL_BASE?>javascript/jslib/overlib.js"></script>
	</head>
	<body style="cursor:default">
	<?
		print "<div style=\"cursor:pointer\">".$imgMap1."</div><img src=\"".$graph_name."?".time()."\" ismap usemap=\"#".$mapName."\" border=\"0\">"; 
	?>
	</body>
</html>