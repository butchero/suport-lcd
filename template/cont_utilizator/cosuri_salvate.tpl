{include file="top.tpl"}
{include file="left.tpl"}
{strip}
<td valign="top" align="left">
	<table style="margin-left:6px;margin-right:6px;" cellpadding="0" cellspacing="0" width="557">
		<tr>
			<td>
				<table cellpadding="3" cellspacing="0" class="menu_container" style="background:url({$DIR_TEMPLATE}img/bg_menu.gif);border-top:1px solid #F2F2F2;border-left:1px solid #F2F2F2;border-right:1px solid #F2F2F2;">
					<tr><td align="left" class="menu"><b>Cosuri salvate</b></td></tr>
				</table>	
				<table cellpadding="5" cellspacing="0" class="box">	
					{*-------------------------------------------------INCLUDE USER MENU-------------------------------------------*}
					<tr><td valign="top" align="center">{include file="cont_utilizator/user_menu.tpl" menu_selectat="cosuri_salvate"}</td></tr>
					{*--------------------------------------------------------END--------------------------------------------------*}
					<tr>
					{*-----------------------------------------------INSTRUCTIUNI UTILIZARE----------------------------------------*}
						<td>		
							<ul>
								<li>In aceasta pagina aveti posibilitatea de a salva cosul de cumparaturi, sau de a incarca un cos existent, salvat de dvs. anterior.</li>
								<li>Astfel nu mai este necesar sa navigati prin tot site-ul pt a cumpara produsele dvs. favorite.</li>
								<li class="special">ATENTIE: Incarcarea unui cos de cumparaturi salvat anterior va suprascrie cosul curent!</li>
							</ul>		
						</td>
					</tr>
					{*--------------------------------------------------------END---------------------------------------------------*}
					{*-------------------------------------------------SALVARE COS CURENT-------------------------------------------*}
					<tr><td><b>Salveaza cosul curent:</b> {if $salveaza_cos eq "0"}(Tb. sa aveti cel putin un produs in cos!){/if}</td></tr>
					<tr>
						<td>	
							<form action="{$LINK_COSURI_SALVATE}" method="POST">
								<div style="margin-left:10px">
									Nume cos: <input type="text" name="nume_cos" maxlength="32" {if $cos_check.valid eq "0"}class="eroare_bg"{/if}> <input type="submit" name="salveaza_cos" value="SALVEAZA COSUL" class="buton{if $salveaza_cos eq "0"}2{/if}" {if $salveaza_cos eq "0"}disabled{/if}> 					
									&nbsp; {if $cos_check.eroare neq ""}<font class="eroare_text"><b><u>{$cos_check.eroare}</u></b></font>{/if}
								</div>
							</form>	
						</td>
					</tr>
					{*--------------------------------------------------------END---------------------------------------------------*}
					<tr><td height="5"></td></tr>
					<tr><td height="1" class="bg_spatiu" style="padding:0px"></td></tr>
					<tr><td height="5"></td></tr>
					{*------------------------------------------------AFISARE COSURI SALVATE----------------------------------------*}
					<tr><td><b>Cosuri salvate:</b></td></tr>
					<tr>
						<td>				
							<table cellpadding="0" cellspacing="0" width="100%" style="margin-top: 5px">
							{section name=sec loop=$cosuri}
								<tr>
									<td width="20" class="bg_cosuri_salvate" align="center"><img src="{$DIR_TEMPLATE}img/cos.gif" alt=""></td>
									<td width="380" class="bg_cosuri_salvate" height="18"><b>{$smarty.section.sec.index+1}.</b> Nume cos: <b>{$cosuri[sec].nume_cos}</b></td>									
									<td width="150" class="bg_cosuri_salvate">salvat pe <b>{$cosuri[sec].data_salvarii}</b></td>
								</tr>
								<tr>
									<td colspan="3">
										<form action="{$LINK_COSURI_SALVATE}" method="POST">
											<table cellpadding="3" cellspacing="0" width="100%" style="margin-bottom:5px">
												<tr>
													<td bgcolor="#F2F2F2"></td>
													<td class="titlu" bgcolor="#F2F2F2" width="250"><b>Nume produs</b></td>
													<td class="titlu" bgcolor="#F2F2F2" width="50"><b>Cantitate</b></td>
													<td class="titlu" bgcolor="#F2F2F2" width="110" align="center"><b>Pret unitar<br />({$MONEDA} fara TVA)</b></td>
													<td class="titlu" bgcolor="#F2F2F2" width="110" align="center"><b>Pret total<br />({$MONEDA} cu TVA)</b></td>
												</tr>
												{section name=subsec loop=$cosuri[sec].produse}
												<tr>
													<td><img src="{$cosuri[sec].produse[subsec].poza_produs}" alt="{$cosuri[sec].produse[subsec].nume_produs}"></td>
													<td>
														<a href="{$cosuri[sec].produse[subsec].link_produs}" title="{$cosuri[sec].produse[subsec].nume_produs}" class="link_default">
															{$cosuri[sec].produse[subsec].nume_produs|wordwrap:35:"<br />"}
														</a>
													</td>
													<td align="center">{$cosuri[sec].produse[subsec].cantitate}</td>
													<td align="right">{$cosuri[sec].produse[subsec].pret_unitar} &nbsp;</td>
													<td align="right">{$cosuri[sec].produse[subsec].pret_total} &nbsp;</td>
												</tr>
												{sectionelse}
												<tr>
													<td colspan="5">Produsele din acest cos salvat nu mai sunt disponibile!</td></td>
												</tr>											
												{/section}
												<tr>
													<td colspan="5" align="right">
														<input type="hidden" name="id_cos" value="{$cosuri[sec].id_cos}">
														<input type="submit" name="sterge_cos" value="STERGE COS" class="buton_anuleaza"> <input type="submit" name="incarca_cos" value="INCARCA COS" class="buton">
													</td>
												</tr>
											</table>
										</form>
									</td>
								</tr>
							{/section}	
							{if $smarty.section.sec.total eq "0"}<div style="padding-left:10px">Nu aveti cosuri salvate.</div>{/if}
							</table>
						</td>
					</tr>
					{*---------------------------------------------------------END-----------------------------------------------*}
				</table>	
				<br />
				<table width="100%">
					<tr><td align="right"><a href="#top"><img src="{$DIR_TEMPLATE}img/top.gif" alt="top"></a></td></tr>
				</table>
			</td>
		</tr>
	</table>
</td>
{/strip}
{include file="right.tpl"}
{include file="bottom.tpl"}