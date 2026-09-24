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
	{*-------------------------------------------------------------GESTIONEAZA FILTRE----------------------------------------------*}
	<table cellpadding="0" cellspacing="0" class="menu_container" style="background:url({$DIR_TEMPLATE}img/bg_menu.gif);border-top:1px solid #F2F2F2;border-left:1px solid #F2F2F2;border-right:1px solid #F2F2F2;">
		<tr>
			<td align="left" class="menu_title" height="18" style="padding-left:2px;padding-right:2px">
				<h2>Gestioneaza filtre pentru categoria <font class="titlu_cat">{$nume_cat|upper}</font></h2>			
			</td>
		</tr>
	</table>			
	<table cellpadding="5" cellspacing="0" class="box" width="557">	
		<tr>
		{*-------------------------------------------------------INSTRUCTIUNI UTILIZARE--------------------------------------------*}
			<td>		
				<ul>
					<li>
						In aceasta pagina aveti posibilitatea de seta caracteristicile unei categorii. 
						Toate produsele care vor fi adaugate in aceasta categorie vor avea caracteristicile categoriei.
					</li>					
					<li>Caracteristicile pot fi definite si ca filtre.</li>		
					<li>ATENTIE: O carac. definita doar pe categoria curenta nu si pe subcategoriile ei!</li>
					<li>ATENTIE: In momentul cand se modifica/sterge valoarea unei caracteristici, modificarea va afecta toate produsele care o folosesc!</li>					
					<li>ATENTIE: Nu afisati mai mult de 3-4 filtre pe o categorie, deoarece nu vor avea loc la afisare!</li>					
				</ul>	
			</td>				
		</tr>
		{*----------------------------------------------------------------END------------------------------------------------------*}
		{*----------------------------------------------------------FORMULAR FILTRE------------------------------------------------*}
		<tr>
			<td>
				{*---------------------------------------------------ADAUGA FILTRU-------------------------------------------------*}
				<form action="{$URL_ADMIN}gestioneaza_filtre.php?cat={$id_cat}" method="POST">
				<table cellpadding="1" cellspacing="1" width="100%">
					<tr>
						<td colspan="2" height="20">
						<table width="100%" cellpadding="0" cellspacing="0">
							<tr>
								<td><b>Adauga caracteristica(filtru) noua/nou</b></td>
								<td align="right"><a href="{$link_inapoi}" class="link_default">&laquo; Inapoi</a></td>
							</tr>
						</table>	
						</td>						
					</tr>
					<tr><td colspan="2" height="1"></td></tr>										
					<tr>								
						<td colspan="2">								
							Caracteristica: <input type="text" name="nume_filtru_nou" value="{$nume_filtru_nou}" size="30"> - <input name="este_filtru" type="checkbox" {if $este_filtru eq "1"}checked{/if} style="margin:0px;padding:0px"> este filtru
						</td>
					</tr>					
					{section name=sec loop=$valori}
					<tr>
						<td width="85"></td>
						<td>Valoare: <input type="text" name="valori[]" value="{$valori[sec]}" size="30"></td>
					</tr>
					{/section}
					{if $smarty.section.sec.total eq 0}
					<tr>
						<td width="85"></td>
						<td>Valoare: <input type="text" name="valori[]" value="{$valori[sec]}" size="30"></td>
					</tr>
					{/if}
					<tr>
						<td width="85">&nbsp;</td>
						<td width="450" align="left">							
							<input type="submit" name="increment" value="+" class="buton_simplu" style="width:20px"> <input type="submit" name="decrement" value="-" class="buton_simplu" style="width:20px">
						</td>
					</tr>
					<tr><td colspan="2" height="1"></td></tr>
					<tr>						
						<td colspan="3" align="center" class="bg_spatiu">
							<input type="submit" name="adauga_filtru_nou" value="ADAUGA" class="buton_cool" style="width:100px">							
						</td>
					</tr>
					<tr><td colspan="2" height="2"><input type="hidden" name="id_filtru" value=""></td></tr>											
				</table>
				</form>
				{*---------------------------------------------------------END-----------------------------------------------------*}
				{*-----------------------------------------------EDITEAZA FILTRE EXISTENTE-----------------------------------------*}
				<table cellpadding="1" cellspacing="1" width="100%">
					<tr><td height="20"><b>Caracteristici(filtre)</b> - <font class="eroare_text">(valorile pot doar fi litere, numere, spatii, paranteze rotunde, punct, virgula si doua puncte)</font></td></tr>
				</table>	
				{section name=sec loop=$filtre}
					<form action="{$URL_ADMIN}gestioneaza_filtre.php?cat={$id_cat}" method="POST" id="formular_{$filtre[sec].id_filtru}" name="formular_{$filtre[sec].id_filtru}">
					<table cellpadding="1" cellspacing="1" width="100%">
						<tr><td colspan="2" height="1"></td></tr>	
						<tr>								
							<td colspan="2">						
								<table cellpadding="0" cellspacing="0">
									<tr>
										<td>Caracteristica: <input type="text" name="nume_filtru" value="{$filtre[sec].nume_filtru}" size="30"> - <input name="este_filtru" type="checkbox" {if $filtre[sec].afiseaza_filtru eq "1"}checked{/if} style="padding:0px;margin:0px"> este filtru</td>
										<td width="10"></td>
										<td align="right"><input type="submit" name="modifica" value="MODIFICA" class="buton_simplu"></td>
									</tr>	
								</table>
							</td>
						</tr>
						{section name=subsec loop=$filtre[sec].valori_posibile}
						<tr>
							<td width="85"></td>
							<td>
								Valoare: <input type="text" name="valori_posibile[]" value="{$filtre[sec].valori_posibile[subsec]}" size="30">&nbsp;
								<a href="#" onClick="submitForm('{$URL_ADMIN}gestioneaza_filtre.php?cat={$id_cat}&id_val={$smarty.section.subsec.index}&id_filtru={$filtre[sec].id_filtru}&actiune=modifica', 'formular_{$filtre[sec].id_filtru}')" class="link_default">modifica valoare</a> -&nbsp;
								<a href="{$URL_ADMIN}gestioneaza_filtre.php?cat={$id_cat}&id_val={$smarty.section.subsec.index}&id_filtru={$filtre[sec].id_filtru}&actiune=sterge" class="link_cool">sterge valoare</a>																											
							</td>
						</tr>
						{/section}
						<tr>
							<td></td>
							<td>
								<div id="{$filtre[sec].id_filtru}">
									<a href="#" class="link_default" title="Adauga valoare noua" onclick="addValoareFiltru('{$filtre[sec].id_filtru}'); return false;">
										<b>[+] ADAUGA VALOARE NOUA</b>
									</a>
								</div>
							</td>
						</tr>
						<tr><td colspan="2" height="2"></td></tr>
						<tr>						
							<td colspan="3" align="center" class="bg_spatiu">
								<input type="submit" name="salveaza" value="SALVEAZA" class="buton_cool" style="width:100px">
								&nbsp;
								<input type="submit" name="sterge" value="STERGE" class="buton_anuleaza" style="width:100px">
							</td>
						</tr>
						<tr><td colspan="2" height="2"><input type="hidden" name="id_filtru" value="{$filtre[sec].id_filtru}"></td></tr>
						<tr><td colspan="2"></td></tr>						
					</table>
					</form>
				{/section}
			</td>			
		</tr>		
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