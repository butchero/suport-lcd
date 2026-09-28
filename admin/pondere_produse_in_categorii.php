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
	
	$culoare_axe="#263B64";
	$culoare_margine="white";
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@jpggraph cache
	define("IMG_DIR", "jpgraph_cache/");
	
	error_reporting(E_ALL & ~E_DEPRECATED & ~E_WARNING);
	require_once("jpgraph/src/jpgraph.php");
	require_once("jpgraph/src/jpgraph_pie.php");
	require_once("jpgraph/src/jpgraph_pie3d.php");


	$sql="SELECT nr_produse, nume_cat FROM t_categorii WHERE producator='0' AND activ='1'";
	$result=$mysqli->query($sql) or die($mysqli->error);
	
	$i=0;
	$arr=array();
	while($row=$result->fetch_array())
	{
		$arr[$i][0]=$row["nume_cat"];	
		$arr[$i][1]=$row["nr_produse"];	
		$i++;
	}

	$total=0;
	for($i=0;$i<count($arr);$i++)
	{
		$total+=$arr[$i][1];
	}	
	
	for($i=0;$i<count($arr);$i++)
	{
		if(floor(($arr[$i][1]*100)/$total)>= 1)
		{
			$data[]=$arr[$i][1];
			$legend[]=strtoupper(substr($arr[$i][0],0,1))."".substr($arr[$i][0],1,60);
			$total+=$arr[$i][1];
		}	
	}

	for($i=0;$i<count($data)-1;$i++)
	{
		for($j=$i+1;$j<count($data);$j++)
		{
			if($data[$i]>$data[$j])
			{
				$auxd="";
				$auxl="";
				$auxd=$data[$j];
				$auxl=$legend[$j];
				$data[$j]=$data[$i];
				$legend[$j]=$legend[$i];
				$data[$i]=$auxd;
				$legend[$i]=$auxl;
			}
		}
	}
	
	$j=0;
	for($i=0;;)
	{	
		if($i>=count($data))
			break;
		$tempd[]=$data[$j];
		$templ[]=$legend[$j];
		if(count($tempd)<count($data))
		{
			$tempd[]=$data[count($data)-$j-1];
			$templ[]=$legend[count($legend)-$j-1];
		}
		++$j;	
		$i+=2;
	}
	
	$data=$tempd;
	$legend=$templ;
	
	$inaltime_pie=100;
	$inaltime_totala=$inaltime_pie*2+30+12*count($data);
	
	$graph=new PieGraph(450, $inaltime_totala, "auto");
	$graph->SetAntiAliasing();
		
	$graph->title->SetFont(FF_ARIAL, FS_BOLD, 8); 
	$graph->title->SetColor("black");
	$graph->legend->Pos(-0.00, 0.91, "left", "bottom");
	$graph->legend->SetFont(FF_ARIAL,FS_NORMAL, 8);

	$p1=new PiePlot3d($data);
	
	$p1->SetShadow();
	$p1->SetTheme("sand");
	$p1->SetCenter(0.4, $inaltime_pie/$inaltime_totala);
	$p1->SetSize(80);

	$p1->SetAngle(45);
	
	$p1->SetStartAngle(0);
	
	for($i=0;$i<count($arr);$i++)
	{
		$p1->ExplodeSlice($i);
	}
	
	$p1->value->SetFont(FF_VERDANA, FS_NORMAL, 8);
	$p1->value->SetColor("black");
	
	$p1->SetLegends($legend);
	
	$graph->SetMarginColor("white"); 
	$graph->SetFrame(false);
	$graph->Add($p1);
	$graph->Stroke();
?>