<?php /* Smarty version 2.6.12, created on 2014-10-02 09:04:37
         compiled from index.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "top.tpl", 'smarty_include_vars' => array('show_promo' => '1')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "left.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div id="right">
	<div id="container-ult-prod">
		<div id="ultimele-produse"></div>
		<div class="container-produse">
			<?php unset($this->_sections['sec']);
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
?>
			<div class="produs<?php if (! $this->_sections['sec']['last']): ?> produs-border<?php endif; ?>">
				<h3><a href="<?php echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['link_produs']; ?>
" title="<?php echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['nume_produs']; ?>
"><?php echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['nume_produs']; ?>
</a></h3>
				<a href="<?php echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['link_produs']; ?>
" title="<?php echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['nume_produs']; ?>
" rel="nofollow">
					<img src="<?php echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['adresa_poza_produs']; ?>
" alt="" />
				</a>
				<a href="<?php echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['link_produs']; ?>
" title="<?php echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['nume_produs']; ?>
" class="detalii"><?php echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['nume_produs']; ?>
</a>
			</div>
			<?php endfor; endif; ?>
		</div>
	</div>
	<div id="container-despre-noi">
		<div id="despre-noi"></div>
		<?php echo $this->_tpl_vars['text_despre_noi']; ?>

	</div>
	<div id="container-contact">
		<div id="contact"></div>
		<?php echo $this->_tpl_vars['text_contact']; ?>

		<p><a href="<?php echo $this->_tpl_vars['LINK_CONTACT']; ?>
" rel="nofollow" class="citeste">Vezi formular de contact</a></p>
	</div>
</div>	

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "bottom.tpl", 'smarty_include_vars' => array('show_links' => '1','seo_index' => '1')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>