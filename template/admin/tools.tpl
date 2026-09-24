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
	<table cellpadding="0" cellspacing="0" class="menu_container" style="background:url({$DIR_TEMPLATE}img/bg_menu.gif);border-top:1px solid #F2F2F2;border-left:1px solid #F2F2F2;border-right:1px solid #F2F2F2;">
		<tr>
			<td align="left" class="menu_title" height="18" style="padding-left:2px;padding-right:2px">
				<h2>UNELTE MENTENANTA ADMIN</h2>
			</td>
		</tr>
	</table>
	<form action="{$URL_ADMIN}tools.php" method="POST">
	<table cellpadding="5" cellspacing="0" class="box" width="557">
		{*-------------------------------------------------------INSTRUCTIUNI UTILIZARE--------------------------------------------*}
		<tr>
			<td>
				<ul>
					<li>Atentie: <b>ACESTE UNELTE SE FOLOSESC NUMAI DE CATRE WEBMASTER!</b></li>	
					<li>Atentie: <b>Rulati scripturile de mai jos doar daca apar nereguli in site!</b></li>				
				</ul>
			</td>
		</tr>
		{*----------------------------------------------------------------END------------------------------------------------------*}		
		<tr><td align="center"><input type="submit" name="update_nr_poze" value="UPDATE NUMAR POZE PRODUSE" class="buton" style="width:210px"></td></tr>
		<tr><td align="center"><input type="submit" name="update_nr_produse" value="UPDATE NR. PRODUSE CATEGORII" class="buton" style="width:210px"></td></tr>
		<tr><td align="center"><input type="submit" name="update_top_vanzari" value="UPDATE TOP VANZARI" class="buton" style="width:210px"></td></tr>
		<tr><td style="padding:0px" height="5"></td></tr>
		<tr><td height="1" class="bg_spatiu" height="1" style="padding:0px"></td></tr>
		<tr>
			<td>
				<table cellspacing="1" cellpadding="2" style="margin-top:5px">
					<tr>
						<td class="bg_spatiu" width="160"><b>Nume tabel</b></td>
						<td class="bg_spatiu" width="40"><b>Op</b></td>
						<td class="bg_spatiu" width="60"><b>Msg_type</b></td>
						<td class="bg_spatiu" width="60"><b>Msg_text</b></td>
						<td class="bg_spatiu"><b>Actiuni</b></td>
					</tr>
					{section name=sec loop=$tabele}
					<tr>
						<td>{$tabele[sec].nume_tabel}</td>
						<td>{$tabele[sec].op}</td>
						<td>{$tabele[sec].msg_type}</td>
						<td>{$tabele[sec].msg_text} {if $tabele[sec].msg_text eq "OK"}<img src="{$DIR_TEMPLATE}img_admin/ok.gif" alt="">{else}<img src="{$DIR_TEMPLATE}img_admin/bifa_ok.gif" alt="">{/if}</td>
						<td>
							<input type="button" value="REPARA" class="buton" style="width:90px" onClick="document.location.href='{$URL_ADMIN}tools.php?actiune=repara&tabel={$tabele[sec].nume_tabel}'">&nbsp;
							<input type="button" value="OPTIMIZEAZA" class="buton_cool" style="width:100px" onClick="document.location.href='{$URL_ADMIN}tools.php?actiune=optimizeaza&tabel={$tabele[sec].nume_tabel}'">
						</td>
					</tr>
					{/section}
				</table>
			</td>
		</tr>
	</table>
	</form>
	<p align="center"><a href="{$link_inapoi}" class="link_default">&laquo; Inapoi</a></p>
	<p align="right"><a href="#top"><img src="{$DIR_TEMPLATE}img/top.gif" alt="top"></a></p>
			</td>
		</tr>
	</table>
</td>
{/strip}
{include file="admin/right.tpl"}
{include file="admin/bottom.tpl"}