{strip}
<tr>
	<td width="182" align="left" valign="top" style="padding-left:2px">	
		<table cellpadding="0" cellspacing="0" class="box" width="180">
			<tr>
				<td>
				<table cellpadding="0" cellspacing="0" width="100%" class="menu_container">
					<tr><td class="menu_title" align="center" height="18">Actiuni categorii</td></tr>
				</table>	
				<table cellpadding="0" cellspacing="0" width="100%">
					<tr style="background-image: url({$DIR_TEMPLATE}img/menu_bg.jpg);">
						<td width="5" height="18"></td>
						<td width="10"><img src="{$DIR_TEMPLATE}img_admin/adauga.gif" alt="" class="icon"></td>
						<td style="padding-left:3px"><a href="{$URL_ADMIN}adauga_categorie.php" class="menu_left2" title="Adauga categorie noua">Adauga categorie</a></td>
					</tr>
					<tr><td colspan="3" height="1" class="bg_spatiu"></td></tr>
					<tr style="background-image: url({$DIR_TEMPLATE}img/menu_bg.jpg);">
						<td width="5" height="18"></td>
						<td width="10"><img src="{$DIR_TEMPLATE}img_admin/edit.gif" alt="" class="icon"></td>
						<td style="padding-left:3px"><a href="{$URL_ADMIN}catalog.php?edit=categorii_principale" class="menu_left2" title="Editeaza categoriile principale">Editeaza categorii</a></td>
					</tr>
					<tr><td colspan="3" height="1" class="bg_spatiu"></td></tr>
					<tr style="background-image: url({$DIR_TEMPLATE}img/menu_bg.jpg);">
						<td width="5" height="18"></td>
						<td width="10"><img src="{$DIR_TEMPLATE}img_admin/ordoneaza.gif" alt="" class="icon"></td>
						<td style="padding-left:3px"><a href="{$URL_ADMIN}ordoneaza_categorii.php" class="menu_left2" title="Ordoneaza categoriile">Ordoneaza categorii</a></td>
					</tr>
				</table>
				</td>
			</tr>
		</table>
		<table cellpadding="0" cellspacing="0" class="box" width="180" style="margin-top:5px">
			<tr>
				<td>
				<table cellpadding="0" cellspacing="0" width="100%" class="menu_container">
					<tr><td class="menu_title" align="center" height="18">Cautare</td></tr>
				</table>
				<form action="{$URL_ADMIN}cauta_produs.php" method="GET">
				<table cellpadding="3" cellspacing="0" width="100%">		
					<tr><td><input type="text" name="string" value="{$cautare_string_camp}" id="text_cautat2" size="20" maxlength="30" onClick="this.select()"> <input type="submit" value="GO" class="buton"></td></tr>
				</table>	
				</form>
				</td>
			</tr>
		</table>		
		<table cellpadding="0" cellspacing="0" class="box" width="180" style="margin-top:5px">
			<tr>
				<td>
				<table cellpadding="0" cellspacing="0" width="100%" class="menu_container">
					<tr><td class="menu_title" align="center" height="18">Categorii</td></tr>
				</table>	
				<table cellpadding="0" cellspacing="0" width="100%">
					{*----------------------------------------------CATEGORII TREE---------------------------------------------*}
					{section name=sec loop=$left_menu}
						<tr style="background-image: url({$DIR_TEMPLATE}img/menu_bg.jpg);">
							<td width="5"></td>
							<td height="18">	
								<table cellpadding="0" cellspacing="0">
									<tr>
										<td>{$left_menu[sec].indent}</td>
										<td {if $left_menu[sec].activ eq 0}class="categorie_dezactivata"{/if}>
											<a href="{$left_menu[sec].link_cat_admin}" title="{$left_menu[sec].nume_cat}" class="{if $left_menu[sec].nivel eq "0"}menu_left{else}submenu_left{/if}">
												{if $left_menu[sec].id_cat eq $cat_selectata}
													<font class="menu_selectat">{$left_menu[sec].nume_cat}</font>	
												{else}													
													{$left_menu[sec].nume_cat}	
												{/if}
												&nbsp;({$left_menu[sec].nr_produse})
											</a>
										</td>
									</tr>		
								</table>
							</td>
						</tr>
						{if !$smarty.section.sec.last}
						<tr><td colspan="2" height="1" class="bg_spatiu"></td></tr>
						{/if}
					{/section}
					{*---------------------------------------------END CATEGORII TREE------------------------------------------*}					
				</table>
				</td>
			</tr>
		</table>	
		<table cellpadding="0" cellspacing="0" class="box" width="180" style="margin-top:5px">
			<tr>
				<td>
				<table cellpadding="0" cellspacing="0" width="100%" class="menu_container">
					<tr><td class="menu_title" align="center" height="18">Actiuni producatori</td></tr>
				</table>	
				<table cellpadding="0" cellspacing="0" width="100%">
					<tr style="background-image: url({$DIR_TEMPLATE}img/menu_bg.jpg);">
						<td width="5" height="18"></td>
						<td width="10"><img src="{$DIR_TEMPLATE}img_admin/adauga.gif" alt="" class="icon"></td>
						<td style="padding-left:3px"><a href="{$URL_ADMIN}adauga_categorie.php?adauga=producator" class="menu_left2" title="Adauga producator nou">Adauga producator</a></td>
					</tr>
					<tr><td colspan="3" height="1" class="bg_spatiu"></td></tr>
					<tr style="background-image: url({$DIR_TEMPLATE}img/menu_bg.jpg);">
						<td width="5" height="18"></td>
						<td width="10"><img src="{$DIR_TEMPLATE}img_admin/edit.gif" alt="" class="icon"></td>
						<td style="padding-left:3px"><a href="{$URL_ADMIN}catalog.php?edit=producatori" class="menu_left2" title="Editeaza categoriile principale">Editeaza producatori</a></td>
					</tr>
					<tr><td colspan="3" height="1" class="bg_spatiu"></td></tr>
					<tr style="background-image: url({$DIR_TEMPLATE}img/menu_bg.jpg);">
						<td width="5" height="18"></td>
						<td width="10"><img src="{$DIR_TEMPLATE}img_admin/ordoneaza.gif" alt="" class="icon"></td>
						<td style="padding-left:3px"><a href="{$URL_ADMIN}ordoneaza_categorii.php?ordoneaza=producatori" class="menu_left2" title="Ordoneaza producatori">Ordoneaza producatori</a></td>
					</tr>
				</table>
				</td>
			</tr>
		</table>												
	</td>
{/strip}	