{include file="admin/top.tpl"}
{include file="admin/left.tpl"}
{strip}
<td valign="top" align="left" width="568">
	<script src="{$URL_BASE}javascript/scriptaculous-js-1.7.0/lib/prototype.js" type="text/javascript"></script>	
	<script type="text/javascript" src="{$URL_BASE}javascript/EditInPlace.js"></script>
	<script type="text/javascript">
		Event.observe(window, 'load', init, false);	
		function init() {literal}{{/literal}
		{section name=sec loop=$produse}
			EditInPlace.makeEditable({literal}{{/literal} 
				id: 'editare_pret_{$produse[sec].id_produs}', 				
				save_url: 'server_edit_in_place.php?id_produs={$produse[sec].id_produs}',
				size: '6'
			{literal}}{/literal});
		{/section}
		{literal}
			}
		{/literal}
	</script>
	<table style="margin-left:6px;margin-right:6px;width:557px;" cellpadding="0" cellspacing="0">
		<tr><td>
	{if $mesaj neq ""}	
		{include file="admin/mesaj.tpl" mesaj=$mesaj}	
	{/if}	
	{*-----------------------------------------------------------------------CAUTARE--------------------------------------------*}	
	<form action="" method="GET">
	<table cellpadding="3" cellspacing="1">
		<tr>
			<td class="menu_title" style="background:url({$DIR_TEMPLATE}img/bg_menu.gif);border-top:1px solid #F2F2F2;border-left:1px solid #F2F2F2;border-right:1px solid #F2F2F2;">
				Cautare
			</td>
		</tr>
	</table>
	<table>
		<tr>
			<td>Textul cautat: <input type="text" name="string" value="{$cautare_string_camp}" id="text_cautat2" maxlength="30"> <input type="submit" value="CAUTA" class="buton"></td>
		</tr>	
	</table>	
	</form>
	{*----------------------------------------------------------------INSTRUCTIUNI UTILIZARE------------------------------------*}
	<ul>
		<li>Cautarea se face in nume categorie, nume produs si in descrierea produsului.</li>
		<li>ATENTIE: Cautarea se face doar in categoriile active!</li>
	</ul>
	{*-------------------------------------------------------------------------END----------------------------------------------*}
	<div style="margin-top:10px">
		Rezultatele cautarii pentru "<b>{$cautare_string_camp}</b>":
	</div>
	{*---------------------------------------------------------------------END CAUTARE------------------------------------------*}
	{*-----------------------------------------------------------------------PAGINARE-------------------------------------------*}
	<table width="100%" cellpadding="0" cellspacing="0" style="margin-top:10px">
		<tr>
			<td width="120"><b>Afisare produse:</b></td>
			<td align="right">
				{if $paginare neq ""}
					<table cellpadding="2" cellspacing="0">
						<tr><td height="14" class="paginare_tabel" style="border-bottom: 1px solid #F4F4F4">&nbsp;{$paginare}&nbsp;</td></tr>
					</table>
				{/if}
			</td>			
		</tr>
	</table>
	{*-------------------------------------------------------------------END PAGINARE-------------------------------------------*}	
	<table cellpadding="0" cellspacing="0" class="tabel_produse" width="100%">	
		<tr><td height="1" class="tab_line"></td></tr>
		<tr><td height="5"></td></tr>
		<tr>
			<td valign="top">
				<table cellpadding="2" cellspacing="2" width="100%">
					{*-------------------------------------------------HEADER TABEL PRODUSE-------------------------------------*}
					<tr>
						<td class="header_tabel" width="110" align="center">Poza</td>						
						<td class="header_tabel" align="center">Produs</td>
						<td class="header_tabel" width="5"></td>
						<td class="header_tabel" width="80" align="center">Pret</td>
					</tr>
					{*-----------------------------------------------END HEADER TABEL PRODUSE-----------------------------------*}
					<tr><td colspan="4" height="10"></td></tr>
					{*---------------------------------------------------AFISARE PRODUSE----------------------------------------*}
					{section name=sec loop=$produse}
					<tr>	
						<td valign="top" align="center">	
							<a href="#" onClick="NewWindow('/galerie.php?id_prod={$produse[sec].id_produs}&amp;poza='+document.getElementById('poza{$smarty.section.sec.index}').src, '', '800', '750', 'yes'); return false;" class="mareste_poza">
								<img src="{$DIR_TEMPLATE}img/mareste_poza.gif" alt="Mareste poza"> Mareste poza
							</a>											
							<table cellpadding="2" class="img">
								{*----------------------------------------POZA PRODUS-------------------------------------------*}
								<tr>
									<td class="margine_poza"></td>
									<td width="90" height="90" align="center">
										<div class="productImg" id="product_{$produse[sec].id_produs}">
											<img src="{$produse[sec].adresa_poza_produs}" alt="Trage poza in cos pentru a cumpara produsul" id="poza{$smarty.section.sec.index}">
										</div>
									</td>
								</tr>
								{*--------------------------------------------END-----------------------------------------------*}
							</table>
							{if $produse[sec].poze_sec_mici neq ""}
							<table cellspacing="2" cellpadding="1">		
								{*---------------------------------------MINI GALERIE-------------------------------------------*}															
								{section name=tr loop=$produse[sec].poze_sec_mici step=4}
								<tr>	
									{section name=td start=$smarty.section.tr.index loop=$smarty.section.tr.index+4}
									{if $produse[sec].poze_sec_mici[td] neq ""}
									<td class="box_poze_mici" onmouseover="this.className='box_poze_mici_hover'" onmouseout="this.className='box_poze_mici'">
										<a href="#" onmouseover="document.getElementById('poza{$smarty.section.sec.index}').src='{$produse[sec].poze_sec_medii[td]}'; return false;"
													onClick="NewWindow('{$URL_BASE}galerie.php?id_produs={$produse[sec].id_produs}&amp;poza='+document.getElementById('poza{$smarty.section.sec.index}').src, '', '800', '750', 'yes'); return false;">
											<img src="{$produse[sec].poze_sec_mici[td]}" alt="Schimba poza principala">
										</a>
									</td>
									{else}
									<td></td>
									{/if}
									{/section}																											
								</tr>						
								{/section}
								{*--------------------------------------------END-----------------------------------------------*}
							</table>	
							{/if}	
							<table>
								<tr>																												
									<td>
										<input type="checkbox" id="{$produse[sec].id_produs}" {if $produse[sec].id_produs_newsletter neq ""}checked{/if} onClick="toggleProduseNewsletter('{$produse[sec].id_produs}')">
									</td>
									<td class="text_mic">In newsletter</td>	
								</tr>
							</table>												
						</td>			
						<td valign="top">							
							{*--------------------------------------------NUME PRODUS-------------------------------------------*}
							{if $produse[sec].nume_produs neq ""}
								<a href="{$produse[sec].link_produs}" class="{if $produse[sec].tip eq "1"}produse_speciale{else}produse{/if}">
									{if $produse[sec].producator neq ""}{$produse[sec].producator} - {/if}<b>{$produse[sec].nume_produs}</b>
								</a>								
							{/if}
							{*------------------------------------------------END-----------------------------------------------*}
							<table cellspacing="1" cellpadding="1">
								{*-------------------------------------CARACTERISTICI PRODUS------------------------------------*}
								{section name=subsec loop=$produse[sec].caracteristici}								
								<tr>
									<td width="5"></td>
									<td class="caracteristici" width="130"><img src="{$DIR_TEMPLATE}img/bullet.gif" alt=""> {$produse[sec].caracteristici[subsec].nume_carac}:</td>
									<td class="caracteristici">{$produse[sec].caracteristici[subsec].val_carac}</td>
								</tr>
								{/section}
								{*--------------------------------------------END-----------------------------------------------*}
								{*----------------------------------------PRODUCATOR--------------------------------------------*}
								<tr>
									<td width="5"></td>
									<td class="caracteristici" width="130"><img src="{$DIR_TEMPLATE}img/bullet.gif" alt=""> Producator:</td>
									<td class="caracteristici">{$produse[sec].producator}</td>
								</tr>
								{*--------------------------------------------END-----------------------------------------------*}
								{*------------------------------------------COD PRODUS------------------------------------------*}
								<tr>
									<td width="5"></td>
									<td class="caracteristici" width="130"><img src="{$DIR_TEMPLATE}img/bullet.gif" alt=""> Cod produs:</td>
									<td class="caracteristici"><b>{if $produse[sec].cod_produs eq ""}-{else}{$produse[sec].cod_produs}{/if}</b></td>
								</tr>
								{*----------------------------------------------END---------------------------------------------*}
								{*----------------------------------------STOC PRODUS-------------------------------------------*}
								<tr>
									<td width="5"></td>
									<td class="caracteristici" width="130"><img src="{$DIR_TEMPLATE}img/bullet.gif" alt=""> Stoc:</td>
									<td class="caracteristici">
										<select class="select" style="width:140px" onChange="setStoc('{$produse[sec].id_produs}', this.value)">
											{html_options options=$stocuri selected=$produse[sec].id_stoc}
										</select>
									</td>
								</tr>
								{*--------------------------------------------END-----------------------------------------------*}
								<tr><td colspan="3" height="3"></td></tr>
								<tr>
									<td width="5"></td>
									<td align="left" colspan="2">
										<table width="100%" cellpadding="0" cellspacing="1">
											<tr>
												<td class="caracteristici"><b>Rating:</b></td>
												<td>
													{repeat count=$produse[sec].rating[1]}<img src="{$DIR_TEMPLATE}img/flower.gif" alt="">{/repeat}
													{repeat count=$produse[sec].rating[2]}<img src="{$DIR_TEMPLATE}img/flower_gri.gif" alt="">{/repeat}
												</td>
												<td class="caracteristici">&nbsp;[{$produse[sec].nr_comentarii}] voturi</td>
											</tr>											
										</table>		
									</td>
								</tr>
								<tr><td colspan="3" height="1" class="bg_spatiu" style="padding:0px"></td></tr>
								{*-------------------------------------INFO SUPLIMENTARE----------------------------------------*}
								<tr>
									<td width="5"></td>
									<td colspan="2">
										<img src="{$DIR_TEMPLATE}img/stoc/{$produse[sec].id_stoc}.gif" alt="{$produse[sec].stoc}">&nbsp;										
										{if $produse[sec].nr_comentarii gt "0"}<img src="{$DIR_TEMPLATE}img/reviews.gif" alt="Review-uri disponibile">&nbsp;{/if} 
										{if $produse[sec].tip eq "1"}<img src="{$DIR_TEMPLATE}img/oferta_speciala.gif" alt="Oferta speciala">&nbsp;{/if}
										{if $produse[sec].pret_vechi neq ""}<img src="{$DIR_TEMPLATE}img/reducere_pret.gif" alt="Reducere pret">{/if}
									</td>																		
								</tr>
								{*-----------------------------------------END INFO---------------------------------------------*}	
								<tr><td colspan="3" height="1" class="bg_spatiu" style="padding:0px"></td></tr>
								{*------------------------------------STATISTICI, CAT SEC---------------------------------------*}
								<tr>	
									<td colspan="3" class="caracteristici">																			
										{section name=rad loop=$produse[sec].radacina_produs}
											<a href="{$produse[sec].radacina_produs[rad].link_cat}" class="link_default_mic">
												{$produse[sec].radacina_produs[rad].nume_cat}
											</a>
											{if !$smarty.section.rad.last} &raquo; {/if}
										{/section}
										<br />
										<a href="{$URL_ADMIN}statistici_vanzari_pe_produs.php?id_produs={$produse[sec].id_produs}" class="link_default_mic">
										 	<img src="{$DIR_TEMPLATE}img_admin/statistici_vanzari_produs.gif" alt=""> Statistici vanzari produs
										</a>
										{if $CAT_SECUNDARE eq 1}
										&nbsp;- <a href="{$URL_ADMIN}asociatii_produse.php?id_produs={$produse[sec].id_produs}" class="link_default_mic" title="Editeaza categorii secundare">Editeaza categorii secundare</a>	
										{/if}
									</td>									
								</tr>
								{*--------------------------------------------END-----------------------------------------------*}
								<tr><td colspan="3" height="1" class="bg_spatiu" style="padding:0px"></td></tr>
								{*-----------------------------------CATEGORII SECUNDARE----------------------------------------*}
								{if $CAT_SECUNDARE eq 1}
								<tr>
									<td colspan="3" class="text_mic" style="color:#C15DCD">
										<b>Categorii secundare:</b>&nbsp;
										{section name=s loop=$produse[sec].cat_sec}
											{$produse[sec].cat_sec[s].nume_cat_sec}
											{if !$smarty.section.s.last}, {/if}
										{sectionelse}
											-	
										{/section}
									</td>
								</tr>	
								{/if}
								{*--------------------------------------------END-----------------------------------------------*}
							</table>
						</td>	
						<td width="10"></td>					
						<td align="center" valign="middle" class="pret">
							{if $produse[sec].adresa_poza_producator neq ""}
								<img src="{$produse[sec].adresa_poza_producator}" alt="{$produse[sec].nume_producator}">
							{/if}	
							{*------------------------------------------------PRET----------------------------------------------*}
							<div style="margin-bottom:5px;margin-top:5px">
							Pret cu TVA <br />
							{if $produse[sec].pret_vechi neq ""}<font class="pret_vechi">{$produse[sec].pret_vechi} {$MONEDA}</font><br />{/if}
							<div class="pret"><b><span id="editare_pret_{$produse[sec].id_produs}">{$produse[sec].pret_produs}</span> {$MONEDA}</b></div>		
							</div>
							{*-------------------------------------------------END----------------------------------------------*}	
							{*---------------------------------------BUTOANE STERGERE/EDITARE-----------------------------------*}
							<table>
								<tr>
									<td><input type="button" value="EDITEAZA" class="buton" style="width:80px" onClick="window.location.href='{$URL_ADMIN}gestioneaza_produse.php?string={$cautare_string}&id_produs={$produse[sec].id_produs}'"></td>
								</tr>	
								<tr>
								 	<td><input type="button" value="STERGE" class="buton_anuleaza" style="width:80px" 
										    onClick="casutaConfirmare('Sunteti sigur ca doriti sa stergeti produsul
												     				   <br /><b>{$produse[sec].nume_produs_js}</b>?
												     				   <br /><br /><font class=eroare_text>Produsul va fi sters definitiv!</font>', '400',
												     				  '{$URL_ADMIN}sterge_produs.php?string={$cautare_string}&id_produs={$produse[sec].id_produs}')"></td>
								</tr>	
							</table>													
							{*---------------------------------------------------END---------------------------------------------*}
						</td>
					</tr>
					{if !$smarty.section.sec.last}
					<tr><td colspan="4" height="2"></td></tr>
					<tr><td colspan="4" height="1" style="background-image:url({$DIR_TEMPLATE}img/dashed_line.gif);background-repeat:repeat-x;padding:0px;"></td></tr>
					<tr><td colspan="4" height="2"></td></tr>
					{/if}
					{*----------------------------------------------------END AFISARE PRODUSE------------------------------------*}
					{/section}		
				</table>		
				{if $smarty.section.sec.last eq ""}<center>Nu sunt produse in aceasta sectiune!<br /><br /></center>{/if}			
			</td>
		</tr>
		<tr><td height="5"></td></tr>
		<tr><td height="1" class="tab_line"></td></tr>
	</table>
	{*--------------------------------------------------------------------------PAGINARE----------------------------------------*}
	<table width="100%" cellpadding="0" cellspacing="0">
		<tr>
			<td width="120"></td>
			<td align="right">
				{if $paginare neq ""}<table cellpadding="2" cellspacing="0"><tr><td height="14" class="paginare_tabel" style="border-bottom: 1px solid #F4F4F4">&nbsp;{$paginare}&nbsp;</td></tr></table>{/if}
			</td>			
		</tr>
	</table>
	{*-------------------------------------------------------------------------END PAGINARE-------------------------------------*}
	<br />	
	<p align="center"><a href="{$link_inapoi}" class="link_default">&laquo; Inapoi</a></p>	
	<p align="right"><a href="#top"><img src="{$DIR_TEMPLATE}img/top.gif" alt="top"></a> &nbsp;</p>
	
			</td>
		</tr>
	</table>
</td>
{/strip}
{include file="admin/right.tpl"}
{include file="admin/bottom.tpl"}