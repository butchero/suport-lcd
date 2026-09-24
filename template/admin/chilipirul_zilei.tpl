{include file="admin/top.tpl"}
{include file="admin/left.tpl"}
{strip}
<td valign="top" align="left" width="568">
	<script src="{$URL_BASE}javascript/scriptaculous-js-1.7.0/lib/prototype.js" type="text/javascript"></script>	
	<table style="margin-left:6px;margin-right:6px;" cellpadding="0" cellspacing="0" width="557">
		<tr>
			<td>
	{*--------------------------------------------------------------------MESAJE-----------------------------------------------------*}
	{if $mesaj neq ""}
		{include file="admin/mesaj.tpl" mesaj=$mesaj}
	{/if}
	{*----------------------------------------------------------------------END------------------------------------------------------*}
	<table cellpadding="0" cellspacing="0" class="menu_container" style="background:url({$DIR_TEMPLATE}img/bg_menu.gif);border-top:1px solid #F2F2F2;border-left:1px solid #F2F2F2;border-right:1px solid #F2F2F2;">
		<tr>
			<td align="left" class="menu_title" height="18" style="padding-left:2px;padding-right:2px">
				<h2>Chilipirul zilei</h2>
			</td>
		</tr>
	</table>
	<table cellpadding="5" cellspacing="0" width="557">
		{*--------------------------------------------------------INSTRUCTIUNI UTILIZARE---------------------------------------------*}
		<tr>		
			<td colspan="2">
				<ul>
					<li>In aceasta pagina aveti posibilitatea de a seta chilipirul zilei.</li>
					<li>ATENTIE: Produs setat "chilipir" pentru ziua selectata nu va mai putea fi setat chilipir pentru alta zi!</li>	
					<li>ATENTIE: O zi nu poate sa aiba decat un singur chilipir setat!</li>		
					<li>ATENTIE: Chilipirul se schimba automat la 24:00, de aceea este recomandat sa setati mai multe "chilipuri" in avans!</li>		
				</ul>
			</td>
		</tr>
		{*------------------------------------------------------------------END------------------------------------------------------*}
	</table>
	<style type="text/css" media="all">
		@import "{$DIR_TEMPLATE}calendar.css";
	</style>
	<center>
		<div class="box" style="padding:5px;text-align:left">
		<table cellpadding="0" cellspacing="0">
			<tr>
				<td valign="top">
					{$calendar}
				<table style="margin-top:5px">
					<tr><td colspan="2" class="text_mic"><b>LEGENDA</b></td></tr>
					<tr><td width="14" height="14" class="currentDate"></td><td class="text_mic"> = Data curenta</td></tr>
					<tr><td width="14" height="14" class="selectedDate"></td><td class="text_mic"> = Data selectata</td></tr>
					<tr><td width="14" height="14" class="zi_marcata"></td><td class="text_mic"> = Zi cu chilipir setat</td></tr>
				</table>	
				</td>
				<td style="padding-left:20px;padding-top:2px" valign="top">
					<table cellpadding="0" cellspacing="0" style="margin-bottom:10px">
						<tr>
							<td width="75"><b>ID Produs:</b></td>
							<td width="40" style="padding-left:5px;padding-right:5px"><input type="text" name="id_produs" id="id_produs" size="6"></td>
							<td style="padding-left:5px;padding-right:5px">
								<input type="button" class="buton_cool" value="AFISEAZA" style="width:70px" onClick="afiseazaProdusChilipir($('id_produs').value, '{$an}', '{$luna}', '{$ziua}')">
							</td>
						</tr>
					</table>
					<div id="chilipir_container">
					{if $chilipir_setat eq "1"}
						<form action="{$URL_ADMIN}chilipirul_zilei.php?calendar_year={$an}&calendar_month={$luna}&calendar_Day={$ziua}&id_chilipir={$id_chilipir}" method="POST">
						 <table>
							<tr><td><img src="{$poza_chilipir}" alt=""></td><td>{$nume_chilipir}</td></tr>
							<tr><td></td><td>Pret curent: <input type="text" value="{$pret_curent}" size="12" disabled> (<b>{$MONEDA}</b> {if $TVA neq 1}fara{else}cu{/if} <b>TVA</b>)</td></tr>
							<tr><td></td><td>Pret chilipir: <input type="text" name="pret_chilipir" value="{$pret_chilipir}" size="12" disabled> (<b>{$MONEDA}</b> {if $TVA neq 1}fara{else}cu{/if} <b>TVA</b>)</td></tr>
							<tr><td></td><td><input type="submit" name="sterge_chilipir" value="STERGE CHILIPIR" class='buton_anuleaza' style="width:150px" {$atribut_camp}>
						 </table>
					 </form>
					{/if}
					</div>
				</td>
		</table>	
		</div>	
	</center>
	
	<p align="center"><a href="{$link_inapoi}" class="link_default">&laquo; Inapoi</a></p>
	<p align="right"><a href="#top"><img src="{$DIR_TEMPLATE}img/top.gif" alt="top"></a></p>
	
			</td>
		</tr>
	</table>
</td>
{/strip}
{include file="admin/right.tpl"}
{include file="admin/bottom.tpl"}