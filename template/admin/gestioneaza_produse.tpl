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
	{*------------------------------------------------------------GESTIONEAZA PRODUSE----------------------------------------------*}
	<table cellpadding="0" cellspacing="0" class="menu_container" style="background:url({$DIR_TEMPLATE}img/bg_menu.gif);border-top:1px solid #F2F2F2;border-left:1px solid #F2F2F2;border-right:1px solid #F2F2F2;">
		<tr>
			<td align="left" class="menu_title" height="18" style="padding-left:2px;padding-right:2px">
				<h2>{if $id_produs neq ""}Editeaza{else}Adauga{/if} produs in categoria <font class="titlu_cat">{$nume_cat|upper}</font></h2>			
			</td>
		</tr>
	</table>			
	<table cellpadding="5" cellspacing="0" class="box" width="557">	
		{*-------------------------------------------------------INSTRUCTIUNI UTILIZARE--------------------------------------------*}
		<tr>		
			<td>		
				<ul>
					<li>
						In aceasta pagina aveti posibilitatea de a {if $id_produs neq ""}edita un produs existent{else}adauga un produs nou{/if}. <br />
						Produsul va avea caracteristicile categoriei. Alte caracteristici suplimentare sau detalii tehnice le puteti adauga la descrierea generala
					</li>
					<li>ATENTIE: Produsele cu optiunea "nu e pe stoc" nu vor putea fi cumparate!</li>					
					<li>ATENTIE: Daca poza uplodata este prea mica ea va fi marita automat si va arata deformat. Este recomandat sa uploadati poze >= 600x600pixeli!</li>
					<li>ATENTIE: Puteti adauga maxim 8 poze secundare si una principala!</li>					
				</ul>	
			</td>				
		</tr>
		{*----------------------------------------------------------------END------------------------------------------------------*}
		{*---------------------------------------------------FORMULAR ADAUGARE/EDITARE PRODUS--------------------------------------*}
		<tr>
			<td>
				<form action="{$URL_ADMIN}gestioneaza_produse.php?{if $string neq ""}string={$string}{else}cat={$id_cat}{/if}{if $id_produs neq ""}&id_produs={$id_produs}{/if}" method="POST" enctype="multipart/form-data">
					<table cellpadding="2" cellspacing="1" width="557">
						<tr>
							<td colspan="2" height="20"><b>{if $id_produs neq ""}Editeaza produs{else}Adauga produs{/if}</td>
							<td align="right"><a href="{$link_inapoi}" class="link_default">&laquo; Inapoi</a></td>
						</tr>
						<tr><td colspan="3" height="1"></td></tr>
						<tr>
							<td width="250" height="20" {if $nume_produs_check.valid eq "0"}class="eroare_text"{/if}>Nume*:</td>
							<td width="180"><input type="text" name="nume_produs" size="50" value="{$nume_produs_check.camp}" {if $nume_produs_check.valid eq "0"}class="eroare_bg"{/if} maxlength="128"></td>
							<td class="eroare_form" width="150">
								{$nume_produs_check.eroare}
								{if $nume_produs_check.eroare eq "" && $form_submit eq "1"}<img src="{$DIR_TEMPLATE}img/ok.gif" alt="">{/if}
							</td>
						</tr>
						<tr>
							<td height="20" {if $cod_produs_check.valid eq "0"}class="eroare_text"{/if}>Cod produs:</td>
							<td><input type="text" name="cod_produs" value="{$cod_produs_check.camp}" {if $cod_produs_check.valid eq "0"}class="eroare_bg"{/if} size="16" maxlength="16"></td>
							<td class="eroare_form">
								{$cod_produs_check.eroare}
								{if $cod_produs_check.eroare eq "" && $form_submit eq "1"}<img src="{$DIR_TEMPLATE}img/ok.gif" alt="">{/if}
							</td>
						</tr>
						<tr><td height="20" colspan="3"><b>Producator:</b></td></tr>
						<tr>
							<td height="20">Alege:</td>
							<td>
								<select name="producator" class="select" style="width:150px">
									<option value="0">--Alege--</option>
									{html_options options=$producatori selected=$producator_selectat}
								</select>
							</td>
							<td></td>
						</tr>
						<tr><td height="20" colspan="3"><b>Furnizor:</b></td></tr>
						<tr>
							<td height="20">Furnizor:</td>
							<td><input type="text" name="furnizor" value="{$furnizor}" size="50"></td>
							<td></td>
						</tr>
						<tr><td height="20" colspan="3"><b>Pret:</b></td></tr>
						<tr>
							<td height="20" {if $pret_check.valid eq "0"}class="eroare_text"{/if}>Pret produs*:</td>
							<td><input type="text" name="pret" value="{$pret_check.camp}" size="15" {if $pret_check.valid eq "0"}class="eroare_bg"{/if}> <b>{$MONEDA}</b> {if $TVA neq 1}fara{else}cu{/if} <b>TVA</b></td>
							<td class="eroare_form">
								{$pret_check.eroare}
								{if $pret_check.eroare eq "" && $form_submit eq "1"}<img src="{$DIR_TEMPLATE}img/ok.gif" alt="">{/if}
							</td>
						</tr>
						<tr>
							<td height="20" {if $pret_vechi_check.valid eq "0"}class="eroare_text"{/if}>Pret vechi:</td>
							<td><input type="text" name="pret_vechi" value="{$pret_vechi_check.camp}" size="15" {if $pret_vechi_check.valid eq "0"}class="eroare_bg"{/if}> <b>{$MONEDA}</b> {if $TVA neq 1}fara{else}cu{/if} <b>TVA</b></td>
							<td class="eroare_form">
								{$pret_vechi_check.eroare}
								{if $pret_vechi_check.eroare eq "" && $form_submit eq "1" && $pret_vechi_check.camp neq ""}
									<img src="{$DIR_TEMPLATE}img/ok.gif" alt="">
								{/if}
							</td>
						</tr>
						<tr>
							<td height="20" colspan="3"><b>Caracteristici (filtre):</b></td>							
						</tr>
						{section name=sec loop=$filtre}
						<tr>
							<td height="20">{$filtre[sec].nume_filtru}:</td>
							<td>
								<select name="filtre[]" class="select" style="width:150px">
									<option value="-">--Alege--</option>
									{html_options options=$filtre[sec].valori_posibile selected=$filtre_selectate[sec]}
								</select>
								&nbsp; <input type="checkbox" {if $filtre[sec].afiseaza_filtru eq "1"}checked{/if} disabled style="padding:0px;margin:0px"> Filtru								
							</td>
							<td></td>
						</tr>
						{/section}
						{if $smarty.section.sec.total eq 0}
						<tr>
							<td colspan="3" class="text_avertizare" style="padding:5px">
								- Nu sunt definite caracteristici pt. aceasta categorie. Este recomandat sa le definiti inainte sa adaugati produse!
							</td>
						</tr>
						{/if}
						<tr>
							<td height="20"><b>Info stoc:</b></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td height="20">Stoc:</td>
							<td>
								<select name="stoc" class="select" style="width:150px">									
									{html_options options=$stocuri selected=$stoc_selectat}
								</select>								
							</td>
							<td></td>
						</tr>						
						<tr>
							<td height="20" colspan="3"><b>Descriere generala:</b></td>							
						</tr>
						<tr>
							<td height="20" valign="top" style="padding-top:2px">Descriere:</td>
							<td colspan="2"><textarea rows="10" cols="80" name="descriere_produs">{$descriere_produs}</textarea></td>
						</tr>
						<tr>
							<td height="20" colspan="3"><b>Altele:</b></td>							
						</tr>
						<tr>
							<td height="20">Oferta speciala:</td>
							<td colspan="2"><input type="radio" name="oferta_speciala" value="0" {if $oferta_speciala neq "1"}checked{/if}> Nu <input type="radio" name="oferta_speciala" value="1" {if $oferta_speciala eq "1"}checked{/if}> Da</td>
						</tr>
						<tr>
							<td height="20" colspan="3"><b>Upload poze:</b> (se recomanda poze >= 600x600 pixeli si maxim 2MB dimensiune) <a name="poze"></a></td>							
						</tr>
						<tr>
							<td height="20" valign="top" style="padding-top:2px">Poza principala:</td>
							<td colspan="2">
								<input type="file" name="poza_principala" size="58" class="bg_spatiu"> <br />
								{if $poza_principala neq ""}
									<img src="{$poza_principala}?{$timestamp}" alt=""> <br />
									&nbsp;
									<a href="{$URL_ADMIN}gestioneaza_produse.php?cat={$id_cat}&id_produs={$id_produs}&sterge_poza=0.jpg#poze" class="link_default">
										[sterge poza]
									</a>
								{/if}
							</td>
						</tr>
						<tr>
							<td height="20" valign="top" style="padding-top:2px">Poze:</td>
							<td colspan="2">
							{repeat count=$NR_POZE_DISPONIBILE}
								<input type="file" name="poze[]" size="58"><br />
							{/repeat}			
							<table cellpadding="2" cellspacing="0">
							{section name=tr loop=$poze_sec_medii step=4}							
								<tr>
									{section name=td start=$smarty.section.tr.index loop=$smarty.section.tr.index+4}
									<td align="center">
										{if $poze_sec_medii[td] neq ""}
											<img src="{$poze_sec_medii[td]}?{$timestamp}" alt=""><br />
											<a href="{$URL_ADMIN}gestioneaza_produse.php?cat={$id_cat}&id_produs={$id_produs}&sterge_poza={$poze[td]}#poze" class="link_default">
												[sterge poza]
											</a>
										{/if}
									</td>
									{/section}
								</tr>	
							{/section}
							</table>				
							</td>
						</tr>
						<tr>
							<td height="20" valign="top" style="padding-top:2px">Fisiere:</td>
							<td colspan="2">							
								<input type="file" name="fisier" size="58" class="bg_spatiu"> <a name="poze"></a>
								<table>
									{section name=sec loop=$fisiere_upl}
									<tr>
										<td><b>{$fisiere_upl[sec]}</b> - <a href="{$URL_ADMIN}gestioneaza_produse.php?cat={$id_cat}&id_produs={$id_produs}&sterge_fisier={$fisiere_upl[sec]}#poze" class="link_default">[sterge]</a></td>
									</tr>
									{/section}
								</table>
							</td>
						</tr>
						<tr>
							<td align="right" colspan="3">
								<table>
									<tr>
										<td><img src="{$DIR_TEMPLATE}img/watermark.png" alt="Watermark"></td>
										<td>Aplica watermark:</td>
										<td><input type="checkbox" name="watermark" value="1" checked></td>
									</tr>	
								</table>
							</td>
						</tr>
						<tr>
							<td></td>
							<td colspan="2">
								<input type="submit" name="{if $id_produs neq ""}modifica{else}adauga{/if}_produs" value="{if $id_produs neq ""}MODIFICA{else}ADAUGA{/if} PRODUS" class="{if $id_produs neq ""}buton{else}buton_cool{/if}" style="width:166px">
								&nbsp;
								{if $id_produs neq ""}
									<input type="button" value="STERGE PRODUS" class="buton_anuleaza" style="width:166px"
										onClick="casutaConfirmare('Sunteti sigur ca doriti sa stergeti
																   <br />produsul <b>{$nume_produs}</b>?',
																  '400',
																  '{$URL_ADMIN}sterge_produs.php?cat={$id_cat}&id_produs={$id_produs}')">
								{/if}
							</td>
						</tr>
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