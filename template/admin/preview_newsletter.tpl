{literal}
<style type="text/css">
	body, td, p, span {
		font-family:Verdana;
		font-size:11px;
		color:#6C6C6C;	
	}
		
	a {
		color:#04A2C4;
		text-decoration:none;	
	}
				
	a:hover {
		color:#6F6F6F;	
		text-decoration:none;	
	}
	
	img {
		border:0px;
	}
	
	.box {
		border:1px solid #F2F2F2
	}
	
	.pret_vechi {
		text-decoration:line-through;
	}
	
	a.link_dezabonare {
		font-family:Arial;
		font-size:9px;
		color:#C82F2F;
		text-decoration:none;	
	}
</style>
{/literal}
<table cellpadding="0" cellspacing="0" width="600" style="margin-left:10px;margin-top:10px">
	<tr><td><img src="{$URL_POZA_ADMIN}colt_up_newsletter.gif" alt=""></td></tr>
	<tr>
		<td style="border-left:3px solid #E3E3E3;padding-left:15px;padding-bottom:10px">
			<a href="{$URL_BASE}"><img src="{$URL_POZA}sigla.jpg" alt="" border="0"></a>
			<table cellpadding="1" cellspacing="1" style="margin-top:20px">
				<tr><td align="left"><b>{$titlu_newsletter|upper}</b></td></tr>
				<tr><td align="left" style="padding:10px">{$text_newsletter}</td></tr>
			</table>
			{*--------------------------------------------------------AFISARE PRODUSE NEWSLETTER-----------------------------------------*}
			<table cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:5px">		
				{if $nume_chilipir neq ""}
				<tr>
					<td colspan="3" height="20" style="background-color:#FFCC00;color:#FFFFFF;padding-left:3px">
						<b>CHILIPIRUL ZILEI - IN FIECARE ZI UN PRODUS LA UN PRET SPECIAL, DOAR PENTRU O ZI</b>
					</td>
				</tr>
				<tr>
					<td colspan="3" style="background-color:#ECFCFF;padding:5px">
						<center>
							<table>
								<tr>
									<td><img src="{$poza_chilipir}" alt="" class="box"></td>
									<td width="240" style="padding-left:10px">
										{$nume_chilipir} 
										<br />
										<div style="margin-top:3px">
											doar azi <span style="font-size:14px;color:#00A4FF"><b>{$pret_chilipir} {$MONEDA}</b></span> - <span style="text-decoration:line-through">{$pret_curent} {$MONEDA}</span>
										</div>
									</td>
									<td valign="middle" align="center" style="padding-left:20px">
										<table cellpadding="3">
											<tr>
												<td height="20" style="background-color:#FFCC00;border:2px solid #FFA800">
												&nbsp;<a href="{$link_chilipir}" style="font-family:Arial;font-size:13px;color:#FFFFFF;text-decoration:none"><b>VEZI DETALII</b></a>&nbsp;
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</center>
					</td>
				</tr>
				<tr>
					<td colspan="3" style="font-family:arial;text-align:right;font-size:9px;color:#FFA800;background-color:#ECFCFF">
						acest produs nu va mai fi niciodata la pret de chilipir &nbsp;
					</td>
				</tr>
				{/if}
				<tr><td colspan="3" height="20" style="background-color:#35BBFA;color:#FFFFFF;padding-left:3px"><b>VA MAI RECOMANDAM URMATOARELE PRODUSE</b></td></tr>										
				{section name=tr_newsletter loop=$produse_newsletter step=3}
				<tr>	
					{section name=td_newsletter start=$smarty.section.tr_newsletter.index loop=$smarty.section.tr_newsletter.index+3}
					<td valign="top" align="center" width="33%">	
						{if $produse_newsletter[td_newsletter].nume_produs neq ""}	
							{*------------------------------------------------NUME PRODUS------------------------------------------------*}
							<div style="margin-top:5px;height:30px;display:table;text-align:center">
								<a href="{$produse_newsletter[td_newsletter].link_produs}" title="{$produse_newsletter[td_newsletter].nume_produs}" style="font-size:10px;text-decoration:none" target="_blank">
									{$produse_newsletter[td_newsletter].nume_produs}
								</a>																		
							</div>							
							{*----------------------------------------------------END----------------------------------------------------*}
							<table class="box">
								<tr>
									<td></td>
									<td width="95" height="75" align="center">
										<a href="{$produse_newsletter[td_newsletter].link_produs}" title="{$produse_newsletter[td_newsletter].nume_produs}" target="_blank" style="text-decoration:none">
											<img src="{$produse_newsletter[td_newsletter].adresa_poza_produs}" alt="{$produse_newsletter[td_newsletter].nume_produs}">
										</a>
									</td>							
								</tr>
							</table>
							{*----------------------------------------------------PRET---------------------------------------------------*}
							<div style="margin-bottom:5px;height:35px">
								Pret cu TVA <br />
								{if $produse_newsletter[td_newsletter].pret_vechi neq ""}<span class="pret_vechi">{$produse_newsletter[td_newsletter].pret_vechi} {$MONEDA}</span><br />{/if}
								<b>{$produse_newsletter[td_newsletter].pret_produs} {$MONEDA}</b>	
							</div>				
							{*-----------------------------------------------------END---------------------------------------------------*}					
						{/if}												
					</td>			
					{/section}			
				</tr>				
				{/section}	
			</table>
			{*------------------------------------------------------END AFISARE PRODUSE NEWSLETTER---------------------------------------*}			
		</td>
	</tr>	
	<tr><td><img src="{$URL_POZA_ADMIN}colt_down_newsletter.gif" alt=""></td></tr>
</table>