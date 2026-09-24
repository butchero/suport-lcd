<?php /* Smarty version 2.6.12, created on 2013-01-30 20:47:31
         compiled from admin/editare_texte.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'upper', 'admin/editare_texte.tpl', 35, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/top.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/left.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  echo '<td valign="top" align="left" width="568"><script language="javascript" type="text/javascript" src="';  echo $this->_tpl_vars['URL_BASE'];  echo 'javascript/tinymce/jscripts/tiny_mce/tiny_mce.js"></script><script language="javascript" type="text/javascript">var url_css="';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'tinymce.css"</script>';  echo '
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
	';  echo '<table style="margin-left:6px;margin-right:6px;" cellpadding="0" cellspacing="0" width="557"><tr><td>';  echo '';  if ($this->_tpl_vars['mesaj'] != ""):  echo '';  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/mesaj.tpl", 'smarty_include_vars' => array('mesaj' => $this->_tpl_vars['mesaj'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  echo '';  endif;  echo '';  echo '<table cellpadding="3" cellspacing="1"><tr><td colspan="4" class="menu_title" style="background:url(';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img/bg_menu.gif);border-top:1px solid #F2F2F2;border-left:1px solid #F2F2F2;border-right:1px solid #F2F2F2;"><h2>Editeaza pagina <font class="titlu_cat">';  echo ((is_array($_tmp=$this->_tpl_vars['titlu'])) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp));  echo '</font></h2></td></tr></table>';  echo '<ul><li>In aceasta sectiune aveti posibilitatea de a adauga/modifica textul unei pagini statice.</li><li>Este recomandat sa nu dati copy/paste din word sau alte editoare de text deoarece textul va fi introdus cu fonturile din word si nu va fi formatat corect.</li><li>Daca aveti text in word la care doriti sa dati copy/paste va recomandam sa dati mai intai copy/paste in notepad pentru a pierde formatarea si apoi copy/paste in acest editor.</li><li>Pentru un rand nou apasati SHIFT+ENTER, in caz contrar ENTER simplu va genera un nou paragraf.</li><li>Pentru colorarea textului va recomanda stilurile din "STYLES" a.i. sa mentineti gama de coloristica a site-ului cu cea din design.</li><li>ATENTIE: Pagina nu poate fi stearsa, doar salvata</li></ul>';  echo '<form action="" method="POST"><table><tr><td><textarea rows="30" cols="103" name="text">';  echo $this->_tpl_vars['text'];  echo '</textarea></td></tr><tr><td align="center"><input type="submit" name="salveaza" value="SALVEAZA" class="buton" style="width:130px">&nbsp;<input type="reset" value="RESETEAZA" class="buton_anuleaza" style="width:130px"></td></tr></table></form><p align="center"><a href="';  echo $this->_tpl_vars['link_inapoi'];  echo '" class="link_default">&laquo; Inapoi</a></p><p align="right"><a href="#top"><img src="';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img/top.gif" alt="top"></a> &nbsp;</p></td></tr></table></td>'; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/right.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/bottom.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>