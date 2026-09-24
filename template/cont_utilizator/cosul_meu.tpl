{include file="top.tpl"}
{include file="left.tpl"}
	{strip}
<td valign="top" align="left">
	<table cellpadding="0" cellspacing="0" width="500" style="margin-top:10px;background:url({$DIR_TEMPLATE}{$POZE_DIR}/middle_chenar.gif);background-repeat:repeat-y">										
		<tr>
			<td><img src="{$DIR_TEMPLATE}{$POZE_DIR}/top_chenar.gif" alt=""></td>
		</tr>
		<tr>
			<td style="padding:0px 5px 0px 5px">
				<form action="{$LINK_COSUL_MEU}" method="POST" id="cos">	
				<table cellpadding="5" cellspacing="0" width="100%">										
					<tr>
						<td></td>
						<td class="titlu" width="240"><b>Nume produs</b></td>
						<td class="titlu" width="65"><b>Cantitate</b></td>
						<td class="titlu" width="110" align="center"><b>Pret unitar<br />(fara TVA)</b></td>
						<td class="titlu" width="100" align="center"><b>Pret total<br />(cu TVA)</b></td>
					</tr>
					{section name=sec loop=$cosul_meu}					
					<tr>
						<td width="40">
							<input type="hidden" name="id_produs[]" value="{$cosul_meu[sec].id_produs}">
							<table cellpadding="2" class="img">
								<tr>
									<td width="30" height="30" align="center">										
										<img src="{$cosul_meu[sec].poza_produs}" alt="{$cosul_meu[sec].nume_produs}">										
									</td>
								</tr>
							</table>
						</td>
						<td>
							<a href="{$cosul_meu[sec].link_produs}" title="{$cosul_meu[sec].nume_produs}"  class="{if $cosul_meu[sec].stoc eq "0"}produse_indisponibile{else}produse{/if}">
								<b>{$cosul_meu[sec].nume_produs}</b>
							</a>
							{if $cosul_meu[sec].stoc eq "0"}
								<br /><font class="eroare_text_mic"><b>Nu mai este disponibil in stoc!</b></font>
							{/if}
						</td>
						<td align="center">							
							<input type="text" name="cantitate[]" value="{$cosul_meu[sec].cantitate}" size="2" id="{$smarty.section.sec.index}">							
							<br />
							<a href="{$cosul_meu[sec].link_sterge_produs}" class="text_mic">(sterge)</a>
						</td>
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
					{if $smarty.section.sec.total eq "0"}
						<tr><td colspan="5" align="center" class="special">Cosul dvs. este gol !</td></tr>
					{/if}
					<tr>
						<td colspan="2" align="left" class="bg_spatiu">{if $comanda_minima neq ""}* Comanda minima {$comanda_minima} {$MONEDA}{/if}</td>
						<td colspan="3" align="right" class="bg_spatiu">
							<table cellpadding="0" cellspacing="0">
								<tr>
									<td><img src="{$DIR_TEMPLATE}img/total_cos.gif" alt="Cos cumparaturi"></td>
									<td width="10"></td>
									<td><b>Total cu TVA:</b></td>
									<td width="100" class="special" align="right"><b>{$total_cos}</b> {$MONEDA}&nbsp;</td>
								</tr>
							</table>
						</td>
					</tr>
					{if $smarty.section.sec.total neq "0"}
					{if $transport_combo neq ""}
					<tr>
						<td colspan="5" align="right">
							<table cellpadding="0" cellspacing="0">
								<tr>
									<td width="400" align="left" class="text_estompat">Alege metoda de transport: <select name="transport" class="select" onChange="this.form.submit()">{html_options options=$transport_combo selected=$transport_selectat}</select></td>
									<td width="10"></td>
									<td class="text_estompat"><b>Cost:</b></td>
									<td width="100" class="special" align="right">{$transport_cost} {$MONEDA}&nbsp;</td></tr>
							</table>
						</td>
					</tr>
					{/if}
					<tr>
						<td colspan="5" align="right" style="background-color:#f2f2f2">
							<table cellpadding="0" cellspacing="0">
								<tr><td><b>Total de plata:</b></td><td width="100" class="special" align="right"><b>{$total_cos_cu_transport}</b> {$MONEDA}&nbsp;</td></tr>
							</table>
						</td>
					</tr>
					{/if}
				</table>				
				<div align="center" style="margin-top: 10px">
					<input type="submit" name="actualizeaza_cos" value="ACTUALIZEAZA COS" class="buton" style="width:130px"> <input type="submit" name="goleste_cos" value="GOLESTE COS" class="buton_anuleaza" style="width:130px">
				</div>								
				<br />
				<table>
					<tr>
						<td></td>
						<td>Puteti adauga un comentariu comenzii inainte de finalizare:</td>
						<td><textarea name="comentarii" rows="4" cols="50">{$comentarii_comanda}</textarea></td>
					</tr>
				</table>	
				<br />
				<input type="hidden" name="finalizeaza_comanda" id="finalizeaza_comanda" value="0">
				<div align="center" style="margin-top: 10px">
					<input type="button" value="VALIDEAZA COMANDA" class="buton" onClick="valideazaComanda('{$total_cos_value}','{$comanda_minima_value}','{$LINK_COSUL_MEU}','cos', '{$erori_cos}', '{$username}')">
					{if $erori_cos neq "0"}
						<div style="margin-top:10px">
							<font class="eroare_text"><b>Pentru a finaliza comanda, trebuie sa stergeti din cos produsele care nu mai sunt pe stoc !</b></font>
						</div>	
					{/if}
				</div>				
				<br />
				<b>Continua cumparaturile:</b>
				<div style="margin-left:20px;margin-top:10px">
					<a href="javascript:history.go(-1)" class="link" title="Pagina anterioara">&laquo; Pagina anterioare</a> <br />
					<a href="{$URL_BASE}" class="link" title="Prima pagina">&laquo; Prima pagina</a>
				</div>		
				<table width="100%">
					<tr><td align="right"><a href="#top"><img src="{$DIR_TEMPLATE}img/top.gif" alt="top"></a></td></tr>
				</table>
				</form>
			</td>
		</tr>
		<tr>
			<td>
				<img src="{$DIR_TEMPLATE}{$POZE_DIR}/bottom_chenar.gif" alt="">
			</td>
		</tr>	
	</table>
</td>
	{/strip}
{include file="right.tpl"}
{include file="bottom.tpl"}