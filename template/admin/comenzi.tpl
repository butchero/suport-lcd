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
				<h2>Vizualizeaza <font class="titlu_cat">COMENZI {$stare_comanda|upper}</font></h2>
			</td>
		</tr>
	</table>
	{*-----------------------------------------------------------INSTRUCTIUNI UTILIZARE---------------------------------------------*}
	<ul>
		<li>In aceasta sectiune aveti posibilitatea de a vizualiza comenzile {$stare_comanda}.</li>
		<li>Pentru comenzile onorate, data comenzii devine data onorarii.</li>	
		{if $stare_comanda eq "anulate"}
			<li>Pentru a vizualiza motivul anularii unei comenzi, trebuie sa puneti mouse-ul pe statusul comenzii.</li>
		{/if}
	</ul>
	{*---------------------------------------------------------------------END------------------------------------------------------*}
	<center>
	<form action="{$URL_ADMIN}comenzi.php?stare={$stare_comanda}" method="POST">
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
	<center>
	<table style="margin:10px">
		<tr>
			<td class="titlu" align="center">
			<table>
				<tr>
					<td><img src="{$DIR_TEMPLATE}img/dolar.jpg" alt=""></td>
					<td>Tranzactii {$stare_comanda} in perioada:</td>
				</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td align="center">
				<b>{$de_la_formatat} - {$pana_la_formatat}</b>
				{if $total_cumparaturi neq ""}
					&nbsp; <font class="titlu">in valoare de</font> <b>{$total_cumparaturi}</b> {$MONEDA}
				{/if}	
			</td>
		</tr>
	</table>
	</center>	
	<table>
		<tr>
			<td><b>Comenzi {$stare_comanda} <span class="eroare_text">({$nr_rezultate})</span>:</b> {if $nr_comenzi_fara_transport neq ""}- din care cu transport gratuit <span class="eroare_text">({$nr_comenzi_fara_transport})</span> si cu transport platit <span class="eroare_text">({$nr_comenzi_cu_transport})</span>{/if}</td>
		</tr>		
		<tr>
			<td>	
				<table cellpadding="0" cellspacing="0" width="100%">
					{if $comenzi neq ""}
					<tr>
						<td colspan="4" align="right" style="padding:2px;background-color:#DEF2FF;border-top:1px solid #CCCCCC;border-bottom:1px solid #CCCCCC">
							{$paginare}
						</td>
					</tr>
					<tr><td colspan="4" height="10"></td></tr>
					{section name=sec loop=$comenzi}					
					<tr>
						<td width="20" align="center" height="18"><a href="{$comenzi[sec].proforma}" target="_blank"><img src="{$DIR_TEMPLATE}img/doc.gif" alt="Click pentru a descarca proforma"></a></td>
						<td width="70">ID: <b>{$comenzi[sec].id_comanda}</b></td>	
						<td width="290"><div id="comanda_status_{$comenzi[sec].id_comanda}">Status: [<b>{$comenzi[sec].stare_comanda}</b>] - {$comenzi[sec].admin}</div></td>								
						<td width="170">Data: <b>{$comenzi[sec].data_comenzii}</b></td>
					</tr>					
					<tr>
						<td colspan="4">
							<table cellpadding="3" cellspacing="1" width="100%" style="margin-bottom:10px">
								<tr bgcolor="#EFEFEF">
									<td></td>
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
								{if $comenzi[sec].nota_admin}
								<tr>
									<td colspan="5" class="text_mic">
										<b>Nota admin:</b> {$comenzi[sec].nota_admin}
									</td>
								</tr>
								{/if}
								<tr>
									<td colspan="5" height="10" align="right">
										<div id="comanda_{$comenzi[sec].id_comanda}">
											<input type="button" value="DETALII CUMPARATOR" class="buton" onClick="getInfoComanda({$comenzi[sec].id_comanda})" style="width:150px">
										</div>
									</td>
								</tr>
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
									<td colspan="2" height="16"></td>
									<td colspan="2" align="right">Total comanda* = </td>
									<td align="right"><b>{$comenzi[sec].total_comanda}</b> &nbsp;</td>
								</tr>																													
							</table>
						</td>
					</tr>	
					{if !$smarty.section.sec.last}
					<tr><td colspan="4" height="2">&nbsp;</td></tr>	
					<tr><td colspan="4" height="1" style="background-image:url({$DIR_TEMPLATE}img/dashed_line.gif);background-repeat:repeat-x;padding:0px"></td></tr>
					<tr><td colspan="4" height="2">&nbsp;</td></tr>		
					{/if}				
					{/section}	
					<tr><td colspan="4" height="2"></td></tr>
					<tr>
						<td colspan="4" align="right" style="padding:2px;background-color:#DEF2FF;border-top:1px solid #F2F2F2;border-bottom:1px solid #F2F2F2">
							{$paginare}
						</td>
					</tr>
					{/if}
				</table>							
				{if $comenzi eq ""}
					<div style="padding-left:10px">Nu aveti tranzactii/comenzi facute.</div>
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