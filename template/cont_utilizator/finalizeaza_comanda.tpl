{include file="top.tpl"}
{include file="left.tpl"}
	{strip}
<td valign="top" align="left">
	<table cellpadding="0" cellspacing="0" width="500" style="margin-top:10px;background:url({$DIR_TEMPLATE}{$POZE_DIR}/middle_chenar.gif);background-repeat:repeat-y">										
		<tr>
			<td colspan="3">
				<img src="{$DIR_TEMPLATE}{$POZE_DIR}/top_chenar.gif" alt="">
			</td>
		</tr>
		<tr>
			<td style="padding:5px">
				<form action="{$LINK_FINALIZEAZA_COMANDA}" method="POST" id="cos">
				<input type="hidden" name="trimite_comanda" value="1">
				<table cellpadding="5" cellspacing="0" width="100%">
					<tr>
						<td colspan="5">						
							<table class="box" cellpadding="2" cellspacing="0" width="100%">
								<tr>
									<td class="bg_spatiu"><b>Facturare pe:</b></td>
									<td class="bg_spatiu">
										<table cellpadding="0" cellspacing="0">
											<tr>
												<td align="right"><input type="radio" name="tip_factura" value="0" {if $tip_factura neq "1"}checked{/if} id="p_fizica" onClick="document.getElementById('date_p_fizica').style.display='block';document.getElementById('date_p_juridica').style.display='none'"></td>
												<td><label for="p_fizica">p. fizica</label></td>
												<td align="right"><input type="radio" name="tip_factura" value="1" {if $tip_factura eq "1"}checked{/if} id="p_juridica" onClick="document.getElementById('date_p_fizica').style.display='none';document.getElementById('date_p_juridica').style.display='block'" {if $user.societate eq ""}disabled{/if}></td>
												<td><label for="p_juridica">p. juridica</label></td>
											</tr>					
										</table>
									</td>
									<td align="center">																					
										<input type="submit" name="buton" value="TRIMITE COMANDA" class="buton">									
									</td>
								</tr>
							</table>
							<div id="date_p_fizica" style="margin-top:5px;display:{if $tip_factura neq "1"}block{else}none{/if}">
							<table class="box" cellpadding="2" width="100%">
								<tr><td width="110" class="titlu_sec">Nume:</td><td>{$user.nume}</td></tr>
								<tr><td class="titlu_sec">Prenume:</td><td>{$user.prenume}</td></tr>	
								<tr><td class="titlu_sec">CNP:</td><td>{$user.cnp}</td></tr>
								<tr><td class="titlu_sec" valign="top">Adresa:</td><td>{$user.adresa}</td></tr>								
								<tr><td class="titlu_sec">Cod postal:</td><td>{$user.cod_postal}</td></tr>
								<tr><td class="titlu_sec">Localitate:</td><td>{$user.localitate}</td></tr>
								<tr><td class="titlu_sec">Judet:</td><td>{$user.judet}</td></tr>
							</table>
							</div>							
							<div id="date_p_juridica" style="margin-top:5px;display:{if $tip_factura eq "1"}block{else}none{/if}">
							<table class="box" width="100%">
								<tr><td width="110" class="titlu_sec"><b>Societate:</b></td><td>{$user.societate}</td></tr>
								<tr><td class="titlu_sec">Cod fiscal:</td><td>{$user.cod_fiscal}</td></tr>	
								<tr><td class="titlu_sec">Nr. Reg. Comert:</td><td>{$user.nr_reg_comert}</td></tr>
								<tr><td class="titlu_sec">Banca:</td><td>{$user.banca}</td></tr>							
								<tr><td class="titlu_sec">Cod IBAN:</td><td>{$user.cod_iban}</td></tr>
								<tr><td class="titlu_sec" valign="top">Adresa:</td><td>{$user.adresa}</td></tr>								
								<tr><td class="titlu_sec">Cod postal:</td><td>{$user.cod_postal}</td></tr>
								<tr><td class="titlu_sec">Localitate:</td><td>{$user.localitate}</td></tr>
								<tr><td class="titlu_sec">Judet:</td><td>{$user.judet}</td></tr>					
							</table>
							</div>
							<table class="box" cellpadding="2" cellspacing="0" style="margin-top:5px" width="100%">
								<tr>
									<td>
										<input type="checkbox" name="adresa_livrare" value="1" id="checkbox_adr_livrare" {if $adresa_livrare eq "1"}checked{/if} onClick="toggleCampuri('checkbox_adr_livrare',  new Array('adresa','cod_postal','localitate','judet'), new Array('{$user.adresa}','{$user.cod_postal}','{$user.localitate}','{$user.id_jud}'))">
									 	<b>Adresa de livrare este diferita de adresa de contact:</b>
									</td>									
								</tr>
							</table>
							<div id="date_adresa_livrare" style="margin-top:5px;">
							<table class="box" width="100%">
								<tr>
									<td valign="top" width="110" class="titlu_sec"><b>Adresa:</b></td>
									<td><input type="text" name="adresa" id="adresa" {if $adresa_livrare neq "1"}disabled{/if} value="{$user_adresa_livrare.adresa}" size="30" {if $adresa_check.valid eq "0"}class="eroare_bg"{/if}></td>
								</tr>								
								<tr>
									<td class="titlu_sec">Cod postal:</td>
									<td>
										<input type="text" name="cod_postal" value="{$user_adresa_livrare.cod_postal}" id="cod_postal" {if $adresa_livrare neq "1"}disabled{/if} size="30" {if $cod_postal_check.valid eq "0"}class="eroare_bg"{/if}>
										&nbsp; - <a href="http://www.posta-romana.ro/index.jsp?page=coduri_postale" target="_blank" rel="nofollow" class="link"><u>coduri postale</u></a>
									</td>
								</tr>
								<tr><td class="titlu_sec">Localitate:</td><td><input type="text" name="localitate" value="{$user_adresa_livrare.localitate}" id="localitate" {if $adresa_livrare neq "1"}disabled{/if} size="30" {if $localitate_check.valid eq "0"}class="eroare_bg"{/if}></td></tr>
								<tr>
									<td class="titlu_sec">Judet:</td>
									<td>
										<select name="judet" class="select" {if $adresa_livrare neq "1"}disabled{/if}>
											<option value="0" {if $judet_check.valid eq "0"}class="eroare_bg"{/if}>-Alege-</option>
											{html_options options=$judete selected=$user_adresa_livrare.id_jud}
										</select>
									</td>
								</tr>					
							</table>
							</div>
						</td>
					</tr>													
					<tr class="bg_spatiu">
						<td></td>
						<td width="240"><b>Nume produs</b></td>
						<td width="65"><b>Cantitate</b></td>
						<td width="110" align="center"><b>Pret unitar<br />(fara TVA)</b></td>
						<td width="100" align="center"><b>Pret total<br />(cu TVA)</b></td>
					</tr>
					{section name=sec loop=$cosul_meu}					
					<tr>
						<td width="40">
							<table cellpadding="2" class="img">
								<tr>
									<td width="30" height="30" align="center">										
										<img src="{$cosul_meu[sec].poza_produs}" alt="{$cosul_meu[sec].nume_produs}">										
									</td>
								</tr>
							</table>
						</td>
						<td>{$cosul_meu[sec].nume_produs}</td>
						<td align="center">{$cosul_meu[sec].cantitate}</td>
						<td align="right"><b>{$cosul_meu[sec].pret_unitar}</b> {$MONEDA}&nbsp;</td>
						<td align="right"><b>{$cosul_meu[sec].pret_total}</b> {$MONEDA}&nbsp;</td>
					</tr>
					{if !$smarty.section.sec.last}
					<tr>
						<td colspan="5">
							<table cellpadding="0" cellspacing="0" width="100%"><tr><td height="1" bgcolor="#F2F2F2"></td></tr></table>
						</td>
					</tr>	
					{/if}									
					{/section}
					<tr>
						<td colspan="5" align="right">
							<table cellpadding="0" cellspacing="0">
								<tr>
									<td><b>Total cos {$MONEDA} cu TVA:</b></td>
									<td width="100" class="special" align="right"><b>{$total_cos}</b> {$MONEDA}&nbsp;</td>
								</tr>
							</table>
						</td>
					</tr>
					{if $smarty.section.sec.total neq "0"}
					<tr>
						<td colspan="5" align="right">
							<table cellpadding="0" cellspacing="0">
								<tr><td class="text_estompat"><b>Transport ({$transport}):</b></td><td width="100" class="special"  align="right"><b>{$transport_cost}</b> {$MONEDA}&nbsp;</td></tr>
							</table>
						</td>
					</tr>
					
					<tr>
						<td colspan="5" align="right" class="bg_spatiu">
							<table cellpadding="0" cellspacing="0">
								<tr><td><b>Total de plata:</b></td><td width="100" class="special" align="right"><b>{$total_cos_cu_transport}</b> {$MONEDA}&nbsp;</td></tr>
							</table>
						</td>
					</tr>
					{/if}
				</table>				
				<table width="100%" cellpadding="5" class="box" style="margin-bottom:10px">
					<tr>
						<td width="200" align="right"><b>Comentariu comanda:</b></td>
						<td width="10"></td>
						<td align="left">{if $comentariu_comanda eq ""}-{else}{$comentariu_comanda}{/if}</td>
					</tr>
				</table>	
				<br />									
				<b>Renunta la finalizare:</b>
				<div style="margin-left:20px;margin-top:10px">
					<a href="{$LINK_COSUL_MEU}" class="link" title="Inapoi la editare cos">&laquo; Inapoi la editare cos</a> <br />
					<a href="{$URL_BASE}" class="link" title="Prima pagina">&laquo; Prima pagina</a>
				</div>		
				<table width="100%">
					<tr><td align="right"><a href="#top"><img src="{$DIR_TEMPLATE}img/top.gif" alt="top"></a></td></tr>
				</table>
				</form>
			</td>
		</tr>	
		<tr>
			<td colspan="3">
				<img src="{$DIR_TEMPLATE}{$POZE_DIR}/bottom_chenar.gif" alt="">
			</td>
		</tr>	
	</table>
</td>
	{/strip}
{include file="right.tpl"}
{include file="bottom.tpl"}