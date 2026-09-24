<?php /* Smarty version 2.6.12, created on 2011-06-06 21:11:28
         compiled from sitemap.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "top.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "left.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div id="right">
	<h3><?php echo $this->_tpl_vars['titlu_pagina']; ?>
</h3>
	
	<?php unset($this->_sections['sec']);
$this->_sections['sec']['name'] = 'sec';
$this->_sections['sec']['loop'] = is_array($_loop=$this->_tpl_vars['sitemap']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
?>
	<?php if ($this->_tpl_vars['sitemap'][$this->_sections['sec']['index']]['activ'] == '1' && $this->_tpl_vars['sitemap'][$this->_sections['sec']['index']]['nume_cat'] != 'Mobuler' && $this->_tpl_vars['sitemap'][$this->_sections['sec']['index']]['nume_cat'] != 'Serend'): ?>
		<?php echo $this->_tpl_vars['sitemap'][$this->_sections['sec']['index']]['indent']; ?>

		<a href="<?php echo $this->_tpl_vars['sitemap'][$this->_sections['sec']['index']]['link_cat']; ?>
" title="<?php echo $this->_tpl_vars['sitemap'][$this->_sections['sec']['index']]['nume_cat']; ?>
" class="<?php if ($this->_tpl_vars['sitemap'][$this->_sections['sec']['index']]['nivel'] == '0'): ?>menu_left<?php else: ?>submenu_left<?php endif; ?>">
			<?php echo $this->_tpl_vars['sitemap'][$this->_sections['sec']['index']]['nume_cat']; ?>
	
		</a>
		<br />
	<?php endif; ?>	
	<?php endfor; endif; ?>

	<br />
	<a href="<?php echo $this->_tpl_vars['URL_BASE']; ?>
" class="menu_left">Suport LCD, Suporti LCD, Suporturi LCD</a><br />
	<a href="<?php echo $this->_tpl_vars['LINK_DESPRE_NOI']; ?>
" class="menu_left" rel="nofollow">Despre Noi</a><br /> 
	<a href="<?php echo $this->_tpl_vars['LINK_CONTACT']; ?>
" class="menu_left" rel="nofollow">Contact</a>
						
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "right.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "bottom.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>