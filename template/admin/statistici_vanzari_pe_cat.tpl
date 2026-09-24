{include file="admin/top.tpl"}
{include file="admin/left.tpl"}
{strip}
<td valign="top" align="left" width="568">	
	<script type="text/javascript" src="{$URL_BASE}javascript/calendar_js/calendarDateInput.js"></script>
	<table style="margin-left:6px;margin-right:6px;" cellpadding="0" cellspacing="0" width="557">
		<tr><td>		
	{*-------------------------------------------------------------------MESAJE----------------------------------------------------*}
	{if $mesaj neq ""}
		{include file="admin/mesaj.tpl" mesaj=$mesaj}
	{/if}
	{*--------------------------------------------------------------------END------------------------------------------------------*}
	<table cellpadding="3" cellspacing="1">
		<tr>
			<td colspan="4" class="menu_title" style="background:url({$DIR_TEMPLATE}img/bg_menu.gif);border-top:1px solid #F2F2F2;border-left:1px solid #F2F2F2;border-right:1px solid #F2F2F2;">
				<h2>Statistici pe categorii</h2>
			</td>
		</tr>
	</table>	
	{*-----------------------------------------------------------INSTRUCTIUNI UTILIZARE--------------------------------------------*}
	<ul>
		<li>Statistici numar produse vandute, valoare totala, grupate pe categoriile principale.</li>
		<li>ATENTIE: Doar comenzile onorate apar in aceste statistici!</li>
		<li>ATENTIE: Produsele care au fost sterse nu apar in aceste statistici!</li>
	</ul>
	{*--------------------------------------------------------------------END------------------------------------------------------*}		
	<table cellpadding="2" class="box">
		<tr>
			<td colspan="4">				
				<table cellpadding="0" cellspacing="0">
					<tr>
						<td style="padding-right:10px;padding-left:10px"><i><b>Statistici:</b></i></td>
						<td>
							<form action="{$URL_ADMIN}statistici_vanzari_pe_cat.php" method="POST">
								<input type="radio" name="perioada" value="0" onClick="this.form.submit()" {if $perioada eq 0}checked{/if}></td>
						<td style="padding-right:10px">De la inceput</td>
						<td><input type="radio" name="perioada" value="1" onClick="this.form.submit()" {if $perioada eq 1}checked{/if}></td>
						<td>
								Astazi 
							</form>
						</td>		
						<td width="100"></td>				
					</tr>	
					<tr><td colspan="6" align="center" style="padding:10px">sau alege perioada</td></tr>
					<tr>
						<td colspan="6" style="padding-bottom:10px">
							<form action="{$URL_ADMIN}statistici_vanzari_pe_cat.php" method="POST">
							<table cellpadding="0" cellspacing="0">
				   	   			<tr>
				   	   				<td><script>DateInput('de_la', true, 'YYYYMMDD', '{$de_la}')</script></td>
				   	    			<td width="24" align="center">-</td>
				   	    			<td><script>DateInput('pana_la', true, 'YYYYMMDD', '{$pana_la}')</script></td>
				   	    			<td><input type="submit" value="AFISEAZA" class="buton_cool"></td>
				   	    		</tr>	
				   	    	</table>
				   	    	</form>
				   	    </td>	
					</tr>
				</table>
			</td>
		</tr>	
		{section name=sec loop=$categ_stats}
		<tr class="bg_spatiu">
			<td style="padding-left:10px">{$categ_stats[sec].nume_cat}</td>
			<td width="30" align="center">=</td>
			<td style="padding-right:10px" width="90" align="right"><b>{$categ_stats[sec].nr_produse}</b> produse</td>
			<td align="right"><b>{$categ_stats[sec].total}</b> {$MONEDA}</td>
		</tr>
		{/section}
		<tr bgcolor="#FAFFD2">
			<td style="padding-left:10px"><b>Total:</b></td>
			<td></td>
			<td style="padding-right:10px" width="90" align="right"><b>{$total.nr_produse}</b> produse</td>
			<td align="right"><b>{$total.vanzari}</b> {$MONEDA}</td>
		</tr>
	</table>
	<center>
		<img src="{$URL_ADMIN}pondere_vanzari_in_categorii.php" alt="Pondere produse in categorii">
	</center>		
	<p align="center"><a href="{$link_inapoi}" class="link_default">&laquo; Inapoi</a></p>
	<p align="right"><a href="#top"><img src="{$DIR_TEMPLATE}img/top.gif" alt="top"></a> &nbsp;</p>
			</td>
		</tr>
	</table>
</td>
{/strip}
{include file="admin/right.tpl"}
{include file="admin/bottom.tpl"}