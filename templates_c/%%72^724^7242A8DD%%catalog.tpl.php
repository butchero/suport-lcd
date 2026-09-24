<?php /* Smarty version 2.6.12, created on 2013-01-30 18:26:31
         compiled from admin/catalog.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'upper', 'admin/catalog.tpl', 39, false),array('function', 'html_options', 'admin/catalog.tpl', 110, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/top.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/left.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  echo '<td valign="top" align="left" width="568"><script src="';  echo $this->_tpl_vars['URL_BASE'];  echo 'javascript/scriptaculous-js-1.7.0/lib/prototype.js" type="text/javascript"></script><script src="';  echo $this->_tpl_vars['URL_BASE'];  echo 'javascript/EditInPlace.js" type="text/javascript"></script><script type="text/javascript">Event.observe(window, \'load\', init, false);var id_cat=\'';  echo $this->_tpl_vars['id_cat'];  echo '\';';  echo '
		function init() {			
			EditInPlace.makeEditable ({
				type: \'textarea\',
				id: \'editare_categorie\',
				save_url: \'server_edit_in_place.php?id_cat=\'+id_cat	
			});				
		';  echo '';  unset($this->_sections['sec']);
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
		';  echo '</script><table style="margin-left:6px;margin-right:6px;" cellpadding="0" cellspacing="0" width="557"><tr><td>';  if ($this->_tpl_vars['mesaj'] != ""):  echo '';  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/mesaj.tpl", 'smarty_include_vars' => array('mesaj' => $this->_tpl_vars['mesaj'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  echo '';  endif;  echo '';  echo '<table cellpadding="3" cellspacing="1" class="bg_spatiu" width="100%"><tr><td colspan="4" class="menu_title"><h2>Actiuni pentru categoria: ';  if ($this->_tpl_vars['edit'] == 'producatori'):  echo 'PRODUCATORI';  else:  echo '';  if ($this->_tpl_vars['nume_cat'] == ""):  echo 'ROOT';  else:  echo '';  echo ((is_array($_tmp=$this->_tpl_vars['nume_cat'])) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp));  echo '';  endif;  echo '';  endif;  echo '</h2></td></tr><tr><td width="136">';  if ($this->_tpl_vars['edit'] == 'producatori'):  echo '<input type="button" value="ADAUGA PRODUCATOR" class="buton_cool" style="width:180px" onClick="window.location.href=\'';  echo $this->_tpl_vars['URL_ADMIN'];  echo 'adauga_categorie.php?cat=';  echo $this->_tpl_vars['id_cat'];  echo '&adauga=producator\'">';  else:  echo '<input type="button" value="ADAUGA SUBCAT" class="buton_cool" style="width:132px" onClick="window.location.href=\'';  echo $this->_tpl_vars['URL_ADMIN'];  echo 'adauga_categorie.php?cat=';  echo $this->_tpl_vars['id_cat'];  echo '\'">';  endif;  echo '</td><td width="136">';  if ($this->_tpl_vars['edit'] == 'producatori'):  echo '<input type="button" value="ORDONEAZA PRODUCATORI" class="buton_cool" style="width:180px" onClick="window.location.href=\'';  echo $this->_tpl_vars['URL_ADMIN'];  echo 'ordoneaza_categorii.php?ordoneaza=producatori\'">';  else:  echo '<input type="button" value="ORDONEAZA SUBCAT" class="buton_cool" style="width:132px" onClick="window.location.href=\'';  echo $this->_tpl_vars['URL_ADMIN'];  echo 'ordoneaza_categorii.php?id_parinte=';  echo $this->_tpl_vars['id_cat'];  echo '\'">';  endif;  echo '</td><td width="136">';  if ($this->_tpl_vars['edit'] != 'categorii_principale' && $this->_tpl_vars['edit'] != 'producatori'):  echo '<input type="button" value="EDITEAZA SUBCAT" class="buton" style="width:132px" onClick="window.location.href=\'';  echo $this->_tpl_vars['URL_ADMIN'];  echo 'editeaza_categorie.php?cat=';  echo $this->_tpl_vars['id_cat'];  echo '\'">';  endif;  echo '</td><td width="136">';  if ($this->_tpl_vars['edit'] != 'categorii_principale' && $this->_tpl_vars['edit'] != 'producatori'):  echo '<input type="button" value="STERGE SUBCAT" class="buton_anuleaza" style="width:132px"onClick="casutaConfirmare(\'Sunteti sigur ca doriti sa stergeti<br />categoria <b>';  echo $this->_tpl_vars['nume_cat'];  echo '</b>?<br /><br /><font class=eroare_text>Toate produsele din aceasta categorie vor fi sterse definitiv!</font>\', \'400\',\'';  echo $this->_tpl_vars['URL_ADMIN'];  echo 'sterge_categorie.php?cat=';  echo $this->_tpl_vars['id_cat'];  echo '\')">';  endif;  echo '</td></tr>';  if ($this->_tpl_vars['edit'] != 'categorii_principale' && $this->_tpl_vars['edit'] != 'producatori'):  echo '<tr><td><input type="button" value="ADAUGA PRODUS" class="buton_cool" style="width:132px" onClick="window.location.href=\'';  echo $this->_tpl_vars['URL_ADMIN'];  echo 'gestioneaza_produse.php?cat=';  echo $this->_tpl_vars['id_cat'];  echo '\'"></td><td><input type="button" value="FILTRE CATEGORIE" class="buton_cool" style="width:132px" onClick="window.location.href=\'';  echo $this->_tpl_vars['URL_ADMIN'];  echo 'gestioneaza_filtre.php?cat=';  echo $this->_tpl_vars['id_cat'];  echo '\'"></td><td><input type="button" value="ORDONEAZA FILTRE" class="buton_cool" style="width:132px" onClick="window.location.href=\'';  echo $this->_tpl_vars['URL_ADMIN'];  echo 'ordoneaza_filtre.php?cat=';  echo $this->_tpl_vars['id_cat'];  echo '\'"></td><td><input type="button" value="BANNERE CAT" class="buton_cool" style="width:132px" onClick="window.location.href=\'';  echo $this->_tpl_vars['URL_ADMIN'];  echo 'gestioneaza_bannere_cat.php?cat=';  echo $this->_tpl_vars['id_cat'];  echo '\'"></td></tr>';  endif;  echo '</table>';  echo '';  echo '<ul>';  if ($this->_tpl_vars['edit'] == 'producatori'):  echo ' ';  echo '<li>In aceasta pagina aveti posibilitatea de a adauga un producator(fabricant) nou sau de a sterge un producator existent.</li><li>Producatori pot fi ordonati, dar nu si dezactivati ca in cazul categoriilor.</li><li>ATENTIE: Stergerea unui producator va duce scoaterea acelui producatori din toate produsele.</li>';  else:  echo '						';  echo '<li>In aceasta pagina aveti posibilitatea de a adauga o (sub)categorie noua, de a sterge categoria, de a adauga un produse nou sau de a defini filtre pentru categorie.</li><li>Subcategoriile categoriei asociate pot fi sterse, ordonate, sau dezactivate.</li><li>ATENTIE: Dezactivarea unei categorii va duce si la dezactivarea subcategoriilor acesteia. Produsele din categoriile dezactivate nu vor mai fi afisate in site.</li><li>ATENTIE: Stergerea unei categorii va duce la stergerea tuturor produselor care apartin de acea categorie.</li>';  endif;  echo '</ul><div class="bg_spatiu" style="padding:3px"><b>Editare rapida descriere categorie:</b></div><div style="padding:3px;font-size:10px;border:1px solid #F2F2F2" id="editare_categorie">';  echo $this->_tpl_vars['descriere_cat'];  echo '</div><br />';  echo '';  if ($this->_tpl_vars['edit'] == "" && $this->_tpl_vars['nr_produse_cat'] > 0):  echo '';  echo '<form action="';  echo $this->_tpl_vars['URL_ADMIN'];  echo 'catalog.php?cat=';  echo $this->_tpl_vars['id_cat'];  echo '" method="POST"><table><tr><td>Producator:</td><td><select name="producator" class="select"><option value="0">--Oricare--</option>';  echo smarty_function_html_options(array('options' => $this->_tpl_vars['toti_producatorii'],'selected' => $this->_tpl_vars['id_prod']), $this); echo '</select></td><td>Ordonare:</td><td><select name="ordonare" class="select">';  echo smarty_function_html_options(array('options' => $this->_tpl_vars['combo_ordonari'],'selected' => $this->_tpl_vars['id_ordonare']), $this); echo '</select></td><td>Cod produs:</td><td><input type="text" name="cod_produs" value="';  echo $this->_tpl_vars['cod_produs'];  echo '" size="10"></td><td><input type="submit" name="filtreaza" value="GO" class="buton"></td></tr></table></form>';  endif;  echo '';  echo '';  echo '';  if ($this->_tpl_vars['radacina'] != ""):  echo '<table cellpadding="0" cellspacing="0" class="menu_container" style="background:url(';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img/bg_menu.gif);border-top:1px solid #F2F2F2;border-left:1px solid #F2F2F2;border-right:1px solid #F2F2F2;"><tr><td align="left" class="menu_title" height="18" style="padding-left:2px"><h2>Subcategorii in:';  unset($this->_sections['sec']);
$this->_sections['sec']['name'] = 'sec';
$this->_sections['sec']['loop'] = is_array($_loop=$this->_tpl_vars['radacina']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
 echo '&nbsp;<a href="';  echo $this->_tpl_vars['radacina'][$this->_sections['sec']['index']]['link_radacina'];  echo '" title="';  echo $this->_tpl_vars['radacina'][$this->_sections['sec']['index']]['nume_radacina'];  echo '" class="radacina">';  echo $this->_tpl_vars['radacina'][$this->_sections['sec']['index']]['nume_radacina'];  echo '</a>&nbsp;';  if (! $this->_sections['sec']['last']):  echo '&raquo;';  endif;  echo '';  endfor; endif;  echo '</h2></td></tr></table>';  endif;  echo '';  echo '';  if ($this->_tpl_vars['catalog'] != ""):  echo '<table cellpadding="5" cellspacing="0" class="box" width="557"><tr><td valign="top"><table width="100%" cellpadding="0" cellspacing="0">';  unset($this->_sections['tr']);
$this->_sections['tr']['name'] = 'tr';
$this->_sections['tr']['loop'] = is_array($_loop=$this->_tpl_vars['catalog']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
 echo '';  if ($this->_tpl_vars['catalog'][$this->_sections['td']['index']]['nume_cat'] != ""):  echo '<td width="130" valign="top" align="center" class="box">';  echo '';  if ($this->_tpl_vars['edit'] != 'producatori'):  echo '<table><tr><td class="text_mic">Activa:</td><td><input type="checkbox" id="';  echo $this->_tpl_vars['catalog'][$this->_sections['td']['index']]['id_cat'];  echo '"onClick="toggleCategoriiActivare(\'';  echo $this->_tpl_vars['catalog'][$this->_sections['td']['index']]['id_cat'];  echo '\')" ';  if ($this->_tpl_vars['catalog'][$this->_sections['td']['index']]['activ'] == '1'):  echo 'checked';  endif;  echo '></td></tr></table>';  endif;  echo '';  echo '<table><tr><td height="70"><a href="';  echo $this->_tpl_vars['catalog'][$this->_sections['td']['index']]['link_cat_admin'];  echo '" title="';  echo $this->_tpl_vars['catalog'][$this->_sections['td']['index']]['nume_cat'];  echo '" class="produse"><img src="';  echo $this->_tpl_vars['catalog'][$this->_sections['td']['index']]['poza_cat'];  echo '?';  echo $this->_tpl_vars['timestamp'];  echo '" alt="';  echo $this->_tpl_vars['catalog'][$this->_sections['td']['index']]['nume_cat'];  echo '"></a></td></tr></table><div style="height:25px;display:table;position:relative;text-align:center;vertical-align:top">';  if ($this->_tpl_vars['edit'] == 'producatori'):  echo '';  echo $this->_tpl_vars['catalog'][$this->_sections['td']['index']]['nume_cat'];  echo ' ';  if ($this->_tpl_vars['catalog'][$this->_sections['td']['index']]['nr_produse'] != ""):  echo '<font class="nr_produse">(';  echo $this->_tpl_vars['catalog'][$this->_sections['td']['index']]['nr_produse'];  echo ')</font>';  endif;  echo '';  else:  echo '<a href="';  echo $this->_tpl_vars['catalog'][$this->_sections['td']['index']]['link_cat_admin'];  echo '" title="';  echo $this->_tpl_vars['catalog'][$this->_sections['td']['index']]['nume_cat'];  echo '" class="produse" style="font-size:10px">';  echo $this->_tpl_vars['catalog'][$this->_sections['td']['index']]['nume_cat'];  echo ' ';  if ($this->_tpl_vars['catalog'][$this->_sections['td']['index']]['nr_produse'] != ""):  echo '<font class="nr_produse" style="font-size:10px">(';  echo $this->_tpl_vars['catalog'][$this->_sections['td']['index']]['nr_produse'];  echo ')</font>';  endif;  echo '</a>';  endif;  echo '</div><table><tr><td><input type="button" value="EDITEAZA" class="buton" style="width:80px"onClick="window.location.href=\'';  echo $this->_tpl_vars['URL_ADMIN'];  echo 'editeaza_categorie.php?cat=';  echo $this->_tpl_vars['catalog'][$this->_sections['td']['index']]['id_cat'];  echo '\'"></td></tr><tr><td><input type="button" value="STERGE" class="buton_anuleaza" style="width:80px"onClick="casutaConfirmare(\'Sunteti sigur ca doriti sa stergeti<br />';  if ($this->_tpl_vars['edit'] == 'producatori'):  echo 'producatorul';  else:  echo 'categoria';  endif;  echo ' <b>';  echo $this->_tpl_vars['catalog'][$this->_sections['td']['index']]['nume_cat'];  echo '</b>?';  if ($this->_tpl_vars['edit'] != 'producatori'):  echo ' <br /><br /><font class=eroare_text>Toate produsele din aceasta categorie vor fi sterse definitiv!</font>';  endif;  echo '\', \'400\',\'';  echo $this->_tpl_vars['URL_ADMIN'];  echo 'sterge_categorie.php?cat=';  echo $this->_tpl_vars['catalog'][$this->_sections['td']['index']]['id_cat'];  echo '\')"></td></tr></table></td>';  else:  echo '<td width="130"></td>';  endif;  echo '';  endfor; endif;  echo '</tr>';  if (! $this->_sections['tr']['last']):  echo '<tr><td colspan="4" height="5"></td></tr>';  endif;  echo '';  endfor; endif;  echo '</table></td></tr></table>';  else:  echo '';  if ($this->_tpl_vars['nr_produse_cat'] == 0):  echo '';  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/mesaj.tpl", 'smarty_include_vars' => array('mesaj' => "Nu sunt subcategorii in aceasta categorie!")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  echo '';  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/mesaj.tpl", 'smarty_include_vars' => array('mesaj' => "Nu sunt produse in aceasta categorie!")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  echo '';  endif;  echo '';  endif;  echo '';  echo '';  echo '';  if ($this->_tpl_vars['edit'] == "" && $this->_tpl_vars['nr_produse_cat'] > 0):  echo '';  echo '<table cellpadding="0" cellspacing="0" width="557"><tr><td>';  if ($this->_tpl_vars['paginare'] != ""):  echo '<table cellpadding="2" cellspacing="0" width="100%"><tr><td height="14" class="paginare_tabel" style="border-bottom: 1px solid #F4F4F4" align="right">&nbsp;';  echo $this->_tpl_vars['paginare'];  echo '&nbsp;</td></tr></table>';  endif;  echo '</td></tr></table><table cellpadding="0" cellspacing="0" width="557" class="tabel_produse" ><tr><td height="1" class="tab_line"></td></tr><tr><td height="5"></td></tr><tr><td valign="top"><table cellpadding="2" cellspacing="2" width="100%">';  echo '<tr><td class="header_tabel" width="110" align="center">Poza</td><td class="header_tabel" align="center">Produs</td><td class="header_tabel" width="5"></td><td class="header_tabel" width="80" align="center">Pret</td></tr>';  echo '<tr><td colspan="4" height="10"></td></tr>';  echo '';  unset($this->_sections['sec']);
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
 echo '<tr><td valign="top" align="center"><table cellpadding="2" class="img">';  echo '<tr><td width="90" height="90" align="center"><img src="';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['adresa_poza_produs'];  echo '?';  echo $this->_tpl_vars['timestamp'];  echo '" alt="" id="poza';  echo $this->_sections['sec']['index'];  echo '"></td></tr>';  echo '</table>';  if ($this->_tpl_vars['produse'][$this->_sections['sec']['index']]['poze_sec_mici'] != ""):  echo '<table cellspacing="2" cellpadding="1">';  echo '';  unset($this->_sections['tr']);
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
 echo '';  if ($this->_tpl_vars['produse'][$this->_sections['sec']['index']]['poze_sec_mici'][$this->_sections['td']['index']] != ""):  echo '<td class="box_poze_mici" onmouseover="this.className=\'box_poze_mici_hover\'" onmouseout="this.className=\'box_poze_mici\'"><a href="#" onmouseover="$(\'poza';  echo $this->_sections['sec']['index'];  echo '\').src=\'';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['poze_sec_medii'][$this->_sections['td']['index']];  echo '\'; return false;"onClick="NewWindow(\'';  echo $this->_tpl_vars['URL_BASE'];  echo 'galerie.php?id_produs=';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['id_produs'];  echo '&amp;poza=\'+$(\'poza';  echo $this->_sections['sec']['index'];  echo '\').src, \'\', \'800\', \'750\', \'yes\'); return false;"><img src="';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['poze_sec_mici'][$this->_sections['td']['index']];  echo '" alt="Schimba poza principala"></a></td>';  else:  echo '<td></td>';  endif;  echo '';  endfor; endif;  echo '</tr>';  endfor; endif;  echo '';  echo '</table>';  endif;  echo '<table><tr><td><input type="checkbox" id="';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['id_produs'];  echo '" ';  if ($this->_tpl_vars['produse'][$this->_sections['sec']['index']]['id_produs_newsletter'] != ""):  echo 'checked';  endif;  echo ' onClick="toggleProduseNewsletter(\'';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['id_produs'];  echo '\')"></td><td class="text_mic">In newsletter</td></tr></table></td><td valign="top"><br />';  echo '';  if ($this->_tpl_vars['produse'][$this->_sections['sec']['index']]['nume_produs'] != ""):  echo '<a href="';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['link_produs'];  echo '" title="';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['nume_produs'];  echo '" class="';  if ($this->_tpl_vars['produse'][$this->_sections['sec']['index']]['tip'] == '1'):  echo 'produse_speciale';  else:  echo 'produse';  endif;  echo '">';  if ($this->_tpl_vars['produse'][$this->_sections['sec']['index']]['producator'] != ""):  echo '';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['producator'];  echo ' - ';  endif;  echo '<b>';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['nume_produs'];  echo '</b></a>';  endif;  echo '';  echo '<table cellspacing="1" cellpadding="1" width="290">';  echo '';  unset($this->_sections['subsec']);
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
 echo '<tr><td width="5"></td><td class="caracteristici" width="110"><img src="';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img/bullet.gif" alt=""> ';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['caracteristici'][$this->_sections['subsec']['index']]['nume_carac'];  echo ':</td><td class="caracteristici" width="175">';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['caracteristici'][$this->_sections['subsec']['index']]['val_carac'];  echo '</td></tr>';  endfor; endif;  echo '';  echo '';  echo '<tr><td width="5"></td><td class="caracteristici"><img src="';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img/bullet.gif" alt=""> Producator:</td><td class="caracteristici">';  if ($this->_tpl_vars['produse'][$this->_sections['sec']['index']]['producator'] != ""):  echo '';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['producator'];  echo '';  else:  echo 'fara producator';  endif;  echo '</td></tr>';  echo '';  echo '<tr><td width="5"></td><td class="caracteristici"><img src="';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img/bullet.gif" alt=""> Cod produs:</td><td class="caracteristici"><b>';  if ($this->_tpl_vars['produse'][$this->_sections['sec']['index']]['cod_produs'] == ""):  echo '-';  else:  echo '';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['cod_produs'];  echo '';  endif;  echo '</b></td></tr>';  echo '<tr><td colspan="3" height="1" class="bg_spatiu" style="padding:0px"></td></tr>';  echo '<tr><td width="5"></td><td colspan="2"><font class="text_mic">Ultima editare facuta de: <b>';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['username'];  echo '</b></font></td></tr>';  echo '<tr><td colspan="3" height="1" class="bg_spatiu" style="padding:0px"></td></tr>';  echo '</table></td><td width="5"></td><td align="center" valign="middle" class="pret">';  echo '';  if ($this->_tpl_vars['produse'][$this->_sections['sec']['index']]['adresa_poza_producator'] != ""):  echo '<img src="';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['adresa_poza_producator'];  echo '" alt="';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['producator'];  echo '">';  endif;  echo '';  echo '';  echo '<div style="margin-bottom:5px;margin-top:5px">Pret cu TVA <br />';  if ($this->_tpl_vars['produse'][$this->_sections['sec']['index']]['pret_vechi'] != ""):  echo '<font class="pret_vechi">';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['pret_vechi'];  echo ' ';  echo $this->_tpl_vars['MONEDA'];  echo '</font><br />';  endif;  echo '<b><span id="editare_pret_';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['id_produs'];  echo '">';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['pret_produs'];  echo '</span> ';  echo $this->_tpl_vars['MONEDA'];  echo '</b></div>';  echo '';  echo '<table><tr><td><input type="button" value="EDITEAZA" class="buton" style="width:80px" onClick="window.location.href=\'';  echo $this->_tpl_vars['URL_ADMIN'];  echo 'gestioneaza_produse.php?cat=';  echo $this->_tpl_vars['id_cat'];  echo '&id_produs=';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['id_produs'];  echo '\'"></td></tr><tr><td><input type="button" value="STERGE" class="buton_anuleaza" style="width:80px"onClick="casutaConfirmare(\'Sunteti sigur ca doriti sa stergeti produsul<br /><b>';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['nume_produs_js'];  echo '</b>?<br /><br /><font class=eroare_text>Produsul va fi sters definitiv!</font>\', \'400\',\'';  echo $this->_tpl_vars['URL_ADMIN'];  echo 'sterge_produs.php?cat=';  echo $this->_tpl_vars['id_cat'];  echo '&id_produs=';  echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['id_produs'];  echo '\')"></td></tr></table>';  echo '</td></tr>';  if (! $this->_sections['sec']['last']):  echo '<tr><td colspan="4" height="2"></td></tr><tr><td colspan="4" height="1" style="background-image:url(';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img/dashed_line.gif);background-repeat:repeat-x;padding:0px"></td></tr><tr><td colspan="4" height="2"></td></tr>';  endif;  echo '';  echo '';  endfor; endif;  echo '</table></td></tr><tr><td height="5"></td></tr><tr><td height="1" class="tab_line"></td></tr></table><table cellpadding="0" cellspacing="0" width="557"><tr><td>';  if ($this->_tpl_vars['paginare'] != ""):  echo '<table cellpadding="2" cellspacing="0" width="100%"><tr><td height="14" class="paginare_tabel" style="border-bottom:1px solid #F4F4F4" align="right">&nbsp;';  echo $this->_tpl_vars['paginare'];  echo '&nbsp;</td></tr></table>';  endif;  echo '</td></tr></table>';  endif;  echo ' ';  echo '<p align="center"><a href="javascript:history.go(-1)" class="link_default">&laquo; Inapoi</a></p><p align="right"><a href="#top"><img src="';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img/top.gif" alt="top"></a></p></td></tr></table></td>'; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/right.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/bottom.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>