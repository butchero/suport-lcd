<?php /* Smarty version 2.6.12, created on 2013-04-14 15:34:59
         compiled from admin/ordoneaza_filtre.tpl */ ?>
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
  echo '';  endif;  echo '';  echo '';  echo '<table cellpadding="0" cellspacing="0" class="menu_container" style="background:url(';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img/bg_menu.gif);border-top:1px solid #F2F2F2;border-left:1px solid #F2F2F2;border-right:1px solid #F2F2F2;"><tr><td align="left" class="menu_title" height="18" style="padding-left:2px;padding-right:2px"><h2>Ordoneaza filtrele definite pe categoria: <font class="titlu_cat">';  echo $this->_tpl_vars['nume_cat'];  echo '</font></h2></td></tr></table>';  echo '<script type="text/javascript" src="/javascript/scriptaculous-js-1.5.3/prototype.js"></script><script type="text/javascript" src="/javascript/scriptaculous-js-1.5.3/scriptaculous.js"></script><table cellpadding="5" cellspacing="0" class="box" width="557" style="background-color:#F2F2F2"><tr>';  echo '<td colspan="2"><ul><li>In aceasta pagina aveti posibilitatea de a ordona filtrele definite pentru o categorie.</li><li>Ordonarea se face prin drag & drop.</li><li class="atentie">ATENTIE: Nu exista confirmare pentru ordonarea.</li></ul></td></tr>';  echo '<tr><td width="400"><ul id="filtre_list" class="sortable-list">';  unset($this->_sections['sec']);
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
 echo '<li id="categorie_';  echo $this->_tpl_vars['filtre'][$this->_sections['sec']['index']]['id_filtru'];  echo '">';  echo $this->_tpl_vars['filtre'][$this->_sections['sec']['index']]['nume_filtru'];  echo '</li>';  endfor; endif;  echo '</ul>';  echo '
				<script type="text/javascript">
					//ordoneazaFiltre() e definita in functii/functii_admin.js
			    	Sortable.create(\'filtre_list\', { onUpdate : ordoneazaFiltre });
			    </script>
			    ';  echo '<center><form action="" method="POST"><input type="submit" name="ordoneaza_alfabetic" value="RESETEAZA LA ORDONAREA ALFABETICA" class="buton_cool" style="width:260px"></form></center></td><td valign="middle" width="157"><div id="indicator" style="display:none;margin:10"><img src="';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img/loader.gif" alt="">Ordonez...</div></td></tr></table>';  echo '<p align="center"><a href="';  echo $this->_tpl_vars['link_inapoi'];  echo '" class="link_default">&laquo; Inapoi</a></p><p align="right"><a href="#top"><img src="';  echo $this->_tpl_vars['DIR_TEMPLATE'];  echo 'img/top.gif" alt="top"></a></p></td></tr></table></td>'; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/right.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/bottom.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>