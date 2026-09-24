{strip}
Specificatii <b>{$produs.nume_produs}</b>																
<table cellspacing="1" cellpadding="1">
	{*------------------------------CARACTERISTICI (din filtru)-------------------------*}
	{section name=subsec loop=$produs.caracteristici}								
	<tr bgcolor="{cycle values="#F2F2F2,#FFFFFF"}">
		<td width="5" height="18">&nbsp;</td>
		<td class="caracteristici_mari" width="50%"><img src="{$DIR_TEMPLATE}img/bullet.gif" alt=""> <b>{$produs.caracteristici[subsec].nume_carac}:</b></td>
		<td class="caracteristici_mari" width="50%">{$produs.caracteristici[subsec].val_carac}</td>
	</tr>
	{/section}
	{*---------------------------------------END----------------------------------------*}
	{*-----------------------------------PRODUCATOR-------------------------------------*}
	{if $produs.producator neq ""}
	{*
	<tr bgcolor="{cycle values="#F2F2F2,#FFFFFF"}">
		<td width="5" height="18"></td>
		<td class="caracteristici_mari"><img src="{$DIR_TEMPLATE}img/bullet.gif" alt=""> <b>Colectia:</b></td>
		<td class="caracteristici_mari">{$produs.producator}</td>
	</tr>	
	*}
	{/if}
	{*---------------------------------------END----------------------------------------*}	
</table>
{*-------------------------------------DESCRIERE PRODUS---------------------------------*}
{if $produs.descriere_produs neq ""}
	<br />
	<img src="{$DIR_TEMPLATE}img/comentariu.gif" alt=""> <b>Informatii suplimentare</b>
	<br />
	<div style="padding:10px">
		{$produs.descriere_produs}
	</div>
{/if}
{*-------------------------------------------END---------------------------------------*}	
<div class="text_estompat" style="margin-top:10px">
	<i>Nota:</i> Specificatiile si poza pentru produsul <b>{$produs.nume_produs}</b> au caracter informativ, pot fi schimbate fara instiintare prealabila si nu constituie obligativitate contractuala.
</div>	
{*-------------------------------------------END---------------------------------------*}
{/strip}