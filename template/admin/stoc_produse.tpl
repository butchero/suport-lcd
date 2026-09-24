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
				<h2>Gestioneaza stoc(disponibilitatile posible pt. un produs)</h2>
			</td>
		</tr>
	</table>
	<table cellpadding="5" cellspacing="0" class="box" width="557">
		{*-------------------------------------------------------INSTRUCTIUNI UTILIZARE--------------------------------------------*}
		<tr>
			<td>
				<ul>
					<li>In aceasta pagina aveti posibilitatea de a adauga, edita sau sterge disponibilitatile(stocul) pe care poate sa le aiba un produs.</li>
					<li>ATENTIE: Pentru a sterge o disponibilitate trebuie ca toate produsele care o folosesc sa fie setate pe alta disponibilitate!</li>
					<li>ATENTIE: Va rugam sa lasati ca aceste modificari sa fie facute de webmaster, orice modificare facuta gresit putand afecta buna functionare a site-ului!</li>
					<li>ATENTIE: Produsele care au setarea "NU E PE STOC" nu pot fi comandate !</li>
				</ul>
			</td>
		</tr>
		{*----------------------------------------------------------------END------------------------------------------------------*}		
		<tr>
			<td align="center">
				<form action="{$URL_ADMIN}stoc_produse.php" method="POST">
				<table bgcolor="#EFEFEF">
					<tr><td align="left">Stoc*:</td><td align="left"><input type="text" name="stoc" value="" size="45"></td></tr>						
					<tr><td></td><td align="left"><input type="submit" name="adauga_stoc" value="ADAUGA STOC" class="buton_cool" style="width:100px"></td></tr>
				</table>
				</form>
			</td>
		</tr>
		<tr>
			<td valign="top">
				<center>
				<table style="margin-top:10px">
					<tr bgcolor="#EFEFEF">
						<td class="titlu" align="left"><b>Nume disponibilitate</b></td>
						<td></td>
						<td class="titlu" align="center"><b>Actiuni</b></td>
					</tr>
					{section name=sec loop=$stoc}
					<tr>
						<td>
							<form action="{$URL_ADMIN}stoc_produse.php" method="POST">
							<input type="text" name="stoc" value="{$stoc[sec].stoc}" size="45">
						</td>
						<td align="right"><img src="{$DIR_TEMPLATE}img/stoc/{$stoc[sec].id_stoc}.gif" alt=""></td>						
						<td style="padding-left:10px">
							<input type="submit" name="modifica" value="MODIFICA" class="buton" style="width:80px">&nbsp;
							<input type="button" name="sterge" value="STERGE" class="buton_anuleaza" style="width:80px" 
								onClick="casutaConfirmare('Sunteti sigur ca doriti sa stergeti
														   <br />optiunea <b>{$stoc[sec].stoc}</b>?
														   <br /><br /><font class=eroare_text>Daca disponibilitatea este folosita pentru vreun produs nu va putea fi stearsa!</font>', '400',
														  '{$URL_ADMIN}stoc_produse.php?id_stoc={$stoc[sec].id_stoc}&actiune=sterge')">
							<input type="hidden" name="id_stoc" value="{$stoc[sec].id_stoc}">
							</form>
						</td>
					</tr>
					{/section}
				</table>
				</center>				
				<p alig="left">* = Campuri obligatorii</p>
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