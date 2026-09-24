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
	{*------------------------------------------------------------GESTIONEAZA TRANSPORT--------------------------------------------*}
	<table cellpadding="0" cellspacing="0" class="menu_container" style="background:url({$DIR_TEMPLATE}img/bg_menu.gif);border-top:1px solid #F2F2F2;border-left:1px solid #F2F2F2;border-right:1px solid #F2F2F2;">
		<tr>
			<td align="left" class="menu_title" height="18" style="padding-left:2px;padding-right:2px">
				<h2>Gestioneaza transport</h2>
			</td>
		</tr>
	</table>
	<table cellpadding="5" cellspacing="0" class="box" width="557">
		{*-------------------------------------------------------INSTRUCTIUNI UTILIZARE--------------------------------------------*}
		<tr>
			<td>
				<ul>
					<li>In aceasta pagina aveti posibilitatea de a adauga, edita sau sterge modalitatile de transport.</li>
					<li>O modalitate de transport care a fost folosita(aleasa) la o comanda, nu mai poate fi stearsa!</li>
					<li>ATENTIE: Pretul setat la transport este considerat a fi cu tot cu TVA inclus.</li>
				</ul>
			</td>
		</tr>
		{*----------------------------------------------------------------END------------------------------------------------------*}
		{*----------------------------------------------------FORMULAR ADAUGARE TRANSPORT------------------------------------------*}
		<tr>
			<td align="center">				
				<form action="{$URL_ADMIN}gestioneaza_transport.php" method="POST">
				<table class="bg_spatiu">
					<tr><td align="left">Nume transport*:</td><td align="left"><input type="text" name="nume_transport" value="{$nume_transport}" size="45"></td></tr>
					<tr><td align="left">Pret transport*:</td><td align="left"><input type="text" name="cost" value="{$cost}" size="10"> <input type="text" value="{$MONEDA}" disabled size="4"></td></tr>
					<tr><td></td><td align="left"><input type="submit" name="adauga_transport" value="ADAUGA TRANSPORT" class="buton_cool" style="width:140px"></td></tr>
				</table>
				</form>				
			</td>
		</tr>
		{*----------------------------------------------------------------END------------------------------------------------------*}
		{*---------------------------------------------------FORMULAR GESTIONARE TRANSPORT-----------------------------------------*}
		<tr>
			<td valign="top">
				<table style="margin-top:10px">
					<tr bgcolor="#EFEFEF">
						<td class="titlu" align="left"><b>Nume Transport</b></td>
						<td class="titlu" align="left"><b>Pret</b></td>
						<td class="titlu" align="center"><b>Actiuni</b></td>
					</tr>
					{section name=sec loop=$transport}
					<tr>
						<td>
							<form action="{$URL_ADMIN}gestioneaza_transport.php" method="POST">
							<input type="text" name="nume_transport" value="{$transport[sec].nume_transport}" size="45">
						</td>
						<td><input type="text" name="cost" value="{$transport[sec].cost}" size="10"> <input type="text" value="{$MONEDA}" disabled size="4"></td>
						<td>
							<input type="submit" name="modifica" value="MODIFICA" class="buton" style="width:80px">&nbsp;
							<input type="button" name="sterge" value="STERGE" class="buton_anuleaza" style="width:80px" 
								onClick="casutaConfirmare('Sunteti sigur ca doriti sa stergeti
														   <br />transportul <b>{$transport[sec].nume_transport}</b>?
														   <br /><br /><font class=eroare_text>Daca transportul este ales in vreo comanda nu va fi sters!</font>', '400',
														  '{$URL_ADMIN}gestioneaza_transport.php?id_transport={$transport[sec].id_transport}&actiune=sterge')">
							<input type="hidden" name="id_transport" value="{$transport[sec].id_transport}">
							</form>
						</td>
					</tr>
					{/section}
				</table>				
				<p align="left">* = Campuri obligatorii</p>
			</td>
		</tr>
		{*-----------------------------------------------------------END FORMULAR--------------------------------------------------*}
	</table>
	{*--------------------------------------------------------END GESTIONEAZA TRANSPORT--------------------------------------------*}
	<p align="center"><a href="{$link_inapoi}" class="link_default">&laquo; Inapoi</a></p>
	<p align="right"><a href="#top"><img src="{$DIR_TEMPLATE}img/top.gif" alt="top"></a></p>
			</td>
		</tr>
	</table>
</td>
{/strip}
{include file="admin/right.tpl"}
{include file="admin/bottom.tpl"}