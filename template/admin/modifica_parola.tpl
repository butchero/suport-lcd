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
	{*-----------------------------------------------------------MODIFICA PAROLA ADMIN---------------------------------------------*}
	<table cellpadding="0" cellspacing="0" class="menu_container" style="background:url({$DIR_TEMPLATE}img/bg_menu.gif);border-top:1px solid #F2F2F2;border-left:1px solid #F2F2F2;border-right:1px solid #F2F2F2;">
		<tr>
			<td align="left" class="menu_title" height="18" style="padding-left:2px;padding-right:2px">
				<h2>Modifica parola</h2>
			</td>
		</tr>
	</table>
	<table cellpadding="5" cellspacing="0" class="box" width="557">
		{*-------------------------------------------------------INSTRUCTIUNI UTILIZARE--------------------------------------------*}
		<tr>
			<td>
				<ul>
					<li>In aceasta pagina aveti posibilitatea de a modifica parola pentru contul dvs. de administrator.</li>
				</ul>
			</td>
		</tr>
		{*-----------------------------------------------------------------END-----------------------------------------------------*}
		{*------------------------------------------------------FORMULAR MODIFICARE PAROLA-----------------------------------------*}
		<tr>
			<td align="center">
				<form action="{$URL_ADMIN}modifica_parola.php" method="POST">
				<table class="bg_spatiu">
					<tr><td align="left">Parola noua:</td><td align="left"><input type="password" name="parola_noua" value="" size="23"></td></tr>						
					<tr><td></td><td align="left"><input type="submit" name="modifica_parola" value="MODIFICA PAROLA" class="buton" style="width:130px"></td></tr>
				</table>
				</form>
			</td>
		</tr>
		{*----------------------------------------------------------------END------------------------------------------------------*}
	</table>
	{*---------------------------------------------------------END MODIFICA PAROLA ADMIN-------------------------------------------*}
	<p align="center"><a href="{$link_inapoi}" class="link_default">&laquo; Inapoi</a></p>
	<p align="right"><a href="#top"><img src="{$DIR_TEMPLATE}img/top.gif" alt="top"></a></p>
			</td>
		</tr>
	</table>
</td>
{/strip}
{include file="admin/right.tpl"}
{include file="admin/bottom.tpl"}