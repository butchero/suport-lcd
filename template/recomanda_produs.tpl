{strip}
<html>
	<head>
		<title>Recomanda produs</title>		
 		<link href="{$DIR_TEMPLATE}stylesheet.css" type="text/css" rel="stylesheet">
	</head>
	<script src="/javascript/jslib/overlib.js" type="text/javascript"></script>
	<body>
		<table cellpadding="0" cellspacing="0" width="100%">
			<tr><td colspan="2" height="80" style="padding:10px"><img src="{$DIR_TEMPLATE}img/sigla.jpg" alt="{$NUME_FIRMA}"></td></tr>
			<tr style="background:url({$DIR_TEMPLATE}img/bg_menu_top.gif)">
				<td height="30" style="padding-left:5px"><font color="white"><b>Recomanda produs</b></font></td>
				<td align="right" style="padding-right:5px">
					<a href="javascript:window.self.close()" class="inchide_fereastra"><b>[Inchide fereastra]</b></a>
				</td>
			</tr>
			<tr><td colspan="2" height="4" class="bg_spatiu"></td></tr>			
			<tr>
				<td colspan="2" valign="top" align="center" style="padding-top:10px">
				Trimite un mesaj unui prieten care ar putea fi interesat de acest produs: 
				<br /><br />
				<table class="box">
					<tr>
						<td width="1" class="margine_poza"></td>
						<td><img src="{$produs.adresa_poza_produs}" alt="{$produs.nume_produs}"></td>
						<td><b>{$produs.nume_produs}</b></td>
					</tr>
				</table>
				<br />
				<font class="eroare_text"><b>{$mesaj}</b></font>
				<br />
				<form action="" method="POST">
				<table cellpadding="2" cellspacing="0" class="box">
					<tr>
						<td align="left" colspan="3" class="bg_spatiu"><b>De la</b></td>
					</tr>
					<tr>
						<td align="left" {if $nume_check.valid eq "0"}class="eroare_text"{/if}>Numele tau:</td>		
						<td align="left"><input type="text" name="nume" value="{$nume_check.camp}" {if $nume_check.valid eq "0"}class="eroare_bg"{/if} size="30" maxlength="30"></td>
						<td class="eroare_form" valign="top" width="200" style="padding-top:5px">
							{$nume_check.eroare|wordwrap:35:"<br />"}	
							{if $nume_check.eroare eq "" && $form_submit eq "1"}<img src="{$DIR_TEMPLATE}img/ok.gif" alt="">{/if}			
						</td>
					</tr>
					<tr>
						<td align="left" {if $email_check.valid eq "0"}class="eroare_text"{/if}>Email-ul tau:</td>		
						<td align="left"><input type="text" name="adresa_email" value="{$email_check.camp}" {if $email_check.valid eq "0"}class="eroare_bg"{/if} size="30"></td>
						<td class="eroare_form" valign="top" width="200" style="padding-top:5px">
							{$email_check.eroare|wordwrap:35:"<br />"}	
							{if $email_check.eroare eq "" && $form_submit eq "1"}<img src="{$DIR_TEMPLATE}img/ok.gif" alt="">{/if}			
						</td>
					</tr>
					<tr><td colspan="3" height="10"></td></tr>
					<tr><td align="left" colspan="3" class="bg_spatiu"><b>Pentru</b></td></tr>
					<tr>
						<td align="left" {if $email_destinatar_check.valid eq "0"}class="eroare_text"{/if}>Email prieten:</td>		
						<td align="left"><input type="text" name="adresa_email_destinatar" value="{$email_destinatar_check.camp}" {if $email_destinatar_check.valid eq "0"}class="eroare_bg"{/if} size="30"></td>
						<td class="eroare_form" valign="top" width="200" style="padding-top:5px">
							{$email_destinatar_check.eroare|wordwrap:35:"<br />"}	
							{if $email_destinatar_check.eroare eq "" && $form_submit eq "1"}<img src="{$DIR_TEMPLATE}img/ok.gif" alt="">{/if}			
						</td>
					</tr>
					<tr>
						<td align="left" valign="top" style="padding-top:5px">Mesaj suplimentar:</td>
						<td align="left" colspan="2"><textarea name="mesaj_suplimentar" rows="3" cols="40">{$mesaj_suplimentar}</textarea></td>
					</tr>
					<tr>
						<td align="left" valign="top" style="padding-top:5px" {if $cod_verificare_check.valid eq "0"}class="eroare_text"{/if}>Cod verificare:</td>
						<td align="left">
							<input type="text" name="cod_verificare" value="{$cod_verificare_check.camp}" {if $cod_verificare_check.valid eq "0"}class="eroare_bg"{/if} size="21" maxlength="8">
							<br />
							<img src="{$URL_BASE}imagine_cod_verificare.php">
						</td>
						<td class="eroare_form" valign="top" width="200" style="padding-top:5px">
							{$cod_verificare_check.eroare|wordwrap:35:"<br />"}	
							{if $cod_verificare_check.eroare eq "" && $form_submit eq "1"}<img src="{$DIR_TEMPLATE}img/ok.gif" alt="">{/if}			
						</td>
					</tr>
					<tr>
						<td></td>
						<td colspan="2"><input type="submit" name="trimite" value="TRIMITE" class="buton"></td>
					</tr>
				</table>
				<input type="hidden" name="id_produs" value="{$produs.id_produs}">
				</form>
				</td>
			</tr>
			<tr><td align="center" colspan="2" height="10">&copy; 2006 {$NUME_FIRMA}</td></tr>
		</table>
	</body>
</html>
{/strip}