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
				<h2>Vizualizeaza loguri</h2>
			</td>
		</tr>
	</table>	
	{*-----------------------------------------------------------INSTRUCTIUNI UTILIZARE--------------------------------------------*}
	<ul>
		<li>In aceasta sectiune aveti posibilitatea de a vizualiza log-ul de actiuni al unui subadmin.</li>
	</ul>
	{*--------------------------------------------------------------------END------------------------------------------------------*}	
	<form action="{$URL_ADMIN}log_subadmini.php" method="POST">
	<table class="bg_spatiu">
		<tr>
			<td width="100">Alege subadmin:</td>
			<td>
				<select name="id_admin" class="select" style="width:150px">
					<option value="0">--ALEGE--</option>
					{html_options options=$subadmini selected=$id_admin}
				</select>
			</td>
			<td><input type="submit" name="afiseaza_log" value="AFISEAZA LOG" class="buton_cool"></td>
		</tr>
	</table>
	</form>	
	{if $loguri neq ""}
	<table cellpadding="3" cellspacing="1" style="margin-top:10px">
		<tr>
			<td colspan="2" align="right" style="padding:2px;background-color:#DEF2FF;border-top:1px solid #CCCCCC;border-bottom:1px solid #CCCCCC">
				{$paginare}
			</td>
		</tr>
		<tr bgcolor="#EFEFEF">
			<td class="titlu" align="left" width="65"><b>Data log</b></td>
			<td class="titlu" align="left"><b>SQL</b></td>
		</tr>
		{section name=sec loop=$loguri}
		<tr bgcolor="{cycle values='#FFFFFF,#F2F2F2'}">
			<td valign="top">{$loguri[sec].data_log}</td>
			<td>{$loguri[sec].log}</td>
		</tr>		
		{/section}
		<tr>
			<td colspan="2" align="right" style="padding:2px;background-color:#DEF2FF;border-top:1px solid #CCCCCC;border-bottom:1px solid #CCCCCC">
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