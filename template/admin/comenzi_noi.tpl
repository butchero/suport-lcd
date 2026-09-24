{include file="admin/top.tpl"}
{include file="admin/left.tpl"}
{strip}
<td valign="top" align="left" width="568">	
	<script type="text/javascript" src="{$URL_BASE}javascript/calendar_js/calendarDateInput.js"></script>
	<script type="text/javascript" src="{$URL_BASE}javascript/prototype.js"></script>	
	<table style="margin-left:6px;margin-right:6px;" cellpadding="0" cellspacing="0" width="557">
		<tr>
			<td class="box">
	{*-------------------------------------------------------------------MESAJE----------------------------------------------------*}
	{if $mesaj neq ""}
		{include file="admin/mesaj.tpl" mesaj=$mesaj}
	{/if}
	{*---------------------------------------------------------------------END-----------------------------------------------------*}
	<table cellpadding="3" cellspacing="1">
		<tr>
			<td class="menu_title" style="background:url({$DIR_TEMPLATE}img/bg_menu.gif);border-top:1px solid #F2F2F2;border-left:1px solid #F2F2F2;border-right:1px solid #F2F2F2">
				<h2>Gestioneaza <font class="titlu_cat">COMENZI NOI</font> {$status}</h2>
			</td>
		</tr>
	</table>
	{*-----------------------------------------------------------INSTRUCTIUNI UTILIZARE---------------------------------------------*}
	<ul>
		<li>In aceasta sectiune aveti posibilitatea de a procesa, onora sau anula comenzi.</li>
		<li>Toate comenzile noi sunt in stadiul de "asteapta procesare".</li>
		<li>In momentul cand o comanda este setata "in procesare" clientul este informat ca s-a luat cunostinta de comanda lui.</li>
		<li>Fiecare comanda facuta are asociata o factura proforma in format "pdf" pe care o puteti descarca apasand pe pictograma <img src="{$DIR_TEMPLATE}img/doc.gif" alt="">.</li>
		<li>Pentru a vizualiza fisierele in format "pdf" trebuie sa aveti Acrobat Reader instalat.</li>
		<li>ATENTIE: O comanda onorata nu mai poate fi anulata!</li>
		<li>ATENTIE: In momentul cand se foloseste "merge", comentariile si adresa de livrare a comenzii cu care se face merge se pierd.</li>
	</ul>
	{*--------------------------------------------------------------------END------------------------------------------------------*}
	<center>
	<form action="{$URL_ADMIN}comenzi_noi.php{if $status neq ""}?stare={$status}{/if}" method="POST">
		<table cellpadding="2" class="bg_spatiu" style="margin-top:5px;margin-bottom:5px">
			<tr>
				<td align="left"><b>Nume:</b></td>
				<td align="left"><input type="text" name="nume" value="{$nume}"></td>	
				<td align="left"><b>Prenume:</b></td>
				<td align="left"><input type="text" name="prenume" value="{$prenume}"></td>
			</tr>	
			<tr>
				<td align="left"><b>Societate:</b></td>
				<td align="left"><input type="text" name="societate" value="{$societate}"></td>
				<td align="left"><b>Username:</b></td>
				<td align="left"><input type="text" name="user_client" value="{$user_client}"></td>
			</tr>
			</tr>	
				<td align="left"><b>Judet:</b></td>
				<td align="left">
					<select name="judet" class="select" style="width:118px">
						<option value="">--Alege--</option>
						{html_options options=$judete selected=$judet}
					</select>
				</td>
				<td align="left"><b>Tip factura:</b></td>
				<td align="left">
					<select name="tip_factura" class="select" style="width:118px">
						<option value="" {if $tip_factura eq ""}selected{/if}>--Alege--</option>
						<option value="0" {if $tip_factura eq "0"}selected{/if}>Pers. fizica</option>
						<option value="1" {if $tip_factura eq "1"}selected{/if}>Pers. juridica</option>
					</select>
				</td>
			</tr>
			<tr>
				<td align="left"><b>Perioada:</b></td>
				<td align="left" colspan="3">
					<table cellpadding="0" cellspacing="0">
		   	   			<tr>
		   	   				<td><script>DateInput('de_la', true, 'YYYYMMDD', '{$de_la}')</script></td>
		   	    			<td width="24" align="center">-</td>
		   	    			<td><script>DateInput('pana_la', true, 'YYYYMMDD', '{$pana_la}')</script></td>
		   	    		</tr>	
		   	    	</table>
		   	    </td> 
			</tr>
			<tr>
				<td></td>
				<td align="left"><input type="submit" name="cauta" value="CAUTA" class="buton_cool"></td>
				<td colspan="2" align="right" style="padding-right:5px"><input type="checkbox" name="astazi" style="padding:0px;margin:0px"> <b>ASTAZI</b></td>
			</tr>	
		</table>
	</form>		
	</center>	
	<table style="margin-top:10px">
		<tr>
			<td><b>Comenzi noi {$status} <span class="eroare_text">({$nr_rezultate})</span> in valoare de <span class="eroare_text">{$total_cumparaturi}</span> {$MONEDA}:</b> {if $nr_comenzi_fara_transport neq ""}<br />&nbsp; din care cu transport gratuit <span class="eroare_text">({$nr_comenzi_fara_transport})</span> si cu transport platit <span class="eroare_text">({$nr_comenzi_cu_transport})</span>{/if}</td>
		</tr>
		<tr>
			<td>	
				<table cellpadding="0" cellspacing="0" width="100%">
					{if $comenzi neq ""}
					<tr>
						<td colspan="4" align="right" style="padding:2px;background-color:#DEF2FF;border-top:1px solid #F2F2F2;border-bottom:1px solid #F2F2F2">
							{$paginare}
						</td>
					</tr>
					<tr><td colspan="4" height="10"></td></tr>
					{section name=sec loop=$comenzi}					
					<tr>
						<td width="20" align="center" height="18"><a href="{$comenzi[sec].proforma}" target="_blank"><img src="{$DIR_TEMPLATE}img/doc.gif" alt="Click pentru a descarca proforma"></a></td>
						<td width="70">ID: <b>{$comenzi[sec].id_comanda}</b></td>	
						<td width="290"><div id="comanda_status_{$comenzi[sec].id_comanda}">Status: [<b>{$comenzi[sec].stare_comanda}</b>]</div></td>								
						<td width="170">Data: <b>{$comenzi[sec].data_comenzii}</b></td>
					</tr>	
					{if $comenzi[sec].stare neq 0}
					<tr>
						<td colspan="4">
						<table cellpadding="0" cellspacing="0" class="box" style="background-color:#FAFAFA;border-top:3px solid #FAF4DA" width="100%">
							<tr>
								<td valign="top" width="50%">
									<table>
										<tr>
											<td class="text_mic_default" valign="top" width="100">Username:</td>
											<td class="text_mic" align="left"><b>{$comenzi[sec].date_client.username}</b></td>
										</tr>
										<tr>
											<td class="text_mic_default" valign="top">Nume:</td>
											<td class="text_mic" align="left"><b>{$comenzi[sec].date_client.nume}</b></td>
										</tr>
										<tr>
											<td class="text_mic_default" valign="top">CNP:</td>
											<td class="text_mic" align="left"><b>{$comenzi[sec].date_client.cnp}</b></td>
										</tr>
										<tr>
											<td class="text_mic_default" valign="top">Societate:</td>
											<td class="text_mic" align="left"><b>{$comenzi[sec].date_client.societate}</b></td>
										</tr>
										<tr>
											<td class="text_mic_default" valign="top">Nr. Reg. Comert:</td>
											<td class="text_mic" align="left"><b>{$comenzi[sec].date_client.nr_reg_comert}</b></td>
										</tr>
										<tr>
											<td class="text_mic_default" valign="top">Banca:</td>
											<td class="text_mic" align="left"><b>{$comenzi[sec].date_client.banca}</b></td>
										</tr>
										<tr>
											<td class="text_mic_default" valign="top">Cod IBAN:</td>
											<td class="text_mic" align="left"><b>{$comenzi[sec].date_client.cod_iban}</b></td>
										</tr>
										<tr>
											<td class="text_mic_default" valign="top">CF:</td>
											<td class="text_mic" align="left"><b>{$comenzi[sec].date_client.cod_fiscal}</b></td>
										</tr>
									 </table>
								 </td>
								 <td width="20"></td>	 
								 <td valign="top" width="50%">
								 	 <table>
										<tr>
											<td class="text_mic_default" valign="top" width="80">Adresa:</td>
											<td class="text_mic" align="left"><b>{$comenzi[sec].date_client.adresa}</b></td>
										</tr>
										<tr>
											<td class="text_mic_default" valign="top">Cod postal:</td>
											<td class="text_mic" align="left"><b>{$comenzi[sec].date_client.cod_postal}</b></td>
										</tr>
										<tr>
											<td class="text_mic_default" valign="top">Loc/Jud:</td>
											<td class="text_mic" align="left"><b>{$comenzi[sec].date_client.localitate}/{$comenzi[sec].date_client.judet}</b></td>
										</tr>
										<tr>
											<td class="text_mic_default" valign="top">Telefon:</td>
											<td class="text_mic" align="left"><b>{$comenzi[sec].date_client.telefon}</b></td>
										</tr>
										<tr>
											<td class="text_mic_default" valign="top">Mobil:</td>
											<td class="text_mic" align="left"><b>{$comenzi[sec].date_client.telefon_mobil}</b></td>
										</tr>								
										<tr>
											<td class="text_mic_default" valign="top">Email:</td>
											<td class="text_mic" align="left"><a href="mailto:{$comenzi[sec].date_client.email}" class='link_default_mic'>{$comenzi[sec].date_client.email}</a></td>
										</tr>
										<tr>
											<td class="text_mic_default" valign="top">Tip fact.:</td>
											<td class="eroare_text_mic" align="left"><b>{$comenzi[sec].date_client.tip_factura}</b></td>
										</tr>
										{if $comenzi[sec].date_client.alta_adresa neq ""}
										<tr>
											<td class="text_mic_default" valign="top">Alta adresa de livrare</td>
											<td></td>
										</tr>	
										<tr><td colspan="2" class="text_mic" align="left" style="padding-left:15px">{$comenzi[sec].date_client.alta_adresa}</td></tr>						
										{/if}
										<tr>
											<td class="text_mic_default" valign="top" colspan="2">
												Comenzi noi: <a href="{$URL_ADMIN}comenzi_noi.php?user_client={$comenzi[sec].date_client.username}&cauta" class="link_default_mic">{$comenzi[sec].date_client.nr_comenzi_noi}</a>
											 	&nbsp;- onorate:  <a href="{$URL_ADMIN}comenzi.php?stare=onorate&user_client={$comenzi[sec].date_client.username}&cauta" class="link_default_mic">{$comenzi[sec].date_client.nr_comenzi_onorate}</a>
											 	&nbsp;- anulate:  <a href="{$URL_ADMIN}comenzi.php?stare=anulate&user_client={$comenzi[sec].date_client.username}&cauta" class="link_default_mic">{$comenzi[sec].date_client.nr_comenzi_anulate}</a>
											</td>
										</tr>
									 </table>
								 </td>
							</tr>
							{if $comenzi[sec].date_client.comentariu_comanda neq ""}
							<tr><td colspan="3" height="1" bgcolor="#F6F6F6"></td></tr>
							<tr>
								<td colspan="3" class="text_mic_default" align="left" style="padding:3px"><b>Comentariu comanda:</b> {$comenzi[sec].date_client.comentariu_comanda}</td>
							</tr>
							{/if}
						</table>
						</td>
					</tr>		
					{/if}		
					<tr>
						<td colspan="4">
							<a name="label{$comenzi[sec].id_comanda}"></a>
							<table cellpadding="3" cellspacing="1" width="100%" style="margin-bottom:20px">
								<tr bgcolor="#EFEFEF">
									<td align="center"><a href="{$URL_ADMIN}editeaza_comanda_noua.php?id_comanda={$comenzi[sec].id_comanda}&stare={$status}&pag={$pag}" class="link_default_mic" title="Editeaza produse/cantitati din comanda" style="color:red">(edit)</a></td>
									<td class="titlu" width="250"><b>Nume produs</b></td>
									<td class="titlu" width="50"><b>Cantitate</b></td>
									<td class="titlu" width="110" align="center"><b>Pret unitar<br />({$MONEDA} {if $TVA neq 1}fara{else}cu{/if} TVA)</b></td>
									<td class="titlu" width="110" align="center"><b>Pret total<br />({$MONEDA} cu TVA)</b></td>
								</tr>
								{section name=subsec loop=$comenzi[sec].produse}
								<tr>
									<td>										
										<a href="{$comenzi[sec].produse[subsec].link_produs}" target="_new">
											<img src="{$comenzi[sec].produse[subsec].poza_produs}" alt="{$cosuri[sec].produse[subsec].nume_produs}">
										</a>
									</td>
									<td>										
										{if $comenzi[sec].produse[subsec].nume_produs eq ""}
											<font class="eroare_text"><b>produs sters</b></font>
										{else}	
											<a href="{$comenzi[sec].produse[subsec].link_produs}" target="_new" title="Vezi produs" style="text-decoration:none">
												{$comenzi[sec].produse[subsec].nume_produs}
											</a>
										{/if}
										{if $comenzi[sec].produse[subsec].cod_produs neq ""}&nbsp;- <b>{$comenzi[sec].produse[subsec].cod_produs}</b>{/if}
									</td>
									<td align="center">{$comenzi[sec].produse[subsec].cantitate}</td>
									<td align="right">{$comenzi[sec].produse[subsec].pret_unitar} &nbsp;</td>
									<td align="right">{$comenzi[sec].produse[subsec].pret_total} &nbsp;</td>
								</tr>											
								{/section}	
								<tr>
									<td></td>
									<td colspan="4">{$comenzi[sec].transport}</td>
								</tr>
								<tr>
									<td colspan="5" class="bg_spatiu">
									<span class="text_mic_default">
										ID Comanda: <input type="text" name="id_comanda_merge" id="merge_{$comenzi[sec].id_comanda}" size="4">&nbsp;
										<input type="button" value="MERGE" class="buton_cool" onClick="location.href='{$URL_ADMIN}comenzi_noi.php?pag={$pag}&id_comanda={$comenzi[sec].id_comanda}{if $status neq ""}&stare={$status}{/if}&id_comanda_merge='+document.getElementById('merge_{$comenzi[sec].id_comanda}').value">&nbsp;
										(uneste 2 comenzi trimise de acelasi cumparator)
									</span>	
									</td>
								</tr>
								{if $comenzi[sec].nota_admin}
								<tr>
									<td colspan="5" class="text_mic">
										<b>Nota admin:</b> {$comenzi[sec].nota_admin}
									</td>
								</tr>
								{/if}
								{if $comenzi[sec].stare eq 0}
								<tr>
									<td colspan="5" height="10" align="right">
										<div id="comanda_{$comenzi[sec].id_comanda}">
											<input type="button" value="DETALII CUMPARATOR" class="buton" onClick="getInfoComanda({$comenzi[sec].id_comanda})" style="width:150px">
										</div>
									</td>
								</tr>
								{/if}
								<tr>
									<td colspan="5" style="padding:2px;background-color:#FAF4DA">
										<span class="text_mic_default">Metoda plata: <b>{$comenzi[sec].metoda_plata}</b>
										{if $comenzi[sec].metoda_plata neq "ramburs"}
											&nbsp;-&nbsp; Achitata: <span class="eroare_text"><b>{$comenzi[sec].achitata}</span></b>
										{/if}
										</span>
									</td>
								</tr>
								<tr bgcolor="#FAF4DA">
									<td colspan="2" height="16">
										<table cellpadding="0" cellspacing="0">
											<tr>
												<td style="padding-right:2px"><input type="button" value="ONOREAZA" class="buton_cool" onClick="NewWindow('{$URL_ADMIN}onoreaza_comanda.php?id_comanda={$comenzi[sec].id_comanda}', '', '500', '650')"></td>
												{if $status neq "asteptare"}
												<td style="padding-right:2px"><input type="button" value="ASTEPTARE" class="buton" onclick="setComanda('Sunteti sigur ca doriti sa puneti comanda cu ID-ul {$comenzi[sec].id_comanda} in <b>asteptare</b>? <br /><br /> <b>Motiv (optional):</b> <br /> <textarea name=nota_admin id=nota_admin rows=5 cols=40></textarea>', '400', '{$URL_ADMIN}asteptare_comanda.php?id_comanda={$comenzi[sec].id_comanda}{if $status neq ""}&stare={$status}{/if}')"></td>
												{/if}
												<td style="padding-right:2px"><input type="button" value="ANULEAZA" class="buton_anuleaza" onclick="setComanda('Sunteti sigur ca doriti sa <b>anulati</b> comanda cu ID-ul {$comenzi[sec].id_comanda}? <br /><br /> <b>Motiv (optional):</b> <br /> <textarea name=nota_admin id=nota_admin rows=5 cols=40></textarea>', '400', '{$URL_ADMIN}anuleaza_comanda.php?id_comanda={$comenzi[sec].id_comanda}{if $status neq ""}&stare={$status}{/if}')"></td>
												<td></td>
											</tr>
										</table>
									</td>
									<td colspan="2" align="right">Total comanda* = </td>
									<td align="right"><b>{$comenzi[sec].total_comanda}</b> &nbsp;</td>
								</tr>																													
							</table>
						</td>
					</tr>
					{if !$smarty.section.sec.last}
					<tr><td colspan="4" height="1" style="background-image:url({$DIR_TEMPLATE}img/dashed_line.gif);background-repeat:repeat-x;padding:0px"></td></tr>
					<tr><td colspan="4" height="2">&nbsp;</td></tr>		
					{/if}
					{/section}
					<tr>
						<td colspan="4" align="right" style="padding:2px;background-color:#DEF2FF;border-top:1px solid #F2F2F2;border-bottom:1px solid #F2F2F2">
							{$paginare}
						</td>
					</tr>
					{/if}
				</table>							
				{if $comenzi eq ""}
					<div class="bg_spatiu" style="padding:10px;margin-top:10px;margin-left:160px;">
						Nu aveti tranzactii/comenzi facute.
					</div>
				{/if}						
				<p><b>* Total comanda = nu include transportul</b></p>
			</td>
		</tr>
	</table>		
			</td>
		</tr>
	</table>	
	<p align="center"><a href="{$link_inapoi}" class="link_default">&laquo; Inapoi</a></p>	
	<p align="right"><a href="#top"><img src="{$DIR_TEMPLATE}img/top.gif" alt="top"></a>&nbsp;</p>	
</td>
{/strip}
{include file="admin/right.tpl"}
{include file="admin/bottom.tpl"}