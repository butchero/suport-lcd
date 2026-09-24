<?php /* Smarty version 2.6.12, created on 2013-01-30 18:26:28
         compiled from admin/right.tpl */ ?>
<?php echo '<td valign="top" align="left" style="padding-right:2px"><table cellpadding="0" cellspacing="0" class="box" width="180"><tr><td><table cellpadding="0" cellspacing="0" width="100%" class="menu_container"><tr><td class="menu_title" align="center" height="18">Editare texte site</td></tr></table><table cellpadding="0" cellspacing="0" width="100%">';  unset($this->_sections['sec']);
$this->_sections['sec']['name'] = 'sec';
$this->_sections['sec']['loop'] = is_array($_loop=$this->_tpl_vars['texte']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
 echo '<tr style="background-image:url(';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img/menu_bg.jpg)"><td width="5" height="18"></td><td width="10"><img src="';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img_admin/texte.gif" alt="" class="icon"></td><td style="padding-left:3px"><a href="';  if ($this->_tpl_vars['super_admin'] == '1'):  echo '';  echo $this->_tpl_vars['texte'][$this->_sections['sec']['index']]['link'];  echo '';  else:  echo '#';  endif;  echo '" class="menu_left2';  if ($this->_tpl_vars['super_admin'] != '1'):  echo '_inactiv';  endif;  echo '" title="Editeaza text ';  echo $this->_tpl_vars['texte'][$this->_sections['sec']['index']]['nume'];  echo '">';  echo $this->_tpl_vars['texte'][$this->_sections['sec']['index']]['nume'];  echo '</a></td></tr>';  endfor; endif;  echo '</table></td></tr></table><table cellpadding="0" cellspacing="0" class="box" width="180" style="margin-top:5px"><tr><td><table cellpadding="0" cellspacing="0" width="100%" class="menu_container" style="background:url(';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img/bg_menu.gif)"><tr><td class="menu_title" align="center" height="18">Alte optiuni</td></tr></table><table cellpadding="0" cellspacing="0" width="100%"><tr style="background-image:url(';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img/menu_bg.jpg)"><td width="5" height="18"></td><td width="10"><img src="';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img_admin/param.gif" alt="" class="icon"></td><td style="padding-left:3px"><a href="';  if ($this->_tpl_vars['super_admin'] == '1'):  echo '';  echo $this->_tpl_vars['URL_ADMIN'];  echo 'parametri_site.php';  else:  echo '#';  endif;  echo '" class="menu_left2';  if ($this->_tpl_vars['super_admin'] != '1'):  echo '_inactiv';  endif;  echo '" title="Configureaza parametrii site">Parametri site</a></td></tr></table></td></tr></table><table cellpadding="0" cellspacing="0" class="box" width="180" style="margin-top:5px"><tr><td><table cellpadding="0" cellspacing="0" width="100%" class="menu_container"><tr><td class="menu_title" align="center" height="18">Optiuni admin</td></tr></table><table cellpadding="0" cellspacing="0" width="100%"><tr style="background-image:url(';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img/menu_bg.jpg)"><td width="5" height="18"></td><td width="10"><img src="';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img_admin/cheie.gif" alt="" class="icon"></td><td style="padding-left:3px"><a href="';  echo $this->_tpl_vars['URL_ADMIN'];  echo 'modifica_parola.php" class="menu_left2" title="Modifica parola">Modifica parola</a></td></tr></table></td></tr></table></td></tr>'; ?>