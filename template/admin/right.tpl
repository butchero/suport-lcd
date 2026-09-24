{strip}	
	<td valign="top" align="left" style="padding-right:2px">		
		<table cellpadding="0" cellspacing="0" class="box" width="180">
			<tr>
				<td>
				<table cellpadding="0" cellspacing="0" width="100%" class="menu_container">
					<tr><td class="menu_title" align="center" height="18">Editare texte site</td></tr>
				</table>		
				<table cellpadding="0" cellspacing="0" width="100%">
					{section name=sec loop=$texte}
					<tr style="background-image:url({$DIR_TEMPLATE}img/menu_bg.jpg)">
						<td width="5" height="18"></td>
						<td width="10"><img src="{$DIR_TEMPLATE}img_admin/texte.gif" alt="" class="icon"></td>
						<td style="padding-left:3px"><a href="{if $super_admin eq "1"}{$texte[sec].link}{else}#{/if}" class="menu_left2{if $super_admin neq "1"}_inactiv{/if}" title="Editeaza text {$texte[sec].nume}">{$texte[sec].nume}</a></td>
					</tr>	
					{/section}				
				</table>
				</td>
			</tr>
		</table>
		<table cellpadding="0" cellspacing="0" class="box" width="180" style="margin-top:5px">
			<tr>
				<td>
				<table cellpadding="0" cellspacing="0" width="100%" class="menu_container" style="background:url({$DIR_TEMPLATE}img/bg_menu.gif)">
					<tr><td class="menu_title" align="center" height="18">Alte optiuni</td></tr>
				</table>	
				<table cellpadding="0" cellspacing="0" width="100%">
					<tr style="background-image:url({$DIR_TEMPLATE}img/menu_bg.jpg)">
						<td width="5" height="18"></td>
						<td width="10"><img src="{$DIR_TEMPLATE}img_admin/param.gif" alt="" class="icon"></td>
						<td style="padding-left:3px"><a href="{if $super_admin eq "1"}{$URL_ADMIN}parametri_site.php{else}#{/if}" class="menu_left2{if $super_admin neq "1"}_inactiv{/if}" title="Configureaza parametrii site">Parametri site</a></td>
					</tr>
				</table>
				</td>
			</tr>
		</table>
		<table cellpadding="0" cellspacing="0" class="box" width="180" style="margin-top:5px">
			<tr>
				<td>
				<table cellpadding="0" cellspacing="0" width="100%" class="menu_container">
					<tr><td class="menu_title" align="center" height="18">Optiuni admin</td></tr>
				</table>		
				<table cellpadding="0" cellspacing="0" width="100%">
					<tr style="background-image:url({$DIR_TEMPLATE}img/menu_bg.jpg)">
						<td width="5" height="18"></td>
						<td width="10"><img src="{$DIR_TEMPLATE}img_admin/cheie.gif" alt="" class="icon"></td>
						<td style="padding-left:3px"><a href="{$URL_ADMIN}modifica_parola.php" class="menu_left2" title="Modifica parola">Modifica parola</a></td>
					</tr>
				</table>
				</td>
			</tr>
		</table>	
	</td>
</tr>
{/strip}