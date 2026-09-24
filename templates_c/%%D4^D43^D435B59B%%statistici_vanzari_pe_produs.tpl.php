<?php /* Smarty version 2.6.12, created on 2013-02-07 23:02:26
         compiled from admin/statistici_vanzari_pe_produs.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'admin/statistici_vanzari_pe_produs.tpl', 32, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/top.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/left.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  echo '<td valign="top" align="left" width="568"><table style="margin-left:6px;margin-right:6px;" cellpadding="0" cellspacing="0" width="557"><tr><td>';  echo '';  if ($this->_tpl_vars['mesaj'] != ""):  echo '';  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/mesaj.tpl", 'smarty_include_vars' => array('mesaj' => $this->_tpl_vars['mesaj'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  echo '';  endif;  echo '';  echo '<table cellpadding="3" cellspacing="1"><tr><td colspan="4" class="menu_title" style="background:url(';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img/bg_menu.gif);border-top:1px solid #F2F2F2;border-left:1px solid #F2F2F2;border-right:1px solid #F2F2F2;"><h2>Statistici vanzari pe produs</h2></td></tr></table>';  echo '<ul><li>In aceasta sectiune aveti posibilitatea de a vizualiza grafic evolutia comenzilor pentru un produs.</li><li>ATENTIE: Zilele in care nu au fost vanzari nu apar in grafic.</li></ul>';  echo '<form action="';  echo $this->_tpl_vars['URL_ADMIN'];  echo 'statistici_vanzari_pe_produs.php" method="POST"><table bgcolor="#EFEFEF" width="100%"><tr><td align="left">Afiseaza situatie din anul: <input type="text" name="an" size="4" value="';  echo $this->_tpl_vars['an_selectat'];  echo '"> luna: &nbsp;<select name="luna" class="select"><option value="0">--Toate lunile--</option>';  echo smarty_function_html_options(array('options' => $this->_tpl_vars['luni'],'selected' => $this->_tpl_vars['luna_selectata']), $this); echo '</select>&nbsp;pt. produs cu id: <input type="text" name="id_produs" value="';  echo $this->_tpl_vars['id_produs'];  echo '" size="3">&nbsp;<input type="submit" value="AFISEAZA" class="buton_cool" style="width:70px"></td></tr></table></form><br />';  if ($this->_tpl_vars['id_produs'] != ""):  echo '<font class="titlu"><b>';  echo $this->_tpl_vars['nume_produs'];  echo '</b></font><br /><br /><iframe src="';  echo $this->_tpl_vars['URL_ADMIN'];  echo 'statistici_incasari_pe_produs_grafic.php?an=';  echo $this->_tpl_vars['an_selectat'];  echo '&luna=';  echo $this->_tpl_vars['luna_selectata'];  echo '&id_produs=';  echo $this->_tpl_vars['id_produs'];  echo '" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" width="471" height="130"></iframe><br /><iframe src="';  echo $this->_tpl_vars['URL_ADMIN'];  echo 'statistici_vanzari_pe_produs_grafic.php?an=';  echo $this->_tpl_vars['an_selectat'];  echo '&luna=';  echo $this->_tpl_vars['luna_selectata'];  echo '&id_produs=';  echo $this->_tpl_vars['id_produs'];  echo '" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" width="471" height="130"></iframe>';  endif;  echo '<p align="center"><a href="';  echo $this->_tpl_vars['link_inapoi'];  echo '" class="link_default">&laquo; Inapoi</a></p><p align="right"><a href="#top"><img src="';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img/top.gif" alt="top"></a> &nbsp;</p></td></tr></table></td>'; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/right.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/bottom.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>