{include file="admin/top.tpl"}
{include file="admin/left.tpl"}
{strip}
<td valign="top" align="left" width="568">	
	<script type="text/javascript" src="{$URL_BASE}javascript/calendar_js/calendarDateInput.js"></script>
	<script type="text/javascript" src="{$URL_BASE}javascript/prototype.js"></script>	
	<table style="margin-left:6px;margin-right:6px;" cellpadding="0" cellspacing="0" width="557">
		<tr>
			<td class="box">
	{*-------------------------------------------------------------------MESAJE----------------------------------------------------*}
	{if $mesaj neq ""}
		{include file="admin/mesaj.tpl" mesaj=$mesaj}
	{/if}
	{*---------------------------------------------------------------------END-----------------------------------------------------*}
	<table cellpadding="3" cellspacing="1">
		<tr>
			<td class="menu_title" style="background:url({$DIR_TEMPLATE}img/bg_menu.gif);border-top:1px solid #F2F2F2;border-left:1px solid #F2F2F2;border-right:1px solid #F2F2F2;">
				<h2>Editeaza <font class="titlu_cat">COMANDA</font></h2>
			</td>
		</tr>
	</table>
	{*-----------------------------------------------------------INSTRUCTIUNI UTILIZARE--------------------------------------------*}
	<ul>
		<li>In aceasta sectiune aveti posibilitatea de a edita produsele comandate dintr-o comanda noua, in caz ca nu aveti pe stoc tot ce a comandat utilizatorul.</li>
		<li>ATENTIE: De fiecare daca cand se modifica comanda, proforma pdf exista va fi inlocuita cu alta noua, bazate pe modificarile facute de dvs.</li>		
	</ul>
	{*---------------------------------------------------------------------END-----------------------------------------------------*}
	<table style="margin-top:5px">
		<tr>
			<td>	
				<table cellpadding="0" cellspacing="0" width="100%">
					{section name=sec loop=$comenzi}					
					<tr>
						<td width="20" align="center" height="18"><a href="{$comenzi[0].proforma}" target="_blank"><img src="{$DIR_TEMPLATE}img/doc.gif" alt="Click pentru a descarca proforma"></a></td>
						<td width="160"><b>Comanda cu ID: <b>{$comenzi[0].id_comanda}</b></td>	
						<td width="200"><div id="comanda_status_{$comenzi[0].id_comanda}">Status: [<b>{$comenzi[0].stare_comanda}</b>]</div></td>								
						<td width="170">Data: <b>{$comenzi[0].data_comenzii}</b></td>
					</tr>					
					<tr>
						<td colspan="4">
							<form action="{$URL_ADMIN}editeaza_comanda_noua.php?id_comanda={$comenzi[0].id_comanda}&stare={$status}&pag={$pag}" method="POST">
							<table cellpadding="3" cellspacing="1" width="100%" style="margin-bottom:10px">
								<tr bgcolor="#EFEFEF">
									<td align="center"></td>
									<td class="titlu" width="250"><b>Nume produs</b></td>
									<td class="titlu" width="50"><b>Cantitate</b></td>
									<td class="titlu" width="110" align="center"><b>Pret unitar<br />({$MONEDA} {if $TVA neq 1}fara{else}cu{/if} TVA)</b></td>
									<td class="titlu" width="110" align="center"><b>Pret total<br />({$MONEDA} cu TVA)</b></td>
								</tr>
								{section name=subsec loop=$comenzi[0].produse}
								<tr>
									<td>										
										<a href="{$comenzi[0].produse[subsec].link_produs}" target="_new">
											<img src="{$comenzi[0].produse[subsec].poza_produs}" alt="{$cosuri[sec].produse[subsec].nume_produs}">
										</a>
									</td>
									<td>										
										{if $comenzi[0].produse[subsec].nume_produs eq ""}
											<font class="eroare_text"><b>produs sters</b></font>
										{else}	
											<a href="{$comenzi[0].produse[subsec].link_produs}" target="_new" title="Vezi produs" style="text-decoration:none">
												{$comenzi[0].produse[subsec].nume_produs}
											</a>
										{/if}
										{if $comenzi[0].produse[subsec].cod_produs neq ""}&nbsp;- <b>{$comenzi[0].produse[subsec].cod_produs}</b>{/if}
									</td>
									<td align="center"><input type="text" name="cantitati[]" value="{$comenzi[0].produse[subsec].cantitate}" size="4"></td>
									<td align="right">{$comenzi[0].produse[subsec].pret_unitar} &nbsp;</td>
									<td align="right">{$comenzi[0].produse[subsec].pret_total} &nbsp;</td>
								</tr>											
								{/section}	
								<tr>
									<td></td>
									<td colspan="4">
										<select name="transport" class="select">
											{html_options options=$transport selected=$comenzi[0].id_transport}
										</select>
									</td>
								</tr>		
								<tr class="bg_spatiu">
									<td align="center"><input type="checkbox" name="discount" value="1" {if $discount eq 1}checked{/if} onClick="toggleEnable('lista_discount')"></td>
									<td height="12"><b>Aplica discount la comanda</b></td>
									<td colspan="2" align="right"><b>Adauga produs nou:</b></td>
									<td><input type="text" name="id_produs_nou" size="3">(id produs)</td>
								</tr>
								<tr><td colspan="5" class="tab_line" height="1" style="padding:0px"></td></tr>	
								<tr>
									<td></td>
									<td colspan="4">
										<select name="lista_discount" id="lista_discount" class="select" {if $discount neq 1}disabled{/if}>
											<option value="0">--Alege lista--</option>
											{html_options options=$liste_combobox selected=$lista_selectata}
										</select>
									</td>
								</tr>
								<tr><td colspan="5" class="tab_line" height="1" style="padding:0px"></td></tr>	
								<tr bgcolor="#FAF4DA">
									<td colspan="2" height="16">
										<input type="submit" name="modifica" value="MODIFICA" class="buton" style="width:76px">&nbsp; 
										<input type="reset" value="RESET" class="buton_anuleaza" style="width:76px">&nbsp;
										<input type="button" value="ONOREAZA" class="buton_cool" onClick="NewWindow('{$URL_ADMIN}onoreaza_comanda.php?id_comanda={$comenzi[0].id_comanda}', '', '500', '650')" style="width:76px">
									</td>
									<td colspan="2" align="right">Total comanda* = </td>
									<td align="right"><b>{$comenzi[0].total_comanda}</b> &nbsp;</td>
								</tr>																																									
							</table>
							</form>
						</td>
					</tr>					
					{/section}	
				</table>														
				<p><b>* Total comanda = nu include transportul</b></p>
			</td>
		</tr>
	</table>
	{if $factura_fiscala neq ""}
	<p align="center">
		<a href="{$factura_fiscala}" target="_blank">Downlodeaza factura fiscala</a>
	</p>	
	{/if}
			</td>
		</tr>
	</table>	
	<p align="center"><a href="{$URL_ADMIN}comenzi_noi.php?pag={$pag}&stare={$status}#label{$comenzi[0].id_comanda}" class="link_default">&laquo; Inapoi</a></p>	
	<p align="right"><a href="#top"><img src="{$DIR_TEMPLATE}img/top.gif" alt="top"></a>&nbsp;</p>	
</td>
{/strip}
{include file="admin/right.tpl"}
{include file="admin/bottom.tpl"}