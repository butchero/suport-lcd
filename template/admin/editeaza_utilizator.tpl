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
	<table cellpadding="3" cellspacing="1" class="bg_spatiu" width="100%">
		<tr>
			<td class="menu_title" style="background:url({$DIR_TEMPLATE}img/bg_menu.gif);border-top:1px solid #F2F2F2;border-left:1px solid #F2F2F2;border-right:1px solid #F2F2F2;">
				<h2>Editeaza <font class="titlu_cat">UTILIZATOR</font></h2>
			</td>
		</tr>
	</table>
	{*-----------------------------------------------------------INSTRUCTIUNI UTILIZARE---------------------------------------------*}
	<ul>
		<li>Editare date utilizator.</li>
		<li>ATENTIE: Username-ul nu poate fi schimbat!</li>
	</ul>
	{*--------------------------------------------------------------------END------------------------------------------------------*}
	{*--------------------------------------------------------------SETARE FLAG AJAX-----------------------------------------------*}	
	<table style="margin-left:20px" class="bg_spatiu">
		<tr>
			<td>Flag:</td>
			<td><input type="checkbox" name="flag_user" id="flag_user" value="1" {if $flag eq "1"}checked{/if} onClick="setUserFlag('{$id_user}')"></td>
			<td>(pentru a putea gasi mai usor anumiti utilizatori)</td>
			<td style="padding-left:5px"><div id="flag_loader" class="eroare_text"></div></td>
		</tr>
	</table>
	{*--------------------------------------------------------------------END------------------------------------------------------*}	
	{include file="cont_utilizator/form_editeaza_date_cont.tpl"}
			</td>
		</tr>
	</table>		
	<p align="center"><a href="{$link_inapoi_useri}" class="link_default">&laquo; Inapoi</a></p>			
	<p align="right"><a href="#top"><img src="{$DIR_TEMPLATE}img/top.gif" alt="top"></a>&nbsp;</p>
</td>
{/strip}
{include file="admin/right.tpl"}
{include file="admin/bottom.tpl"}