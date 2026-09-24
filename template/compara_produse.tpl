{strip}
<html>
	<head>
		<title>Compara produse</title>		
 		<link href="{$DIR_TEMPLATE}stylesheet.css" type="text/css" rel="stylesheet">
	</head>
	<script src="/javascript/jslib/overlib.js" type="text/javascript"></script>
	{literal}
	<script type="text/javascript" language="javascript">
	top.window.moveTo(0,0);
	if (document.all) 
	{
		top.window.resizeTo(screen.availWidth,screen.availHeight);
	}
	else if (document.layers||document.getElementById) 
	{
		if (top.window.outerHeight<screen.availHeight||top.window.outerWidth<screen.availWidth)
		{
			top.window.outerHeight = screen.availHeight;
			top.window.outerWidth = screen.availWidth;
		}
	}
	//-->
	</script>
	{/literal}
	<body>
		<table cellpadding="0" cellspacing="0" width="100%">
			<tr><td colspan="2" height="80" style="padding:10px"><img src="{$DIR_TEMPLATE}img/sigla.jpg" alt="Oraso Plant"></td></tr>
			<tr bgcolor="#CCCCCC">
				<td height="30" style="padding-left:5px"><font color="white"><b>Compara produse</b></font></td>
				<td align="right" style="padding-right:5px">
					<a href="javascript:window.self.close()" class="inchide_fereastra"><b>[Inchide fereastra]</b></a>
				</td>
			</tr>
			<tr><td colspan="2" height="4" class="bg_spatiu"></td></tr>			
			<tr>
				<td colspan="2" valign="top">
					<form action="{$form_action}" method="GET">
					<table cellpadding="0" cellspacing="0" width="100%">
						<tr>
							{*------------------------------------------CARACTERISTICI PRODUSE---------------------------------------*}
							<td width="300" valign="top">
								<img src="{$DIR_TEMPLATE}img/blank200.gif">
								<table width="300" cellpadding="2" cellspacing="0" style="margin-top:{if $producatori neq ""}282{else}250px{/if}">
									<tr><td align="left" colspan="3"><b>Caracteristici produs</b></td></tr>
									<tr><td height="5"></td></tr>
									{section name=sec loop=$filtre}								
									<tr bgcolor="{cycle name=cycle1 values="#C1C6C9,#FFFFFF"}">
										<td width="5"></td>
										<td align="left" height="20" width="300">
											<img src="{$DIR_TEMPLATE}img/bullet.gif" alt=""> {$filtre[sec].nume_filtru}:
										</td>										
									</tr>
									{/section}
								</table>
							</td>
							{*----------------------------------------------------END------------------------------------------------*}
							<td width="1" style="background-image:url({$DIR_TEMPLATE}img/spatiere_comparare.gif)" valign="top">
								<img src="{$DIR_TEMPLATE}img/spatiere_comparare.gif" alt="">
							</td>
							{*--------------------------------------------PRODUSE DE COMPARAT----------------------------------------*}
							{section name=sec loop=$produse}
							<td valign="top" align="center" width="290" class="bg_spatiu">
								<table width="100%" cellpadding="0" cellspacing="0">
									{*------------------------------------COMBOBOX PRODUCATOR----------------------------------------*}
									{if $producatori neq ""}
									<tr><td align="center"><b>Producator</b><td></tr>
									<tr>
										<td align="center">
											<select name="id_producator{$smarty.section.sec.index}" class="select" onChange="this.form.submit()">
												{html_options options=$producatori selected=$produse[sec].producator_selectat}
											</select>
										</td>
									</tr>
									{/if}
									{*--------------------------------------------END------------------------------------------------*}
									{*-------------------------------------COMBOBOX PRODUSE------------------------------------------*}
									<tr><td height="5"></td></tr>
									<tr><td align="center"><b>Produs</b><td></tr>
									<tr>
										<td align="center" style="padding:5px">
											<select name="id_produs{$smarty.section.sec.index}" class="select" onChange="this.form.submit()">
												<option value="0">--Alege produs--</option>
												{html_options options=$produse[sec].produse_combo selected=$produse[sec].produs_selectat}
											</select>
										</td>
									</tr>
									{*---------------------------------------------END-----------------------------------------------*}
									<tr><td height="5"></td></tr>
									<tr>
										<td align="center" height="17">
										{if $smarty.section.sec.total gt 1}
											<input type="submit" name="sterge{$smarty.section.sec.index}" value="STERGE PRODUS" class="buton_anuleaza">
										{/if}	
										</td>
									</tr>
									<tr><td height="5"></td></tr>
									{*-----------------------------------------NUME PRODUS-------------------------------------------*}
									<tr>
										<td align="center" height="50">
											<a href="{$produse[sec].link_produs}" target="_blank" class="link_default"><u>{$produse[sec].nume_produs}</u></a>
										</td>
									</tr>
									{*---------------------------------------------END-----------------------------------------------*}
									{*-----------------------------------------POZA PRODUS-------------------------------------------*}
									<tr><td align="center" height="94"><img src="{$produse[sec].adresa_poza_produs}" class="img"></td></tr>
									{*---------------------------------------------END-----------------------------------------------*}
									{*-----------------------------------------PRET PRODUS-------------------------------------------*}
									<tr>
										<td align="center" class="pret" height="50">
										<div class="box" style="width:120px;height:50px">
											Pret cu TVA <br />
											{if $produse[sec].pret_vechi neq ""}<font class="pret_vechi">{$produse[sec].pret_vechi} {$MONEDA}</font><br />{/if}
											<div class="pret" onmouseover="this.style.cursor='default'; return overlib('{$produse[sec].popup_js}');" onmouseout="return nd();">
												<b>{$produse[sec].pret_produs} {$MONEDA}</b>
											</div>
										</div>
										</td>
									</tr>
									{*---------------------------------------------END-----------------------------------------------*}
									{*------------------------------------CARACTERISTICI PRODUS--------------------------------------*}
									<tr><td height="5"></td></tr>
									<tr>
										<td align="center" valign="top">										
											<table width="100%" cellpadding="2" cellspacing="0">
												{section name=subsec loop=$produse[sec].caracteristici}								
												<tr bgcolor="{cycle name=$smarty.section.sec.index values="#C1C6C9,#FFFFFF"}">																								
													<td align="left" height="20" style="padding-left:15px">{$produse[sec].caracteristici[subsec].val_carac}</td>
												</tr>
												{/section}
											</table>
										</td>
									</tr>
									{*---------------------------------------------END-----------------------------------------------*}	
								</table>				
							</td>
							{if !$smarty.section.sec.last}
							<td width="1" style="background-image:url({$DIR_TEMPLATE}img/spatiere_comparare.gif)" valign="top">
								<img src="{$DIR_TEMPLATE}img/spatiere_comparare.gif" alt="">
							</td>
							{/if}
							{/section}
							{*-------------------------------------------END PRODUSE DE COMPARAT-------------------------------------*}
							<td width="1" style="background-image:url({$DIR_TEMPLATE}img/spatiere_comparare.gif)" valign="top">
								<img src="{$DIR_TEMPLATE}img/spatiere_comparare.gif" alt="">
							</td>	
							{*--------------------------------------------PRODUS NOU DE COMPARAT-------------------------------------*}
							{if $smarty.section.sec.rownum lt $nr_produse_de_comparat}
							<td valign="top" width="290" align="center" bgcolor="#FCF8EA">
								<table width="100%" cellpadding="0" cellspacing="0">	
									{if $producatori neq ""}								
									<tr><td align="center"><b>Producator</b><td></tr>
									<tr>
										<td align="center">
											<select name="id_producator{$smarty.section.sec.rownum}" class="select" onChange="this.form.submit()">
												{html_options options=$producatori selected=$producator_selectat_combo_nou}
											</select>
										</td>
									</tr>	
									{/if}								
									<tr><td height="5"></td></tr>									
									<tr><td align="center"><b>Produs</b><td></tr>
									<tr>
										<td align="center" style="padding:5px">
											<select name="id_produs{$smarty.section.sec.rownum}" class="select" onChange="this.form.submit()">
												<option value="">Alege</option>
												{html_options options=$produse_combo_nou}
											</select>
										</td>
									</tr>									
									<tr><td height="5"></td></tr>									
								</table>				
							</td>
							{/if}	
							{*------------------------------------------------------END----------------------------------------------*}					
							<td width="50%"></td>
						</tr>
					</table>
					<input type="hidden" name="id_cat" value="{$id_cat}">
					</form>
				</td>
			</tr>
			<tr><td colspan="2" height="4" class="bg_spatiu"></td></tr>
			<tr><td align="center" colspan="2" height="10">&copy; 2007 {$NUME_FIRMA}</td></tr>
		</table>
	</body>
</html>
{/strip}