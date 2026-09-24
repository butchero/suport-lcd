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
	{*-------------------------------------------------------------GESTIONEAZA EXPORT----------------------------------------------*}
	<table cellpadding="0" cellspacing="0" class="menu_container" style="background:url({$DIR_TEMPLATE}img/bg_menu.gif);border-top:1px solid #F2F2F2;border-left:1px solid #F2F2F2;border-right:1px solid #F2F2F2;">
		<tr>
			<td align="left" class="menu_title" height="18" style="padding-left:2px;padding-right:2px">
				<h2>Export magazine-online.ro</h2>
			</td>
		</tr>
	</table>
	<form action="{$URL_ADMIN}export_magazine_online.php" method="POST">
	<table cellpadding="5" cellspacing="0" class="box" width="557">
		{*-------------------------------------------------------INSTRUCTIUNI UTILIZARE--------------------------------------------*}
		<tr>
			<td>
				<ul>
					<li>In aceasta pagina aveti posibilitatea de a genera si a downloada csv-urile necesare pentru a importa toata baza de date in magazine-online.ro</li>					
				</ul>
			</td>
		</tr>
		{*----------------------------------------------------------------END------------------------------------------------------*}
		<tr><td><input type="submit" name="export" value="GENEREAZA CSV-URI PENTRU -> MAGAZINE-ONLINE.RO" class="buton_cool" style="width:350px"></td></tr>
		<tr>
			<td>
				<ul>
					{section name=sec loop=$fisiere_csv}
						<li><a href="{$fisiere_csv[sec].link}">{$fisiere_csv[sec].nume}</a></li>
					{/section}
				</ul>
			</td>
		</tr>
	</table>
	</form>
	{*-----------------------------------------------------------END GESTIONEAZA EXPORT--------------------------------------------*}
	<p align="center"><a href="{$link_inapoi}" class="link_default">&laquo; Inapoi</a></p>
	<p align="right"><a href="#top"><img src="{$DIR_TEMPLATE}img/top.gif" alt="top"></a></p>
			</td>
		</tr>
	</table>
</td>
{/strip}
{include file="admin/right.tpl"}
{include file="admin/bottom.tpl"}