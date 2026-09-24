<?php /* Smarty version 2.6.12, created on 2018-05-13 20:11:13
         compiled from contact.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'upper', 'contact.tpl', 5, false),array('modifier', 'wordwrap', 'contact.tpl', 17, false),)), $this); ?>
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
	<h3>CONTACT <?php echo ((is_array($_tmp=$this->_tpl_vars['NUME_FIRMA'])) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)); ?>
</h3>
	<div style="padding-left:5px"><span class="eroare_form"><b><?php echo ((is_array($_tmp=$this->_tpl_vars['mesaj'])) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)); ?>
</b></span></div>
	<table>
		<tr>									
			<td>
				<span class="mesaj"><?php echo $this->_tpl_vars['erori']; ?>
</span>									
				<form action="" method="post">
				<table>
					<tr>
						<td <?php if ($this->_tpl_vars['nume_check']['valid'] == '0'): ?>class="eroare_text"<?php endif; ?>>Nume *:</td>
						<td><input type="text" name="nume" value="<?php echo $this->_tpl_vars['nume_check']['camp']; ?>
" <?php if ($this->_tpl_vars['nume_check']['valid'] == '0'): ?>class="eroare_bg"<?php endif; ?> /></td>
						<td class="eroare_form" valign="top" style="padding-top:5px">
							<?php echo ((is_array($_tmp=$this->_tpl_vars['nume_check']['eroare'])) ? $this->_run_mod_handler('wordwrap', true, $_tmp, 35, "<br />") : smarty_modifier_wordwrap($_tmp, 35, "<br />")); ?>
		
						</td>
					</tr>
					<tr>
						<td <?php if ($this->_tpl_vars['email_check']['valid'] == '0'): ?>class="eroare_text"<?php endif; ?>>E-mail *:</td>
						<td><input type="text" name="email" value="<?php echo $this->_tpl_vars['email_check']['camp']; ?>
" <?php if ($this->_tpl_vars['email_check']['valid'] == '0'): ?>class="eroare_bg"<?php endif; ?> /></td>
						<td class="eroare_form" valign="top" style="padding-top:5px">
							<?php echo ((is_array($_tmp=$this->_tpl_vars['email_check']['eroare'])) ? $this->_run_mod_handler('wordwrap', true, $_tmp, 35, "<br />") : smarty_modifier_wordwrap($_tmp, 35, "<br />")); ?>
				
						</td>
					</tr>
					<tr>
						<td <?php if ($this->_tpl_vars['telefon_check']['valid'] == '0'): ?>class="eroare_text"<?php endif; ?>>Telefon *:</td>
						<td><input type="text" name="telefon" value="<?php echo $this->_tpl_vars['telefon_check']['camp']; ?>
" <?php if ($this->_tpl_vars['telefon_check']['valid'] == '0'): ?>class="eroare_bg"<?php endif; ?> /></td>
						<td class="eroare_form" valign="top" style="padding-top:5px">
							<?php echo ((is_array($_tmp=$this->_tpl_vars['telefon_check']['eroare'])) ? $this->_run_mod_handler('wordwrap', true, $_tmp, 35, "<br />") : smarty_modifier_wordwrap($_tmp, 35, "<br />")); ?>
			
						</td>
					</tr>
					<tr>
						<td <?php if ($this->_tpl_vars['mesaj_check']['valid'] == '0'): ?>class="eroare_text"<?php endif; ?>>Mesaj *:</td>
						<td><textarea name="mesaj" rows="4" cols="40" <?php if ($this->_tpl_vars['mesaj_check']['valid'] == '0'): ?>class="eroare_bg"<?php endif; ?>><?php echo $this->_tpl_vars['mesaj_check']['camp']; ?>
</textarea></td>
						<td class="eroare_form" valign="top" style="padding-top:5px">
							<?php echo ((is_array($_tmp=$this->_tpl_vars['mesaj_check']['eroare'])) ? $this->_run_mod_handler('wordwrap', true, $_tmp, 35, "<br />") : smarty_modifier_wordwrap($_tmp, 35, "<br />")); ?>
			
						</td>
					</tr>
					<tr>
						<td valign="top" <?php if ($this->_tpl_vars['cod_validare_check']['valid'] == '0'): ?>class="eroare_text"<?php endif; ?> style="padding-top:5px">Cod verificare *:</td>
						<td valign="top">
							<input type="text" name="cod_verificare" value="<?php echo $this->_tpl_vars['cod_validare_check']['camp']; ?>
" <?php if ($this->_tpl_vars['cod_validare_check']['valid'] == '0'): ?>class="eroare_bg"<?php endif; ?> size="22" />
							<br /><img src="<?php echo $this->_tpl_vars['URL_BASE']; ?>
imagine_cod_verificare.php" class="poza" alt="Poza cod verificare" style="margin-top:2px" />
						</td>
						<td class="eroare_form" valign="top" style="padding-top:5px">
							<?php echo ((is_array($_tmp=$this->_tpl_vars['cod_validare_check']['eroare'])) ? $this->_run_mod_handler('wordwrap', true, $_tmp, 35, "<br />") : smarty_modifier_wordwrap($_tmp, 35, "<br />")); ?>
			
						</td>
					</tr>
					<tr><td></td><td><input type="submit" name="trimite_mesaj" value="TRIMITE MESAJ" class="buton" /></td></tr>
				</table>
				</form>
				<iframe width="300" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=ro&amp;geocode=&amp;q=str.Ion+Ratiu,+nr.133A+Constanta&amp;sll=37.0625,-95.677068&amp;sspn=60.158465,135.263672&amp;ie=UTF8&amp;hq=&amp;hnear=Strada+Ion+Ra%C8%9Biu,+Constan%C8%9Ba,+Rom%C3%A2nia&amp;t=m&amp;ll=44.195498,28.645048&amp;spn=0.018461,0.025749&amp;z=14&amp;iwloc=A&amp;output=embed"></iframe><br /><small><a href="http://maps.google.com/maps?f=q&amp;source=embed&amp;hl=ro&amp;geocode=&amp;q=str.Ion+Ratiu,+nr.133A+Constanta&amp;sll=37.0625,-95.677068&amp;sspn=60.158465,135.263672&amp;ie=UTF8&amp;hq=&amp;hnear=Strada+Ion+Ra%C8%9Biu,+Constan%C8%9Ba,+Rom%C3%A2nia&amp;t=m&amp;ll=44.195498,28.645048&amp;spn=0.018461,0.025749&amp;z=14&amp;iwloc=A" style="color:#0000FF;text-align:left">Vizualizare harta marita</a></small>
			</td>
		</tr>
	</table>
		
	<hr />
	<?php echo $this->_tpl_vars['contact_text']; ?>

</div>	
	
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "bottom.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>