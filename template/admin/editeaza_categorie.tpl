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
	{*-------------------------------------------------------------ADAUGARE CATEGORIE----------------------------------------------*}
	<table cellpadding="0" cellspacing="0" class="menu_container" style="background:url({$DIR_TEMPLATE}img/bg_menu.gif);border-top:1px solid #F2F2F2;border-left:1px solid #F2F2F2;border-right:1px solid #F2F2F2;">
		<tr>
			<td align="left" class="menu_title" height="18" style="padding-left:2px;padding-right:2px">
				<h2>Editeaza {if $edit eq "producatori"}producatori{else}categoria{/if}: <font class="titlu_cat">{$nume_cat|upper}</font></h2>			
			</td>
		</tr>
	</table>			
	<table cellpadding="5" cellspacing="0" class="box" width="557">	
		<tr>
		{*-------------------------------------------------------INSTRUCTIUNI UTILIZARE--------------------------------------------*}
			<td>		
				<ul>
					<li>In aceasta pagina aveti posibilitatea de a edita {if $edit eq "producatori"}producatorul{else}categoria{/if}.</li>
					<li>Daca doriti sa nu folositi redimensionarea unei poze, debifati casuta optiunea "resize" si veti avea posibilitea sa uploadati manual thumb si poza medie.</li>
					<li>Aveti posibilitatea sa mutati {if $edit eq "producatori"}producatorul{else}categoria{/if} in radacina sau ca subcategorie a unei categorii existente.</li>
					<li class="atentie">ATENTIE: Exemplu filtre pret: <99,100-499,500-1000,>1001 sau 100-200,201-300,301-500 sau <1000,1001-2000 sau 100-150,>151 etc.</li>				
				</ul>		
			</td>				
		</tr>
		{*----------------------------------------------------------------END------------------------------------------------------*}
		{*-----------------------------------------------------FORMULAR ADAUGARE CATEGORIE-----------------------------------------*}
		<tr>
			<td>
				<form action="editeaza_categorie.php?cat={$id_cat}" method="POST" enctype="multipart/form-data">
				<table>
					{if $edit neq "producatori"}
					<tr>
						<td>Categoria parinte:</td>
						<td colspan="2">
							<select name="cat_parinte" class="select">
								<option value="0">--ROOT--</option>
								{html_options options=$toate_cat selected=$id_parinte}
							</select>
						</td>
					</tr>
					{/if}
					<tr>
						<td {if $categorie_check.valid eq "0"}class="eroare_text"{/if} width="120">Nume {if $edit eq "producatori"}producator{else}categorie{/if}*:</td>
						<td><input type="text" name="nume_cat" value="{$categorie_check.camp}" maxlength="64" size="30" {if $categorie_check.valid eq "0"}class="eroare_bg"{/if}></td>
						<td class="eroare_form">
							{$categorie_check.eroare}
							{if $categorie_check.eroare eq "" && $form_submit eq "1"}<img src="{$DIR_TEMPLATE}img/ok.gif" alt="">{/if}
						</td>
					</tr>
					{if $edit neq "producatori"}
					<tr>
						<td>Categorie activa:</td>
						<td align="left"><input type="radio" name="activ" value="1" {if  $activ eq "1"}checked{/if}> Da <input type="radio" name="activ" value="0" {if  $activ eq "0"}checked{/if}> Nu </td>
						<td></td>
					</tr>
					{/if}
					<tr>
						<td {if $link_check.valid eq "0"}class="eroare_text"{/if}>Link {if $edit eq "producatori"}producator{else}categorie{/if}:</td>
						<td><input type="text" name="link_cat" value="{$link_check.camp}" maxlength="64" size="30" disabled id="link_cat" {if $link_check.valid eq "0"}class="eroare_bg"{/if}></td>
						<td class="eroare_form">
							{$link_check.eroare}
							{if $link_check.eroare eq "" && $categorie_check.eroare eq "" && $form_submit eq "1"}<img src="{$DIR_TEMPLATE}img/ok.gif" alt="">{/if}
						</td>
					</tr>
					<tr>
						<td></td>
						<td>Seteaza link manual: <input type="checkbox" onClick="toggleEnable('link_cat')" style="margin:0px;padding:0px"></td>
						<td></td>
					</tr>
					<tr>
						<td valign="top" style="padding-top:2px">Descriere {if $edit eq "producatori"}producator{else}categorie{/if}:</td>
						<td colspan="2"><textarea name="descriere_cat" rows="10" cols="76">{$descriere_check.camp}</textarea></td>
					</tr>
					{if $edit neq "producatori"}
					<tr>
						<td valign="top" style="padding-top:2px">Discount (%):</td>
						<td colspan="2"><input type="text" name="discount" value="{$discount_check.camp}" size="4"></td>
					</tr>
					<tr>
						<td {if $limite_preturi_check.valid eq "0"}class="eroare_text"{/if}>Filtre preturi</td>
						<td><input type="text" name="limite_preturi" value="{$limite_preturi_check.camp}" size="30" maxlength="255" {if $limite_preturi_check.valid eq "0"}class="eroare_bg"{/if}></td>
						<td class="eroare_form">
							{$limite_preturi_check.eroare|wordwrap:40:"<br />"}
							{if $link_check.eroare eq "" && $categorie_check.eroare eq "" && $form_submit eq "1"}<img src="{$DIR_TEMPLATE}img/ok.gif" alt="">{/if}
						</td>
					</tr>
					{/if}
					<tr>
						<td>Poza {if $edit eq "producatori"}producator{else}categorie{/if}:</td>
						<td colspan="2"><input type="file" name="poza_cat" size="30" id="poza_cat"> &nbsp; Resize: <input type="checkbox" value="1" name="do_resize" onClick="toggleEnableAndShowDiv('poza_cat', 'upload_manual')" style="margin:0px;padding:0px" checked></td>
					</tr>
					<tr>
						<td>
							{if $poza_cat neq ""}
								<img src="{$poza_cat}?{$timestamp}" alt="" class="box" style="padding:10px">
								<br />
								&nbsp; &nbsp;<a href="{$URL_ADMIN}editeaza_categorie.php?cat={$id_cat}&actiune=sterge_poza" class="link_default">Sterge poza</a>
							{/if}
						</td>
						<td colspan="2">
							<div id="upload_manual" style="display:none">
							<table>
								<tr>
									<td>Thumb: (40x30) .jpg</td>
									<td><input type="file" name="poza_cat_thumb"></td>
								</tr>
								<tr>
									<td>Medium: (70x53) .jpg</td>
									<td><input type="file" name="poza_cat_medium"></td>
								</tr>								
							</table>
							</div>
						</td>
					</tr>					
					<tr>
						<td></td>
						<td colspan="2">
							<input type="submit" name="modifica_categorie" value="MODIFICA {if $edit eq "producatori"}PRODUCATOR{else}CATEGORIE{/if}" class="buton" style="width:166px">
							&nbsp;
							<input type="button" value="STERGE CATEGORIE" class="buton_anuleaza" style="width:166px" 
									onClick="casutaConfirmare('Sunteti sigur ca doriti sa stergeti
															   <br />{if $edit eq "producatori"}producatorul{else}categoria{/if} <b>{$nume_cat}</b>?
															  {if $edit neq "producatori"} <br /><br /><font class=eroare_text>Toate produsele din aceasta categorie vor fi sterse definitiv!</font>{/if}', '400',
															  '{$URL_ADMIN}sterge_categorie.php?cat={$id_cat}')">
						</td>
					</tr>
					{if $edit neq "producatori"}
					<tr>
						<td></td>
						<td colspan="2">
							<input type="button" value="FILTRE CATEGORIE" class="buton_cool" style="width:166px" onClick="window.location.href='{$URL_ADMIN}gestioneaza_filtre.php?cat={$id_cat}'">
							&nbsp;
							<input type="button" value="ADAUGA PRODUS" class="buton_cool" style="width:166px" onClick="window.location.href='{$URL_ADMIN}gestioneaza_produse.php?cat={$id_cat}'">
						</td>
					</tr>
					{/if}
				</table>				
				</form>
				<hr size="1">
				* = Campuri obligatorii
			</td>			
		</tr>
		{*-----------------------------------------------------------END FORMULAR--------------------------------------------------*}
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