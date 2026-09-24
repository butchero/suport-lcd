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
				<h2>Statistici vanzari pe produs</h2>
			</td>
		</tr>
	</table>	
	{*-----------------------------------------------------------INSTRUCTIUNI UTILIZARE--------------------------------------------*}
	<ul>
		<li>In aceasta sectiune aveti posibilitatea de a vizualiza grafic evolutia comenzilor pentru un produs.</li>		
		<li>ATENTIE: Zilele in care nu au fost vanzari nu apar in grafic.</li>
	</ul>
	{*--------------------------------------------------------------------END------------------------------------------------------*}		
	<form action="{$URL_ADMIN}statistici_vanzari_pe_produs.php" method="POST">
	<table bgcolor="#EFEFEF" width="100%">
		<tr>
			<td align="left">
				Afiseaza situatie din anul: <input type="text" name="an" size="4" value="{$an_selectat}"> luna: &nbsp; 
				<select name="luna" class="select">
					<option value="0">--Toate lunile--</option>
					{html_options options=$luni selected=$luna_selectata}
				</select> 
				&nbsp;pt. produs cu id: <input type="text" name="id_produs" value="{$id_produs}" size="3">
				&nbsp;<input type="submit" value="AFISEAZA" class="buton_cool" style="width:70px">
			</td>
		</tr>		
	</table>	
	</form>	
	<br />						
	{if $id_produs neq ""}
		<font class="titlu"><b>{$nume_produs}</b></font>
		<br /><br />
		<iframe src="{$URL_ADMIN}statistici_incasari_pe_produs_grafic.php?an={$an_selectat}&luna={$luna_selectata}&id_produs={$id_produs}" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" width="471" height="130"></iframe>
		<br />						
		<iframe src="{$URL_ADMIN}statistici_vanzari_pe_produs_grafic.php?an={$an_selectat}&luna={$luna_selectata}&id_produs={$id_produs}" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" width="471" height="130"></iframe>
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