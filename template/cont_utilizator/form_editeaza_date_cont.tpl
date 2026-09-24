{strip}
{*------------------------------------------------FORMULAR DESCHIDERE CONT NOU---------------------------------------------*}
<form action="" method="POST">
	<table cellpadding="2" cellspacing="0" width="100%" style="margin-left:10px;">					
		<tr>
			<td colspan="3" align="left" height="20"><b>Detalii cont</b></td>
		</tr>
		<tr><td colspan="3" height="10"></td></tr>
		<tr>
			<td width="140" {if $user_check.valid eq "0"}class="eroare_text"{/if}>Username *:</td>
			<td><input type="text" name="username" value="{$user_check.camp}" size="30" maxlength="32" {if $user_check.valid eq "0"}class="eroare_bg"{/if} readonly></td>
			<td class="eroare_form" width="250">
				{$user_check.eroare|wordwrap:35:"<br />"}
				{if $user_check.eroare eq "" && $form_submit eq "1"}<img src="{$DIR_TEMPLATE}img/ok.gif" alt="">{/if}
			</td>
		</tr>
		<tr>
			<td {if $parola_check.valid eq "0"}class="eroare_text"{/if}>Parola *:</td>
			<td><input type="password" name="parola" value="{$parola_check.camp}" size="30" maxlength="30" {if $parola_check.valid eq "0"}class="eroare_bg"{/if}></td>
			<td class="eroare_form">
				{$parola_check.eroare|wordwrap:35:"<br />"}
				{if $parola_check.eroare eq "" && $form_submit eq "1"}<img src="{$DIR_TEMPLATE}img/ok.gif" alt="">{/if}
			</td>
		</tr>
		<tr>
			<td {if $parola_check.valid eq "0"}class="eroare_text"{/if}>Verifica parola *:</td>
			<td><input type="password" name="parola_verificare" value="{$parola_verificare}" size="30" maxlength="30" {if $parola_check.valid eq "0"}class="eroare_bg"{/if}></td>
			<td class="eroare_form">
				{if $parola_check.eroare eq "" && $form_submit eq "1"}<img src="{$DIR_TEMPLATE}img/ok.gif" alt="">{/if}
			</td>
		</tr>
		<tr>
			<td colspan="3" height="10"></td>
		</tr>
		<tr>
			<td colspan="3" align="left" height="20"><b>Detalii personale</b></td>
		</tr>
		<tr>
			<td colspan="3" height="5"></td>
		</tr>
		<tr>
			<td {if $nume_check.valid eq "0"}class="eroare_text"{/if}>Nume *:</td>
			<td><input type="text" name="nume" value="{$nume_check.camp}" size="30" {if $nume_check.valid eq "0"}class="eroare_bg"{/if}></td>
			<td class="eroare_form">
				{$nume_check.eroare|wordwrap:35:"<br />"}
				{if $nume_check.eroare eq "" && $form_submit eq "1"}<img src="{$DIR_TEMPLATE}img/ok.gif" alt="">{/if}
			</td>
		</tr>
		<tr>
			<td {if $prenume_check.valid eq "0"}class="eroare_text"{/if}>Prenume *:</td>
			<td><input type="text" name="prenume" value="{$prenume_check.camp}" size="30" {if $prenume_check.valid eq "0"}class="eroare_bg"{/if}></td>
			<td class="eroare_form">
				{$prenume_check.eroare|wordwrap:35:"<br />"}
				{if $prenume_check.eroare eq "" && $form_submit eq "1"}<img src="{$DIR_TEMPLATE}img/ok.gif" alt="">{/if}
			</td>
		</tr>
		<tr>
			<td {if $cnp_check.valid eq "0"}class="eroare_text"{/if}>CNP:</td>
			<td><input type="text" name="cnp" size="30" value="{$cnp_check.camp}" {if $cnp_check.valid eq "0"}class="eroare_bg"{/if}></td>
			<td class="eroare_form">
				{$cnp_check.eroare|wordwrap:35:"<br />"}
				{if $cnp_check.eroare eq "" && $form_submit eq "1"}<img src="{$DIR_TEMPLATE}img/ok.gif" alt="">{/if}
			</td>
		</tr>
		<tr>
			<td {if $email_check.valid eq "0"}class="eroare_text"{/if}>Email *:</td>
			<td><input type="text" name="email" size="30" value="{$email_check.camp}" {if $email_check.valid eq "0"}class="eroare_bg"{/if}></td>
			<td class="eroare_form">
				{$email_check.eroare|wordwrap:35:"<br />"}
				{if $email_check.eroare eq "" && $form_submit eq "1"}<img src="{$DIR_TEMPLATE}img/ok.gif" alt="">{/if}
			</td>
		</tr>
		<tr>
			<td {if $email_check.valid eq "0"}class="eroare_text"{/if}>Verificare email *:</td>
			<td><input type="text" name="email_verificare" value="{$email_verificare}" size="30" {if $email_check.valid eq "0"}class="eroare_bg"{/if}></td>
			<td class="eroare_form">
				{if $email_check.eroare eq "" && $form_submit eq "1"}<img src="{$DIR_TEMPLATE}img/ok.gif" alt="">{/if}
			</td>
		</tr>
		<tr>
			<td colspan="3" height="10"></td>
		</tr>
		<tr>
			<td colspan="3" align="left" height="20"><b>Detalii contact (adresa de livrare)</b></td>
		</tr>
		<tr>
			<td colspan="3" height="5"></td>
		</tr>
		<tr>
			<td {if $adresa_check.valid eq "0"}class="eroare_text"{/if}>Adresa *:</td>
			<td><input type="text" name="adresa" value="{$adresa_check.camp}" size="30" {if $adresa_check.valid eq "0"}class="eroare_bg"{/if}></td>
			<td class="eroare_form">
				{$adresa_check.eroare|wordwrap:35:"<br />"}
				{if $adresa_check.eroare eq "" && $form_submit eq "1"}<img src="{$DIR_TEMPLATE}img/ok.gif" alt="">{/if}
			</td>
		</tr>
		<tr>
			<td {if $cod_postal_check.valid eq "0"}class="eroare_text"{/if}>Cod postal *:</td>
			<td><input type="text" name="cod_postal" value="{$cod_postal_check.camp}" size="30" {if $cod_postal_check.valid eq "0"}class="eroare_bg"{/if}></td>
			<td class="eroare_form">
				{$cod_postal_check.eroare|wordwrap:35:"<br />"}
				{if $cod_postal_check.eroare eq "" && $form_submit eq "1"}<img src="{$DIR_TEMPLATE}img/ok.gif" alt="">{/if}
			</td>
		</tr>					
		<tr>
			<td {if $localitate_check.valid eq "0"}class="eroare_text"{/if}>Localitate *:</td>
			<td><input type="text" name="localitate" size="30" value="{$localitate_check.camp}" {if $localitate_check.valid eq "0"}class="eroare_bg"{/if}></td>
			<td class="eroare_form">
				{$localitate_check.eroare|wordwrap:35:"<br />"}
				{if $localitate_check.eroare eq "" && $form_submit eq "1"}<img src="{$DIR_TEMPLATE}img/ok.gif" alt="">{/if}
			</td>
		</tr>
		<tr>
			<td {if $judet_check.valid eq "0"}class="eroare_text"{/if}>Judet: *</td>
			<td>
				<select name="judet" class="select">
					<option value="0" {if $judet_check.valid eq "0"}class="eroare_bg"{/if}>-Alege-</option>
					{html_options options=$judete selected=$judet_check.camp}
				</select>
			</td>
			<td class="eroare_form">
				{$judet_check.eroare|wordwrap:35:"<br />"}
				{if $judet_check.eroare eq "" && $form_submit eq "1"}<img src="{$DIR_TEMPLATE}img/ok.gif" alt="">{/if}
			</td>
		</tr>
		<tr>
			<td {if $telefon_check.valid eq "0"}class="eroare_text"{/if}>Telefon: *</td>
			<td><input type="text" name="telefon" size="30" maxlength="10" value="{$telefon_check.camp}" {if $telefon_check.valid eq "0"}class="eroare_bg"{/if}></td>
			<td class="eroare_form">
				{$telefon_check.eroare|wordwrap:35:"<br />"}
				{if $telefon_check.eroare eq "" && $form_submit eq "1"}<img src="{$DIR_TEMPLATE}img/ok.gif" alt="">{/if}
			</td>
		</tr>
		<tr>
			<td>Fax:</td>
			<td><input type="text" name="fax" size="30" value="{$fax_check.camp}"></td>
			<td></td>
		</tr>
		<tr>
			<td colspan="2" height="10"></td>
		</tr>
		<tr>
			<td colspan="3" align="left" height="20">
				<table cellpadding="0" cellspacing="0">
					<tr>
						<td><b>Sunt societate</b></td>
						<td><input type="checkbox" name="sunt_societate" value="1" onClick="toggle('date_soc');" {if $sunt_societate eq "1"}checked{/if}></td>
					</tr>
				</table>		
			</td>
		</tr>
		<tr><td colspan="2" height="5"></td></tr>
	</table> 
	<div id="date_soc" style="display:{if $sunt_societate eq "1"}block{else}none{/if}">
		<table cellpadding="2" cellspacing="0" width="100%" style="margin-left:10px;">
			<tr>
				<td width="140" {if $societate_check.valid eq "0"}class="eroare_text"{/if}>Societate:</td>
				<td><input type="text" name="societate" size="30" value="{$societate_check.camp}" {if $societate_check.valid eq "0"}class="eroare_bg"{/if}></td>
				<td width="250" class="eroare_form">
					{$societate_check.eroare|wordwrap:35:"<br />"}
					{if $societate_check.eroare eq "" && $form_submit eq "1" && $sunt_societate eq "1"}<img src="{$DIR_TEMPLATE}img/ok.gif" alt="">{/if}
				</td>
			</tr>
			<tr>
				<td {if $cod_fiscal_check.valid eq "0"}class="eroare_text"{/if}>Cod fiscal:</td>
				<td><input type="text" name="cod_fiscal" size="30" value="{$cod_fiscal_check.camp}" {if $cod_fiscal_check.valid eq "0"}class="eroare_bg"{/if}></td>
				<td class="eroare_form">
					{$cod_fiscal_check.eroare|wordwrap:35:"<br />"}
					{if $cod_fiscal_check.eroare eq "" && $form_submit eq "1" && $sunt_societate eq "1"}<img src="{$DIR_TEMPLATE}img/ok.gif" alt="">{/if}
				</td>
			</tr>
			<tr>
				<td {if $nr_reg_comert_check.valid eq "0"}class="eroare_text"{/if}>Nr. Reg. Comert:</td>
				<td><input type="text" name="nr_reg_comert" size="30" value="{$nr_reg_comert_check.camp}" {if $nr_reg_comert_check.valid eq "0"}class="eroare_bg"{/if}></td>
				<td class="eroare_form">
					{$nr_reg_comert_check.eroare|wordwrap:35:"<br />"}
					{if $nr_reg_comert_check.eroare eq "" && $form_submit eq "1" && $sunt_societate eq "1"}<img src="{$DIR_TEMPLATE}img/ok.gif" alt="">{/if}
				</td>
			</tr>
			<tr>
				<td {if $banca_check.valid eq "0"}class="eroare_text"{/if}>Banca:</td>
				<td><input type="text" name="banca" size="30" value="{$banca_check.camp}" {if $banca_check.valid eq "0"}class="eroare_bg"{/if}></td>
				<td class="eroare_form">
					{$banca_check.eroare|wordwrap:35:"<br />"}
					{if $banca_check.eroare eq "" && $form_submit eq "1" && $sunt_societate eq "1"}<img src="{$DIR_TEMPLATE}img/ok.gif" alt="">{/if}
				</td>
			</tr>
			<tr>
				<td {if $cod_iban_check.valid eq "0"}class="eroare_text"{/if}>Cod IBAN:</td>
				<td><input type="text" name="cod_iban" size="30" value="{$cod_iban_check.camp}" {if $cod_iban_check.valid eq "0"}class="eroare_bg"{/if}></td>
				<td class="eroare_form">
					{$cod_iban_check.eroare|wordwrap:35:"<br />"}
					{if $cod_iban_check.eroare eq "" && $form_submit eq "1" && $sunt_societate eq "1"}<img src="{$DIR_TEMPLATE}img/ok.gif" alt="">{/if}
				</td>
			</tr>
		</table>		
	</div>								
	<table width="100%" style="margin-left:10px;margin-top:10px">
		<tr><td colspan="2" height="1" bgcolor="#F2F2F2" style="padding:0px"></td></tr>
		<tr><td colspan="2">* = Campuri obligatorii</td></tr>
		<tr><td colspan="2" height="1" bgcolor="#F2F2F2" style="padding:0px"></td></tr>
		<tr>
			<td width="110"></td>
			<td align="left">
				<input type="submit" name="modifica_cont" value="MODIFICA CONT" class="buton" style="width:150px">
			</td>
		</tr>
	</table>
</form>	
{*----------------------------------------------END FORMULAR DESCHIDERE CONT NOU--------------------------------------------*}
{/strip}