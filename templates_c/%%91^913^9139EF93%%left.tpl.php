<?php /* Smarty version 2.6.12, created on 2013-11-06 00:34:38
         compiled from left.tpl */ ?>
<div id="left">
	<div id="categorii"></div>
	<ul>
		<?php unset($this->_sections['sec']);
$this->_sections['sec']['name'] = 'sec';
$this->_sections['sec']['loop'] = is_array($_loop=$this->_tpl_vars['left_menu']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
			<?php if ($this->_tpl_vars['left_menu'][$this->_sections['sec']['index']]['activ'] == '1'): ?>
				<li>
					<?php if ($this->_tpl_vars['left_menu'][$this->_sections['sec']['index']]['nume_cat'] == 'Serend' || $this->_tpl_vars['left_menu'][$this->_sections['sec']['index']]['nume_cat'] == 'Mobuler' || $this->_tpl_vars['left_menu'][$this->_sections['sec']['index']]['nume_cat'] == 'Brateck'): ?>
						<span class="menu_left"><?php echo $this->_tpl_vars['left_menu'][$this->_sections['sec']['index']]['nume_cat']; ?>
</span>
					<?php else: ?>
					<a href="<?php echo $this->_tpl_vars['left_menu'][$this->_sections['sec']['index']]['link_cat']; ?>
" title="<?php echo $this->_tpl_vars['left_menu'][$this->_sections['sec']['index']]['nume_cat']; ?>
" class="<?php if ($this->_tpl_vars['left_menu'][$this->_sections['sec']['index']]['nivel'] == '0'): ?>menu_left<?php else: ?>submenu_left<?php endif;  if ($this->_tpl_vars['left_menu'][$this->_sections['sec']['index']]['id_cat'] == $this->_tpl_vars['cat_selectata']): ?> item_selectat<?php endif; ?>">
						<?php echo $this->_tpl_vars['left_menu'][$this->_sections['sec']['index']]['nume_cat']; ?>

					</a>
					<?php endif; ?>
				</li>
			<?php endif; ?>
		<?php endfor; endif; ?>	
	</ul>
</div>