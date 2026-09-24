{include file="top.tpl"}
{include file="left.tpl"}
{strip}
<td valign="top" align="left">
	<script type="text/javascript" src="/javascript/calendar_js/calendarDateInput.js"></script>
	<table cellpadding="0" cellspacing="0" width="500" style="margin-top:10px;background:url({$DIR_TEMPLATE}{$POZE_DIR}/middle_chenar.gif);background-repeat:repeat-y">										
		<tr>
			<td colspan="3">
				<img src="{$DIR_TEMPLATE}{$POZE_DIR}/top_chenar.gif" alt="">
			</td>
		</tr>
		<tr>
			<td style="padding:5px">	
				<table cellpadding="5" cellspacing="0">	
					{*-------------------------------------------------INCLUDE USER MENU-------------------------------------------*}
					<tr><td valign="top" align="center">{include file="cont_utilizator/user_menu.tpl" menu_selectat="istoric_tranzactii"}</td></tr>
					{*--------------------------------------------------------END--------------------------------------------------*}
					<tr>
					{*-----------------------------------------------INSTRUCTIUNI UTILIZARE----------------------------------------*}
						<td>		
							<ul>
								<li>In aceasta pagina aveti posibilitatea de a vizualiza toate cumparaturile facute.</li>
								<li>Fiecare comanda facuta are asociata o factura proforma in format "pdf" pe care o puteti descarca apasand pe pictograma <img src="{$DIR_TEMPLATE}img/doc.gif" alt="">.</li>
								<li>Pentru a vizualiza fisierele in format "pdf" trebuie sa aveti Acrobat Reader instalat.</li>
							</ul>		
						</td>
					</tr>
					{*--------------------------------------------------------END---------------------------------------------------*}					
					<tr><td height="5"></td></tr>
					<tr><td height="1" class="bg_spatiu" style="padding:0px"></td></tr>
					<tr><td height="5"></td></tr>
					{*-------------------------------------------------AFISARE TRANZACTII-------------------------------------------*}
					<tr><td><b>Tranzactii (cumparaturi facute):</b></td></tr>
					<tr>
						<td>							
							<center>
								<table style="margin:10px">
									<tr><td class="titlu" align="center">Cumparaturi facute in perioada:</td></tr>
									<tr>
										<td align="center">
											<b>{$de_la_formatat} - {$pana_la_formatat}</b>
											{if $total_cumparaturi neq ""}
												&nbsp; <font class="titlu">in valoare de</font> <b>{$total_cumparaturi}</b> {$MONEDA}
											{/if}	
										</td>
									</tr>
								</table>
							</center>
							
							<table cellpadding="0" cellspacing="0" width="100%" style="margin-top:10px">
								<tr><td colspan="4" align="right" style="padding:2px">{$paginare}&nbsp;</td></tr>
								<tr><td colspan="4" height="2"></td></tr>
								{section name=sec loop=$comenzi}
								<tr>
									<td width="20" class="bg_cosuri_salvate" align="center" height="18"><a href="{$comenzi[sec].proforma}" target="_blank"><img src="{$DIR_TEMPLATE}img/doc.gif" alt="Click pentru a descarca proforma"></a></td>
									<td width="160" class="bg_cosuri_salvate"><b>{$smarty.section.sec.index+1}.</b> Comanda cu ID: <b>{$comenzi[sec].id_comanda}</b></td>	
									<td width="200" class="bg_cosuri_salvate">[<b>{$comenzi[sec].stare_comanda}</b>]</td>								
									<td width="170" class="bg_cosuri_salvate" align="right"><b>{$comenzi[sec].data_comenzii}</b></td>
								</tr>
								<tr>
									<td colspan="4">
										<table cellpadding="3" cellspacing="0" width="100%" style="margin-bottom:5px">
											<tr>
												<td bgcolor="#F2F2F2"></td>
												<td class="titlu" bgcolor="#F2F2F2" width="250"><b>Nume produs</b></td>
												<td class="titlu" bgcolor="#F2F2F2" width="50"><b>Cantitate</b></td>
												<td class="titlu" bgcolor="#F2F2F2" width="110" align="center"><b>Pret unitar<br />({$MONEDA} fara TVA)</b></td>
												<td class="titlu" bgcolor="#F2F2F2" width="110" align="center"><b>Pret total<br />({$MONEDA} cu TVA)</b></td>
											</tr>
											{section name=subsec loop=$comenzi[sec].produse}
											<tr>
												<td><img src="{$comenzi[sec].produse[subsec].poza_produs}" alt="{$cosuri[sec].produse[subsec].nume_produs}"></td>
												<td>{$comenzi[sec].produse[subsec].nume_produs|wordwrap:35:"<br />"}</td>
												<td align="center">{$comenzi[sec].produse[subsec].cantitate}</td>
												<td align="right">{$comenzi[sec].produse[subsec].pret_unitar} &nbsp;</td>
												<td align="right">{$comenzi[sec].produse[subsec].pret_total} &nbsp;</td>
											</tr>											
											{/section}	
											<tr><td colspan="5" class="tab_line" height="1" style="padding:0px"></td></tr>	
											<tr bgcolor="#faedde">
												<td colspan="4" align="right" height="16">Total comanda* = </td>
												<td align="right"><b>{$comenzi[sec].total_comanda}</b> &nbsp;</td>
											</tr>																					
											<tr><td colspan="5" class="tab_line" height="1" style="padding:0px"></td></tr>
										</table>
									</td>
								</tr>
								{/section}	
							<tr><td colspan="4" height="2"></td></tr>
							<tr><td colspan="4" align="right" style="padding:2px">{$paginare}&nbsp;</td></tr>
							</table>							
							{if $smarty.section.sec.total eq "0"}<div style="padding-left:10px">Nu aveti tranzactii/comenzi facute.</div>{/if}							
							<p><b>* Total comanda = nu include transportul</b></p>
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