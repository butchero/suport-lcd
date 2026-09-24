<?
	/*
	 *****************************************************************************
	 *****************************************************************************
	 **                                                                         **
	 **          CIUCA VALERIU (BUTCHER) - GOGO PROMOTIONS - 2007       		**
	 **                                                                         **
	 *****************************************************************************
	 *****************************************************************************
	*/
	//-----------------------------------------------------------------------------------------------------------------------------
	//@include-uri
	require_once("../conectare.php");
	require_once("../configurare.php");
	require_once("../functii/f_generale.php");
	require_once("../clase/fpdf.php");
	require_once("../init.php");
		
	//-----------------------------------------------------------------------------------------------------------------------------
	class PDF extends FPDF
	{
		//-------------------------------------------------------------------------------------------------------------------------
		//@latime tabel (in care sunt afisate produsele)
		var $latime=array(10, 92, 9, 16, 23, 20, 20);
		
		//-------------------------------------------------------------------------------------------------------------------------
		//@date cumparator
		var $cumparator="";
		var $nr_reg_comert="";
		var $cui="";
		var $adresa="";
		var $judetul="";
		var $contul="";
		var $banca="";
		
		//-------------------------------------------------------------------------------------------------------------------------
		//@transport
		var $transport="";
		var $transport_cost="";
		
		//-------------------------------------------------------------------------------------------------------------------------
		//@date produse
		var $date=array();
		
		//-------------------------------------------------------------------------------------------------------------------------
		//@info client - a fost adaugat dupa finalizarea proformei si anumite variabile contin aceleasi informatii...:/
		var $tip_facturare="";
		var $nume_prenume="";
		var $societate="";
		var $telefon="";
		var $telefon_mobil="";
		var $fax="";
		var $email="";
		var $cod_postal="";
		var $localitate="";
		var $alta_adresa=array();	
		
		var $comentariu_comanda="";	
		
		//-------------------------------------------------------------------------------------------------------------------------
		//ADAUGA PRODUS
		function adaugaProdus($nume_produs, $cantitate, $pret, $id_produs, $um="buc.") 
		{
			$this->date[]=array("nume_produs"=>$nume_produs, "cantitate"=>$cantitate, "pret"=>$pret, "id_produs"=>$id_produs, "um"=>$um);
		}
		
		//-------------------------------------------------------------------------------------------------------------------------
		//HEADER PAGINA
		function Header()
		{
		    //@sigla
		    //$this->Image(DIR_TEMPLATE_ABS."img/sigla.jpg", 11, 8, 0, 26, "", URL_BASE);
		    		    
		    //@linie noua
		    $this->Ln(5);
		}
		
		//-------------------------------------------------------------------------------------------------------------------------
		//FOOTER PAGINA
		function Footer()
		{
		    //@Pozitionat la 1.5 cm de marginea de jos
		    $this->SetY(-15);
		    
		    //@fontul
		    $this->SetFont("Arial", "I", 8);
		    
		    //@nr paginii
		    $this->Cell(0, 10, "Pagina ".$this->PageNo()."/{nb}", 0, 0, "C");
		}
		
		//-------------------------------------------------------------------------------------------------------------------------
		//HEADER PROFORMA CU DATELE SOCIETATII SI DATELE CUMPARATORULUI
		function genereazaHeaderProforma($factura_fiscala=false)
		{
			$this->SetFont("Arial", "", 8);
			
			//@culori, font, grosimie linie tabel
		    $this->SetFillColor(255, 255, 255);
		    $this->SetTextColor(0, 0, 0);
		    $this->SetDrawColor(0, 0, 0);
		    $this->SetLineWidth(.2);
		    $this->SetFont("", "B");
		    
		    //@linie noua
			$this->Ln();
			
			$this->SetFont("", "");
			$this->Cell(16, 6, "Furnizor:", "TL", 0, "L", 1);
			$this->SetFont("Arial", "B", 12);
			$this->Cell(76, 6, strtoupper(NUME_FIRMA), "T", 0, "L", 1);
			$this->SetFont("Arial", "", 8);
			$this->cell(30, 6, "", "T", 0, "L", 1);			
			$this->cell(18, 6, "Cumparator: ", "T", 0, "L", 1);
			$this->SetFont("Arial", "B", 8);
			$this->cell(50, 6, $this->cumparator, "TR", 0, "L", 1);
			$this->SetFont("Arial", "", 8);
			
			//@linie noua
			$this->Ln();
						
			$this->Cell(16, 6, "Nr. inreg. in:", "L", 0, "L", 1);	
			$this->SetFont("Arial", "B");		
			$this->Cell(76, 6, "Registrul com/an ".NR_REG_COMERT, "", 0, "L", 1);
			$this->SetFont("Arial", "", 8);
			$this->cell(30, 6, "", "", 0, "L", 1);			
			$this->cell(44, 6, "Nr. de inmatric. in Reg. com/anul:", "", 0, "L", 1);
			$this->SetFont("Arial", "B", 8);
			$this->cell(24, 6, $this->nr_reg_comert, "R", 0, "L", 1);
			$this->SetFont("Arial", "", 8);
			
			//@linie noua
			$this->Ln();
			
			$this->Cell(16, 6, "Cod fiscal:", "L", 0, "L", 1);	
			$this->SetFont("Arial", "B");		
			$this->Cell(76, 6, COD_FISCAL, "", 0, "L", 1);
			$this->SetFont("Arial", "", 8);
			$this->cell(30, 6, "", "", 0, "L", 1);			
			$this->cell(28, 6, "Codul fiscal (C.U.I.):", "", 0, "L", 1);
			$this->SetFont("Arial", "B", 8);
			$this->cell(40, 6, $this->cui, "R", 0, "L", 1);
			$this->SetFont("Arial", "", 8);
			
			//@linie noua
			$this->Ln();
			
			$this->Cell(16, 6, "Sediul:", "L", 0, "L", 1);	
			$this->SetFont("Arial", "B");		
			$this->Cell(50, 6, SEDIUL, "", 0, "L", 1);
			$this->SetFont("Arial", "B", 16);
			$this->cell(56, 6, "FACTURA", "", 0, "C", 1);	
			$this->SetFont("Arial", "", 7);		
			$this->cell(10, 6, "Sediul:", "", 0, "L", 1);
			$this->SetFont("Arial", "B", 8);
			$this->cell(58, 6, $this->adresa, "R", 0, "L", 1);
			$this->SetFont("Arial", "", 8);
			
			//@linie noua
			$this->Ln();
			
			$this->Cell(16, 6, "Judetul:", "L", 0, "L", 1);		
			$this->SetFont("Arial", "B");	
			$this->Cell(50, 6, JUDETUL, "", 0, "L", 1);
			$this->SetFont("Arial", "B", 16);
			
			if($factura_fiscala==false)
				$this->cell(56, 6, "PROFORMA", "", 0, "C", 1);	
			else
			{
				$this->SetFont("Arial", "", 10);	
				$this->cell(56, 6, "serie ............ nr. ........................", "", 0, "C", 1);	
			}
				
			$this->SetFont("Arial", "", 8);		
			$this->cell(11, 6, "Judetul:", "", 0, "L", 1);
			$this->SetFont("Arial", "B", 8);
			$this->cell(57, 6, $this->judetul, "R", 0, "L", 1);
			$this->SetFont("Arial", "", 8);
			
			//@linie noua
			$this->Ln();
			
			$this->Cell(16, 6, "Cont:", "L", 0, "L", 1);	
			$this->SetFont("Arial", "B");		
			$this->Cell(50, 6, CONT, "", 0, "L", 1);	
			
			if($factura_fiscala==false)
			{
				$this->cell(56, 6, "", "", 0, "C", 1);
			}
			else
			{
				$this->SetFont("Arial", "", 10);	
				$this->cell(56, 6, "data: ........................", "", 0, "C", 1);
				$this->SetFont("Arial", "", 8);	
			}
				
			$this->SetFont("Arial", "");				
			$this->cell(11, 6, "Contul:", "", 0, "L", 1);
			$this->SetFont("Arial", "B", 8);
			$this->cell(57, 6, $this->contul, "R", 0, "L", 1);
			$this->SetFont("Arial", "", 8);
			
			//@linie noua
			$this->Ln();
			
			$this->Cell(16, 6, "Banca:", "L", 0, "L", 1);
			$this->SetFont("Arial", "B");			
			$this->Cell(50, 6, BANCA, "", 0, "L", 1);			
			$this->cell(56, 6, "", "", 0, "C", 1);	
			$this->SetFont("Arial", "");				
			$this->cell(11, 6, "Banca:", "", 0, "L", 1);
			$this->SetFont("Arial", "B", 8);
			$this->cell(57, 6, $this->banca, "R", 0, "L", 1);
			$this->SetFont("Arial", "", 8);
			
			//@linie noua
			$this->Ln();
		}
		
		//-------------------------------------------------------------------------------------------------------------------------
		//GENERATOR TABEL
		function genereazaTabel()
		{
		    //@culori, font, grosimie linie tabel
		    $this->SetFont("Arial", "", 8);
		    $this->SetFillColor(242, 242, 242);
		    $this->SetTextColor(0, 0, 0);
		    $this->SetDrawColor(0, 0, 0);
		    $this->SetLineWidth(.2);
		    $this->SetFont("", "B");
		        		    
		    $this->Cell($this->latime[0], 5, "Nr.", "LRT", 0, "C", 1);
		    $this->Cell($this->latime[1], 5, "Denumirea produselor", "LRT", 0, "C", 1);
		    $this->Cell($this->latime[2], 5, "U.M.", "LRT", 0, "C", 1);
		    $this->Cell($this->latime[3], 5, "Cantitate", "LRT", 0, "C", 1);
		    $this->Cell($this->latime[4], 5, "Pretul unitar", "LRT", 0, "C", 1);
		    $this->Cell($this->latime[5], 5, "Valoarea Tot.", "LRT", 0, "C", 1);
		    $this->Cell($this->latime[6], 5, ((TVA==1)?"Pret unitar":"Valoarea"), "LRT", 0, "C", 1);

		    //@linie noua
		    $this->Ln();
		    
		    $this->Cell($this->latime[0], 5, "crt.", "LBR", 0, "C", 1);
		    $this->Cell($this->latime[1], 5, "sau a serviciilor", "LBR", 0, "C", 1);
		    $this->Cell($this->latime[2], 5, "", "LBR", 0, "C", 1);
		    $this->Cell($this->latime[3], 5, "", "LBR", 0, "C", 1);
		    $this->Cell($this->latime[4], 5, ((TVA==1)?"cu":"fara")." TVA (RON)", "LBR", 0, "C", 1);
		    $this->Cell($this->latime[5], 5, ((TVA==1)?"cu":"fara")." TVA (RON)", "LBR", 0, "C", 1);
		    $this->Cell($this->latime[6], 5, ((TVA==1)?"(fara TVA)":"T.V.A. (19%)"), "LBR", 0, "C", 1);
		    
		    //@linie noua
		    $this->Ln();
		    
		    //@culori si font
		    $this->SetFillColor(248, 248, 248);
		    $this->SetTextColor(0);
		    $this->SetFont("");
		    
		    $fill=0;
		    
		    //@ordonare produse alfabetic (asa vrea gsmnet)
		    foreach($this->date as $k=>$v)
		    {
		    	$nume_produs[$k]=$v["nume_produs"];
		    	$cantitate[$k]=$v["cantitate"];
		    	$pret[$k]=$v["pret"];
		    	$um[$k]=$v["um"];
		    }
		    
		    @array_multisort($nume_produs, SORT_ASC, $this->date);
		    
		    //@date produse
		    $i=1;
		    
		    foreach($this->date as $row)
		    {		    	
		        $this->Cell($this->latime[0], 6, $i, "LR", 0, "C", $fill);
		        
		        $arr_produs=arrayFromDB("*", "t_produse", "WHERE id_produs='".$row["id_produs"]."'");
		        
		        if($arr_produs[0]["stoc"]!=2)
		        	$this->SetTextColor(242, 34, 7);
		        
		        $this->Cell($this->latime[1], 6, stringLimit($row["nume_produs"], 65, "..").((!empty($arr_produs[0]["cod_produs"]))?" - ".$arr_produs[0]["cod_produs"]:""), "LR", 0, "L", $fill);
		        $this->Cell($this->latime[2], 6, $row["um"], "LR", 0, "R", $fill);
		        $this->Cell($this->latime[3], 6, $row["cantitate"], "LR", 0, "C", $fill);
		        $this->Cell($this->latime[4], 6, formateazaNr($row["pret"]), "LR", 0, "R", $fill); // pretul unitar
		        $this->Cell($this->latime[5], 6, formateazaNr($row["pret"]*$row["cantitate"]), "LR", 0, "R", $fill);  // valoare= pret_unitar * cantitate
		        $this->Cell($this->latime[6], 6, (TVA==1)?formateazaNr($row["pret"]/1.19):formateazaNr($row["pret"]*$row["cantitate"]*TVA_NEPRELUCRAT), "LR", 0, "R", $fill); //valoarea_tva= pret_unitar * cantitate * 0.19
		        $this->Ln();
		        
		        $this->SetTextColor(0);	
		        
		        $fill=!$fill;
		        
		        $i++;
		        $total_valoare+=$row["pret"]*$row["cantitate"];
		        $total_valoare_tva+=$row["pret"]*$row["cantitate"]*TVA_NEPRELUCRAT;
		    }
		    		    
		    if($this->transport!="" && is_numeric($this->transport_cost))
		    {
			    //@transport
			    $transport=(($total_valoare+$total_valoare_tva)>=TRANSPORT_GRATUIT && TRANSPORT_GRATUIT!=0)?0:$this->transport_cost;
			    
			    $this->Cell($this->latime[0], 6, $i, "LR", 0, "C", $fill);
			    $this->Cell($this->latime[1], 6, $this->transport, "LR", 0, "L", $fill);
			    $this->Cell($this->latime[2], 6, "buc.", "LR", 0, "R", $fill);
		        $this->Cell($this->latime[3], 6, "1", "LR", 0, "C", $fill);
		        $this->Cell($this->latime[4], 6, formateazaNr($transport/TVA), "LR", 0, "R", $fill); // pretul unitar
		        $this->Cell($this->latime[5], 6, formateazaNr($transport/TVA), "LR", 0, "R", $fill);  // valoare= pret_unitar * cantitate
		        $this->Cell($this->latime[6], 6, (TVA==1)?formateazaNr($transport/1.19):formateazaNr($transport-($transport/1.19)), "LR", 0, "R", $fill); //valoarea_tva= pret_unitar * cantitate * 0.19
 
		        $total_valoare+=$transport/TVA;
		        $total_valoare_tva+=(TVA==1)?($transport/1.19):($transport-($transport/1.19));
		        
		        $this->Ln();
		    }
		    
		    //@linia care inchide tabelul
		    $this->Cell(array_sum($this->latime), 0, "", "T");
		    
		    //@linie noua
		    $this->Ln();
		    
		    $this->Cell($this->latime[0]+$this->latime[1]+$this->latime[2]+$this->latime[3], 20, "", "TLBR", 0, "C", 0);
		    $this->Cell($this->latime[4], 5, "Total din", "TLR", 0, "L", 0);
		    $this->Cell($this->latime[5], 5, formateazaNr($total_valoare), "TLBR", 0, "R", 0); // total valoare
		    $this->Cell($this->latime[6], 5, (TVA==1)?"-":formateazaNr($total_valoare_tva), "TLBR", 0, "R", 0); // total valoare tva
		    
		    //@linie noua
		    $this->Ln();
		    
		    $this->Cell($this->latime[0]+$this->latime[1]+$this->latime[2]+$this->latime[3], 0, "", "", 0, "C", 0);
		    $this->Cell($this->latime[4], 5, "care accize", "LBR", 0, "L", 0);
		    $this->Cell($this->latime[5], 5, "", "TLBR", 0, "R", 0);
		    $this->Cell($this->latime[6], 5, "", "TLBR", 0, "C", 0);
		    
		    //@linie noua
		    $this->Ln();
		    
		    $this->Cell($this->latime[0]+$this->latime[1]+$this->latime[2]+$this->latime[3], 0, "", "", 0, "C", 0);
		    $this->Cell($this->latime[4], 5, "Semnatura", "LR", 0, "C", 0);
		    $this->SetFont("", "B");
		    $this->Cell($this->latime[5]+$this->latime[6], 5, "Total de plata", "TR", 0, "C", 0);
		    $this->SetFont("", "");
		    
		    //@linie noua
		    $this->Ln();
		    
		    $this->Cell($this->latime[0]+$this->latime[1]+$this->latime[2]+$this->latime[3], 0, "", "", 0, "C", 0);
		    $this->Cell($this->latime[4], 5, "de primire", "LBR", 0, "C", 0);		    
		    $this->SetFont("Arial", "B", 10);
		    $this->Cell($this->latime[5]+$this->latime[6], 5, formateazaNr((TVA==1)?$total_valoare:($total_valoare+$total_valoare_tva)), "LBR", 0, "C", 0); //total de plata
		    $this->SetFont("", "");   
		}
		
		//-------------------------------------------------------------------------------------------------------------------------
		//GENEREAZA INFO CLIENT
		function genereazaInfoClient()
		{
			//@tip facturare
			$this->Ln(10);
			$this->SetFont("Arial", "B", 8);
			$this->Cell(25, 5, "TIP FACTURARE:");
			$this->SetFont("", "");
			$this->Cell(20, 5, ($this->tip_facturare==0)?"Persoana fizica":"Persoana juridica");
			
			//@alta adresa de livrare
			$this->Ln(10);
			$this->SetFont("", "B");			
			$this->Cell(190, 5, "ADRESA LIVRARE", "LTR");
			
			$this->Ln();
			$this->SetFont("", "B");
			$this->Cell(50, 5, "Adresa:", "LT");
			$this->SetFont("", "");
			$this->Cell(140, 5, $this->alta_adresa["adresa"], "LTR");
			
			$this->Ln();
			$this->SetFont("", "B");
			$this->Cell(50, 5, "Cod postal:", "LT");
			$this->SetFont("", "");
			$this->Cell(140, 5, $this->alta_adresa["cod_postal"], "LTR");
			
			$this->Ln();
			$this->SetFont("", "B");
			$this->Cell(50, 5, "Localitate:", "LT");
			$this->SetFont("", "");
			$this->Cell(140, 5, $this->alta_adresa["localitate"], "LTR");
			
			$this->Ln();
			$this->SetFont("", "B");
			$this->Cell(50, 5, "Judet:", "LTB");
			$this->SetFont("", "");
			$this->Cell(140, 5, $this->alta_adresa["judet"], "LTRB");
			
			$this->Ln(10);
			$this->SetFont("", "B");
			$this->Cell(20, 5, "Comentariu: ");
			$this->SetFont("", "");
			$this->Cell(20, 5, ($this->comentariu_comanda=="")?"-":$this->comentariu_comanda);
			
			//@date client
			$this->Ln(10);
			$this->SetFont("Arial", "B", 8);
			$this->Cell(190, 5, "DATE CLIENT", "LTR");
			
			$this->Ln();			
			$this->Cell(50, 5, "Nume:", "LT");
			$this->SetFont("", "");
			$this->Cell(140, 5, $this->nume_prenume, "LTR");
			
			$this->Ln();
			$this->SetFont("", "B");
			$this->Cell(50, 5, "Societate:", "LT");
			$this->SetFont("", "");
			$this->Cell(140, 5, $this->societate, "LTR");
			
			$this->Ln();
			$this->SetFont("", "B");
			$this->Cell(50, 5, "Nr. Reg. Comert:", "LT");
			$this->SetFont("", "");
			$this->Cell(140, 5, $this->nr_reg_comert, "LTR");
			
			$this->Ln();
			$this->SetFont("", "B");
			$this->Cell(50, 5, "Banca:", "LT");
			$this->SetFont("", "");
			$this->Cell(140, 5, $this->banca, "LTR");
			
			$this->Ln();
			$this->SetFont("", "B");
			$this->Cell(50, 5, "Cod IBAN:", "LT");
			$this->SetFont("", "");
			$this->Cell(140, 5, $this->contul, "LTR");
			
			$this->Ln();
			$this->SetFont("", "B");
			$this->Cell(50, 5, "CNP/Cod fiscal:", "LT");
			$this->SetFont("", "");
			$this->Cell(140, 5, $this->cui, "LTR");
			
			$this->Ln();
			$this->SetFont("", "B");
			$this->Cell(50, 5, "Adresa:", "LT");
			$this->SetFont("", "");
			$this->Cell(140, 5, $this->adresa, "LTR");
			
			$this->Ln();
			$this->SetFont("", "B");
			$this->Cell(50, 5, "Cod postal:", "LT");
			$this->SetFont("", "");
			$this->Cell(140, 5, $this->cod_postal, "LTR");
			
			$this->Ln();
			$this->SetFont("", "B");
			$this->Cell(50, 5, "Localitate:", "LT");
			$this->SetFont("", "");
			$this->Cell(140, 5, $this->localitate, "LTR");
			
			$this->Ln();
			$this->SetFont("", "B");
			$this->Cell(50, 5, "Judet:", "LT");
			$this->SetFont("", "");
			$this->Cell(140, 5, $this->judetul, "LTR");
			
			$this->Ln();
			$this->SetFont("", "B");
			$this->Cell(50, 5, "Telefon:", "LT");
			$this->SetFont("", "");
			$this->Cell(140, 5, $this->telefon, "LTR");
			
			$this->Ln();
			$this->SetFont("", "B");
			$this->Cell(50, 5, "Telefon mobil:", "LT");
			$this->SetFont("", "");
			$this->Cell(140, 5, $this->telefon_mobil, "LTR");
			
			$this->Ln();
			$this->SetFont("", "B");
			$this->Cell(50, 5, "Fax:", "LT");
			$this->SetFont("", "");
			$this->Cell(140, 5, $this->fax, "LTR");
			
			$this->Ln();
			$this->SetFont("", "B");
			$this->Cell(50, 5, "E-mail:", "LTB");
			$this->SetFont("", "");
			$this->Cell(140, 5, $this->email, "LTRB");
		}
	}
	
	//-----------------------------------------------------------------------------------------------------------------------------
	//INSTANTIEZ CLASA PDF - codul demo de mai jos pt testing only accesand direct fisierul
	/*
	$pdf=new PDF("P", "mm", "A4");
	$pdf->AliasNbPages();
	$pdf->AddPage();
	
	//@date cumparator
	$pdf->cumparator="S.C. Gecad SOFT S.R.L.";
	$pdf->nr_reg_comert="J13/1749/2004";
	$pdf->cui="16750904";
	$pdf->adresa="Navodari, Str. Nuferilor, nr. 6, bl. 36";
	$pdf->judetul="Constanta";
	$pdf->contul="RO62BRDE140SV207895661400";
	$pdf->banca="BRD SVC. Delfinariu";
	
	//@transport
	$pdf->transport="TRANSPORT: Curierul sageata mov turbat";
	$pdf->transport_cost=12;
	
	//@adaug produsele
	$pdf->adaugaProdus("Gigabyte 7VAX socket A", 3, 30); //(nume_produs, cantitate, pret_unitar_fara_tva)
	$pdf->adaugaProdus("Intel Celeron", 1, 220);
	$pdf->adaugaProdus("Mouse Logitech MX 310", 2, 152);
			
	$pdf->genereazaHeaderProforma();	
	$pdf->genereazaTabel();
	$pdf->genereazaInfoClient();

	$pdf->Output();
	*/
?>