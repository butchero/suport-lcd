<?php /* Smarty version 2.6.12, created on 2013-01-31 00:41:59
         compiled from admin/cauta_produs.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'admin/cauta_produs.tpl', 168, false),array('block', 'repeat', 'admin/cauta_produs.tpl', 181, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/top.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/left.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  echo '<td valign="top" align="left" width="568"><script src="';  echo $this->_tpl_vars['URL_BASE'];  echo 'javascript/scriptaculous-js-1.7.0/lib/prototype.js" type="text/javascript"></script><script type="text/javascript" src="';  echo $this->_tpl_vars['URL_BASE'];  echo 'javascript/EditInPlace.js"></script><script type="text/javascript">Event.observe(window, \'load\', init, false);function init() ';  echo '{';  echo '';  unset($this->_sections['sec']);
$this->_sections['sec']['name'] = 'sec';
$this->_sections['sec']['loop'] = is_array($_loop=$this->_tpl_vars['produse']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
 echo 'EditInPlace.makeEditable(';  echo '{';  echo 'id: \'editare_pret_';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['id_produs'];  echo '\',save_url: \'server_edit_in_place.php?id_produs=';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['id_produs'];  echo '\',size: \'6\'';  echo '}';  echo ');';  endfor; endif;  echo '';  echo '
			}
		';  echo '</script><table style="margin-left:6px;margin-right:6px;width:557px;" cellpadding="0" cellspacing="0"><tr><td>';  if ($this->_tpl_vars['mesaj'] != ""):  echo '';  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/mesaj.tpl", 'smarty_include_vars' => array('mesaj' => $this->_tpl_vars['mesaj'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  echo '';  endif;  echo '';  echo '<form action="" method="GET"><table cellpadding="3" cellspacing="1"><tr><td class="menu_title" style="background:url(';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img/bg_menu.gif);border-top:1px solid #F2F2F2;border-left:1px solid #F2F2F2;border-right:1px solid #F2F2F2;">Cautare</td></tr></table><table><tr><td>Textul cautat: <input type="text" name="string" value="';  echo $this->_tpl_vars['cautare_string_camp'];  echo '" id="text_cautat2" maxlength="30"> <input type="submit" value="CAUTA" class="buton"></td></tr></table></form>';  echo '<ul><li>Cautarea se face in nume categorie, nume produs si in descrierea produsului.</li><li>ATENTIE: Cautarea se face doar in categoriile active!</li></ul>';  echo '<div style="margin-top:10px">Rezultatele cautarii pentru "<b>';  echo $this->_tpl_vars['cautare_string_camp'];  echo '</b>":</div>';  echo '';  echo '<table width="100%" cellpadding="0" cellspacing="0" style="margin-top:10px"><tr><td width="120"><b>Afisare produse:</b></td><td align="right">';  if ($this->_tpl_vars['paginare'] != ""):  echo '<table cellpadding="2" cellspacing="0"><tr><td height="14" class="paginare_tabel" style="border-bottom: 1px solid #F4F4F4">&nbsp;';  echo $this->_tpl_vars['paginare'];  echo '&nbsp;</td></tr></table>';  endif;  echo '</td></tr></table>';  echo '<table cellpadding="0" cellspacing="0" class="tabel_produse" width="100%"><tr><td height="1" class="tab_line"></td></tr><tr><td height="5"></td></tr><tr><td valign="top"><table cellpadding="2" cellspacing="2" width="100%">';  echo '<tr><td class="header_tabel" width="110" align="center">Poza</td><td class="header_tabel" align="center">Produs</td><td class="header_tabel" width="5"></td><td class="header_tabel" width="80" align="center">Pret</td></tr>';  echo '<tr><td colspan="4" height="10"></td></tr>';  echo '';  unset($this->_sections['sec']);
$this->_sections['sec']['name'] = 'sec';
$this->_sections['sec']['loop'] = is_array($_loop=$this->_tpl_vars['produse']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
 echo '<tr><td valign="top" align="center"><a href="#" onClick="NewWindow(\'/galerie.php?id_prod=';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['id_produs'];  echo '&amp;poza=\'+document.getElementById(\'poza';  echo $this->_sections['sec']['index'];  echo '\').src, \'\', \'800\', \'750\', \'yes\'); return false;" class="mareste_poza"><img src="';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img/mareste_poza.gif" alt="Mareste poza"> Mareste poza</a><table cellpadding="2" class="img">';  echo '<tr><td class="margine_poza"></td><td width="90" height="90" align="center"><div class="productImg" id="product_';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['id_produs'];  echo '"><img src="';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['adresa_poza_produs'];  echo '" alt="Trage poza in cos pentru a cumpara produsul" id="poza';  echo $this->_sections['sec']['index'];  echo '"></div></td></tr>';  echo '</table>';  if ($this->_tpl_vars['produse'][$this->_sections['sec']['index']]['poze_sec_mici'] != ""):  echo '<table cellspacing="2" cellpadding="1">';  echo '';  unset($this->_sections['tr']);
$this->_sections['tr']['name'] = 'tr';
$this->_sections['tr']['loop'] = is_array($_loop=$this->_tpl_vars['produse'][$this->_sections['sec']['index']]['poze_sec_mici']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
 echo '';  if ($this->_tpl_vars['produse'][$this->_sections['sec']['index']]['poze_sec_mici'][$this->_sections['td']['index']] != ""):  echo '<td class="box_poze_mici" onmouseover="this.className=\'box_poze_mici_hover\'" onmouseout="this.className=\'box_poze_mici\'"><a href="#" onmouseover="document.getElementById(\'poza';  echo $this->_sections['sec']['index'];  echo '\').src=\'';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['poze_sec_medii'][$this->_sections['td']['index']];  echo '\'; return false;"onClick="NewWindow(\'';  echo $this->_tpl_vars['URL_BASE'];  echo 'galerie.php?id_produs=';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['id_produs'];  echo '&amp;poza=\'+document.getElementById(\'poza';  echo $this->_sections['sec']['index'];  echo '\').src, \'\', \'800\', \'750\', \'yes\'); return false;"><img src="';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['poze_sec_mici'][$this->_sections['td']['index']];  echo '" alt="Schimba poza principala"></a></td>';  else:  echo '<td></td>';  endif;  echo '';  endfor; endif;  echo '</tr>';  endfor; endif;  echo '';  echo '</table>';  endif;  echo '<table><tr><td><input type="checkbox" id="';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['id_produs'];  echo '" ';  if ($this->_tpl_vars['produse'][$this->_sections['sec']['index']]['id_produs_newsletter'] != ""):  echo 'checked';  endif;  echo ' onClick="toggleProduseNewsletter(\'';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['id_produs'];  echo '\')"></td><td class="text_mic">In newsletter</td></tr></table></td><td valign="top">';  echo '';  if ($this->_tpl_vars['produse'][$this->_sections['sec']['index']]['nume_produs'] != ""):  echo '<a href="';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['link_produs'];  echo '" class="';  if ($this->_tpl_vars['produse'][$this->_sections['sec']['index']]['tip'] == '1'):  echo 'produse_speciale';  else:  echo 'produse';  endif;  echo '">';  if ($this->_tpl_vars['produse'][$this->_sections['sec']['index']]['producator'] != ""):  echo '';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['producator'];  echo ' - ';  endif;  echo '<b>';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['nume_produs'];  echo '</b></a>';  endif;  echo '';  echo '<table cellspacing="1" cellpadding="1">';  echo '';  unset($this->_sections['subsec']);
$this->_sections['subsec']['name'] = 'subsec';
$this->_sections['subsec']['loop'] = is_array($_loop=$this->_tpl_vars['produse'][$this->_sections['sec']['index']]['caracteristici']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
 echo '<tr><td width="5"></td><td class="caracteristici" width="130"><img src="';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img/bullet.gif" alt=""> ';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['caracteristici'][$this->_sections['subsec']['index']]['nume_carac'];  echo ':</td><td class="caracteristici">';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['caracteristici'][$this->_sections['subsec']['index']]['val_carac'];  echo '</td></tr>';  endfor; endif;  echo '';  echo '';  echo '<tr><td width="5"></td><td class="caracteristici" width="130"><img src="';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img/bullet.gif" alt=""> Producator:</td><td class="caracteristici">';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['producator'];  echo '</td></tr>';  echo '';  echo '<tr><td width="5"></td><td class="caracteristici" width="130"><img src="';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img/bullet.gif" alt=""> Cod produs:</td><td class="caracteristici"><b>';  if ($this->_tpl_vars['produse'][$this->_sections['sec']['index']]['cod_produs'] == ""):  echo '-';  else:  echo '';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['cod_produs'];  echo '';  endif;  echo '</b></td></tr>';  echo '';  echo '<tr><td width="5"></td><td class="caracteristici" width="130"><img src="';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img/bullet.gif" alt=""> Stoc:</td><td class="caracteristici"><select class="select" style="width:140px" onChange="setStoc(\'';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['id_produs'];  echo '\', this.value)">';  echo smarty_function_html_options(array('options' => $this->_tpl_vars['stocuri'],'selected' => $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['id_stoc']), $this); echo '</select></td></tr>';  echo '<tr><td colspan="3" height="3"></td></tr><tr><td width="5"></td><td align="left" colspan="2"><table width="100%" cellpadding="0" cellspacing="1"><tr><td class="caracteristici"><b>Rating:</b></td><td>';  $this->_tag_stack[] = array('repeat', array('count' => $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['rating'][1])); $_block_repeat=true;smarty_block_repeat($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start();  echo '<img src="';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img/flower.gif" alt="">';  $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_repeat($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack);  echo '';  $this->_tag_stack[] = array('repeat', array('count' => $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['rating'][2])); $_block_repeat=true;smarty_block_repeat($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start();  echo '<img src="';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img/flower_gri.gif" alt="">';  $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_repeat($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack);  echo '</td><td class="caracteristici">&nbsp;[';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['nr_comentarii'];  echo '] voturi</td></tr></table></td></tr><tr><td colspan="3" height="1" class="bg_spatiu" style="padding:0px"></td></tr>';  echo '<tr><td width="5"></td><td colspan="2"><img src="';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img/stoc/';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['id_stoc'];  echo '.gif" alt="';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['stoc'];  echo '">&nbsp;';  if ($this->_tpl_vars['produse'][$this->_sections['sec']['index']]['nr_comentarii'] > '0'):  echo '<img src="';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img/reviews.gif" alt="Review-uri disponibile">&nbsp;';  endif;  echo '';  if ($this->_tpl_vars['produse'][$this->_sections['sec']['index']]['tip'] == '1'):  echo '<img src="';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img/oferta_speciala.gif" alt="Oferta speciala">&nbsp;';  endif;  echo '';  if ($this->_tpl_vars['produse'][$this->_sections['sec']['index']]['pret_vechi'] != ""):  echo '<img src="';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img/reducere_pret.gif" alt="Reducere pret">';  endif;  echo '</td></tr>';  echo '<tr><td colspan="3" height="1" class="bg_spatiu" style="padding:0px"></td></tr>';  echo '<tr><td colspan="3" class="caracteristici">';  unset($this->_sections['rad']);
$this->_sections['rad']['name'] = 'rad';
$this->_sections['rad']['loop'] = is_array($_loop=$this->_tpl_vars['produse'][$this->_sections['sec']['index']]['radacina_produs']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['rad']['show'] = true;
$this->_sections['rad']['max'] = $this->_sections['rad']['loop'];
$this->_sections['rad']['step'] = 1;
$this->_sections['rad']['start'] = $this->_sections['rad']['step'] > 0 ? 0 : $this->_sections['rad']['loop']-1;
if ($this->_sections['rad']['show']) {
    $this->_sections['rad']['total'] = $this->_sections['rad']['loop'];
    if ($this->_sections['rad']['total'] == 0)
        $this->_sections['rad']['show'] = false;
} else
    $this->_sections['rad']['total'] = 0;
if ($this->_sections['rad']['show']):

            for ($this->_sections['rad']['index'] = $this->_sections['rad']['start'], $this->_sections['rad']['iteration'] = 1;
                 $this->_sections['rad']['iteration'] <= $this->_sections['rad']['total'];
                 $this->_sections['rad']['index'] += $this->_sections['rad']['step'], $this->_sections['rad']['iteration']++):
$this->_sections['rad']['rownum'] = $this->_sections['rad']['iteration'];
$this->_sections['rad']['index_prev'] = $this->_sections['rad']['index'] - $this->_sections['rad']['step'];
$this->_sections['rad']['index_next'] = $this->_sections['rad']['index'] + $this->_sections['rad']['step'];
$this->_sections['rad']['first']      = ($this->_sections['rad']['iteration'] == 1);
$this->_sections['rad']['last']       = ($this->_sections['rad']['iteration'] == $this->_sections['rad']['total']);
 echo '<a href="';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['radacina_produs'][$this->_sections['rad']['index']]['link_cat'];  echo '" class="link_default_mic">';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['radacina_produs'][$this->_sections['rad']['index']]['nume_cat'];  echo '</a>';  if (! $this->_sections['rad']['last']):  echo ' &raquo; ';  endif;  echo '';  endfor; endif;  echo '<br /><a href="';  echo $this->_tpl_vars['URL_ADMIN'];  echo 'statistici_vanzari_pe_produs.php?id_produs=';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['id_produs'];  echo '" class="link_default_mic"><img src="';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img_admin/statistici_vanzari_produs.gif" alt=""> Statistici vanzari produs</a>';  if ($this->_tpl_vars['CAT_SECUNDARE'] == 1):  echo '&nbsp;- <a href="';  echo $this->_tpl_vars['URL_ADMIN'];  echo 'asociatii_produse.php?id_produs=';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['id_produs'];  echo '" class="link_default_mic" title="Editeaza categorii secundare">Editeaza categorii secundare</a>';  endif;  echo '</td></tr>';  echo '<tr><td colspan="3" height="1" class="bg_spatiu" style="padding:0px"></td></tr>';  echo '';  if ($this->_tpl_vars['CAT_SECUNDARE'] == 1):  echo '<tr><td colspan="3" class="text_mic" style="color:#C15DCD"><b>Categorii secundare:</b>&nbsp;';  unset($this->_sections['s']);
$this->_sections['s']['name'] = 's';
$this->_sections['s']['loop'] = is_array($_loop=$this->_tpl_vars['produse'][$this->_sections['sec']['index']]['cat_sec']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['s']['show'] = true;
$this->_sections['s']['max'] = $this->_sections['s']['loop'];
$this->_sections['s']['step'] = 1;
$this->_sections['s']['start'] = $this->_sections['s']['step'] > 0 ? 0 : $this->_sections['s']['loop']-1;
if ($this->_sections['s']['show']) {
    $this->_sections['s']['total'] = $this->_sections['s']['loop'];
    if ($this->_sections['s']['total'] == 0)
        $this->_sections['s']['show'] = false;
} else
    $this->_sections['s']['total'] = 0;
if ($this->_sections['s']['show']):

            for ($this->_sections['s']['index'] = $this->_sections['s']['start'], $this->_sections['s']['iteration'] = 1;
                 $this->_sections['s']['iteration'] <= $this->_sections['s']['total'];
                 $this->_sections['s']['index'] += $this->_sections['s']['step'], $this->_sections['s']['iteration']++):
$this->_sections['s']['rownum'] = $this->_sections['s']['iteration'];
$this->_sections['s']['index_prev'] = $this->_sections['s']['index'] - $this->_sections['s']['step'];
$this->_sections['s']['index_next'] = $this->_sections['s']['index'] + $this->_sections['s']['step'];
$this->_sections['s']['first']      = ($this->_sections['s']['iteration'] == 1);
$this->_sections['s']['last']       = ($this->_sections['s']['iteration'] == $this->_sections['s']['total']);
 echo '';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['cat_sec'][$this->_sections['s']['index']]['nume_cat_sec'];  echo '';  if (! $this->_sections['s']['last']):  echo ', ';  endif;  echo '';  endfor; else:  echo '-';  endif;  echo '</td></tr>';  endif;  echo '';  echo '</table></td><td width="10"></td><td align="center" valign="middle" class="pret">';  if ($this->_tpl_vars['produse'][$this->_sections['sec']['index']]['adresa_poza_producator'] != ""):  echo '<img src="';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['adresa_poza_producator'];  echo '" alt="';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['nume_producator'];  echo '">';  endif;  echo '';  echo '<div style="margin-bottom:5px;margin-top:5px">Pret cu TVA <br />';  if ($this->_tpl_vars['produse'][$this->_sections['sec']['index']]['pret_vechi'] != ""):  echo '<font class="pret_vechi">';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['pret_vechi'];  echo ' ';  echo $this->_tpl_vars['MONEDA'];  echo '</font><br />';  endif;  echo '<div class="pret"><b><span id="editare_pret_';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['id_produs'];  echo '">';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['pret_produs'];  echo '</span> ';  echo $this->_tpl_vars['MONEDA'];  echo '</b></div></div>';  echo '';  echo '<table><tr><td><input type="button" value="EDITEAZA" class="buton" style="width:80px" onClick="window.location.href=\'';  echo $this->_tpl_vars['URL_ADMIN'];  echo 'gestioneaza_produse.php?string=';  echo $this->_tpl_vars['cautare_string'];  echo '&id_produs=';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['id_produs'];  echo '\'"></td></tr><tr><td><input type="button" value="STERGE" class="buton_anuleaza" style="width:80px"onClick="casutaConfirmare(\'Sunteti sigur ca doriti sa stergeti produsul<br /><b>';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['nume_produs_js'];  echo '</b>?<br /><br /><font class=eroare_text>Produsul va fi sters definitiv!</font>\', \'400\',\'';  echo $this->_tpl_vars['URL_ADMIN'];  echo 'sterge_produs.php?string=';  echo $this->_tpl_vars['cautare_string'];  echo '&id_produs=';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['id_produs'];  echo '\')"></td></tr></table>';  echo '</td></tr>';  if (! $this->_sections['sec']['last']):  echo '<tr><td colspan="4" height="2"></td></tr><tr><td colspan="4" height="1" style="background-image:url(';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img/dashed_line.gif);background-repeat:repeat-x;padding:0px;"></td></tr><tr><td colspan="4" height="2"></td></tr>';  endif;  echo '';  echo '';  endfor; endif;  echo '</table>';  if ($this->_sections['sec']['last'] == ""):  echo '<center>Nu sunt produse in aceasta sectiune!<br /><br /></center>';  endif;  echo '</td></tr><tr><td height="5"></td></tr><tr><td height="1" class="tab_line"></td></tr></table>';  echo '<table width="100%" cellpadding="0" cellspacing="0"><tr><td width="120"></td><td align="right">';  if ($this->_tpl_vars['paginare'] != ""):  echo '<table cellpadding="2" cellspacing="0"><tr><td height="14" class="paginare_tabel" style="border-bottom: 1px solid #F4F4F4">&nbsp;';  echo $this->_tpl_vars['paginare'];  echo '&nbsp;</td></tr></table>';  endif;  echo '</td></tr></table>';  echo '<br /><p align="center"><a href="';  echo $this->_tpl_vars['link_inapoi'];  echo '" class="link_default">&laquo; Inapoi</a></p><p align="right"><a href="#top"><img src="';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img/top.gif" alt="top"></a> &nbsp;</p></td></tr></table></td>'; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/right.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/bottom.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>