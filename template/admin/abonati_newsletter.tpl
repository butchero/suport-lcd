{include file="admin/top.tpl"}
{include file="admin/left.tpl"}
{strip}
<td valign="top" align="left" width="568">
	<table style="margin-left:6px;margin-right:6px;" cellpadding="0" cellspacing="0" width="557">
		<tr>
			<td>
	{*--------------------------------------------------------------------MESAJE-----------------------------------------------------*}
	{if $mesaj neq ""}
		{include file="admin/mesaj.tpl" mesaj=$mesaj}
	{/if}
	{*----------------------------------------------------------------------END------------------------------------------------------*}
	<table cellpadding="0" cellspacing="0" class="menu_container" style="background:url({$DIR_TEMPLATE}img/bg_menu.gif);border-top:1px solid #F2F2F2;border-left:1px solid #F2F2F2;border-right:1px solid #F2F2F2;">
		<tr>
			<td align="left" class="menu_title" height="18" style="padding-left:2px;padding-right:2px">
				<h2>Abonati newsletter</h2>
			</td>
		</tr>
	</table>
	<table cellpadding="5" cellspacing="0" width="557">
		{*--------------------------------------------------------INSTRUCTIUNI UTILIZARE---------------------------------------------*}
		<tr>		
			<td colspan="2">
				<ul>
					<li>In aceasta pagina aveti posibilitatea sa vizualizati/stergeti abonatii la newsletter.</li>					
				</ul>
			</td>
		</tr>
		{*------------------------------------------------------------------END------------------------------------------------------*}
	</table>
	<div class="box" style="padding:20px">
	<center>
		<table width="500">
			<tr bgcolor="#EFEFEF">
				<td class="titlu" align="left" width="250"><b>E-mail abonat</b></td>
				<td class="titlu" align="center" width="100"><b>Contor</b></td>
				<td class="titlu" align="center" width="100"><b>Actiuni</b></td>
			</tr>
			{section name=sec loop=$arr_abonati}
			<tr>
				<td align="left">{$arr_abonati[sec].email}</td>
				<td align="center">{$arr_abonati[sec].contor}</td>
				<td align="center">
					<input type="button" name="sterge" value="STERGE" class="buton_anuleaza" style="width:80px" 
							onClick="casutaConfirmare('Sunteti sigur ca doriti sa stergeti<br />abonatul <b>{$arr_abonati[sec].email}</b>?', '400',
													  '{$URL_ADMIN}abonati_newsletter.php?id_newsletter={$arr_abonati[sec].id_newsletter}&actiune=sterge')">
				</td>
			</tr>
			{/section}
			<tr>
				<td colspan="3" align="left" style="padding-top:5px">{$paginare}</td>
			</tr>
		</table>	
	</center>
	</div>
	
	<p align="center"><a href="{$URL_ADMIN}newsletter.php" class="link_default">&laquo; Inapoi</a></p>
	<p align="right"><a href="#top"><img src="{$DIR_TEMPLATE}img/top.gif" alt="top"></a></p>
	
			</td>
		</tr>
	</table>
</td>
{/strip}
{include file="admin/right.tpl"}
{include file="admin/bottom.tpl"}