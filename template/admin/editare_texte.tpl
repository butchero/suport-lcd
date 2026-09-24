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
		<tr><td>		
	{*-------------------------------------------------------------------MESAJE----------------------------------------------------*}
	{if $mesaj neq ""}
		{include file="admin/mesaj.tpl" mesaj=$mesaj}
	{/if}
	{*--------------------------------------------------------------------END------------------------------------------------------*}
	<table cellpadding="3" cellspacing="1">
		<tr>
			<td colspan="4" class="menu_title" style="background:url({$DIR_TEMPLATE}img/bg_menu.gif);border-top:1px solid #F2F2F2;border-left:1px solid #F2F2F2;border-right:1px solid #F2F2F2;">
				<h2>Editeaza pagina <font class="titlu_cat">{$titlu|upper}</font></h2>
			</td>
		</tr>
	</table>	
	{*-----------------------------------------------------------INSTRUCTIUNI UTILIZARE---------------------------------------------*}
	<ul>
		<li>In aceasta sectiune aveti posibilitatea de a adauga/modifica textul unei pagini statice.</li>
		<li>Este recomandat sa nu dati copy/paste din word sau alte editoare de text deoarece textul va fi introdus cu fonturile din word si nu va fi formatat corect.</li>
		<li>Daca aveti text in word la care doriti sa dati copy/paste va recomandam sa dati mai intai copy/paste in notepad pentru a pierde formatarea si apoi copy/paste in acest editor.</li>
		<li>Pentru un rand nou apasati SHIFT+ENTER, in caz contrar ENTER simplu va genera un nou paragraf.</li>
		<li>Pentru colorarea textului va recomanda stilurile din "STYLES" a.i. sa mentineti gama de coloristica a site-ului cu cea din design.</li>
		<li>ATENTIE: Pagina nu poate fi stearsa, doar salvata</li>
	</ul>
	{*--------------------------------------------------------------------END------------------------------------------------------*}		
	<form action="" method="POST">
	<table>
		<tr><td><textarea rows="30" cols="103" name="text">{$text}</textarea></td></tr>
		<tr>
			<td align="center">
				<input type="submit" name="salveaza" value="SALVEAZA" class="buton" style="width:130px">
				&nbsp;
				<input type="reset" value="RESETEAZA" class="buton_anuleaza" style="width:130px">
			</td>
		</tr>
	</table>
	</form>
	<p align="center"><a href="{$link_inapoi}" class="link_default">&laquo; Inapoi</a></p>	
	<p align="right"><a href="#top"><img src="{$DIR_TEMPLATE}img/top.gif" alt="top"></a> &nbsp;</p>
			</td>
		</tr>
	</table>
</td>
{/strip}
{include file="admin/right.tpl"}
{include file="admin/bottom.tpl"}