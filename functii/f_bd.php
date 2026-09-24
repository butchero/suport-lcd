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
	require_once("f_securitate.php");
	
	//@variabila in care stochez toate interogarile facute
	$interogari=array();
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@functie care logheaza fiecare interogare facuta de un subadmin
	function logActiuni($sql)
	{
        global $mysqli;

		//@log sql pt subadmin
		if(is_numeric($_SESSION["admin_id_user"]) && $_SESSION["admin_super_admin"]==0) {
            $mysqli->query("INSERT INTO t_loguri(data_log, log, id_admin) VALUES('".time()."', '".prepareStringToDB($sql)."', '".$_SESSION["admin_id_user"]."')");
        }
	}

	//-------------------------------------------------------------------------------------------------------------
	//functie care imi returneaza un array smarty friendly pt structura {section} sau {foreach} din smarty
	/*
		array(0=>array("coloana1"=>valoare, "coloana2"=>valoare),
			  1=>array("coloana1"=>valoare, "coloana2=>valoare"))
	*/
	function arrayFromDB($cols, $tabel, $conditii="", $debug=false)
	{				
		global $mysqli, $interogari;
				
		$arr_cols=array();
		
		//@construiesc sql-ul
		$sql="SELECT ".((!is_array($cols) && $cols=="*")?"*":implode(",", $cols))." FROM ".$tabel." ".$conditii;
		
		$interogari[]=$sql;
		
		//@debug
		($debug==true)?print $sql:""; 
			
		//@rezultatul interogarii
        $result=$mysqli->query($sql)or die(($debug)?"<br />Eroare SQL: ".$mysqli->error:"");

		$i=0;
		while($row=$result->fetch_assoc())
		{
			//@loop prin campurile selectate si atribuire valori din bd
			foreach($row as $key=>$value)
			{
				$arr_cols[$i][$key]=prepareStringFromDB($value);
			}
			$i++;
		}

		//@curatz rezultatul pt a elibera memoria pana la terminarea executiei scriptului
		($result)?mysqli_free_result($result):"";

		return $arr_cols;
	}
	
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@functie care imi returneaza un array friendly pt smarty->html_options (combobox)
	function arrayFromDBtoCombo($tabel, $camp_id, $camp_valoare, $conditii="", $debug=false)
	{
		global $interogari, $mysqli;
		
		//@construiesc sql-ul
		$sql="SELECT ".$camp_id.", ".$camp_valoare." FROM ".$tabel." ".$conditii;
		
		$interogari[]=$sql;
		
		//@debug
		($debug)?print $sql:"";
		
		//@daca campurile imi vin de forma "a.nume_camp" pastrez doar "nume_camp"
		if(strstr($camp_id, ".")!==false)
			$camp_id=preg_replace("/.*?\..*?/", "${2}", $camp_id);
			
		if(strstr($camp_valoare, ".")!==false)
			$camp_valoare=preg_replace("/.*?\..*?/", "${2}", $camp_valoare);
		
		//@rezultatul interogarii
		$result=$mysqli->query($sql) or die(($debug)?"<br />Eroare SQL: ".mysql_error():"");

		while($row=$result->fetch_assoc())
		{
			$arr_combo[$row[$camp_id]]=prepareStringFromDB($row[$camp_valoare]);
		}
		
		//@curatz rezultatul pt a elibera memoria pana la terminarea executiei scriptului
		($result)?mysqli_free_result($result):"";

		return $arr_combo;
	}
	
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@functie care insereaza in tabel, pentru campurile date in array-ul $campuri, valorile din array-ul $valori
	function arrayInsertToDB($tabel, $campuri, $valori, $debug=false)
	{
		global $interogari, $mysqli;
		
		//@verificare
		if(count($campuri)!=count($valori))
			die("Eroare la inserare: Numarul de campuri nu este egal cu numarul de valori !");
			
		//@pregatesc datele pentru insert in bd	
		foreach($valori as $value)		
			$valori_safe[]=($value=="" && $value!=0)?"null":"'".prepareStringToDB($value)."'";		
			
		//@construiesc sql-ul
		$sql="INSERT INTO ".$tabel."(".implode(",", $campuri).") VALUES(".implode(",", $valori_safe).")";
		
		$interogari[]=$sql;
		
		//@debug
		($debug)?print $sql:"";
		
		//@log sql pt subadmin
		logActiuni($sql);

        $mysqli->query($sql) or die(($debug)?"<br />Eroare SQL: ".$mysqli->error:"");

		return $mysqli->insert_id;
	}
	
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@functie care face update in tabel, pentru campurile date in array-ul $campuri, valorile din array-ul $valori, pe linia cu id-ul $id
	function arrayUpdateToDB($tabel, $campuri, $valori, $linie="", $strip_quotes=false, $debug=false)
	{
		global $interogari, $mysqli;
		
		//@verificare
		if(count($campuri)!=count($valori))
			die("Eroare la update: Numarul de campuri nu este egal cu numarul de valori !");
			
		//@pregatesc datele pentru update in bd		
		for($i=0;$i<count($campuri);$i++)	
			$arr_update[]=$campuri[$i]."=".(($strip_quotes)?$valori[$i]:"'".prepareStringToDB($valori[$i])."'");		
		
		//@construiesc sql-ul
		if(is_array($linie["valoare"]))	
			$sql="UPDATE ".$tabel." SET ".implode(", ", $arr_update)." WHERE ".$linie["id"]." IN (".implode(",", $linie["valoare"]).")";
		elseif($linie=="")	
			$sql="UPDATE ".$tabel." SET ".implode(", ", $arr_update);
		else
			$sql="UPDATE ".$tabel." SET ".implode(", ", $arr_update)." WHERE ".$linie["id"]."='".prepareStringToDB($linie["valoare"])."'";

		$interogari[]=$sql;	
				
		//@debug
		($debug)?print $sql:"";
		
		//@log sql pt subadmin
		logActiuni($sql);

        $mysqli->query($sql) or die(($debug)?"<br />Eroare SQL: ".$mysqli->error:"");
	}
		
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@functie care sterge din tabel, "where"-ul (conditia de stergere) este construita din array-urile $campuri si $valori
	function arrayDeleteFromDB($tabel, $campuri, $valori)
	{
		global $interogari, $mysqli;
		
		//@verificare nr campuri sa fie egal cu nr valori
		if(count($campuri)!=count($valori))
			die("Eroare la stergere: Numarul de campuri nu este egal cu numarul de valori !");
			
		//@pregatire introducere valori in bd
		for($i=0;$i<count($campuri);$i++)	
			$arr_delete[]=$campuri[$i]."='".prepareStringToDB($valori[$i])."'";		
		
		$interogari[]=$sql;	
			
		//@construiesc sql-ul	
		$sql="DELETE FROM ".$tabel." WHERE ".implode("AND ", $arr_delete);
				
		//@log sql pt subadmin
		logActiuni($sql);	
			
		$mysqli->query($sql) or die();
	}
?>