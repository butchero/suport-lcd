{include file="top.tpl"}
{include file="left.tpl"}
{strip}
<td valign="top" align="left">
	<form action="" method="POST">
	<table cellpadding="0" cellspacing="0" width="500" style="margin-top:10px;background:url({$DIR_TEMPLATE}{$POZE_DIR}/middle_chenar.gif);background-repeat:repeat-y">										
		<tr>
			<td colspan="3">
				<img src="{$DIR_TEMPLATE}{$POZE_DIR}/top_chenar.gif" alt="">
			</td>
		</tr>	
		<tr>
			<td style="padding-left:5px">
				<form action="" method="POST">
				<table>
					<tr><td colspan="4" align="left"><h3>RECUPEREAZA PAROLA</h3></td></tr>
					<tr><td colspan="4" class="eroare_form"><b>{$mesaj}</b></td></tr>
					<tr>
						<td width="20"></td>
						<td {if $email_check.valid eq "0"}class="eroare_text"{/if}>E-mail:</td>
						<td><input type="text" name="adresa_email" size="30" {if $email_check.valid eq "0"}class="eroare_bg"{/if}></td>
						<td class="eroare_form">{$email_check.eroare|wordwrap:35:"<br />"}</td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td><input type="submit" value="RECUPEREAZA" class="buton"></td>
						<td></td>
					</tr>
				</table>				
				</form>
			</td>
		<tr>
			<td colspan="3">
				<img src="{$DIR_TEMPLATE}{$POZE_DIR}/bottom_chenar.gif" alt="">
			</td>
		</tr>	
	</table>
	</form>
</td>
{/strip}
{include file="right.tpl"}
{include file="bottom.tpl"}