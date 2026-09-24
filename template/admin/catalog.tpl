{include file="admin/top.tpl"}
{include file="admin/left.tpl"}
{strip}
<td valign="top" align="left" width="568">	
	<script src="{$URL_BASE}javascript/scriptaculous-js-1.7.0/lib/prototype.js" type="text/javascript"></script>	
	<script src="{$URL_BASE}javascript/EditInPlace.js" type="text/javascript"></script>
	<script type="text/javascript">
		Event.observe(window, 'load', init, false);
		var id_cat='{$id_cat}';
		{literal}
		function init() {			
			EditInPlace.makeEditable ({
				type: 'textarea',
				id: 'editare_categorie',
				save_url: 'server_edit_in_place.php?id_cat='+id_cat	
			});				
		{/literal}
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
	<table style="margin-left:6px;margin-right:6px;" cellpadding="0" cellspacing="0" width="557">
		<tr>
			<td>	
	{if $mesaj neq ""}	
		{include file="admin/mesaj.tpl" mesaj=$mesaj}	
	{/if}
	{*-------------------------------------------------------ACTIUNI SUBCATEGORIE SELECTATA-----------------------------------------*}	
	<table cellpadding="3" cellspacing="1" class="bg_spatiu" width="100%">
		<tr>
			<td colspan="4" class="menu_title">
				<h2>Actiuni pentru categoria: {if $edit eq "producatori"}PRODUCATORI{else}{if $nume_cat eq ""}ROOT{else}{$nume_cat|upper}{/if}{/if}</h2>
			</td>
		</tr>
		<tr>
			<td width="136">
			{if $edit eq "producatori"}
				<input type="button" value="ADAUGA PRODUCATOR" class="buton_cool" style="width:180px" onClick="window.location.href='{$URL_ADMIN}adauga_categorie.php?cat={$id_cat}&adauga=producator'">
			{else}
				<input type="button" value="ADAUGA SUBCAT" class="buton_cool" style="width:132px" onClick="window.location.href='{$URL_ADMIN}adauga_categorie.php?cat={$id_cat}'">
			{/if}	
			</td>
			<td width="136">
			{if $edit eq "producatori"}
				<input type="button" value="ORDONEAZA PRODUCATORI" class="buton_cool" style="width:180px" onClick="window.location.href='{$URL_ADMIN}ordoneaza_categorii.php?ordoneaza=producatori'">
			{else}
				<input type="button" value="ORDONEAZA SUBCAT" class="buton_cool" style="width:132px" onClick="window.location.href='{$URL_ADMIN}ordoneaza_categorii.php?id_parinte={$id_cat}'">
			{/if}	
			</td>
			<td width="136">
			{if $edit neq "categorii_principale" && $edit neq "producatori"}
				<input type="button" value="EDITEAZA SUBCAT" class="buton" style="width:132px" onClick="window.location.href='{$URL_ADMIN}editeaza_categorie.php?cat={$id_cat}'">
			{/if}	
			</td>
			<td width="136">
			{if $edit neq "categorii_principale" && $edit neq "producatori"}
				<input type="button" value="STERGE SUBCAT" class="buton_anuleaza" style="width:132px" 
					onClick="casutaConfirmare('Sunteti sigur ca doriti sa stergeti
											   <br />categoria <b>{$nume_cat}</b>?
											   <br /><br /><font class=eroare_text>Toate produsele din aceasta categorie vor fi sterse definitiv!</font>', '400',
											  '{$URL_ADMIN}sterge_categorie.php?cat={$id_cat}')">
			{/if}
			</td>
		</tr>
		{if $edit neq "categorii_principale" && $edit neq "producatori"}
		<tr>
			<td><input type="button" value="ADAUGA PRODUS" class="buton_cool" style="width:132px" onClick="window.location.href='{$URL_ADMIN}gestioneaza_produse.php?cat={$id_cat}'"></td>	
			<td><input type="button" value="FILTRE CATEGORIE" class="buton_cool" style="width:132px" onClick="window.location.href='{$URL_ADMIN}gestioneaza_filtre.php?cat={$id_cat}'"></td>
			<td><input type="button" value="ORDONEAZA FILTRE" class="buton_cool" style="width:132px" onClick="window.location.href='{$URL_ADMIN}ordoneaza_filtre.php?cat={$id_cat}'"></td>
			<td><input type="button" value="BANNERE CAT" class="buton_cool" style="width:132px" onClick="window.location.href='{$URL_ADMIN}gestioneaza_bannere_cat.php?cat={$id_cat}'"></td>			
		</tr>
		{/if}
	</table>
	{*--------------------------------------------------------------------END-------------------------------------------------------*}
	{*-----------------------------------------------------------INSTRUCTIUNI UTILIZARE---------------------------------------------*}
	<ul>
		{if $edit eq "producatori"} {*-PT EDITARE PRODUCATORI-*}
			<li>In aceasta pagina aveti posibilitatea de a adauga un producator(fabricant) nou sau de a sterge un producator existent.</li>
			<li>Producatori pot fi ordonati, dar nu si dezactivati ca in cazul categoriilor.</li>		
			<li>ATENTIE: Stergerea unui producator va duce scoaterea acelui producatori din toate produsele.</li>
		{else}						{*-PT EDITARE (SUB)CATEGORII-*}
			<li>In aceasta pagina aveti posibilitatea de a adauga o (sub)categorie noua, de a sterge categoria, de a adauga un produse nou sau de a defini filtre pentru categorie.</li>
			<li>Subcategoriile categoriei asociate pot fi sterse, ordonate, sau dezactivate.</li>		
			<li>ATENTIE: Dezactivarea unei categorii va duce si la dezactivarea subcategoriilor acesteia. Produsele din categoriile dezactivate nu vor mai fi afisate in site.</li>
			<li>ATENTIE: Stergerea unei categorii va duce la stergerea tuturor produselor care apartin de acea categorie.</li>
		{/if}
	</ul>
	<div class="bg_spatiu" style="padding:3px"><b>Editare rapida descriere categorie:</b></div>
	<div style="padding:3px;font-size:10px;border:1px solid #F2F2F2" id="editare_categorie">
		{$descriere_cat}
	</div>
	<br />
	{*--------------------------------------------------------------------END-------------------------------------------------------*}
	{if $edit eq "" && $nr_produse_cat > 0}
	{*------------------------------------------------------------FILTRE PRODUCATORI------------------------------------------------*}
	<form action="{$URL_ADMIN}catalog.php?cat={$id_cat}" method="POST">
	<table>
		<tr>
			<td>Producator:</td>
			<td>
				<select name="producator" class="select">
					<option value="0">--Oricare--</option>
					{html_options options=$toti_producatorii selected=$id_prod}
				</select>
			</td>
			<td>Ordonare:</td>
			<td>
				<select name="ordonare" class="select">					
					{html_options options=$combo_ordonari selected=$id_ordonare}
				</select>
			</td>
			<td>Cod produs:</td>
			<td><input type="text" name="cod_produs" value="{$cod_produs}" size="10"></td>
			<td><input type="submit" name="filtreaza" value="GO" class="buton"></td>
		</tr>
	</table>
	</form>
	{/if}
	{*--------------------------------------------------------------------END-------------------------------------------------------*}
	{*-----------------------------------------------------------------RADACINA-----------------------------------------------------*}
	{if $radacina neq ""}
	<table cellpadding="0" cellspacing="0" class="menu_container" style="background:url({$DIR_TEMPLATE}img/bg_menu.gif);border-top:1px solid #F2F2F2;border-left:1px solid #F2F2F2;border-right:1px solid #F2F2F2;">
		<tr>
			<td align="left" class="menu_title" height="18" style="padding-left:2px">
				<h2>
				Subcategorii in:
				{section name=sec loop=$radacina}
					&nbsp;
					<a href="{$radacina[sec].link_radacina}" title="{$radacina[sec].nume_radacina}" class="radacina">
						{$radacina[sec].nume_radacina}
					 </a>
					&nbsp;
					{if !$smarty.section.sec.last}
						&raquo;
					{/if}
				{/section}			
				</h2>			
			</td>
		</tr>
	</table>
	{/if}	
	{*---------------------------------------------------------------SUBCATEGORII--------------------------------------------------*}
	{if $catalog neq ""}
	<table cellpadding="5" cellspacing="0" class="box" width="557">	
		<tr>
			<td valign="top">								
				<table width="100%" cellpadding="0" cellspacing="0">
					{section name=tr loop=$catalog step=4}
						<tr>
							{section name=td start=$smarty.section.tr.index loop=$smarty.section.tr.index+4}	
							{if $catalog[td].nume_cat neq ""}					
							<td width="130" valign="top" align="center" class="box">
								{*-------------PRODUCATORII(FABRICANTII) NU POT FI DEZACTIVATI, DOAR (SUB)CATEGORIILE--------------*}
								{if $edit neq "producatori"}
								<table>
									<tr>										
										<td class="text_mic">Activa:</td>										
										<td>
											<input type="checkbox" id="{$catalog[td].id_cat}" 
												onClick="toggleCategoriiActivare('{$catalog[td].id_cat}')" {if $catalog[td].activ eq "1"}checked{/if}>
										</td>
									</tr>
								</table>
								{/if}
								{*--------------------------------------------------END--------------------------------------------*}
								<table>
									<tr>
										<td height="70">
											<a href="{$catalog[td].link_cat_admin}" title="{$catalog[td].nume_cat}" class="produse">
												<img src="{$catalog[td].poza_cat}?{$timestamp}" alt="{$catalog[td].nume_cat}">
											</a>	
										</td>
									</tr>
								</table>
								<div style="height:25px;display:table;position:relative;text-align:center;vertical-align:top">
									{if $edit eq "producatori"}
										{$catalog[td].nume_cat} {if $catalog[td].nr_produse neq ""}<font class="nr_produse">({$catalog[td].nr_produse})</font>{/if}
									{else}
										<a href="{$catalog[td].link_cat_admin}" title="{$catalog[td].nume_cat}" class="produse" style="font-size:10px">
											{$catalog[td].nume_cat} {if $catalog[td].nr_produse neq ""}<font class="nr_produse" style="font-size:10px">({$catalog[td].nr_produse})</font>{/if}
										</a>
									{/if}
								</div>
								<table>
									<tr>
										<td>
											<input type="button" value="EDITEAZA" class="buton" style="width:80px" 
												onClick="window.location.href='{$URL_ADMIN}editeaza_categorie.php?cat={$catalog[td].id_cat}'">
										</td>
									</tr>
									<tr>
										<td>
											<input type="button" value="STERGE" class="buton_anuleaza" style="width:80px" 
												onClick="casutaConfirmare('Sunteti sigur ca doriti sa stergeti
																		   <br />{if $edit eq "producatori"}producatorul{else}categoria{/if} <b>{$catalog[td].nume_cat}</b>?
																		  {if $edit neq "producatori"} <br /><br /><font class=eroare_text>Toate produsele din aceasta categorie vor fi sterse definitiv!</font>{/if}', '400',
																		  '{$URL_ADMIN}sterge_categorie.php?cat={$catalog[td].id_cat}')">
										</td>
									</tr>	
								</table>
							</td>
							{else}
							<td width="130"></td>
							{/if}														
							{/section}
						</tr>
						{if !$smarty.section.tr.last}
						<tr><td colspan="4" height="5"></td></tr>
						{/if}					
					{/section}
				</table>
			</td>
		</tr>
	</table>
	{else}		
		{if $nr_produse_cat eq 0}
			{include file="admin/mesaj.tpl" mesaj="Nu sunt subcategorii in aceasta categorie!"}	
			{include file="admin/mesaj.tpl" mesaj="Nu sunt produse in aceasta categorie!"}		
		{/if}
	{/if}
	{*--------------------------------------------------------------END SUBCATEGORII----------------------------------------------*}		
	{*--DACA NU SUNT PE EDITARE 'CATEGORII PRINCIPALE' SAU 'PRODUCATORI' SI AM PRODUSE IN CATEGORIE AFISEZ CATALOGUL DE PRODUSE---*}
	{if $edit eq "" && $nr_produse_cat > 0}
	{*------------------------------------------------------------------PAGINARE--------------------------------------------------*}	
	<table cellpadding="0" cellspacing="0" width="557">
		<tr>
			<td>
				{if $paginare neq ""}
					<table cellpadding="2" cellspacing="0" width="100%">
						<tr><td height="14" class="paginare_tabel" style="border-bottom: 1px solid #F4F4F4" align="right">&nbsp;{$paginare}&nbsp;</td></tr>
					</table>
				{/if}
			</td>			
		</tr>
	</table>
	<table cellpadding="0" cellspacing="0" width="557" class="tabel_produse" >	
		<tr><td height="1" class="tab_line"></td></tr>
		<tr><td height="5"></td></tr>
		<tr>
			<td valign="top">
				<table cellpadding="2" cellspacing="2" width="100%">
					{*-----------------------------------------------HEADER TABEL PRODUSE---------------------------------------*}
					<tr>
						<td class="header_tabel" width="110" align="center">Poza</td>						
						<td class="header_tabel" align="center">Produs</td>
						<td class="header_tabel" width="5"></td>
						<td class="header_tabel" width="80" align="center">Pret</td>
					</tr>
					{*---------------------------------------------END HEADER TABEL PRODUSE-------------------------------------*}
					<tr><td colspan="4" height="10"></td></tr>
					{*--------------------------------------------------AFISARE PRODUSE-----------------------------------------*}
					{section name=sec loop=$produse}
					<tr>	
						<td valign="top" align="center">											
							<table cellpadding="2" class="img">
								{*----------------------------------------POZA PRODUS-------------------------------------------*}
								<tr>
									<td width="90" height="90" align="center">
										<img src="{$produse[sec].adresa_poza_produs}?{$timestamp}" alt="" id="poza{$smarty.section.sec.index}"> 
									</td>
								</tr>
								{*--------------------------------------------END-----------------------------------------------*}
							</table>
							{if $produse[sec].poze_sec_mici neq ""}
							<table cellspacing="2" cellpadding="1">		
								{*----------------------------------------MINI GALERIE------------------------------------------*}															
								{section name=tr loop=$produse[sec].poze_sec_mici step=4}
								<tr>	
									{section name=td start=$smarty.section.tr.index loop=$smarty.section.tr.index+4}
									{if $produse[sec].poze_sec_mici[td] neq ""}
									<td class="box_poze_mici" onmouseover="this.className='box_poze_mici_hover'" onmouseout="this.className='box_poze_mici'">										
										<a href="#" onmouseover="$('poza{$smarty.section.sec.index}').src='{$produse[sec].poze_sec_medii[td]}'; return false;"
												    onClick="NewWindow('{$URL_BASE}galerie.php?id_produs={$produse[sec].id_produs}&amp;poza='+$('poza{$smarty.section.sec.index}').src, '', '800', '750', 'yes'); return false;">
											<img src="{$produse[sec].poze_sec_mici[td]}" alt="Schimba poza principala">
										</a>
									</td>
									{else}
									<td></td>
									{/if}
									{/section}																											
								</tr>						
								{/section}
								{*---------------------------------------------END----------------------------------------------*}
							</table>	
							{/if}
							<table>
								<tr>																												
									<td><input type="checkbox" id="{$produse[sec].id_produs}" {if $produse[sec].id_produs_newsletter neq ""}checked{/if} onClick="toggleProduseNewsletter('{$produse[sec].id_produs}')"></td>
									<td class="text_mic">In newsletter</td>	
								</tr>
							</table>													
						</td>			
						<td valign="top">
							<br />
							{*---------------------------------------------NUME PRODUS------------------------------------------*}
							{if $produse[sec].nume_produs neq ""}
								<a href="{$produse[sec].link_produs}" title="{$produse[sec].nume_produs}" class="{if $produse[sec].tip eq "1"}produse_speciale{else}produse{/if}">
									{if $produse[sec].producator neq ""}{$produse[sec].producator} - {/if}<b>{$produse[sec].nume_produs}</b>
								</a>								
							{/if}
							{*-------------------------------------------------END----------------------------------------------*}
							<table cellspacing="1" cellpadding="1" width="290">
								{*-------------------------------------CARACTERISTICI PRODUS------------------------------------*}
								{section name=subsec loop=$produse[sec].caracteristici}								
								<tr>
									<td width="5"></td>
									<td class="caracteristici" width="110"><img src="{$DIR_TEMPLATE}img/bullet.gif" alt=""> {$produse[sec].caracteristici[subsec].nume_carac}:</td>
									<td class="caracteristici" width="175">{$produse[sec].caracteristici[subsec].val_carac}</td>
								</tr>
								{/section}
								{*----------------------------------------------END---------------------------------------------*}
								{*------------------------------------------PRODUCATOR------------------------------------------*}
								<tr>
									<td width="5"></td>
									<td class="caracteristici"><img src="{$DIR_TEMPLATE}img/bullet.gif" alt=""> Producator:</td>
									<td class="caracteristici">{if $produse[sec].producator neq ""}{$produse[sec].producator}{else}fara producator{/if}</td>
								</tr>
								{*----------------------------------------------END---------------------------------------------*}
								{*------------------------------------------COD PRODUS------------------------------------------*}
								<tr>
									<td width="5"></td>
									<td class="caracteristici"><img src="{$DIR_TEMPLATE}img/bullet.gif" alt=""> Cod produs:</td>
									<td class="caracteristici"><b>{if $produse[sec].cod_produs eq ""}-{else}{$produse[sec].cod_produs}{/if}</b></td>
								</tr>
								{*----------------------------------------------END---------------------------------------------*}
								<tr><td colspan="3" height="1" class="bg_spatiu" style="padding:0px"></td></tr>
								{*--------------------------------------INFO SUPLIMENTARE---------------------------------------*}
								<tr>
									<td width="5"></td>
									<td colspan="2">
										<font class="text_mic">Ultima editare facuta de: <b>{$produse[sec].username}</b></font>
									</td>																		
								</tr>
								{*------------------------------------------END INFO--------------------------------------------*}	
								<tr><td colspan="3" height="1" class="bg_spatiu" style="padding:0px"></td></tr>
								{*---------------------------------------------END----------------------------------------------*}
							</table>
						</td>	
						<td width="5"></td>					
						<td align="center" valign="middle" class="pret">
							{*--------------------------------------------POZA PRODUCATOR---------------------------------------*}
							{if $produse[sec].adresa_poza_producator neq ""}
							<img src="{$produse[sec].adresa_poza_producator}" alt="{$produse[sec].producator}">
							{/if}
							{*-------------------------------------------------END----------------------------------------------*}
							{*-------------------------------------------------PRET---------------------------------------------*}
							<div style="margin-bottom:5px;margin-top:5px">
							Pret cu TVA <br />
							{if $produse[sec].pret_vechi neq ""}<font class="pret_vechi">{$produse[sec].pret_vechi} {$MONEDA}</font><br />{/if}
							<b><span id="editare_pret_{$produse[sec].id_produs}">{$produse[sec].pret_produs}</span> {$MONEDA}</b>	
							</div>
							{*---------------------------------------------------END--------------------------------------------*}	
							{*-----------------------------------------BUTOANE STERGERE/EDITARE---------------------------------*}
							<table>
								<tr>
									<td><input type="button" value="EDITEAZA" class="buton" style="width:80px" onClick="window.location.href='{$URL_ADMIN}gestioneaza_produse.php?cat={$id_cat}&id_produs={$produse[sec].id_produs}'"></td>
								</tr>	
								<tr>
								 	<td><input type="button" value="STERGE" class="buton_anuleaza" style="width:80px" 
										    onClick="casutaConfirmare('Sunteti sigur ca doriti sa stergeti produsul
												     				   <br /><b>{$produse[sec].nume_produs_js}</b>?
												     				   <br /><br /><font class=eroare_text>Produsul va fi sters definitiv!</font>', '400',
												     				  '{$URL_ADMIN}sterge_produs.php?cat={$id_cat}&id_produs={$produse[sec].id_produs}')"></td>
								</tr>	
							</table>														
							{*---------------------------------------------------END--------------------------------------------*}
						</td>
					</tr>
					{if !$smarty.section.sec.last}
					<tr><td colspan="4" height="2"></td></tr>
					<tr><td colspan="4" height="1" style="background-image:url({$DIR_TEMPLATE}img/dashed_line.gif);background-repeat:repeat-x;padding:0px"></td></tr>
					<tr><td colspan="4" height="2"></td></tr>
					{/if}
					{*----------------------------------------------------END AFISARE PRODUSE-----------------------------------*}
					{/section}		
				</table>	
										
			</td>
		</tr>
		<tr><td height="5"></td></tr>
		<tr><td height="1" class="tab_line"></td></tr>
	</table>
	<table cellpadding="0" cellspacing="0" width="557">
		<tr>
			<td>
				{if $paginare neq ""}
					<table cellpadding="2" cellspacing="0" width="100%">
						<tr><td height="14" class="paginare_tabel" style="border-bottom:1px solid #F4F4F4" align="right">&nbsp;{$paginare}&nbsp;</td></tr>
					</table>
				{/if}
			</td>			
		</tr>
	</table>			
	{/if} {*--END if $edit--*}
	<p align="center"><a href="javascript:history.go(-1)" class="link_default">&laquo; Inapoi</a></p>	
	<p align="right"><a href="#top"><img src="{$DIR_TEMPLATE}img/top.gif" alt="top"></a></p>
			</td>
		</tr>
	</table>
</td>
{/strip}
{include file="admin/right.tpl"}
{include file="admin/bottom.tpl"}