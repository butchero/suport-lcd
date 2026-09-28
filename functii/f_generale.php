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
	//-------------------------------------------------------------------------------------------------------------
	//@functie care imi limiteaza stringul la numarul de caractere $length, fara sa rupa cuvintele, pastreaza ultimul cuvant intreg
	function stringLimit($string, $length=50, $sufix="...") 
	{
  		if(strlen($string)<=$length)
  			return $string;
  			
		return strlen($fragment = substr($string, 0, $length + 1 - strlen($sufix))) < strlen($string) + 1 ?preg_replace('/\s*\S*$/', '', $fragment).$sufix:$string;
	}
	
	//-------------------------------------------------------------------------------------------------------------
	//@implode modificat pentru un array asociativ
	/* ex array:
	 * array(0=>array("nume1"="val1", "nume2"=>"val2"),
	 *		 1=>...)
	 */
	function implodeAssocArray($arr, $key, $glue)
	{
		foreach($arr as $value)
		{
			$pieces[]=$value[$key];
		}
		return implode($glue, $pieces);
	}
	
	//-------------------------------------------------------------------------------------------------------------
	//@formateaza numarul pentru afisare
	function formateazaNr($nr)
	{
		return number_format(round($nr), 2, ",", ".");		
	}

	//-------------------------------------------------------------------------------------------------------------
	//@durata garanției: multiplu de 12 -> ani, altfel luni
	function formateazaGarantie($luni)
	{
		$luni=(int)$luni;

		if($luni>0 && $luni%12==0)
		{
			$ani=(int)($luni/12);
			return $ani." ".(($ani==1)?"an":"ani");
		}

		if($luni==1)
			return "1 lună";

		return $luni." luni";
	}

	//-------------------------------------------------------------------------------------------------------------
	//@ani pentru eticheta GARAN: întreg sau jumătate (2,5)
	function formateazaAniGaran($luni)
	{
		$luni=(int)$luni;

		if($luni%12==0)
			return (string)(int)($luni/12);

		if($luni%6==0)
			return (int)floor($luni/12).",5";

		return "";
	}
	
	//-------------------------------------------------------------------------------------------------------------
	//@fct booleana care intoarce "true" daca requestul este e tip XMLHttpRequest, "false" in caz contrar
	function isAjax() 
	{
		return isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && $_SERVER["HTTP_X_REQUESTED_WITH"]=="XMLHttpRequest";
	}
	
	//-------------------------------------------------------------------------------------------------------------
	//@genereaza un string(numere si cifre random) de o lungime data
	function strRandom($lungime)
	{
		//@am scos anumite caractere care se pot confunda
		$caractere="123456789ABCDEFGHIJKLMNPQRSTUVWXYZ";
		$nr_caractere=strlen($caractere)-1;
		
		$i=0;
		$string="";
		
		while($i<$lungime) 
		{
			$string.=$caractere{mt_rand(0, $nr_caractere)};
			$i++;
		}
		
		return $string;
	}
	
	//-------------------------------------------------------------------------------------------------------------
	//@functie care evidentiaza termenii cautati - daca sunt mai multi de 6 asta e :P
	function highlight($text, $cuvinte_cautare)
	{
		$codes=array("{<}", "{<|}", "{<||}", "{<|||}", "{<||||}", "{<|||||}");
		$classes=array("highlight", "highlight1", "highlight2", "highlight3", "highlight4", "highlight5");
		
		if(is_array($cuvinte_cautare))
		{
			for($i=0;$i<count($cuvinte_cautare);$i++)
			{
				$cuvant=$cuvinte_cautare[$i];
				$cuvant = '/('.$cuvant.')/i';
   				$text = preg_replace($cuvant, $codes[$i].'\1{>}', $text);
			}
			
			for($i=0;$i<count($cuvinte_cautare);$i++)
			{
				$text = str_replace($codes[$i], '<span class="'.$classes[$i].'"><b>', $text); 
			}
			
			$text=str_replace("{>}", "</b></span>", $text);
		}
		return $text;
	}
	
	//-------------------------------------------------------------------------------------------------------------
	//@citeste director
	function citesteDir($dir, $files_only=false)
	{
		$fisiere=array();
		
		if($handle=opendir($dir))
		{
		   while(false!==($file = readdir($handle))) 
		   {
				if($files_only==true && is_dir($dir.$file))
					continue;
		   	
		   		if($file!="." && $file!="..") 
		        	$fisiere[]=$file;
		   }
		   
		   closedir($handle);		   
		   sort($fisiere);
		   return $fisiere;
		}
		else 
		{
			return false;
		}
	}
	
	//-------------------------------------------------------------------------------------------------------------
	//@copiaza director prin conexiune ftp
	function ftp_copyDir($source_path, $destination_path, $con)
	{
	    ftp_mkdir($con, $destination_path);
	    ftp_site($con, "CHMOD 0777 ".$destination_path);
	    ftp_chdir($con,$destination_path);
	
	    if(is_dir($source_path)) 
	    {
	        chdir($source_path);
	        $handle=opendir('.');
	        
	        while(($file = readdir($handle))!==false) 
	        {
	            if(($file != ".") && ($file != "..")) 
	            {
	                if(is_dir($file))
	                {
	                    ftp_copyDir($source_path."/".$file, $file, $con);
	                    chdir($source_path);
	                    ftp_cdup($con);	                
	                }
	                if(is_file($file))
	                {
	                    $fp=fopen($file, "r");
	                    ftp_fput($con, str_replace(" ", "_", $file), $fp, FTP_BINARY);
	                    ftp_site($con, "CHMOD 0755 ".str_replace(" ", "_", $file));
	                } 
	            }
	        }
	        
	        closedir($handle); 
	    }
	}

	//-------------------------------------------------------------------------------------------------------------
	//@sterge recursiv director prin conexiune ftp
	function ftp_removeDir($con, $dst_dir)
	{
    	$arr_files=ftp_nlist($con, $dst_dir);

    	if(is_array($arr_files))
    	{
    		for($i=0;$i<count($arr_files);$i++)
    		{ 
	            $st_file=$arr_files[$i];
	            
	            if($st_file=="." || $st_file=="..")
	            	 continue;
	            
	            //@verific daca e director	 
	            if(ftp_size($con, $dst_dir.'/'.$st_file) == -1)
	            { 
	            	//@sterge director recursiv
	                ftp_removeDir($con, $dst_dir."/".$st_file);
	            }
	            else 
	            {
	            	//@sterge fisier
	                ftp_delete($con, $dst_dir."/".$st_file);
            	}
        	}
    	}
    	
    	//sterg directoarele goale
    	$flag=ftp_rmdir($con, $dst_dir);     
	}
	
	//-------------------------------------------------------------------------------------------------------------
	//@listeaza toate directoare si subdirectoarele recursiv dintr-un folder
	function listdir($start_dir=".")
	{
		$files=array();
		
		if(is_dir($start_dir)) 
		{
			$fh=opendir($start_dir);
			
			$files[]=$start_dir;
				
			while(($file = readdir($fh)) !== false) 
			{      
				if(strcmp($file, ".")==0 || strcmp($file, "..")==0) 
					continue;
				
				$filepath=$start_dir."/".$file;
				
				if(is_dir($filepath))
					$files = array_merge($files, listdir($filepath));
				else
					array_push($files, $filepath);
			}
			closedir($fh);
		} 
		else 
		{    
			$files = false;
		}
		return $files;
	}
		
	//-------------------------------------------------------------------------------------------------------------
	//@calculeaza reducere
	function rotunjesteFloat($value, $zecimale=0) 
	{
	 	if($zecimale<0)
	 	{ 
	 		$zecimale=0; 
	 	}
	 	
	 	$multiplicator=pow(10, $zecimale);
	 	
	 	return ceil($value*$multiplicator)/$multiplicator;
	}
	
	function calculeazaReducere($pret_vechi, $pret_nou)
	{
		$diferenta=$pret_vechi-$pret_nou;
		
		if($diferenta<0 || $pret_vechi==0 || $pret_nou==0)
			return "";
		
		$reducere=@($diferenta/$pret_vechi)*100;
		
		return  number_format(rotunjesteFloat($reducere, 4), 0, '.', '');;
	}
?>