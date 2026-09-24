{include file="admin/top.tpl"}
{include file="admin/left.tpl"}
{strip}
<td valign="top" align="left" width="568">
	<script type="text/javascript" src="{$URL_BASE}javascript/calendar_js/calendarDateInput.js"></script>
	<script type="text/javascript" src="{$URL_BASE}javascript/prototype.js"></script>
	<table style="margin-left:6px;margin-right:6px;" cellpadding="0" cellspacing="0" width="557">
		<tr>
			<td class="box">
	{*-------------------------------------------------------------------MESAJE----------------------------------------------------*}
	{if $mesaj neq ""}
		{include file="admin/mesaj.tpl" mesaj=$mesaj}
	{/if}
	{*---------------------------------------------------------------------END-----------------------------------------------------*}
	<table cellpadding="3" cellspacing="1">
		<tr>
			<td class="menu_title" style="background:url({$DIR_TEMPLATE}img/bg_menu.gif);border-top:1px solid #F2F2F2;border-left:1px solid #F2F2F2;border-right:1px solid #F2F2F2;">
				<h2>Gestioneaza <font class="titlu_cat">COMENTARII</font></h2>
			</td>
		</tr>
	</table>
	{*-----------------------------------------------------------INSTRUCTIUNI UTILIZARE---------------------------------------------*}
	<ul>
		<li>In aceasta sectiunea aveti posibilitatea de a aproba comentariile noi sau de a le edita inainte de aprobare.</li>
	</ul>
	{if $id_comentariu neq ""}
	<form action="" method="POST">
	<center>
		<table cellpadding="3" cellspacing="1" width="85%" style="margin-bottom:10px;background-color:#EFEFEF">
			<tr>
				<td align="right" valign="top" width="110"><b>Produsul:</b></td>
				<td align="left" valign="top" class="titlu"><b>{$nume_produs}</b></td>
			</tr>
			<tr>
				<td align="right" valign="top"><b>Adaugat de:</b></td>
				<td align="left" valign="top" class="titlu"><b>{$username_comentariu}</b></td>
			</tr>
			<tr>
				<td align="right" valign="top"><b>Data adaugarii:</b></td>
				<td align="left" valign="top" class="titlu"><b>{$data_adaugarii}</b></td>
			</tr>
			<tr>
				<td align="right" valign="top" style="padding-top:3px"><b>Comentariu:</b></td>
				<td align="left" valign="top"><textarea name="comentariu" rows="6" cols="60">{$comentariu}</textarea></td>
			</tr>
			<tr>
				<td></td>
				<td align="left"><input type="submit" name="modifica" value="MODIFICA" class="buton"></td>
			</tr>
		</table>
		<input type="hidden" name="id_edit_comentariu" value="{$id_comentariu}">
	</center>
	</form>
	{/if}
	{*--------------------------------------------------------------------END-------------------------------------------------------*}
	{if $comentarii neq ""}
		<form action="" method="POST" name="comentarii">
			<table cellpadding="3" cellspacing="1" width="100%">
				
				<tr><td colspan="4"><b>Comentarii noi care asteapta activare <span class="titlu">({$nr_comentarii})</span>:</b></td></tr>
				<tr>
					<td colspan="4" align="right" style="padding:2px;background-color:#DEF2FF;border-top:1px solid #CCCCCC;border-bottom:1px solid #CCCCCC">
						{$paginare}
					</td>
				</tr>
				<tr><td colspan="4" height="5"></td></tr>
				<tr bgcolor="#EFEFEF">
					<td width="10"></td>
					<td class="titlu" width="120"><b>Username</b></td>
					<td class="titlu" width="80" align="center"><b>Data <br />adaugarii</b></td>
					<td class="titlu" align="center"><b>Comentariu</b></td>
				</tr>
				{*-------------------------------------------------AFISARE COMENTARII-----------------------------------------------*}
				{section name=sec loop=$comentarii}
				<tr bgcolor="#F0F7CB">
					<td></td>
					<td colspan="3">Produs: <b>{$comentarii[sec].nume_produs}</b></td>
				</tr>
				<tr bgcolor="{cycle values="#FFFFFF,#F2F2F2"}">
					<td valign="top" style="padding:0px">
						<input type="radio" name="id_comentariu" value="{$comentarii[sec].id_comentariu}" {if $smarty.section.sec.first}checked{/if}>
					</td>
					<td valign="top" style="padding-top:3px">
						{$comentarii[sec].username}
					</td>
					<td valign="top">
						{$comentarii[sec].data_adaugarii}
					</td>
					<td valign="top">
						{$comentarii[sec].comentariu}
					</td>
				</tr>
				{/section}
				{*---------------------------------------------------------END------------------------------------------------------*}
				<tr>
					<td colspan="4" align="right">
						<input type="submit" name="editeaza" value="EDITEAZA" class="buton" style="width:100px">&nbsp;
						<input type="submit" name="aproba" value="APROBA" class="buton_cool" style="width:100px">&nbsp;
						<input type="button" name="sterge" value="STERGE" class="buton_anuleaza" style="width:100px" 
							onclick="casutaConfirmare('Sunteti sigur ca doriti sa stergeti comentariul selectat ?', '400', '{$URL_ADMIN}comentarii_noi.php?id_comentariu='+getCheckedValue(document.forms['comentarii'].elements['id_comentariu'])+'&actiune=sterge_comentariu')">
					</td>
				</tr>
				<tr>
					<td colspan="4" height="5"></td>
				</tr>
				<tr>
					<td colspan="4" align="right" style="padding:2px;background-color:#DEF2FF;border-top:1px solid #CCCCCC;border-bottom:1px solid #CCCCCC">
						{$paginare}
					</td>
				</tr>
				
			</table>
		</form>
	{else}
	<div style="padding-left:5px;padding-bottom:5px">
		Nu exista comentarii noi!
	</div>	
	{/if}
			</td>
		</tr>
	</table>
	<p align="center"><a href="{$link_inapoi}" class="link_default">&laquo; Inapoi</a></p>
	<p align="right"><a href="#top"><img src="{$DIR_TEMPLATE}img/top.gif" alt="top"></a> &nbsp;</p>
</td>
{/strip}
{include file="admin/right.tpl"}
{include file="admin/bottom.tpl"}