{include file="admin/top.tpl"}
{include file="admin/left.tpl"}
<script src="{$URL_BASE}javascript/jslib/overlib.js" type="text/javascript"></script>
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
	{*---------------------------------------------------------------PARAMETRI SITE------------------------------------------------*}
	<table cellpadding="0" cellspacing="0" class="menu_container" style="background:url({$DIR_TEMPLATE}img/bg_menu.gif);border-top:1px solid #F2F2F2;border-left:1px solid #F2F2F2;border-right:1px solid #F2F2F2;">
		<tr>
			<td align="left" class="menu_title" height="18" style="padding-left:2px;padding-right:2px">
				<h2>Editeaza parametri site</h2>
			</td>
		</tr>
	</table>
	<table cellpadding="5" cellspacing="0" class="box" width="557" style="background-color:#F2F2F2">
		<tr>
		{*-------------------------------------------------------INSTRUCTIUNI UTILIZARE--------------------------------------------*}
			<td colspan="2">
				<ul>
					<li>In aceasta pagina aveti posibilitatea de a edita parametri site-ului.</li>
					<li>
						ATENTIE: Va rugam sa lasati ca aceste modificari sa fie facute de webmaster,&nbsp;
						orice modificare facuta gresit putand afecta buna functionare a site-ului!
					</li>
				</ul>
			</td>
		</tr>
		{*----------------------------------------------------------------END------------------------------------------------------*}
		<tr>
			<td colspan="2">
			<table cellpadding="0" cellspacing="0">
				{section name=sec loop=$parametri}
					<tr><td colspan="3"><form action="{$URL_ADMIN}parametri_site.php" method="POST"></td></tr>
					<tr>
						<td width="220"><span onmouseover="this.style.cursor='default'; return overlib('{$parametri[sec].descriere_param}');" onmouseout="return nd()"><b>?.</b></span> {$parametri[sec].nume_param}:</td>
						<td style="padding-left:5px"><input type="text" name="valoare" value="{$parametri[sec].val_param}" size="45"></td>
						<td style="width:80px;padding-left:5px"><input type="submit" name="modifica" value="MODIFICA" class="buton" style="width:75px"></td>
					</tr>
					<tr><td colspan="3"><input type="hidden" name="id_config" value="{$parametri[sec].id_config}"></form></td></tr>
				{/section}
			</table>
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