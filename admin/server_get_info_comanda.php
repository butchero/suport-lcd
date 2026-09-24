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
	session_name("admin");
	session_start();
	
	//@include-uri
	require_once("../conectare.php");	
	require_once("../configurare.php");
	require_once("../functii/f_bd.php");
	require_once("../functii/f_admin.php");	
	require_once("../functii/f_catalog.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@autorizare user logat
	require_once("autentificare.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@proceseaza requestul
	if(is_numeric($_GET["id_comanda"]) && !empty($_GET["id_comanda"]))
	{
		$id_comanda=$_GET["id_comanda"];
		
		$arr_comanda=arrayFromDB("*",
								 "t_comenzi INNER JOIN t_useri ON t_comenzi.id_user=t_useri.id_user",
								 "WHERE id_comanda='".$id_comanda."'");

		//----------------------------------------------------------------------------------------------------------------------				   
		//@nr comenzi onorate, anulate
		$arr_comenzi_anulate=arrayFromDB(array("COUNT(id_comanda) AS nr"), "t_comenzi", "WHERE stare='3' AND id_user='".$arr_comanda[0]["id_user"]."'");
		$arr_comenzi_onorate=arrayFromDB(array("COUNT(id_comanda) AS nr"), "t_comenzi", "WHERE stare='2' AND id_user='".$arr_comanda[0]["id_user"]."'");
		$arr_comenzi_noi=arrayFromDB(array("COUNT(id_comanda) AS nr"), "t_comenzi", "WHERE (stare='0' OR stare='1') AND id_user='".$arr_comanda[0]["id_user"]."'");							 
								  
		//@judetul						 
		$arr_judet=arrayFromDB(array("judet"), "t_judete", "WHERE id_jud='".$arr_comanda[0]["id_jud"]."'");
		$judet=$arr_judet[0]["judet"];
		
		//@alta adresa de livrare -- unserialize din bd, aici e cam treaba de mantuiala ca sa termin mai rpd
		if(!empty($arr_comanda[0]["alta_adresa_livrare"]))
		{
			$alta_adresa=unserialize($arr_comanda[0]["alta_adresa_livrare"]);
			
			foreach($alta_adresa as $key=>$value)
			{
				if($key=="id_jud")
				{
					$arr_judet_temp=arrayFromDB(array("judet"), "t_judete", "WHERE id_jud='".$value."'");
					$judet_temp=$arr_judet_temp[0]["judet"];
					
					$adresa.="Judet: <b>".$judet_temp."</b><br />";
				}
				else
				{
					$adresa.=ucwords(str_replace("_", " ", $key)).": <b>".$value."</b><br />";
				}
			}	
		}

		//@modific statutul comenzii din "asteapta procesare" in "procesare"
		if($arr_comanda[0]["stare"]!=2 && $arr_comanda[0]["stare"]!=3)
			arrayUpdateToDB("t_comenzi", array("stare"), array("1"), array("id"=>"id_comanda", "valoare"=>$id_comanda));
		 
		//@output ajax cu datele utilizatorului
		$output="<table cellpadding='0' cellspacing='0' class='box' style='background-color:#FAFAFA;border-top:3px solid #FAF4DA' width='100%'>
					<tr>
						<td colspan='2' align='left' style='padding:1px'>	
							<input type='button' value='INCHIDE DETALII' class='buton_anuleaza' onClick=\"closeInfoComanda('".$id_comanda."')\">
						</td>
					</tr>
					<tr>
						<td valign='top' width='50%'>
							<table width='100%'>
								<tr>
									<td class='text_mic_default'>Username:</td>
									<td class='text_mic' align='left'><b>".$arr_comanda[0]["username"]."</b></td>
								</tr>
								<tr>
									<td class='text_mic_default'>Nume:</td>
									<td class='text_mic' align='left'><b>".$arr_comanda[0]["nume"]." ".$arr_comanda[0]["prenume"]."</b></td>
								</tr>
								<tr>
									<td class='text_mic_default'>CNP:</td>
									<td class='text_mic' align='left'><b>".$arr_comanda[0]["cnp"]."</b></td>
								</tr>
								<tr>
									<td class='text_mic_default'>Societate:</td>
									<td class='text_mic' align='left'><b>".$arr_comanda[0]["societate"]."</b></td>
								</tr>
								<tr>
									<td class='text_mic_default'>Nr. Reg. Comert:</td>
									<td class='text_mic' align='left'><b>".$arr_comanda[0]["nr_reg_comert"]."</b></td>
								</tr>
								<tr>
									<td class='text_mic_default'>Banca:</td>
									<td class='text_mic' align='left'><b>".$arr_comanda[0]["banca"]."</b></td>
								</tr>
								<tr>
									<td class='text_mic_default'>Cod IBAN:</td>
									<td class='text_mic' align='left'><b>".$arr_comanda[0]["cod_iban"]."</b></td>
								</tr>
								<tr>
									<td class='text_mic_default'>CF:</td>
									<td class='text_mic' align='left'><b>".$arr_comanda[0]["cod_fiscal"]."</b></td>
								</tr>
							 </table>
						 </td>
						 <td width='20'></td>	 
						 <td valign='top' width='50%'>
						 	<table width='100%'>
								<tr>
									<td class='text_mic_default' width='80' valign='top'>Adresa:</td>
									<td class='text_mic' align='left'><b>".$arr_comanda[0]["adresa"]."</b></td>
								</tr>
								<tr>
									<td class='text_mic_default'>Cod postal:</td>
									<td class='text_mic' align='left'><b>".$arr_comanda[0]["cod_postal"]."</b></td>
								</tr>
								<tr>
									<td class='text_mic_default'>Loc/Jud:</td>
									<td class='text_mic' align='left'><b>".strtoupper($arr_comanda[0]["localitate"])."/".strtoupper($judet)."</b></td>
								</tr>
								<tr>
									<td class='text_mic_default'>Telefon:</td>
									<td class='text_mic' align='left'><b>".$arr_comanda[0]["telefon"]."</b></td>
								</tr>	
								<tr>
									<td class='text_mic_default'>Mobil:</td>
									<td class='text_mic' align='left'><b>".$arr_comanda[0]["telefon_mobil"]."</b></td>
								</tr>							
								<tr>
									<td class='text_mic_default'>Email:</td>
									<td class='text_mic' align='left'><a href='mailto:".$arr_comanda[0]["email"]."' class='link_default_mic'>".$arr_comanda[0]["email"]."</a></td>
								</tr>
								<tr>
									<td class='text_mic_default'>Tip fact.:</td>
									<td class='eroare_text_mic' align='left'><b>".(($arr_comanda[0]["tip_factura"]==0)?"PERS. FIZICA":"PERS. JURIDICA")."</b></td>
								</tr>".
								((!empty($adresa))?
								"<tr>
									<td class='text_mic_default' valign='top'>Alta adresa de livrare:</td>
									<td></td>
								</tr>	
								<tr><td colspan='2' class='text_mic' align='left' style='padding-left:15px'>".$adresa."</td></tr>"
								:
								"").
								"<tr>
									<td class='text_mic_default' valign='top' colspan='2'>
										Comenzi noi: <a href='".$URL_ADMIN."comenzi_noi.php?user_client=".$arr_comanda[0]["username"]."&cauta' class='link_default_mic'>".$arr_comenzi_noi[0]["nr"]."</a> - 
										onorate: <a href='".$URL_ADMIN."comenzi.php?stare=onorate&user_client=".$arr_comanda[0]["username"]."&cauta' class='link_default_mic'>".$arr_comenzi_onorate[0]["nr"]."</a> - 
										anulate: <a href='".$URL_ADMIN."comenzi.php?stare=anulate&user_client=".$arr_comanda[0]["username"]."&cauta' class='link_default_mic'>".$arr_comenzi_anulate[0]["nr"]."</a>
									</td>
								</tr>						
							 </table>
						 </td>
					</tr>".
					((!empty($arr_comanda[0]["comentariu_comanda"]))?			
					"<tr><td colspan='3' height='1' bgcolor='#F6F6F6'></td></tr>
					<tr>
						<td colspan='3' class='text_mic_default' align='left' style='padding:3px'><b>Comentariu comanda:</b> ".$arr_comanda[0]["comentariu_comanda"]."</td>
					</tr>"
					:
					"").
				  "</table>";				

		//@afiseaza ouput 
		print $id_comanda.PATTERN.$arr_comanda[0]["stare"].PATTERN.$output;
	}
?>