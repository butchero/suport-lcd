<?php /* Smarty version 2.6.12, created on 2013-01-30 19:23:21
         compiled from admin/gestioneaza_produse.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'upper', 'admin/gestioneaza_produse.tpl', 17, false),array('function', 'html_options', 'admin/gestioneaza_produse.tpl', 69, false),array('block', 'repeat', 'admin/gestioneaza_produse.tpl', 169, false),)), $this); ?>
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
  echo '';  endif;  echo '';  echo '';  echo '<table cellpadding="0" cellspacing="0" class="menu_container" style="background:url(';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img/bg_menu.gif);border-top:1px solid #F2F2F2;border-left:1px solid #F2F2F2;border-right:1px solid #F2F2F2;"><tr><td align="left" class="menu_title" height="18" style="padding-left:2px;padding-right:2px"><h2>';  if ($this->_tpl_vars['id_produs'] != ""):  echo 'Editeaza';  else:  echo 'Adauga';  endif;  echo ' produs in categoria <font class="titlu_cat">';  echo ((is_array($_tmp=$this->_tpl_vars['nume_cat'])) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp));  echo '</font></h2></td></tr></table><table cellpadding="5" cellspacing="0" class="box" width="557">';  echo '<tr><td><ul><li>In aceasta pagina aveti posibilitatea de a ';  if ($this->_tpl_vars['id_produs'] != ""):  echo 'edita un produs existent';  else:  echo 'adauga un produs nou';  endif;  echo '. <br />Produsul va avea caracteristicile categoriei. Alte caracteristici suplimentare sau detalii tehnice le puteti adauga la descrierea generala</li><li>ATENTIE: Produsele cu optiunea "nu e pe stoc" nu vor putea fi cumparate!</li><li>ATENTIE: Daca poza uplodata este prea mica ea va fi marita automat si va arata deformat. Este recomandat sa uploadati poze >= 600x600pixeli!</li><li>ATENTIE: Puteti adauga maxim 8 poze secundare si una principala!</li></ul></td></tr>';  echo '';  echo '<tr><td><form action="';  echo $this->_tpl_vars['URL_ADMIN'];  echo 'gestioneaza_produse.php?';  if ($this->_tpl_vars['string'] != ""):  echo 'string=';  echo $this->_tpl_vars['string'];  echo '';  else:  echo 'cat=';  echo $this->_tpl_vars['id_cat'];  echo '';  endif;  echo '';  if ($this->_tpl_vars['id_produs'] != ""):  echo '&id_produs=';  echo $this->_tpl_vars['id_produs'];  echo '';  endif;  echo '" method="POST" enctype="multipart/form-data"><table cellpadding="2" cellspacing="1" width="557"><tr><td colspan="2" height="20"><b>';  if ($this->_tpl_vars['id_produs'] != ""):  echo 'Editeaza produs';  else:  echo 'Adauga produs';  endif;  echo '</td><td align="right"><a href="';  echo $this->_tpl_vars['link_inapoi'];  echo '" class="link_default">&laquo; Inapoi</a></td></tr><tr><td colspan="3" height="1"></td></tr><tr><td width="250" height="20" ';  if ($this->_tpl_vars['nume_produs_check']['valid'] == '0'):  echo 'class="eroare_text"';  endif;  echo '>Nume*:</td><td width="180"><input type="text" name="nume_produs" size="50" value="';  echo $this->_tpl_vars['nume_produs_check']['camp'];  echo '" ';  if ($this->_tpl_vars['nume_produs_check']['valid'] == '0'):  echo 'class="eroare_bg"';  endif;  echo ' maxlength="128"></td><td class="eroare_form" width="150">';  echo $this->_tpl_vars['nume_produs_check']['eroare'];  echo '';  if ($this->_tpl_vars['nume_produs_check']['eroare'] == "" && $this->_tpl_vars['form_submit'] == '1'):  echo '<img src="';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img/ok.gif" alt="">';  endif;  echo '</td></tr><tr><td height="20" ';  if ($this->_tpl_vars['cod_produs_check']['valid'] == '0'):  echo 'class="eroare_text"';  endif;  echo '>Cod produs:</td><td><input type="text" name="cod_produs" value="';  echo $this->_tpl_vars['cod_produs_check']['camp'];  echo '" ';  if ($this->_tpl_vars['cod_produs_check']['valid'] == '0'):  echo 'class="eroare_bg"';  endif;  echo ' size="16" maxlength="16"></td><td class="eroare_form">';  echo $this->_tpl_vars['cod_produs_check']['eroare'];  echo '';  if ($this->_tpl_vars['cod_produs_check']['eroare'] == "" && $this->_tpl_vars['form_submit'] == '1'):  echo '<img src="';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img/ok.gif" alt="">';  endif;  echo '</td></tr><tr><td height="20" colspan="3"><b>Producator:</b></td></tr><tr><td height="20">Alege:</td><td><select name="producator" class="select" style="width:150px"><option value="0">--Alege--</option>';  echo smarty_function_html_options(array('options' => $this->_tpl_vars['producatori'],'selected' => $this->_tpl_vars['producator_selectat']), $this); echo '</select></td><td></td></tr><tr><td height="20" colspan="3"><b>Furnizor:</b></td></tr><tr><td height="20">Furnizor:</td><td><input type="text" name="furnizor" value="';  echo $this->_tpl_vars['furnizor'];  echo '" size="50"></td><td></td></tr><tr><td height="20" colspan="3"><b>Pret:</b></td></tr><tr><td height="20" ';  if ($this->_tpl_vars['pret_check']['valid'] == '0'):  echo 'class="eroare_text"';  endif;  echo '>Pret produs*:</td><td><input type="text" name="pret" value="';  echo $this->_tpl_vars['pret_check']['camp'];  echo '" size="15" ';  if ($this->_tpl_vars['pret_check']['valid'] == '0'):  echo 'class="eroare_bg"';  endif;  echo '> <b>';  echo $this->_tpl_vars['MONEDA'];  echo '</b> ';  if ($this->_tpl_vars['TVA'] != 1):  echo 'fara';  else:  echo 'cu';  endif;  echo ' <b>TVA</b></td><td class="eroare_form">';  echo $this->_tpl_vars['pret_check']['eroare'];  echo '';  if ($this->_tpl_vars['pret_check']['eroare'] == "" && $this->_tpl_vars['form_submit'] == '1'):  echo '<img src="';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img/ok.gif" alt="">';  endif;  echo '</td></tr><tr><td height="20" ';  if ($this->_tpl_vars['pret_vechi_check']['valid'] == '0'):  echo 'class="eroare_text"';  endif;  echo '>Pret vechi:</td><td><input type="text" name="pret_vechi" value="';  echo $this->_tpl_vars['pret_vechi_check']['camp'];  echo '" size="15" ';  if ($this->_tpl_vars['pret_vechi_check']['valid'] == '0'):  echo 'class="eroare_bg"';  endif;  echo '> <b>';  echo $this->_tpl_vars['MONEDA'];  echo '</b> ';  if ($this->_tpl_vars['TVA'] != 1):  echo 'fara';  else:  echo 'cu';  endif;  echo ' <b>TVA</b></td><td class="eroare_form">';  echo $this->_tpl_vars['pret_vechi_check']['eroare'];  echo '';  if ($this->_tpl_vars['pret_vechi_check']['eroare'] == "" && $this->_tpl_vars['form_submit'] == '1' && $this->_tpl_vars['pret_vechi_check']['camp'] != ""):  echo '<img src="';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img/ok.gif" alt="">';  endif;  echo '</td></tr><tr><td height="20" colspan="3"><b>Caracteristici (filtre):</b></td></tr>';  unset($this->_sections['sec']);
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
 echo '<tr><td height="20">';  echo $this->_tpl_vars['filtre'][$this->_sections['sec']['index']]['nume_filtru'];  echo ':</td><td><select name="filtre[]" class="select" style="width:150px"><option value="-">--Alege--</option>';  echo smarty_function_html_options(array('options' => $this->_tpl_vars['filtre'][$this->_sections['sec']['index']]['valori_posibile'],'selected' => $this->_tpl_vars['filtre_selectate'][$this->_sections['sec']['index']]), $this); echo '</select>&nbsp; <input type="checkbox" ';  if ($this->_tpl_vars['filtre'][$this->_sections['sec']['index']]['afiseaza_filtru'] == '1'):  echo 'checked';  endif;  echo ' disabled style="padding:0px;margin:0px"> Filtru</td><td></td></tr>';  endfor; endif;  echo '';  if ($this->_sections['sec']['total'] == 0):  echo '<tr><td colspan="3" class="text_avertizare" style="padding:5px">- Nu sunt definite caracteristici pt. aceasta categorie. Este recomandat sa le definiti inainte sa adaugati produse!</td></tr>';  endif;  echo '<tr><td height="20"><b>Info stoc:</b></td><td></td><td></td></tr><tr><td height="20">Stoc:</td><td><select name="stoc" class="select" style="width:150px">';  echo smarty_function_html_options(array('options' => $this->_tpl_vars['stocuri'],'selected' => $this->_tpl_vars['stoc_selectat']), $this); echo '</select></td><td></td></tr><tr><td height="20" colspan="3"><b>Descriere generala:</b></td></tr><tr><td height="20" valign="top" style="padding-top:2px">Descriere:</td><td colspan="2"><textarea rows="10" cols="80" name="descriere_produs">';  echo $this->_tpl_vars['descriere_produs'];  echo '</textarea></td></tr><tr><td height="20" colspan="3"><b>Altele:</b></td></tr><tr><td height="20">Oferta speciala:</td><td colspan="2"><input type="radio" name="oferta_speciala" value="0" ';  if ($this->_tpl_vars['oferta_speciala'] != '1'):  echo 'checked';  endif;  echo '> Nu <input type="radio" name="oferta_speciala" value="1" ';  if ($this->_tpl_vars['oferta_speciala'] == '1'):  echo 'checked';  endif;  echo '> Da</td></tr><tr><td height="20" colspan="3"><b>Upload poze:</b> (se recomanda poze >= 600x600 pixeli si maxim 2MB dimensiune) <a name="poze"></a></td></tr><tr><td height="20" valign="top" style="padding-top:2px">Poza principala:</td><td colspan="2"><input type="file" name="poza_principala" size="58" class="bg_spatiu"> <br />';  if ($this->_tpl_vars['poza_principala'] != ""):  echo '<img src="';  echo $this->_tpl_vars['poza_principala'];  echo '?';  echo $this->_tpl_vars['timestamp'];  echo '" alt=""> <br />&nbsp;<a href="';  echo $this->_tpl_vars['URL_ADMIN'];  echo 'gestioneaza_produse.php?cat=';  echo $this->_tpl_vars['id_cat'];  echo '&id_produs=';  echo $this->_tpl_vars['id_produs'];  echo '&sterge_poza=0.jpg#poze" class="link_default">[sterge poza]</a>';  endif;  echo '</td></tr><tr><td height="20" valign="top" style="padding-top:2px">Poze:</td><td colspan="2">';  $this->_tag_stack[] = array('repeat', array('count' => $this->_tpl_vars['NR_POZE_DISPONIBILE'])); $_block_repeat=true;smarty_block_repeat($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start();  echo '<input type="file" name="poze[]" size="58"><br />';  $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_repeat($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack);  echo '<table cellpadding="2" cellspacing="0">';  unset($this->_sections['tr']);
$this->_sections['tr']['name'] = 'tr';
$this->_sections['tr']['loop'] = is_array($_loop=$this->_tpl_vars['poze_sec_medii']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['tr']['step'] = ((int)4) == 0 ? 1 : (int)4;
$this->_sections['tr']['show'] = true;
$this->_sections['tr']['max'] = $this->_sections['tr']['loop'];
$this->_sections['tr']['start'] = $this->_sections['tr']['step'] > 0 ? 0 : $this->_sections['tr']['loop']-1;
if ($this->_sections['tr']['show']) {
    $this->_sections['tr']['total'] = min(ceil(($this->_sections['tr']['step'] > 0 ? $this->_sections['tr']['loop'] - $this->_sections['tr']['start'] : $this->_sections['tr']['start']+1)/abs($this->_sections['tr']['step'])), $this->_sections['tr']['max']);
    if ($this->_sections['tr']['total'] == 0)
        $this->_sections['tr']['show'] = false;
} else
    $this->_sections['tr']['total'] = 0;
if ($this->_sections['tr']['show']):

            for ($this->_sections['tr']['index'] = $this->_sections['tr']['start'], $this->_sections['tr']['iteration'] = 1;
                 $this->_sections['tr']['iteration'] <= $this->_sections['tr']['total'];
                 $this->_sections['tr']['index'] += $this->_sections['tr']['step'], $this->_sections['tr']['iteration']++):
$this->_sections['tr']['rownum'] = $this->_sections['tr']['iteration'];
$this->_sections['tr']['index_prev'] = $this->_sections['tr']['index'] - $this->_sections['tr']['step'];
$this->_sections['tr']['index_next'] = $this->_sections['tr']['index'] + $this->_sections['tr']['step'];
$this->_sections['tr']['first']      = ($this->_sections['tr']['iteration'] == 1);
$this->_sections['tr']['last']       = ($this->_sections['tr']['iteration'] == $this->_sections['tr']['total']);
 echo '<tr>';  unset($this->_sections['td']);
$this->_sections['td']['name'] = 'td';
$this->_sections['td']['start'] = (int)$this->_sections['tr']['index'];
$this->_sections['td']['loop'] = is_array($_loop=$this->_sections['tr']['index']+4) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['td']['show'] = true;
$this->_sections['td']['max'] = $this->_sections['td']['loop'];
$this->_sections['td']['step'] = 1;
if ($this->_sections['td']['start'] < 0)
    $this->_sections['td']['start'] = max($this->_sections['td']['step'] > 0 ? 0 : -1, $this->_sections['td']['loop'] + $this->_sections['td']['start']);
else
    $this->_sections['td']['start'] = min($this->_sections['td']['start'], $this->_sections['td']['step'] > 0 ? $this->_sections['td']['loop'] : $this->_sections['td']['loop']-1);
if ($this->_sections['td']['show']) {
    $this->_sections['td']['total'] = min(ceil(($this->_sections['td']['step'] > 0 ? $this->_sections['td']['loop'] - $this->_sections['td']['start'] : $this->_sections['td']['start']+1)/abs($this->_sections['td']['step'])), $this->_sections['td']['max']);
    if ($this->_sections['td']['total'] == 0)
        $this->_sections['td']['show'] = false;
} else
    $this->_sections['td']['total'] = 0;
if ($this->_sections['td']['show']):

            for ($this->_sections['td']['index'] = $this->_sections['td']['start'], $this->_sections['td']['iteration'] = 1;
                 $this->_sections['td']['iteration'] <= $this->_sections['td']['total'];
                 $this->_sections['td']['index'] += $this->_sections['td']['step'], $this->_sections['td']['iteration']++):
$this->_sections['td']['rownum'] = $this->_sections['td']['iteration'];
$this->_sections['td']['index_prev'] = $this->_sections['td']['index'] - $this->_sections['td']['step'];
$this->_sections['td']['index_next'] = $this->_sections['td']['index'] + $this->_sections['td']['step'];
$this->_sections['td']['first']      = ($this->_sections['td']['iteration'] == 1);
$this->_sections['td']['last']       = ($this->_sections['td']['iteration'] == $this->_sections['td']['total']);
 echo '<td align="center">';  if ($this->_tpl_vars['poze_sec_medii'][$this->_sections['td']['index']] != ""):  echo '<img src="';  echo $this->_tpl_vars['poze_sec_medii'][$this->_sections['td']['index']];  echo '?';  echo $this->_tpl_vars['timestamp'];  echo '" alt=""><br /><a href="';  echo $this->_tpl_vars['URL_ADMIN'];  echo 'gestioneaza_produse.php?cat=';  echo $this->_tpl_vars['id_cat'];  echo '&id_produs=';  echo $this->_tpl_vars['id_produs'];  echo '&sterge_poza=';  echo $this->_tpl_vars['poze'][$this->_sections['td']['index']];  echo '#poze" class="link_default">[sterge poza]</a>';  endif;  echo '</td>';  endfor; endif;  echo '</tr>';  endfor; endif;  echo '</table></td></tr><tr><td height="20" valign="top" style="padding-top:2px">Fisiere:</td><td colspan="2"><input type="file" name="fisier" size="58" class="bg_spatiu"> <a name="poze"></a><table>';  unset($this->_sections['sec']);
$this->_sections['sec']['name'] = 'sec';
$this->_sections['sec']['loop'] = is_array($_loop=$this->_tpl_vars['fisiere_upl']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
 echo '<tr><td><b>';  echo $this->_tpl_vars['fisiere_upl'][$this->_sections['sec']['index']];  echo '</b> - <a href="';  echo $this->_tpl_vars['URL_ADMIN'];  echo 'gestioneaza_produse.php?cat=';  echo $this->_tpl_vars['id_cat'];  echo '&id_produs=';  echo $this->_tpl_vars['id_produs'];  echo '&sterge_fisier=';  echo $this->_tpl_vars['fisiere_upl'][$this->_sections['sec']['index']];  echo '#poze" class="link_default">[sterge]</a></td></tr>';  endfor; endif;  echo '</table></td></tr><tr><td align="right" colspan="3"><table><tr><td><img src="';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img/watermark.png" alt="Watermark"></td><td>Aplica watermark:</td><td><input type="checkbox" name="watermark" value="1" checked></td></tr></table></td></tr><tr><td></td><td colspan="2"><input type="submit" name="';  if ($this->_tpl_vars['id_produs'] != ""):  echo 'modifica';  else:  echo 'adauga';  endif;  echo '_produs" value="';  if ($this->_tpl_vars['id_produs'] != ""):  echo 'MODIFICA';  else:  echo 'ADAUGA';  endif;  echo ' PRODUS" class="';  if ($this->_tpl_vars['id_produs'] != ""):  echo 'buton';  else:  echo 'buton_cool';  endif;  echo '" style="width:166px">&nbsp;';  if ($this->_tpl_vars['id_produs'] != ""):  echo '<input type="button" value="STERGE PRODUS" class="buton_anuleaza" style="width:166px"onClick="casutaConfirmare(\'Sunteti sigur ca doriti sa stergeti<br />produsul <b>';  echo $this->_tpl_vars['nume_produs'];  echo '</b>?\',\'400\',\'';  echo $this->_tpl_vars['URL_ADMIN'];  echo 'sterge_produs.php?cat=';  echo $this->_tpl_vars['id_cat'];  echo '&id_produs=';  echo $this->_tpl_vars['id_produs'];  echo '\')">';  endif;  echo '</td></tr></table></form><hr size="1">* = Campuri obligatorii</td></tr>';  echo '</table><p align="center"><a href="';  echo $this->_tpl_vars['link_inapoi'];  echo '" class="link_default">&laquo; Inapoi</a></p><p align="right"><a href="#top"><img src="';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img/top.gif" alt="top"></a></p></td></tr></table></td>'; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/right.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/bottom.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>