{include file="admin/top.tpl"}
{include file="admin/left.tpl"}
{strip}
<td valign="top" align="left" width="568">
	<table style="margin-left:6px;margin-right:6px;" cellpadding="0" cellspacing="0" width="557">
		<tr>
			<td>
	{*-------------------------------------------------------------------MESAJE----------------------------------------------------*}
	{if $mesaj neq ""}
		{include file="admin/mesaj.tpl" mesaj=$mesaj}
	{/if}
	{*---------------------------------------------------------------------END-----------------------------------------------------*}
	<table cellpadding="0" cellspacing="0" class="menu_container" style="background:url({$DIR_TEMPLATE}img/bg_menu.gif);border-top:1px solid #F2F2F2;border-left:1px solid #F2F2F2;border-right:1px solid #F2F2F2;">
		<tr>
			<td align="left" class="menu_title" height="18" style="padding-left:2px;padding-right:2px">
				<h2>Gestioneaza liste discount (se incarca inainte de a edita o comanda)</h2>
			</td>
		</tr>
	</table>
	<table cellpadding="5" cellspacing="0" class="box" width="557">
		{*-------------------------------------------------------INSTRUCTIUNI UTILIZARE--------------------------------------------*}
		<tr>
			<td>
				<ul>
					<li>In aceasta pagina aveti posibilitatea de a crea liste si pentru fiecare lista discounturi pe categorii.</li>					
					<li>Butonul "Incarca", aplica discounturile din lista pe categorii.</li>
					<li>ATENTIE: O lista de discount se incarca inainte de edita o comanda si de ai aplica discountul!</li>
					<li>ATENTIE: In momentul cand se incarca o lista de discount, discounturile setate manual pe categorii vor fi sterse si vor fi inlocuite cu cele din lista!</li>					
				</ul>
			</td>
		</tr>
		{*----------------------------------------------------------------END------------------------------------------------------*}		
		<tr>
			<td align="center">
				<form action="{$URL_ADMIN}gestioneaza_liste_discount.php" method="POST">
				<table bgcolor="#EFEFEF">
					<tr><td align="left">Nume lista discount*:</td><td align="left"><input type="text" name="nume_lista_discount" value="" size="45"></td></tr>						
					<tr><td></td><td align="left"><input type="submit" name="adauga_lista_discount" value="ADAUGA LISTA DISCOUNT" class="buton_cool" style="width:170px"></td></tr>
				</table>
				</form>
			</td>
		</tr>
		<tr>
			<td valign="top">
				<center>
				<table style="margin-top:10px">
					<tr bgcolor="#EFEFEF">
						<td></td>
						<td class="titlu" align="left"><b>Nume lista</b></td>
						<td class="titlu" align="center"><b>Actiuni</b></td>
					</tr>
					{section name=sec loop=$liste_discount}
					<tr>
						<td>
							{if $liste_discount[sec].ultima_lista_folosita eq "1"}
							 *
							{/if}
						</td>
						<td>
							<form action="{$URL_ADMIN}gestioneaza_liste_discount.php" method="POST">
							<input type="text" name="nume_lista_discount" value="{$liste_discount[sec].nume_lista}" size="45">
						</td>						
						<td>
							<input type="submit" name="incarca" value="INCARCA" style="width:80px" class="buton_cool">&nbsp;
							<input type="submit" name="modifica" value="MODIFICA" class="buton" style="width:80px">&nbsp;
							<input type="button" name="sterge" value="STERGE" class="buton_anuleaza" style="width:80px" 
								onClick="casutaConfirmare('Sunteti sigur ca doriti sa stergeti
														   <br />lista <b>{$liste_discount[sec].nume_lista}</b>?', '400',
														  '{$URL_ADMIN}gestioneaza_liste_discount.php?id_lista={$liste_discount[sec].id_lista}&actiune=sterge')">
							<input type="hidden" name="id_lista" value="{$liste_discount[sec].id_lista}">
							</form>
						</td>
					</tr>
					{/section}
					<tr>
						<td colspan="3" class="text_mic" align="right">* = ultima lista de discounturi incarcata si aplicata pe categorii</td>
					</tr>
				</table>
				</center>		
				<form action="{$URL_ADMIN}gestioneaza_liste_discount.php" method="POST">		
				<table style="margin-top:10px" cellspacing="0" cellpadding="0">
					<tr style="background-color:#EFEFEF">
						<td style="padding:5px"><b>Seteaza discounturi pt. lista:</b></td>
						<td style="padding-left:10px;padding:5px">
							<select name="lista_discount" class="select" onChange="this.form.submit()">
								<option value="0">--Alege lista--</option>
								{html_options options=$liste_combobox selected=$lista_selectata}
							</select>
						</td>
					</tr>
					{if $lista_selectata neq ""}
					<tr><td colspan="2" align="center" style="padding:5px"><input type="submit" name="salveaza_discounturi" value="SALVEAZA DISCOUNTURI" class="buton"></td></tr>
					<tr>
						<td colspan="2" style="background-color:#FBFFEB">
						
							<table>
								<tr><td class="titlu"><b>Nume categorie</b></td><td class="titlu"><b>Discount</b></td></tr>
								{section name=sec loop=$toate_categ}
								<tr>
									<td>{$toate_categ[sec].indent}{$toate_categ[sec].nume_cat}</td>
									<td style="background-color:#FFFFFF"><input type="text" name="discounturi[]" value="{$discounturi_cat[sec]}" size="5">%</td>
								</tr>	
								{/section}
							</table>								
						</td>
					</tr>
					<tr><td colspan="2" align="center" style="padding:5px"><input type="submit" name="salveaza_discounturi" value="SALVEAZA DISCOUNTURI" class="buton"></td></tr>
					{/if}
				</table>
				</form>
			</td>
		</tr>
	</table>
	<p align="center"><a href="{$link_inapoi}" class="link_default">&laquo; Inapoi</a></p>
	<p align="right"><a href="#top"><img src="{$DIR_TEMPLATE}img/top.gif" alt="top"></a></p>
			</td>
		</tr>
	</table>
</td>
{/strip}
{include file="admin/right.tpl"}
{include file="admin/bottom.tpl"}