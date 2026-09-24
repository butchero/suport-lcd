<?php /* Smarty version 2.6.12, created on 2013-01-30 19:21:05
         compiled from admin/gestioneaza_filtre.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'upper', 'admin/gestioneaza_filtre.tpl', 17, false),)), $this); ?>
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
  echo '';  endif;  echo '';  echo '';  echo '<table cellpadding="0" cellspacing="0" class="menu_container" style="background:url(';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img/bg_menu.gif);border-top:1px solid #F2F2F2;border-left:1px solid #F2F2F2;border-right:1px solid #F2F2F2;"><tr><td align="left" class="menu_title" height="18" style="padding-left:2px;padding-right:2px"><h2>Gestioneaza filtre pentru categoria <font class="titlu_cat">';  echo ((is_array($_tmp=$this->_tpl_vars['nume_cat'])) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp));  echo '</font></h2></td></tr></table><table cellpadding="5" cellspacing="0" class="box" width="557"><tr>';  echo '<td><ul><li>In aceasta pagina aveti posibilitatea de seta caracteristicile unei categorii.Toate produsele care vor fi adaugate in aceasta categorie vor avea caracteristicile categoriei.</li><li>Caracteristicile pot fi definite si ca filtre.</li><li>ATENTIE: O carac. definita doar pe categoria curenta nu si pe subcategoriile ei!</li><li>ATENTIE: In momentul cand se modifica/sterge valoarea unei caracteristici, modificarea va afecta toate produsele care o folosesc!</li><li>ATENTIE: Nu afisati mai mult de 3-4 filtre pe o categorie, deoarece nu vor avea loc la afisare!</li></ul></td></tr>';  echo '';  echo '<tr><td>';  echo '<form action="';  echo $this->_tpl_vars['URL_ADMIN'];  echo 'gestioneaza_filtre.php?cat=';  echo $this->_tpl_vars['id_cat'];  echo '" method="POST"><table cellpadding="1" cellspacing="1" width="100%"><tr><td colspan="2" height="20"><table width="100%" cellpadding="0" cellspacing="0"><tr><td><b>Adauga caracteristica(filtru) noua/nou</b></td><td align="right"><a href="';  echo $this->_tpl_vars['link_inapoi'];  echo '" class="link_default">&laquo; Inapoi</a></td></tr></table></td></tr><tr><td colspan="2" height="1"></td></tr><tr><td colspan="2">Caracteristica: <input type="text" name="nume_filtru_nou" value="';  echo $this->_tpl_vars['nume_filtru_nou'];  echo '" size="30"> - <input name="este_filtru" type="checkbox" ';  if ($this->_tpl_vars['este_filtru'] == '1'):  echo 'checked';  endif;  echo ' style="margin:0px;padding:0px"> este filtru</td></tr>';  unset($this->_sections['sec']);
$this->_sections['sec']['name'] = 'sec';
$this->_sections['sec']['loop'] = is_array($_loop=$this->_tpl_vars['valori']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
 echo '<tr><td width="85"></td><td>Valoare: <input type="text" name="valori[]" value="';  echo $this->_tpl_vars['valori'][$this->_sections['sec']['index']];  echo '" size="30"></td></tr>';  endfor; endif;  echo '';  if ($this->_sections['sec']['total'] == 0):  echo '<tr><td width="85"></td><td>Valoare: <input type="text" name="valori[]" value="';  echo $this->_tpl_vars['valori'][$this->_sections['sec']['index']];  echo '" size="30"></td></tr>';  endif;  echo '<tr><td width="85">&nbsp;</td><td width="450" align="left"><input type="submit" name="increment" value="+" class="buton_simplu" style="width:20px"> <input type="submit" name="decrement" value="-" class="buton_simplu" style="width:20px"></td></tr><tr><td colspan="2" height="1"></td></tr><tr><td colspan="3" align="center" class="bg_spatiu"><input type="submit" name="adauga_filtru_nou" value="ADAUGA" class="buton_cool" style="width:100px"></td></tr><tr><td colspan="2" height="2"><input type="hidden" name="id_filtru" value=""></td></tr></table></form>';  echo '';  echo '<table cellpadding="1" cellspacing="1" width="100%"><tr><td height="20"><b>Caracteristici(filtre)</b> - <font class="eroare_text">(valorile pot doar fi litere, numere, spatii, paranteze rotunde, punct, virgula si doua puncte)</font></td></tr></table>';  unset($this->_sections['sec']);
$this->_sections['sec']['name'] = 'sec';
$this->_sections['sec']['loop'] = is_array($_loop=$this->_tpl_vars['filtre']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
 echo '<form action="';  echo $this->_tpl_vars['URL_ADMIN'];  echo 'gestioneaza_filtre.php?cat=';  echo $this->_tpl_vars['id_cat'];  echo '" method="POST" id="formular_';  echo $this->_tpl_vars['filtre'][$this->_sections['sec']['index']]['id_filtru'];  echo '" name="formular_';  echo $this->_tpl_vars['filtre'][$this->_sections['sec']['index']]['id_filtru'];  echo '"><table cellpadding="1" cellspacing="1" width="100%"><tr><td colspan="2" height="1"></td></tr><tr><td colspan="2"><table cellpadding="0" cellspacing="0"><tr><td>Caracteristica: <input type="text" name="nume_filtru" value="';  echo $this->_tpl_vars['filtre'][$this->_sections['sec']['index']]['nume_filtru'];  echo '" size="30"> - <input name="este_filtru" type="checkbox" ';  if ($this->_tpl_vars['filtre'][$this->_sections['sec']['index']]['afiseaza_filtru'] == '1'):  echo 'checked';  endif;  echo ' style="padding:0px;margin:0px"> este filtru</td><td width="10"></td><td align="right"><input type="submit" name="modifica" value="MODIFICA" class="buton_simplu"></td></tr></table></td></tr>';  unset($this->_sections['subsec']);
$this->_sections['subsec']['name'] = 'subsec';
$this->_sections['subsec']['loop'] = is_array($_loop=$this->_tpl_vars['filtre'][$this->_sections['sec']['index']]['valori_posibile']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['subsec']['show'] = true;
$this->_sections['subsec']['max'] = $this->_sections['subsec']['loop'];
$this->_sections['subsec']['step'] = 1;
$this->_sections['subsec']['start'] = $this->_sections['subsec']['step'] > 0 ? 0 : $this->_sections['subsec']['loop']-1;
if ($this->_sections['subsec']['show']) {
    $this->_sections['subsec']['total'] = $this->_sections['subsec']['loop'];
    if ($this->_sections['subsec']['total'] == 0)
        $this->_sections['subsec']['show'] = false;
} else
    $this->_sections['subsec']['total'] = 0;
if ($this->_sections['subsec']['show']):

            for ($this->_sections['subsec']['index'] = $this->_sections['subsec']['start'], $this->_sections['subsec']['iteration'] = 1;
                 $this->_sections['subsec']['iteration'] <= $this->_sections['subsec']['total'];
                 $this->_sections['subsec']['index'] += $this->_sections['subsec']['step'], $this->_sections['subsec']['iteration']++):
$this->_sections['subsec']['rownum'] = $this->_sections['subsec']['iteration'];
$this->_sections['subsec']['index_prev'] = $this->_sections['subsec']['index'] - $this->_sections['subsec']['step'];
$this->_sections['subsec']['index_next'] = $this->_sections['subsec']['index'] + $this->_sections['subsec']['step'];
$this->_sections['subsec']['first']      = ($this->_sections['subsec']['iteration'] == 1);
$this->_sections['subsec']['last']       = ($this->_sections['subsec']['iteration'] == $this->_sections['subsec']['total']);
 echo '<tr><td width="85"></td><td>Valoare: <input type="text" name="valori_posibile[]" value="';  echo $this->_tpl_vars['filtre'][$this->_sections['sec']['index']]['valori_posibile'][$this->_sections['subsec']['index']];  echo '" size="30">&nbsp;<a href="#" onClick="submitForm(\'';  echo $this->_tpl_vars['URL_ADMIN'];  echo 'gestioneaza_filtre.php?cat=';  echo $this->_tpl_vars['id_cat'];  echo '&id_val=';  echo $this->_sections['subsec']['index'];  echo '&id_filtru=';  echo $this->_tpl_vars['filtre'][$this->_sections['sec']['index']]['id_filtru'];  echo '&actiune=modifica\', \'formular_';  echo $this->_tpl_vars['filtre'][$this->_sections['sec']['index']]['id_filtru'];  echo '\')" class="link_default">modifica valoare</a> -&nbsp;<a href="';  echo $this->_tpl_vars['URL_ADMIN'];  echo 'gestioneaza_filtre.php?cat=';  echo $this->_tpl_vars['id_cat'];  echo '&id_val=';  echo $this->_sections['subsec']['index'];  echo '&id_filtru=';  echo $this->_tpl_vars['filtre'][$this->_sections['sec']['index']]['id_filtru'];  echo '&actiune=sterge" class="link_cool">sterge valoare</a></td></tr>';  endfor; endif;  echo '<tr><td></td><td><div id="';  echo $this->_tpl_vars['filtre'][$this->_sections['sec']['index']]['id_filtru'];  echo '"><a href="#" class="link_default" title="Adauga valoare noua" onclick="addValoareFiltru(\'';  echo $this->_tpl_vars['filtre'][$this->_sections['sec']['index']]['id_filtru'];  echo '\'); return false;"><b>[+] ADAUGA VALOARE NOUA</b></a></div></td></tr><tr><td colspan="2" height="2"></td></tr><tr><td colspan="3" align="center" class="bg_spatiu"><input type="submit" name="salveaza" value="SALVEAZA" class="buton_cool" style="width:100px">&nbsp;<input type="submit" name="sterge" value="STERGE" class="buton_anuleaza" style="width:100px"></td></tr><tr><td colspan="2" height="2"><input type="hidden" name="id_filtru" value="';  echo $this->_tpl_vars['filtre'][$this->_sections['sec']['index']]['id_filtru'];  echo '"></td></tr><tr><td colspan="2"></td></tr></table></form>';  endfor; endif;  echo '</td></tr></table><p align="center"><a href="';  echo $this->_tpl_vars['link_inapoi'];  echo '" class="link_default">&laquo; Inapoi</a></p><p align="right"><a href="#top"><img src="';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img/top.gif" alt="top"></a></p></td></tr></table></td>'; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/right.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/bottom.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>