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
				<h2>Gestioneaza top cautari</h2>
			</td>
		</tr>
	</table>	
	{*-----------------------------------------------------------INSTRUCTIUNI UTILIZARE--------------------------------------------*}
	<ul>
		<li>In aceasta sectiune aveti posibilitatea de a modifica top cautari.</li>
	</ul>
	{*--------------------------------------------------------------------END------------------------------------------------------*}	
	<table cellpadding="3" cellspacing="1" style="margin-top:10px">
		<tr>
			<td colspan="3" align="right" style="padding:2px;background-color:#DEF2FF;border-top:1px solid #CCCCCC;border-bottom:1px solid #CCCCCC">
				{$paginare}
			</td>
		</tr>
		<tr bgcolor="#EFEFEF">
			<td class="titlu" align="left"><b>Text cautat</b></td>
			<td class="titlu" align="center"><b>Contor</b></td>
			<td class="titlu" align="center"><b>Actiuni</b></td>
		</tr>
		{section name=sec loop=$cautari}
		<tr>
			<td>
				<form action="{$URL_ADMIN}gestioneaza_cautari.php?pag={$pag}" method="POST">
					<input type="text" name="cautare" value="{$cautari[sec].cautare}" size="62">
			</td>
			<td>
					<input type="text" name="contor" value="{$cautari[sec].contor}" size="5">
			</td>
			<td>
					<input type="submit" name="modifica" value="MODIFICA" class="buton" style="width:80px">
					&nbsp;
					<input type="button" value="STERGE" class="buton_anuleaza" style="width:80px" 
						onClick="casutaConfirmare('Sunteti sigur ca doriti sa stergeti
												   <br />cautarea <b>{$cautari[sec].cautare}</b>?', '400',
												  '{$URL_ADMIN}gestioneaza_cautari.php?id_cautare={$cautari[sec].id_cautare}&actiune=sterge')">
					<input type="hidden" name="id_cautare" value="{$cautari[sec].id_cautare}">
				</form>
			</td>
		</tr>
		{/section}
		<tr>
			<td colspan="3" align="right" style="padding:2px;background-color:#DEF2FF;border-top:1px solid #CCCCCC;border-bottom:1px solid #CCCCCC">
				{$paginare}
			</td>
		</tr>
	</table>
	<p align="center"><a href="{$link_inapoi}" class="link_default">&laquo; Inapoi</a></p>	
	<p align="right"><a href="#top"><img src="{$DIR_TEMPLATE}img/top.gif" alt="top"></a> &nbsp;</p>
			</td>
		</tr>
	</table>
</td>
{/strip}
{include file="admin/right.tpl"}
{include file="admin/bottom.tpl"}