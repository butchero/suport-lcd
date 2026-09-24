<?php /* Smarty version 2.6.12, created on 2013-01-30 18:26:28
         compiled from admin/index.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/top.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/left.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  echo '<td valign="top" align="left" width="570"><table style="margin-left:6px;margin-right:6px;" cellpadding="0" cellspacing="0" width="557"><tr><td>';  echo '';  if ($this->_tpl_vars['mesaj'] != ""):  echo '';  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/mesaj.tpl", 'smarty_include_vars' => array('mesaj' => $this->_tpl_vars['mesaj'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  echo '';  endif;  echo '';  echo '<table cellpadding="0" cellspacing="0" class="menu_container" style="background:url(';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img/bg_menu.gif);border-top:1px solid #F2F2F2;border-left:1px solid #F2F2F2;border-right:1px solid #F2F2F2;"><tr><td align="left" class="menu_title" height="18" style="padding-left:2px;padding-right:2px"><h2>Administrare site</h2></td></tr></table><table cellpadding="5" cellspacing="0" class="box" width="557"><tr>';  echo '<td><p><b>Downlodeaza lista produse:</b></p><ul>';  unset($this->_sections['sec']);
$this->_sections['sec']['name'] = 'sec';
$this->_sections['sec']['loop'] = is_array($_loop=$this->_tpl_vars['disponibilitati']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['sec']['show'] = true;
$this->_sections['sec']['max'] = $this->_sections['sec']['loop'];
$this->_sections['sec']['step'] = 1;
$this->_sections['sec']['start'] = $this->_sections['sec']['step'] > 0 ? 0 : $this->_sections['sec']['loop']-1;
if ($this->_sections['sec']['show']) {
    $this->_sections['sec']['total'] = $this->_sections['sec']['loop'];
    if ($this->_sections['sec']['total'] == 0)
        $this->_sections['sec']['show'] = false;
} else
    $this->_sections['sec']['total'] = 0;
if ($this->_sections['sec']['show']):

            for ($this->_sections['sec']['index'] = $this->_sections['sec']['start'], $this->_sections['sec']['iteration'] = 1;
                 $this->_sections['sec']['iteration'] <= $this->_sections['sec']['total'];
                 $this->_sections['sec']['index'] += $this->_sections['sec']['step'], $this->_sections['sec']['iteration']++):
$this->_sections['sec']['rownum'] = $this->_sections['sec']['iteration'];
$this->_sections['sec']['index_prev'] = $this->_sections['sec']['index'] - $this->_sections['sec']['step'];
$this->_sections['sec']['index_next'] = $this->_sections['sec']['index'] + $this->_sections['sec']['step'];
$this->_sections['sec']['first']      = ($this->_sections['sec']['iteration'] == 1);
$this->_sections['sec']['last']       = ($this->_sections['sec']['iteration'] == $this->_sections['sec']['total']);
 echo '<li><a href="';  echo $this->_tpl_vars['URL_BASE'];  echo 'oferta_excel.php?id_disponibilitate=';  echo $this->_tpl_vars['disponibilitati'][$this->_sections['sec']['index']]['id_stoc'];  echo '" title="Click pentru a downloada excelul cu produse \'';  echo $this->_tpl_vars['disponibilitati'][$this->_sections['sec']['index']]['stoc'];  echo '\'">Downloadeaza produse <b>"';  echo $this->_tpl_vars['disponibilitati'][$this->_sections['sec']['index']]['stoc'];  echo '"</b> - (';  echo $this->_tpl_vars['disponibilitati'][$this->_sections['sec']['index']]['nr_produse'];  echo ')</a></li>';  endfor; endif;  echo '</ul><table bgcolor="#EFEFEF" width="100%"><tr><td align="center">Ponderea produselor in categorii (cate produse sunt in fiecare categorie procentual)</td></tr></table><center><img src="';  echo $this->_tpl_vars['URL_ADMIN'];  echo 'pondere_produse_in_categorii.php" alt="Pondere produse in categorii"></center></td></tr></table></tr></tr></table></td>'; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/right.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/bottom.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>