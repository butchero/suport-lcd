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
				<h2>Gestioneaza bannere</h2>
			</td>
		</tr>
	</table>	
	{*-----------------------------------------------------------INSTRUCTIUNI UTILIZARE--------------------------------------------*}
	<ul>
		<li>In aceasta sectiune aveti posibilitatea de a gestiona bannerele de pe prima pagina.</li>
	</ul>
	{*--------------------------------------------------------------------END------------------------------------------------------*}	
	<form action="{$URL_ADMIN}gestioneaza_bannere.php" method="POST" enctype="multipart/form-data">
	<table bgcolor="#EFEFEF" width="100%">
		<tr>
			<td>Nume banner:</td>
			<td><input type="text" name="nume_banner" size="30"> ex: HDD Samsung 400GB</td>
		</tr>
		<tr>
			<td>Link banner:</td>
			<td><input type="text" name="link_banner" size="30"> ex: {$URL_BASE}cat/produs--1</td>
		</tr>
		<tr>
			<td>Upload banner:</td>
			<td><input type="file" name="banner" size="30"></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" name="adauga_banner" value="ADAUGA BANNER" class="buton_cool" style="width:120px"></td>
		</tr>
	</table>
	</form>
	<p>Afisare bannere existente:</p>
	<table class="box" width="100%">
		{section name=sec loop=$bannere}
		<tr><td colspan="2"><img src="{$URL_BASE}bannere/{$bannere[sec].fisier}?{$timestamp}" alt=""></td></tr>
		<tr>
			<td width="200"><form action="{$URL_ADMIN}gestioneaza_bannere.php" method="POST" enctype="multipart/form-data">Nume banner:</td>
			<td><input type="text" name="nume_banner" value="{$bannere[sec].nume_banner}" size="40"> - Nr. ordine: <input type="text" name="nr_ordine" value="{$bannere[sec].nr_ordine}" size="4"></td>
		</tr>
		<tr>
			<td>Link banner:</td>
			<td><input type="text" name="link_banner" value="{$bannere[sec].link_banner}" size="40"></td>
		</tr>
		<tr>
			<td>Upload banner nou:</td>
			<td><input type="file" name="banner" size="40"></td>
		</tr>
		<tr>
			<td></td>
			<td>
				<input type="submit" name="modifica_banner" value="MODIFICA BANNER" class="buton" style="width:130px">
				&nbsp;
				<input type="button" value="STERGE BANNER" class="buton_anuleaza" style="width:130px"  
					onClick="casutaConfirmare('Sunteti sigur ca doriti sa stergeti bannerul?
											   <br /><b>{$bannere[sec].nume_banner}</b>?', '400',
						     				  '{$URL_ADMIN}gestioneaza_bannere.php?id_banner={$bannere[sec].id_banner}&actiune=sterge')">
				<input type="hidden" name="id_banner" value="{$bannere[sec].id_banner}">
			</form>				
			</td>
		</tr>
		{/section}	
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