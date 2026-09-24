{include file="admin/top.tpl"}
{include file="admin/left.tpl"}
{strip}
<td valign="top" align="left" width="568">
	<script language="javascript" type="text/javascript" src="{$URL_BASE}javascript/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
	<script language="javascript" type="text/javascript">
		var url_css="{$DIR_TEMPLATE}tinymce.css"
	</script>
	{literal}
	<script language="javascript" type="text/javascript">
		tinyMCE.init({
				relative_urls : false,
				mode : "textareas",
				theme : "advanced",
				content_css : url_css,
				theme_advanced_disable : "outdent,indent,cut,copy,paste,undo,redo,image,cleanup,help,code,hr,removeformat,formatselect,fontselect,fontsizeselect,sub,sup,backcolor,charmap,visualaid,anchor,newdocument,separator,bullist, numlist,link,unlink",	
				theme_advanced_buttons1_add_before: "undo,redo,separator",
				theme_advanced_buttons1_add: "separator,bullist,numlist,separator,forecolor,backcolor,separator,link,unlink",
				theme_advanced_toolbar_location : "top",
				theme_advanced_toolbar_align : "left",
				extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]"
		});
	</script>	
	{/literal}
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
				<h2>Newsletter</h2>
			</td>
		</tr>
	</table>
	<table cellpadding="5" cellspacing="0" width="557">
		{*--------------------------------------------------------INSTRUCTIUNI UTILIZARE---------------------------------------------*}
		<tr>		
			<td colspan="2">
				<ul>
					<li>In aceasta pagina aveti posibilitatea de a trimite newsletter la abonati.</li>
					<li>ATENTIE: Spamul este interzis! Mailurile trimise nesolicitat si in cantitate mare pot duce la blocarea serverului si/sau intrarea domeniul/ip-ului in blacklist!</li>					
				</ul>
			</td>
		</tr>
		{*------------------------------------------------------------------END------------------------------------------------------*}
	</table>
	<center>
	<div class="box">
	<div style="background-color:#F2F2F2;width:200px;height:16px">Numar <a href="{$URL_ADMIN}abonati_newsletter.php">abonati</a> la newsletter: <b>{$nr_abonati}</b></div>
	<form action="{$URL_ADMIN}newsletter.php" method="POST">
		<table cellpadding="1" cellspacing="1" style="margin-top:5px">
			<tr><td align="left"><b>Titlu newsletter:</b></td></tr>
			<tr><td align="left"><input type="text" name="titlu_newsletter" value="{$titlu_newsletter}" size="104" maxlength="128"></td></tr>
			<tr><td align="left" valign="top" style="padding-top:5px"><b>Newsletter:</b></td></tr>
			<tr><td align="left"><textarea name="newsletter" rows="10" cols="103">{$text_newsletter}</textarea></td></tr>
		</table>
		{*--------------------------------------------------------AFISARE PRODUSE NEWSLETTER-----------------------------------------*}
		<table cellpadding="0" cellspacing="0" width="100%" style="margin-top:5px">
			{if $nume_chilipir neq ""}
				<tr>
					<td colspan="3" height="20" style="background-color:#FFCC00;color:#FFFFFF;padding-left:3px;text-align:left">
						<b>CHILIPIRUL ZILEI - IN FIECARE ZI UN PRODUS LA UN PRET SPECIAL, DOAR PT. O ZI</b>
					</td>
				</tr>
				<tr>
					<td colspan="3" style="background-color:#ECFCFF;padding:5px">
						<center>
						<table>
							<tr>
								<td><img src="{$poza_chilipir_afisare}" alt="" class="box"></td>
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
			<tr>
				<td colspan="3" height="20" style="background-color:#35BBFA;color:#FFFFFF;padding-left:3px;text-align:left;border-left:4px solid #FFFFFF;border-right:4px solid #FFFFFF">
					<b>VA MAI RECOMANDAM URMATOARELE PRODUSE</b>
				</td>
			</tr>																				
			{section name=tr_newsletter loop=$produse_newsletter step=3}
			<tr>	
				{section name=td_newsletter start=$smarty.section.tr_newsletter.index loop=$smarty.section.tr_newsletter.index+3}
				<td valign="top" align="center" width="33%">	
					{if $produse_newsletter[td_newsletter].nume_produs neq ""}	
						{*------------------------------------------------NUME PRODUS------------------------------------------------*}
						<div style="margin-top:5px;height:30px;display:table;text-align:center">
							<a href="{$produse_newsletter[td_newsletter].link_produs}" title="{$produse_newsletter[td_newsletter].nume_produs}" class="produse" style="font-size:10px">
								{$produse_newsletter[td_newsletter].nume_produs}
							</a>																		
						</div>							
						{*----------------------------------------------------END----------------------------------------------------*}
						<table cellpadding="2" class="box">
							<tr>
								<td class="margine_poza"></td>
								<td width="95" height="75" align="center">
									<a href="{$produse_newsletter[td_newsletter].link_produs}" title="{$produse_newsletter[td_newsletter].nume_produs}" class="produse">
										<img src="{$produse_newsletter[td_newsletter].adresa_poza_produs_afisare}" alt="{$produse_newsletter[td_newsletter].nume_produs}">
									</a>
								</td>							
							</tr>
						</table>
						{*----------------------------------------------------PRET---------------------------------------------------*}
						<div style="margin-bottom:5px;height:35px" class="pret">
							Pret cu TVA <br />
							{if $produse_newsletter[td_newsletter].pret_vechi neq ""}<font class="pret_vechi">{$produse_newsletter[td_newsletter].pret_vechi} {$MONEDA}</font><br />{/if}
							<b>{$produse_newsletter[td_newsletter].pret_produs} {$MONEDA}</b>	
						</div>
						<input type="button" value="STERGE" class="buton_anuleaza" style="width:80px" 
												onClick="casutaConfirmare('Sunteti sigur ca doriti sa stergeti
																		   <br />produsul din newsletter?', '400',
																		  '{$URL_ADMIN}newsletter.php?actiune=sterge&id_produs={$produse_newsletter[td_newsletter].id_produs}')">
						{*-----------------------------------------------------END---------------------------------------------------*}					
					{/if}												
				</td>			
				{/section}			
			</tr>
			{if !$smarty.section.tr_newsletter.last}
			<tr><td colspan="3" height="10"></td></tr>
			{/if}
			{sectionelse}
			<tr><td colspan="3" align="center">Nu sunt produse selectate in newsletter!</td></tr>
			{/section}	
			<tr><td colspan="3" height="10"></td></tr>
			<tr>
				<td colspan="2" align="center" class="bg_spatiu" style="padding:5px">					
					<input type="submit" name="salveaza_newsletter" value="SALVEAZA NEWSLETTER" class="buton" style="width:160px">
					&nbsp;
					<input type="button" value="PREVIEW NEWSLETTER" class="buton_cool" style="width:160px" onClick="NewWindow('{$URL_ADMIN}preview_newsletter.php', '', '650', '650', 'yes')">
				</td>
				<td class="bg_spatiu">
				{section name=sec loop=$butoane_send}
					<input type="submit" name="trimite_newsletter" value=" TRIMITE NEWSLETTER {$butoane_send[sec].nume_buton}" {$butoane_send[sec].status} class="buton_cool" style="width:190px;text-align:left;margin:2px"><br />
				{/section}	
				</td>
			</tr>	
		</table>
		{*------------------------------------------------------END AFISARE PRODUSE NEWSLETTER-------------------------------------*}
	</form>	
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