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
				<h2>Adauga {if $adauga eq "producator"}producator nou{else}categorie noua{/if} {if $nume_parinte neq ""}in: <font class="titlu_cat">{$nume_parinte|upper}</font>{/if}</h2>			
			</td>
		</tr>
	</table>			
	<table cellpadding="5" cellspacing="0" class="box" width="557">	
		<tr>
		{*-------------------------------------------------------INSTRUCTIUNI UTILIZARE--------------------------------------------*}
			<td>
				{if $adauga eq "producator"}
				<ul>
					<li>In aceasta pagina aveti posibilitatea de a adauga un producator nou.</li>
					<li class="atentie">ATENTIE: Puteti avea producatori cu nume duplicat, cu conditia ca link-ul sa difere.</li>						
				</ul>
				{else}		
				<ul>
					<li>In aceasta pagina aveti posibilitatea de a adauga o categorie noua.</li>
					<li class="atentie">ATENTIE: Puteti avea categorii cu nume duplicat, cu conditia ca link-ul sa difere.</li>	
					<li class="atentie">ATENTIE: Dupa ce adaugati categoria va rugam sa adaugati caracteristicile produselor din aceasta categorie inainte sa adaugati produse. Aceste caracteristici vor fi folosite la filtrare si la adaugarea unui produs nou.</li>
					<li class="atentie">ATENTIE: Exemplu filtre pret: <99,100-499,500-1000,>1001 sau 100-200,201-300,301-500 sau <1000,1001-2000 sau 100-150,>151 etc.</li>				
				</ul>
				{/if}		
			</td>				
		</tr>
		{*----------------------------------------------------------------END------------------------------------------------------*}
		{*-----------------------------------------------------FORMULAR ADAUGARE CATEGORIE-----------------------------------------*}
		<tr>
			<td valign="top">
				<form action="{$url_form}" method="POST" enctype="multipart/form-data">
				<table>
					<tr>
						<td width="190" {if $categorie_check.valid eq "0"}class="eroare_text"{/if}>Nume {if $adauga eq "producator"}produc.{else}categorie{/if}*:</td>
						<td width="150"><input type="text" name="nume_cat" value="{$categorie_check.camp}" maxlength="64" size="30" {if $categorie_check.valid eq "0"}class="eroare_bg"{/if}></td>
						<td width="200" class="eroare_form">
							{$categorie_check.eroare|wordwrap:40:"<br />"}
							{if $categorie_check.eroare eq "" && $form_submit eq "1"}<img src="{$DIR_TEMPLATE}img/ok.gif" alt="">{/if}
						</td>
					</tr>
					<tr>
						<td {if $link_check.valid eq "0"}class="eroare_text"{/if}>Link {if $adauga eq "producator"}producator{else}categorie{/if}:</td>
						<td><input type="text" name="link_cat" value="{$link_check.camp}" maxlength="64" size="30" disabled id="link_cat" {if $link_check.valid eq "0"}class="eroare_bg"{/if}></td>
						<td class="eroare_form">
							{$link_check.eroare|wordwrap:40:"<br />"}
							{if $link_check.eroare eq "" && $categorie_check.eroare eq "" && $form_submit eq "1"}<img src="{$DIR_TEMPLATE}img/ok.gif" alt="">{/if}
						</td>
					</tr>
					<tr>
						<td></td>
						<td>Seteaza link manual: <input type="checkbox" onClick="toggleEnable('link_cat')" style="margin:0px;padding:0px"></td>
						<td></td>
					</tr>
					<tr>
						<td valign="top" style="padding-top:2px">Descriere categorie:</td>
						<td colspan="2"><textarea name="descriere_cat" rows="7" cols="76">{$descriere_check.camp}</textarea></td>
					</tr>
					{if $edit neq "producatori"}
					<tr>
						<td>Discount (%):</td>
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
						<td>Poza {if $adauga eq "producator"}producator{else}categorie{/if}:</td>
						<td colspan="2"><input type="file" name="poza_cat" size="30" id="poza_cat"> &nbsp; Resize: <input type="checkbox" value="1" name="do_resize" onClick="toggleEnableAndShowDiv('poza_cat', 'upload_manual')" checked  style="margin:0px;padding:0px"></td>
					</tr>
					<tr>
						<td></td>
						<td>
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
						<td colspan="2"><input type="submit" name="adauga_categorie" value="ADAUGA {if $adauga eq "producator"}PRODUCATOR{else}CATEGORIE{/if}" class="buton_cool" style="width:166px"></td>
					</tr>
				</table>
				<p align="center"><a href="{$link_inapoi}" class="link_default">&laquo; Inapoi</a></p>
				</form>
				<hr size="1">
				* = Campuri obligatorii
			</td>			
		</tr>
		{*-----------------------------------------------------------END FORMULAR--------------------------------------------------*}
	</table>			
	<p align="right"><a href="#top"><img src="{$DIR_TEMPLATE}img/top.gif" alt="top"></a></p>
			</td>
		</tr>
	</table>
</td>
{/strip}
{include file="admin/right.tpl"}
{include file="admin/bottom.tpl"}