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
	{*------------------------------------------------------------GESTIONEAZA SUBADMINI--------------------------------------------*}
	<table cellpadding="0" cellspacing="0" class="menu_container" style="background:url({$DIR_TEMPLATE}img/bg_menu.gif);border-top:1px solid #F2F2F2;border-left:1px solid #F2F2F2;border-right:1px solid #F2F2F2;">
		<tr>
			<td align="left" class="menu_title" height="18" style="padding-left:2px;padding-right:2px">
				<h2>Gestioneaza subadmini</h2>
			</td>
		</tr>
	</table>
	<table cellpadding="5" cellspacing="0" class="box" width="557">
		{*-------------------------------------------------------INSTRUCTIUNI UTILIZARE--------------------------------------------*}
		<tr>
			<td>
				<ul>
					<li>In aceasta pagina aveti posibilitatea de a adauga, edita sau sterge subadmini.</li>
					<li>Subadminii nu acces la sectiunea de comenzi onorate si anulate, modificare parametri site, transport, stoc produse, texte site si newsletter!</li>
					<li>ATENTIE: Parola unui subadmin poate doar modificata cu alta noua, nu poate fi vizualizata cea noua!</li>
				</ul>
			</td>
		</tr>
		{*----------------------------------------------------------------END------------------------------------------------------*}
		{*----------------------------------------------------FORMULAR ADAUGARE SUBADMINI------------------------------------------*}
		<tr>
			<td align="center">				
				<form action="{$URL_ADMIN}subadmini.php" method="POST">
				<table class="bg_spatiu">
					<tr><td align="left">Username*:</td><td align="left"><input type="text" name="subadmin_username" value="{$subadmin_username}" size="30"></td></tr>
					<tr><td align="left">Parola*:</td><td align="left"><input type="password" name="subadmin_parola" value="" size="30"></td></tr>
					<tr><td></td><td align="left"><input type="submit" name="adauga_subadmin" value="ADAUGA SUBADMIN" class="buton_cool" style="width:140px"></td></tr>
				</table>
				</form>				
			</td>
		</tr>
		{*----------------------------------------------------------------END------------------------------------------------------*}
		{*---------------------------------------------------FORMULAR GESTIONARE SUBADMINI-----------------------------------------*}
		<tr>
			<td valign="top">
				<table style="margin-top:10px" cellpadding="3" cellspacing="0" width="100%">
					<tr bgcolor="#EFEFEF">
						<td class="titlu"><b>Subadmin Username</b></td>
						<td class="titlu"><b>Parola</b></td>
						<td class="titlu" align="center"><b>Actiuni</b></td>
					</tr>
					{section name=sec loop=$subadmini}
					<tr>
						<td>
							<form action="{$URL_ADMIN}subadmini.php" method="POST">
							<input type="text" name="subadmin_username" value="{$subadmini[sec].username}" size="30">
						</td>
						<td><input type="password" name="subadmin_parola" value="" size="30"></td>
						<td>
							<input type="submit" name="modifica" value="MODIFICA" class="buton" style="width:80px">&nbsp;
							<input type="button" name="sterge" value="STERGE" class="buton_anuleaza" style="width:80px" 
								onClick="casutaConfirmare('Sunteti sigur ca doriti sa stergeti
														   <br />subadminul <b>{$subadmini[sec].username}</b>?', '400',
														  '{$URL_ADMIN}subadmini.php?id_admin={$subadmini[sec].id_admin}&actiune=sterge')">
							<input type="hidden" name="id_admin" value="{$subadmini[sec].id_admin}">
							</form>
						</td>
					</tr>
					{/section}
				</table>				
				<p align="left">* = Campuri obligatorii</p>
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