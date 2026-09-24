{strip}
<script type="text/javascript" language="javascript">
	var insert_ok='{$insert_ok}';		
	if(insert_ok=="1")
		alert("Alerta a fost setata !")		
</script>
Alerta pret pentru produsul <b>{$produs.nume_produs}</b>
<br /><br />
<form action="#down" method="POST">
	<table class="box" width="100%">
		<tr>
			<td align="right" {if $email_check.valid eq "0"}class="eroare_text"{/if} width="150">Adresa dvs. de e-mail *:</td>
			<td><input type="text" name="adresa_email" size="30" value="{$email_check.camp}" {if $email_check.valid eq "0"}class="eroare_bg"{/if}></td>
			<td class="eroare_form" valign="top">
				{$email_check.eroare|wordwrap:35:"<br />"}	
				{if $email_check.eroare eq "" && $form_submit eq "1"}<img src="{$DIR_TEMPLATE}img/ok.gif" alt="">{/if}			
			</td>
		</tr>
		<tr>
			<td align="right" {if $pretul_dorit_check.valid eq "0"}class="eroare_text"{/if}>Pretul dorit *:</td>
			<td><input type="text" name="alerta_prag" size="10" value="{$pretul_dorit_check.camp}" {if $pretul_dorit_check.valid eq "0"}class="eroare_bg"{/if}> < <b>{$produs.pret_produs}</b> RON</td>
			<td class="eroare_form" valign="top">
				{$pretul_dorit_check.eroare|wordwrap:35:"<br />"}
				{if $pretul_dorit_check.eroare eq "" && $form_submit eq "1"}<img src="{$DIR_TEMPLATE}img/ok.gif" alt="">{/if}			
			</td>
		</tr>
		<tr>
			<td align="right" {if $cod_verificare_check.valid eq "0"}class="eroare_text"{/if} valign="top" style="padding-top:4px">Cod verificare *:</td>
			<td>
				<input type="text" name="cod_verificare" value="{$cod_verificare_check.camp}" {if $cod_verificare_check.valid eq "0"}class="eroare_bg"{/if} size="21" maxlength="8"> <br />
				<img src="{$URL_BASE}imagine_cod_verificare.php" alt="Cod Verificare">
			</td>
			<td class="eroare_form" valign="top">
				{$cod_verificare_check.eroare|wordwrap:35:"<br />"}
				{if $cod_verificare_check.eroare eq "" && $form_submit eq "1"}<img src="{$DIR_TEMPLATE}img/ok.gif" alt="">{/if}				
			</td>
		</tr>
		<tr>	
			<td></td>	
			<td colspan="2" align="left">
				<input type="submit" name="seteaza_alerta" value="SETEAZA ALERTA" class="buton" style="width:120px">
				<font class="eroare_form">&nbsp; {$alerta_check.eroare}</font>				
			</td>
		</tr>
		<tr><td colspan="3" align="right">* Campuri obligatorii</td></tr>
	</table>
</form>
<br />
<i>In momentul cand produsul va atinge pretul indicat veti fi notificat pe e-mail.</i>
{/strip}