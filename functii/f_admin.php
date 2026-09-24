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
	//@ordoneaza categorii (ordonarea cu ajax o foloseste)
	function ordoneazaCategorii($arr_ids, $id_parinte=0, $ordoneaza="")
	{
		//@basic check
        if(count($arr_ids)==0 || !is_numeric($id_parinte))
          return false;
        
        if($ordoneaza=="producatori")
 			$arr_categorii=getTotiProducatorii();	
        else 
        	$arr_categorii=arrayFromDB(array("id_cat", "nume_cat"), "t_categorii", "WHERE id_parinte='".$id_parinte."'");
 		
 		//@array friendly pt verificarea existentei unui id
 		for($i=0;$i<count($arr_categorii);$i++)
 			$categorii[$arr_categorii[$i]["id_cat"]]=$arr_categorii[$i]["nume_cat"];

 		$nr_de_ordine=1;
 			
        foreach($arr_ids as $id_cat) 
        {
		    if(!array_key_exists($id_cat, $categorii)) //verific daca id-ul categoriei exista in bd
		        continue;
		
		    //@updatez nr de ordine    
		    arrayUpdateToDB("t_categorii", array("nr_ordine"), array($nr_de_ordine), array("id"=>"id_cat", "valoare"=>$id_cat));
		    
		    $nr_de_ordine++;   
		}
		
		return true;
	}
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@ordoneaza filtrele dintr-o cat (ordonarea cu ajax o foloseste)
	function ordoneazaFiltre($arr_ids, $id_cat)
	{
		//@basic check
        if(count($arr_ids)==0 || !is_numeric($id_cat))
          return false;
        
       $arr_filtre=arrayFromDB("*", "t_filtre", "WHERE id_cat='".$id_cat."' ORDER BY nume_filtru ASC");
 		
 		//@array friendly pt verificarea existentei unui id
 		for($i=0;$i<count($arr_filtre);$i++)
 			$filtre[$arr_filtre[$i]["id_filtru"]]=$arr_categorii[$i]["nume_filtru"];

 		$nr_de_ordine=1;
 			
        foreach($arr_ids as $id_filtru) 
        {
	        if(!array_key_exists($id_filtru, $filtre)) //verific daca id-ul categoriei exista in bd
	            continue;
	
	        //@updatez nr de ordine    
	        arrayUpdateToDB("t_filtre", array("nr_ordine"), array($nr_de_ordine), array("id"=>"id_filtru", "valoare"=>$id_filtru));
	        
	        $nr_de_ordine++;   
		}
		
		return true;
	}
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@activeaza/dezactiveaza categorii din arbore (daca sunt dezactivate nu vor mai fi afisate in site)
	function toggleCategoriiActivare($id_cat, $activ)
	{
		//@basic check
        if(!is_numeric($id_cat) || ($activ!=0 && $activ!=1))
            return false;
       
        global $arr_toate_cat;   
        
        if(empty($arr_toate_cat))        
        	$arr_toate_cat=arrayFromDB("*", "t_categorii");
            
        $arr_categorii=arrayFromDB(array("id_cat"), "t_categorii", "WHERE id_cat='".$id_cat."'");
       
        //@second check
        if(count($arr_categorii)!=1)
       		return false;   	   
   	   
   	    //@gasesc toti copii categoriei pentru ai activa/dezactiva
   	    require_once("../clase/arbore.php");	
   	   
   	    $arbore=new arboreComplet($id_cat, 0, $arr_toate_cat);
   	    $arr_copii=$arbore->getArboreComplet();
   	    $nr_copii=count($arr_copii);
   	   
   	    //@adaug si categoria la copii pt a face update-ul dintr-un singur sql   
   	    $copii[]=$id_cat;
   	   
   	    for($i=0;$i<$nr_copii;$i++)
   	    	$copii[]=$arr_copii[$i]["id_cat"]; 

  	    arrayUpdateToDB("t_categorii", array("activ"), array($activ), array("id"=>"id_cat", "valoare"=>$copii));	
  	   
  	    return true;
	}
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@sterge categorie + subcategoriile aferente + produse + poze
	function stergeCategorie($id_cat)
	{
		//@basic check
        if(!is_numeric($id_cat))
            return false;
        
       global $arr_toate_cat;     
            
       $arr_categorii=arrayFromDB(array("id_cat", "producator"), "t_categorii", "WHERE id_cat='".$id_cat."'");
       
       //@second check
       if(count($arr_categorii)!=1)
       	   return false;
   	   	   
       //@sterg pozele categoriei
   	   @unlink(URL_BASE_ABS."poze_categorii/".$id_cat.".jpg");
   	   @unlink(URL_BASE_ABS."poze_categorii/mici/".$id_cat.".jpg");
   	   	   
       //@daca categoria este producator inlocuiesc id_prod din t_produse cu null
       if($arr_categorii[0]["producator"]==1)
       {
       		arrayUpdateToDB("t_produse", array("id_prod"), array(""), array("id"=>"id_prod", "valoare"=>$id_cat));
       		arrayDeleteFromDB("t_categorii", array("id_cat"), array($id_cat));	   
       		return true;   
       }
       				
   	   require_once("../clase/arbore.php");	
   	   
   	   //@gasesc toti copii categoriei pentru ai sterge
   	   $arbore=new arboreComplet($id_cat, 0, $arr_toate_cat);
   	   
   	   $rows=$arbore->getArboreComplet();   	    	   		
   	   $rows[]=array("id_cat"=>$id_cat);   	   
   	   $nr_rows=count($rows);   	   
   	   
   	   //@sterg subcategoriile si produsele asociate + pozele lor
   	   for($i=0;$i<$nr_rows;$i++)
   	   {   	   		
   	   		@unlink(URL_BASE_ABS."poze_categorii/".$rows[$i]["id_cat"].".jpg");
   	   		@unlink(URL_BASE_ABS."poze_categorii/mici/".$rows[$i]["id_cat"].".jpg");   	   		
   	   		
   	   		$arr_produse=arrayFromDB(array("id_produs"), "t_produse", "WHERE id_cat='".$rows[$i]["id_cat"]."'");
	   	    $nr_produse=count($arr_produse);
	   	   
	   	    for($j=0;$j<$nr_produse;$j++)	   	    	   	      	    		   	    
	   	    	stergeProdus($arr_produse[$j]["id_produs"]);	   	    	
	   	    	   	    
	   	    unset($arr_produse, $nr_produse);
   	   }
   	  
   	   //@nu am folosit for-ul de mai sus pt stergere deoarecere nu ar mai fi functionat corect stergeProdus() cu categoriile sterse
   	   for($i=0;$i<$nr_rows;$i++)
   	   {
	   		arrayDeleteFromDB("t_categorii", array("id_cat"), array($rows[$i]["id_cat"]));
	   		arrayDeleteFromDB("t_filtre", array("id_cat"), array($rows[$i]["id_cat"]));
	   		arrayDeleteFromDB("t_filtre", array("id_cat"), array($rows[$i]["id_cat"]));
	   		arrayDeleteFromDB("t_liste_discount_categorii", array("id_cat"), array($rows[$i]["id_cat"]));
	   		
	   		//@selectez gruparile de filtre pt categoria de sters, pentru a le sterge si pe "dansele" :P
	   		$arr_grupuri_filtre=arrayFromDB("*", "t_categorii_filtre", "WHERE id_cat='".$rows[$i]["id_cat"]."'");
	   		
	   		if(is_array($arr_grupuri_filtre) && count($arr_grupuri_filtre)>0)
	   		{
	   			foreach ($arr_grupuri_filtre as $key=>$value)
	   			{
	   				arrayDeleteFromDB("t_categorii_filtre", array("id_cat_filtru"), array($value["id_cat_filtru"]));
	   				arrayDeleteFromDB("t_relatii_cat_filtre", array("id_cat_filtru"), array($value["id_cat_filtru"]));
	   			}
	   		}
   	   }
	   		   
  	   return true;
	}
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@sterge produs (o functie unificata care sterge produsul din toate tabelele unde apare id_produs (mai putin "t_comenzi") + sterge pozele asociate)
	function stergeProdus($id_produs)
	{		
		//@basic check
        if(!is_numeric($id_produs))
            return false;
		
		//@aflu categoria si producatorul produsului
		$arr_produs=arrayFromDB(array("id_cat", "id_prod"), "t_produse", "WHERE id_produs='".$id_produs."'");
		
		//@second check
        if(count($arr_produs)!=1)
       	    return false;
       	   
		$id_cat=$arr_produs[0]["id_cat"];
		$id_prod=$arr_produs[0]["id_prod"];
		
		require_once("../clase/arbore.php");
		
		$arbore=new arbore($id_cat, 0, $arr_toate_cat);
		$rows=$arbore->getParintiGasiti();
		
		(!empty($id_cat))?$rows[]=$id_cat:""; //adaug categoria in array pt a decrementa cantitatile dintr-un foc
		(!empty($id_prod))?$rows[]=$id_prod:""; //adaug producatorul in array pt a decrementa cantitatile dintr-un foc
			
		$nr_rows=count($rows);
		
		//@decrementez cantitatile din: categoria produsului, categoriile parinti, producator
		for($i=0;$i<$nr_rows;$i++)
			arrayUpdateToDB("t_categorii", array("nr_produse"), array("nr_produse-1"), array("id"=>"id_cat", "valoare"=>$rows[$i]), true);		
		
		//@sterg produsul din tabelele in care apare mai putin t_comenzi	
		arrayDeleteFromDB("t_produse", array("id_produs"), array($id_produs));	   	
	   	arrayDeleteFromDB("t_alerte", array("id_produs"), array($id_produs));
	   	arrayDeleteFromDB("t_alerte_stoc", array("id_produs"), array($id_produs));
	   	arrayDeleteFromDB("t_comentarii", array("id_produs"), array($id_produs));
	   	arrayDeleteFromDB("t_newsletter_config", array("id_produs"), array($id_produs));
	   	arrayDeleteFromDB("t_produse_cos_salvat", array("id_produs"), array($id_produs));
	   	arrayDeleteFromDB("t_preturi_produse_valuta", array("id_produs"), array($id_produs));
	   	
	   	if(CAT_SECUNDARE)
	   		arrayDeleteFromDB("t_relatii_cat_sec_produse", array("id_produs"), array($id_produs));
	   		
	   	//@sterg directorul cu poze
	   	removeDir(URL_BASE_ABS."poze_produse/".$id_produs);
	   	
	   	return true;
	}
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@resize imagine + watermark
	function resizeImg($img_in, $img_out, $parametru_latime=THUMB_W, $parametru_inaltime=THUMB_H, $do_watermark=false)
	{
		$x=pathinfo($img_in);
		
		if($x['extension']=="jpg" || $x['extension']=="jpeg" || $x['extension']=="JPEG" || $x['extension']=="JPG")
			$img=imagecreatefromjpeg($img_in);
		elseif($x['extension']=="gif" || $x['extension']=="GIF")
			$img=imagecreatefromgif($img_in);
		elseif($x['extension']=="png" || $x['extension']=="PNG")
			$img=imagecreatefrompng($img_in);
		elseif($x['extension']=="bmp" || $x['extension']=="BMP")
			$img=imagecreatefromwbmp($img_in);				
			
		//SET X,Y, RESIZE IMG
		$imagine_latime=imagesx($img);
		$imagine_inaltime=imagesy($img);

		if($imagine_latime>$imagine_inaltime)
			$factor_resize=$imagine_latime/$parametru_latime;
		else	
			$factor_resize=$imagine_inaltime/$parametru_inaltime;
			
		$imagine_micsorata_latime=round($imagine_latime/$factor_resize);
		$imagine_micsorata_inaltime=round($imagine_inaltime/$factor_resize);

		$dstimg=imagecreatetruecolor($imagine_micsorata_latime, $imagine_micsorata_inaltime);
		$trans_color=imagecolorallocate($dstimg, 255, 255, 255);
		imagefill($dstimg, 0, 0, $trans_color);
		imagecopyresampled($dstimg, $img, 0, 0, 0, 0, $imagine_micsorata_latime, $imagine_micsorata_inaltime, $imagine_latime, $imagine_inaltime);
		imagejpeg($dstimg, $img_out, 100);
		
		if($do_watermark)
		{
			$image=@imagecreatefromjpeg($img_out);
			
			$watermark=imagecreatefrompng(DIR_TEMPLATE_ABS."img/watermark.png"); 
			$imagewidth=imagesx($image); 
			$imageheight=imagesy($image); 
			$watermarkwidth=imagesx($watermark); 
			$watermarkheight=imagesy($watermark); 
			
			$startwidth=(($imagewidth-$watermarkwidth)/2); 
			$startheight=(($imageheight-$watermarkheight)/2); 
			imagecopy($image, $watermark, $startwidth, $startheight, 0, 0, $watermarkwidth, $watermarkheight); 
			imagejpeg($image, $img_out); 
		}
	}
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@adauga poza categorie + resize
	function adaugaPozaCategorie($nume_poza, $id_cat)
	{
		if(!is_uploaded_file($_FILES[$nume_poza]["tmp_name"]))
			return;
		
		$adresa_poza=URL_BASE_ABS."poze_categorii/tmp_".$_FILES[$nume_poza]["name"];
		$adresa_poza_mica=URL_BASE_ABS."poze_categorii/mici/tmp_".$_FILES[$nume_poza]["name"];
		
		copy($_FILES[$nume_poza]["tmp_name"], $adresa_poza);
		copy($_FILES[$nume_poza]["tmp_name"], $adresa_poza_mica);
							
		resizeImg($adresa_poza, URL_BASE_ABS."poze_categorii/".$id_cat.".jpg", 90, 90);
		resizeImg($adresa_poza_mica, URL_BASE_ABS."poze_categorii/mici/".$id_cat.".jpg", 40, 40);
		
		unlink($adresa_poza);
		unlink($adresa_poza_mica);
	}
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@adauga poza categorie 
	function adaugaPozaCategorieNoResize($nume_poza_thumb, $nume_poza_medium, $id_inserat)
	{	
		if(is_uploaded_file($_FILES[$nume_poza_thumb]["tmp_name"]))
			move_uploaded_file($_FILES[$nume_poza_thumb]["tmp_name"], URL_BASE_ABS."poze_categorii/mici/".$id_inserat.".jpg");
			
		if(is_uploaded_file($_FILES[$nume_poza_medium]["tmp_name"]))
			move_uploaded_file($_FILES[$nume_poza_medium]["tmp_name"], URL_BASE_ABS."poze_categorii/".$id_inserat.".jpg");	
	}
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@adauga poza produs
	function adaugaPozaProdus($nume_poza, $id_produs, $i, $watermark, $nr_ultima_poza="")
	{
		if(!is_uploaded_file($_FILES[$nume_poza]["tmp_name"][$i]))
			return;
			
		$adresa_poza=URL_BASE_ABS."poze_produse/".$id_produs."/supermari/".$_FILES[$nume_poza]["name"][$i];
		
		move_uploaded_file($_FILES[$nume_poza]["tmp_name"][$i], $adresa_poza);
			
		//@Note: incrementez $i cu 1 ca sa nu suprascriu poza principala care are numele 0.jpg
		$nume_poza_nou=($i+1+$nr_ultima_poza).".jpg";
		$adresa_destinatie=URL_BASE_ABS."poze_produse/".$id_produs."/%s/".$nume_poza_nou;
				
		resizeImg($adresa_poza, sprintf($adresa_destinatie, "mici"), 57, 57);
		resizeImg($adresa_poza, sprintf($adresa_destinatie, "medii"), 120, 120);
		resizeImg($adresa_poza, sprintf($adresa_destinatie, "mari"), 300, 300);
		resizeImg($adresa_poza, sprintf($adresa_destinatie, "supermari"), 450, 450, $watermark);
		
		if($adresa_poza!=sprintf($adresa_destinatie, "supermari"))
			@unlink($adresa_poza);
	}
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@adauga poza principala produs
	function adaugaPozaPrincipalaProdus($nume_poza, $id_produs, $watermark)
	{
		if(!is_uploaded_file($_FILES[$nume_poza]["tmp_name"]))
			return;
			
		$adresa_poza=URL_BASE_ABS."poze_produse/".$id_produs."/supermari/".$_FILES[$nume_poza]["name"];
		
		move_uploaded_file($_FILES[$nume_poza]["tmp_name"], $adresa_poza);
			
		$adresa_destinatie=URL_BASE_ABS."poze_produse/".$id_produs."/%s/0.jpg";
		
		resizeImg($adresa_poza, sprintf($adresa_destinatie, "mici"), 57, 57);
		resizeImg($adresa_poza, sprintf($adresa_destinatie, "medii"), 120, 120);
		resizeImg($adresa_poza, sprintf($adresa_destinatie, "mari"), 300, 300);
		resizeImg($adresa_poza, sprintf($adresa_destinatie, "supermari"), 450, 450, $watermark);
		
		if($adresa_poza!=sprintf($adresa_destinatie, "supermari"))
			@unlink($adresa_poza);
	}
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@inverse nl2br
	function inverse_nl2br($string)
	{
		return str_replace("<br />", "", $string);
	}
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@stergere recursiva a unui director, daca empty este pus pe TRUE sterge doar continutul directorului
	function removeDir($directory, $empty=FALSE)
	{
		if(substr($directory, -1)=="/")
			$directory = substr($directory, 0, -1);
	
		if(!file_exists($directory) || !is_dir($directory))
		{
			return FALSE;
		}
		elseif(!is_readable($directory))
		{
			return FALSE;
		}
		else
		{
			$handle=opendir($directory);
	
			while(FALSE!==($item=readdir($handle)))
			{
				if($item!="." && $item!="..")
				{
					$path=$directory."/".$item;
	
					if(is_dir($path)) 
						removeDir($path);
					else
						unlink($path);
				}
			}
			closedir($handle);
	
			if($empty==FALSE)
			{
				if(!rmdir($directory))
					return FALSE;
			}
			return TRUE;
		}
	}	
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@extrage extensia unui fisier
	function getExtensieFisier($nume_fisier)
	{
		 return strtolower(substr($nume_fisier, strrpos($nume_fisier, '.') + 1));
	}
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@face exact ce zice numele
	function restrictioneazaAccesSubadmini()
	{
		//@pagini pe care nu au acces subadminii
		global $arr_pagini_restrictionate;
		
		$pagina_curenta=preg_replace("/\/(.*)?\/(.*).php/", "$2.php", $_SERVER["PHP_SELF"]);
		
		if(in_array($pagina_curenta, $arr_pagini_restrictionate) && $_SESSION["admin_super_admin"]!=1)
			die("Aceasta sectiune este interzisa subadminilor! <br /><a href='".URL_ADMIN."'>Prima pagina din administrare.</a>");
	}
?>