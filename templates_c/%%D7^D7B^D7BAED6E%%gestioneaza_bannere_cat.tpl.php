<?php /* Smarty version 2.6.12, created on 2017-10-04 12:42:53
         compiled from admin/gestioneaza_bannere_cat.tpl */ ?>
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
  echo '';  endif;  echo '';  echo '<table cellpadding="3" cellspacing="1"><tr><td colspan="4" class="menu_title" style="background:url(';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img/bg_menu.gif);border-top:1px solid #F2F2F2;border-left:1px solid #F2F2F2;border-right:1px solid #F2F2F2;"><h2>Gestioneaza bannere &raquo; ';  echo $this->_tpl_vars['nume_cat_bannere'];  echo '</h2></td></tr></table>';  echo '<ul><li>In aceasta sectiune aveti posibilitatea de a gestiona bannerele din categoria selectata.</li><li>ATENTIE: Pentru a functiona corect, suma ratelor de aparitie a bannerelor trebuie sa fie intotdeauna 100%!</li></ul>';  echo '<form action="';  echo $this->_tpl_vars['URL_ADMIN'];  echo 'gestioneaza_bannere_cat.php?cat=';  echo $this->_tpl_vars['cat'];  echo '" method="POST" enctype="multipart/form-data"><table bgcolor="#EFEFEF" width="100%"><tr><td>Nume banner:</td><td><input type="text" name="nume_banner" size="30"> ex: HDD Samsung 400GB</td></tr><tr><td>Link banner:</td><td><input type="text" name="link_banner" size="30"> ex: ';  echo $this->_tpl_vars['URL_BASE'];  echo 'cat/produs--1</td></tr><tr><td>Rata aparitie:</td><td><input type="text" name="rata_aparitie" size="3" maxlength="3">%</td></tr><tr><td>Upload banner:</td><td><input type="file" name="banner" size="40"></td></tr><tr><td></td><td><input type="submit" name="adauga_banner" value="ADAUGA BANNER" class="buton_cool" style="width:120px"></td></tr></table></form><p>&nbsp;<b>Afisare bannere existente:</b></p><table class="box" width="100%">';  unset($this->_sections['sec']);
$this->_sections['sec']['name'] = 'sec';
$this->_sections['sec']['loop'] = is_array($_loop=$this->_tpl_vars['bannere']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
 echo '<tr><td colspan="2"><img src="';  echo $this->_tpl_vars['URL_BASE'];  echo 'bannere_cat/';  echo $this->_tpl_vars['bannere'][$this->_sections['sec']['index']]['fisier'];  echo '?';  echo $this->_tpl_vars['timestamp'];  echo '" alt=""></td></tr><tr><td width="170"><form action="';  echo $this->_tpl_vars['URL_ADMIN'];  echo 'gestioneaza_bannere_cat.php?cat=';  echo $this->_tpl_vars['cat'];  echo '" method="POST" enctype="multipart/form-data">Nume banner:</td><td><input type="text" name="nume_banner" value="';  echo $this->_tpl_vars['bannere'][$this->_sections['sec']['index']]['nume_banner'];  echo '" size="40"></td></tr><tr><td>Link banner:</td><td><input type="text" name="link_banner" value="';  echo $this->_tpl_vars['bannere'][$this->_sections['sec']['index']]['link_banner'];  echo '" size="40"></td></tr><tr><td>Rata aparitie:</td><td><input type="text" name="rata_aparitie" value="';  echo $this->_tpl_vars['bannere'][$this->_sections['sec']['index']]['rata_aparitie'];  echo '" size="3" maxlength="3">%</td></tr><tr><td>Upload banner nou:</td><td><input type="file" name="banner" size="40"></td></tr><tr><td></td><td><input type="submit" name="modifica_banner" value="MODIFICA BANNER" class="buton" style="width:130px">&nbsp;<input type="button" value="STERGE BANNER" class="buton_anuleaza" style="width:130px"onClick="casutaConfirmare(\'Sunteti sigur ca doriti sa stergeti bannerul?<br /><b>';  echo $this->_tpl_vars['bannere'][$this->_sections['sec']['index']]['nume_banner'];  echo '</b>?\', \'400\',\'';  echo $this->_tpl_vars['URL_ADMIN'];  echo 'gestioneaza_bannere_cat.php?cat=';  echo $this->_tpl_vars['cat'];  echo '&id_banner=';  echo $this->_tpl_vars['bannere'][$this->_sections['sec']['index']]['id_banner'];  echo '&actiune=sterge\')"><input type="hidden" name="id_banner" value="';  echo $this->_tpl_vars['bannere'][$this->_sections['sec']['index']]['id_banner'];  echo '"></form></td></tr>';  endfor; else:  echo '<tr><td></td><td>Nu exista bannere uploadate pentru aceasta categorie!</td></tr>';  endif;  echo '</table><p align="center"><a href="';  echo $this->_tpl_vars['link_inapoi'];  echo '" class="link_default">&laquo; Inapoi</a></p><p align="right"><a href="#top"><img src="';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img/top.gif" alt="top"></a> &nbsp;</p></td></tr></table></td>'; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/right.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/bottom.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>