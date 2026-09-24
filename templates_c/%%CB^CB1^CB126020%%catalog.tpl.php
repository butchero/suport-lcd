<?php /* Smarty version 2.6.12, created on 2023-10-18 14:14:07
         compiled from catalog.tpl */ ?>
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
	<div class="nume-cat">
		<h2>
			<?php unset($this->_sections['sec']);
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
?>
				<?php if ($this->_tpl_vars['radacina'][$this->_sections['sec']['index']]['nume_radacina'] == 'Serend' || $this->_tpl_vars['radacina'][$this->_sections['sec']['index']]['nume_radacina'] == 'Mobuler'): ?>
						<span class="radacina"><?php echo $this->_tpl_vars['radacina'][$this->_sections['sec']['index']]['nume_radacina']; ?>
</span>
				<?php else: ?>
				<a href="<?php echo $this->_tpl_vars['radacina'][$this->_sections['sec']['index']]['link_radacina']; ?>
" title="<?php echo $this->_tpl_vars['radacina'][$this->_sections['sec']['index']]['nume_radacina']; ?>
" class="radacina">
					<?php echo $this->_tpl_vars['radacina'][$this->_sections['sec']['index']]['nume_radacina']; ?>

				</a>
				<?php endif; ?> 
				 &nbsp;
				<?php if (! $this->_sections['sec']['last']): ?>&raquo;<?php endif; ?>
			<?php endfor; endif; ?>	
		</h2>		
	</div>
	
	<div class="catalog-border"></div>
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
		<div class="<?php if ($this->_tpl_vars['produse'][$this->_sections['sec']['index']]['border'] != '1'): ?>produs-catalog-border<?php else: ?>produs-catalog<?php endif; ?>">
			<h3><a href="<?php echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['link_produs']; ?>
" title="<?php echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['nume_produs']; ?>
"><?php echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['nume_produs']; ?>
</a></h3>
			<?php if ($this->_tpl_vars['produse'][$this->_sections['sec']['index']]['pret_produs'] != "0,00"): ?>
			<span class="pret">Pret: <?php echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['pret_produs']; ?>
 <?php echo $this->_tpl_vars['MONEDA']; ?>
</span> <br />
			<?php endif; ?>
			<img src="<?php echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['adresa_poza_produs']; ?>
" alt="<?php echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['nume_produs']; ?>
" />
			<ul>
				<?php unset($this->_sections['subsec']);
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
?>								
					<li><strong><?php echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['caracteristici'][$this->_sections['subsec']['index']]['nume_carac']; ?>
</strong>: <?php echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['caracteristici'][$this->_sections['subsec']['index']]['val_carac']; ?>
</li>			
				<?php endfor; endif; ?>
			</ul>
			<a href="#" onclick="document.location.href='<?php echo $this->_tpl_vars['produse'][$this->_sections['sec']['index']]['link_produs']; ?>
'" class="detalii"></a>
		</div>
		<?php if ($this->_tpl_vars['produse'][$this->_sections['sec']['index']]['border'] == '1' && ! $this->_sections['sec']['last']): ?>
		<div class="catalog-border"></div>
		<?php endif; ?>
	<?php endfor; else: ?>
		<p>Momentan nu sunt produse in aceasta categorie.</p>	
	<?php endif; ?>
	
	<?php if ($this->_tpl_vars['produse'] != ""): ?>
	<div class="paginare">
		<?php echo $this->_tpl_vars['paginare']; ?>

	</div>
	<div class="nota">
		<strong>Nota:</strong> Preturile contin TVA. Pentru informatii suplimentare contactati-ne pe formularul de <a href="<?php echo $this->_tpl_vars['LINK_CONTACT']; ?>
" title="Contact" rel="nofollow" class="link">contact</a> sau la unul din telefoanele: <strong><?php echo $this->_tpl_vars['TELEFON_COMENZI']; ?>
</strong>
	</div>	
	<?php endif; ?>
</div>				

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "bottom.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>