{include file="top.tpl" titlu_pagina="404"}
{include file="left.tpl"}
{strip}
<td valign="top" align="left">	
	<table cellpadding="0" cellspacing="0" width="500" style="margin-top:10px;background:url({$DIR_TEMPLATE}{$POZE_DIR}/middle_chenar.gif);background-repeat:repeat-y">										
		<tr><td><img src="{$DIR_TEMPLATE}{$POZE_DIR}/top_chenar.gif" alt=""></td></tr>				
		<tr><td style="padding-left:10px"><h3>EROARE</h3></td></tr>
		<tr>
			<td style="padding:10px" align="center">
			<b>Pagina/Produsul</b> cautat nu a fost gasit ! <br />
	   		Ne pare rau.					   		
	   		<br /><br />
	   		<a href="{$URL_BASE}" class="link"><u>Prima pagina a site-ului</u></a>
			</td>
		</tr>
		<tr><td><img src="{$DIR_TEMPLATE}{$POZE_DIR}/bottom_chenar.gif" alt=""></td></tr>	
	</table>
</td>
{/strip}
{include file="right.tpl"}
{include file="bottom.tpl"}