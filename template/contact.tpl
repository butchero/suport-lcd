{include file="top.tpl"}
{include file="left.tpl"}

<div id="right">
	<h3>CONTACT {$NUME_FIRMA|upper}</h3>
	<div style="padding-left:5px"><span class="eroare_form"><b>{$mesaj|upper}</b></span></div>
	<table>
		<tr>									
			<td>
				<span class="mesaj">{$erori}</span>									
				<form action="" method="post">
				<table>
					<tr>
						<td {if $nume_check.valid eq "0"}class="eroare_text"{/if}>Nume *:</td>
						<td><input type="text" name="nume" value="{$nume_check.camp}" {if $nume_check.valid eq "0"}class="eroare_bg"{/if} /></td>
						<td class="eroare_form" valign="top" style="padding-top:5px">
							{$nume_check.eroare|wordwrap:35:"<br />"}		
						</td>
					</tr>
					<tr>
						<td {if $email_check.valid eq "0"}class="eroare_text"{/if}>E-mail *:</td>
						<td><input type="text" name="email" value="{$email_check.camp}" {if $email_check.valid eq "0"}class="eroare_bg"{/if} /></td>
						<td class="eroare_form" valign="top" style="padding-top:5px">
							{$email_check.eroare|wordwrap:35:"<br />"}				
						</td>
					</tr>
					<tr>
						<td {if $telefon_check.valid eq "0"}class="eroare_text"{/if}>Telefon *:</td>
						<td><input type="text" name="telefon" value="{$telefon_check.camp}" {if $telefon_check.valid eq "0"}class="eroare_bg"{/if} /></td>
						<td class="eroare_form" valign="top" style="padding-top:5px">
							{$telefon_check.eroare|wordwrap:35:"<br />"}			
						</td>
					</tr>
					<tr>
						<td {if $mesaj_check.valid eq "0"}class="eroare_text"{/if}>Mesaj *:</td>
						<td><textarea name="mesaj" rows="4" cols="40" {if $mesaj_check.valid eq "0"}class="eroare_bg"{/if}>{$mesaj_check.camp}</textarea></td>
						<td class="eroare_form" valign="top" style="padding-top:5px">
							{$mesaj_check.eroare|wordwrap:35:"<br />"}			
						</td>
					</tr>
					<tr>
						<td valign="top" {if $cod_validare_check.valid eq "0"}class="eroare_text"{/if} style="padding-top:5px">Cod verificare *:</td>
						<td valign="top">
							<input type="text" name="cod_verificare" value="{$cod_validare_check.camp}" {if $cod_validare_check.valid eq "0"}class="eroare_bg"{/if} size="22" />
							<br /><img src="{$URL_BASE}imagine_cod_verificare.php" class="poza" alt="Poza cod verificare" style="margin-top:2px" />
						</td>
						<td class="eroare_form" valign="top" style="padding-top:5px">
							{$cod_validare_check.eroare|wordwrap:35:"<br />"}			
						</td>
					</tr>
					<tr><td></td><td><input type="submit" name="trimite_mesaj" value="TRIMITE MESAJ" class="buton" /></td></tr>
				</table>
				</form>
				<iframe width="300" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=ro&amp;geocode=&amp;q=str.Ion+Ratiu,+nr.133A+Constanta&amp;sll=37.0625,-95.677068&amp;sspn=60.158465,135.263672&amp;ie=UTF8&amp;hq=&amp;hnear=Strada+Ion+Ra%C8%9Biu,+Constan%C8%9Ba,+Rom%C3%A2nia&amp;t=m&amp;ll=44.195498,28.645048&amp;spn=0.018461,0.025749&amp;z=14&amp;iwloc=A&amp;output=embed"></iframe><br /><small><a href="http://maps.google.com/maps?f=q&amp;source=embed&amp;hl=ro&amp;geocode=&amp;q=str.Ion+Ratiu,+nr.133A+Constanta&amp;sll=37.0625,-95.677068&amp;sspn=60.158465,135.263672&amp;ie=UTF8&amp;hq=&amp;hnear=Strada+Ion+Ra%C8%9Biu,+Constan%C8%9Ba,+Rom%C3%A2nia&amp;t=m&amp;ll=44.195498,28.645048&amp;spn=0.018461,0.025749&amp;z=14&amp;iwloc=A" style="color:#0000FF;text-align:left">Vizualizare harta marita</a></small>
			</td>
		</tr>
	</table>
		
	<hr />
	{$contact_text}
</div>	
	
{include file="bottom.tpl"}