{include file="top.tpl"}
{include file="left.tpl"}
{strip}
<td valign="top" align="left">
	<table cellpadding="0" cellspacing="0" width="500" style="margin-top:10px;background:url({$DIR_TEMPLATE}{$POZE_DIR}/middle_chenar.gif);background-repeat:repeat-y">										
		<tr>
			<td colspan="3">
				<img src="{$DIR_TEMPLATE}{$POZE_DIR}/top_chenar.gif" alt="">
			</td>
		</tr>
		<tr>
			<td>
				{*-----------------------------------------------------------TABURI---------------------------------------------------------*}
				<table width="100%" cellpadding="0" cellspacing="0" style="margin-top:5px">
					<tr>
						<td width="10"></td>
						<td width="250">
							<table cellpadding="2" cellspacing="0" width="100%">
								<tr><td height="14" class="{if $tab_selectat eq "creeaza_cont_nou"}tab_top_selectat{else}taburi{/if}" align="center">01. Creeaza cont nou</td></tr>
							</table>
						</td>
						<td width="2"></td>
						<td width="250">
							<table cellpadding="2" cellspacing="0" width="100%">
								<tr><td height="14" class="{if $tab_selectat eq "validare_finalizata"}tab_top_selectat{else}taburi{/if}" align="center">02. Validare finalizata</td></tr>
							</table>
						</td>	
						<td width="242"></td>										
					</tr>
					<tr><td colspan="7" height="1" class="tab_line"></td></tr>
				</table>
				{*---------------------------------------------------------END TABURI------------------------------------------------------*}
				
				{*------------------------------------------------FORMULAR DESCHIDERE CONT NOU---------------------------------------------*}
				{if $tab_selectat eq "validare_finalizata"}
					{include file="cont_utilizator/validare_finalizata.tpl"}
				{else}
					{include file="cont_utilizator/form_date_cont.tpl"}
				{/if}
				{*----------------------------------------------END FORMULAR DESCHIDERE CONT NOU-------------------------------------------*}
			</td>
		</tr>	
		<tr>
			<td colspan="3">
				<img src="{$DIR_TEMPLATE}{$POZE_DIR}/bottom_chenar.gif" alt="">
			</td>
		</tr>	
	</table>
</td>
{/strip}
{include file="right.tpl"}
{include file="bottom.tpl"}