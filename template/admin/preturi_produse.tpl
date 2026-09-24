{include file="admin/top.tpl"}
{include file="admin/left.tpl"}
{strip}
<td valign="top" align="left" width="568">	
	<table style="margin-left:6px;margin-right:6px;" cellpadding="0" cellspacing="0" width="557">
		<tr><td>		
	{*-------------------------------------------------------------------MESAJE----------------------------------------------------*}
	{if $mesaj neq ""}
		{include file="admin/mesaj.tpl" mesaj=$mesaj}
	{/if}
	{*--------------------------------------------------------------------END------------------------------------------------------*}
	<table cellpadding="3" cellspacing="1">
		<tr>
			<td colspan="4" class="menu_title" style="background:url({$DIR_TEMPLATE}img/bg_menu.gif);border-top:1px solid #F2F2F2;border-left:1px solid #F2F2F2;border-right:1px solid #F2F2F2;">
				<h2>Gestioneaza preturi produse</h2>
			</td>
		</tr>
	</table>	
	{*-----------------------------------------------------------INSTRUCTIUNI UTILIZARE--------------------------------------------*}
	<ul>
		<li>In aceasta sectiune aveti posibilitatea de a edita preturile in USD sau EURO.</li>
		<li>Daca pretul este nul, produsul respectiv va avea pretul in RON specificat din catalogul de produse.</li>
		<li>Preturile setate sunt considerate a fi fara TVA. Pretul final cu TVA si convertirea in RON sunt calculate automat de catre site la ultimul curs BNR disponibil.</li>
	</ul>
	{*-------------------------------------------------------------------END------------------------------------------------------*}
	<form action="{$URL_ADMIN}preturi_produse.php" method="POST">
	<table>
		<tr>
			<td>
				<table cellpadding="3" cellspacing="1" width="240" class="box">
					<tr>
						<td colspan="2" bgcolor="#EFEFEF">
							<b>CURS VALUTAR CURENT</b>
						</td>
					</tr>
					<tr>
						<td width="40">USD:</td>
						<td width="180"><b>{$curs.usd}</b> {$MONEDA}</td>
					</tr>
					<tr>
						<td>EURO:</td>
						<td><b>{$curs.euro}</b> {$MONEDA}</td>
					</tr>
				</table>
				{if $CURS_VALUTAR_AUTOMAT eq 0}		
				<table cellpadding="3" cellspacing="1" width="240" class="box" style="margin-top:5px">
					<tr>
						<td colspan="3" bgcolor="#EFEFEF">
							<b>ADAUGA CURS VALUTAR MANUAL</b>
						</td>
					</tr>
					<tr>
						<td width="40">USD:</td>
						<td width="100"><input type="text" name="custom_usd" size="8"> RON</td>
						<td width="80" rowspan="2" align="left"><input type="submit" name="insereaza_curs_nou" value="ADAUGA" class="buton_cool"></td>
					</tr>
					<tr>
						<td>EURO:</td>
						<td><input type="text" name="custom_euro" size="8"> RON</td>
					</tr>
				</table>
				{/if}
			</td>
			<td style="padding-left:20px"><input type="submit" name="converteste_preturi" value="COVERTESTE MANUAL PRETURI IN {$MONEDA}" class="buton" style="width:250px"></td>
		</tr>
	</table>		
	</form>
	<form action="{$URL_ADMIN}preturi_produse.php" method="POST">
	<table style="margin-top:20px">
		<tr>
			<td>Alege categoria:</td>
			<td colspan="2">
			<select name="id_cat" class="select">
				<option value="0">--ROOT--</option>
				{html_options options=$toate_cat selected=$id_cat}
			</select>
			</td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" name="afiseaza_produse" value="AFISEAZA PRODUSE" class="buton_cool"></td>
		</tr>
	</table>
	</form>
	{if $produse neq ""}
	<table cellpadding="3" cellspacing="1" width="100%" style="margin-top:10px">
		<tr>
			<td colspan="5" align="right" style="padding:2px;background-color:#DEF2FF;border-top:1px solid #CCCCCC;border-bottom:1px solid #CCCCCC">
				{$paginare}
			</td>
		</tr>
		<tr>
			<td colspan="5" height="5"></td>
		</tr>
		<tr bgcolor="#EFEFEF">
			<td class="titlu" width="280"><b>Nume produs</b></td>
			<td class="titlu" width="70"><b>Pret</b></td>
			<td class="titlu" width="60"><b>Moneda</b></td>
			<td class="titlu" width="60"><b>Stoc</b></td>
			<td class="titlu" width="75"><b>Actiuni</b></td>
		</tr>
		{section name=sec loop=$produse}
		<tr bgcolor="{cycle values='#FFFFFF,#F2F2F2'}">
			<td valign="top" class="text_mic">
				<form action="{$URL_ADMIN}preturi_produse.php?id_cat={$id_cat}&pag={$pag}" method="POST">
					{$produse[sec].nume_produs}
			</td>
			<td valign="top"><input type="text" name="pret" value="{$produse[sec].pret_valuta}" size="10"></td>
			<td valign="top">
					<select name="moneda" class="select">						
						<option value="euro" {if $produse[sec].moneda eq "euro"}selected{/if}>EURO</option>
						<option value="usd" {if $produse[sec].moneda eq "usd"}selected{/if}>USD</option>
					</select>
			</td>
			<td valign="top">
				<select name="stoc" class="select">
					{html_options options=$stocuri selected=$produse[sec].stoc}
				</selecT>
			</td>
			<td valign="top">
					<input type="submit" name="modifica" value="MODIFICA" class="buton" style="width:70px">
					<input type="hidden" name="id_produs" value="{$produse[sec].id_produs}">
				</form>
			</td>
		</tr>
		{/section}
		<tr>
			<td colspan="5" height="5"></td>
		</tr>
		<tr>
			<td colspan="5" align="right" style="padding:2px;background-color:#DEF2FF;border-top:1px solid #CCCCCC;border-bottom:1px solid #CCCCCC">
				{$paginare}
			</td>
		</tr>
	</table>
	{/if}	
	<p align="center"><a href="{$link_inapoi}" class="link_default">&laquo; Inapoi</a></p>	
	<p align="right"><a href="#top"><img src="{$DIR_TEMPLATE}img/top.gif" alt="top"></a> &nbsp;</p>
			</td>
		</tr>
	</table>
</td>
{/strip}
{include file="admin/right.tpl"}
{include file="admin/bottom.tpl"}