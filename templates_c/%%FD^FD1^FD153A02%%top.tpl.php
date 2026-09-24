<?php /* Smarty version 2.6.12, created on 2013-04-14 15:33:34
         compiled from top.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'top.tpl', 4, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xml:lang="en" lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo ((is_array($_tmp=@$this->_tpl_vars['titlu_pagina'])) ? $this->_run_mod_handler('default', true, $_tmp, "") : smarty_modifier_default($_tmp, "")); ?>
</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="description" content="<?php echo ((is_array($_tmp=@$this->_tpl_vars['titlu_pagina'])) ? $this->_run_mod_handler('default', true, $_tmp, "") : smarty_modifier_default($_tmp, "")); ?>
 - Catalog suporti LCD, suporti LED, suporti plasma, suporti TV marca Serend si Mobuler" />
	<meta name="keywords" content="<?php echo $this->_tpl_vars['keywords']; ?>
" />
	<meta name="robots" content="index, follow" />
	<style type="text/css" media="all">
		@import "<?php echo $this->_tpl_vars['DIR_TEMPLATE']; ?>
style.css";
		<!--[if IE 6]>@import "<?php echo $this->_tpl_vars['DIR_TEMPLATE']; ?>
ie6.css";<![endif]-->
		<!--[if IE 7]>@import "<?php echo $this->_tpl_vars['DIR_TEMPLATE']; ?>
ie7.css";<![endif]-->
	</style>
	<link rel="shortcut icon" href="<?php echo $this->_tpl_vars['DIR_TEMPLATE']; ?>
img/favicon.ico" />
</head>
<body>
<div id="container">
	<a name="top"></a>
	<div id="header">
		<div id="logo" onclick="document.location.href='<?php echo $this->_tpl_vars['URL_BASE']; ?>
'"><a href="<?php echo $this->_tpl_vars['URL_BASE']; ?>
" title="Suport LCD, Suporti LCD TV Plasma, Suporturi LCD TV Plasma">Suport LCD</a></div>
		<div id="meniu">
			<a href="#" title="Suport LCD" class="home" onclick="document.location.href='<?php echo $this->_tpl_vars['URL_BASE']; ?>
'" rel="nofollow"></a>
			<a href="<?php echo $this->_tpl_vars['LINK_DESPRE_NOI']; ?>
" title="Despre noi" class="despre" rel="nofollow"></a>
			<a href="<?php echo $this->_tpl_vars['LINK_CONTACT']; ?>
" title="Contact" class="contact" rel="nofollow"></a>
			<a href="<?php echo $this->_tpl_vars['LINK_SITEMAP']; ?>
" title="Sitemap" class="sitemap"></a>
		</div>
	</div>
	<?php if ($this->_tpl_vars['show_promo'] == 1): ?>
	<div id="suport">
		<a href="<?php echo $this->_tpl_vars['LINK_TOATE_PRODUSELE']; ?>
" title="Toate produsele"><img src="<?php echo $this->_tpl_vars['DIR_TEMPLATE']; ?>
img/suport.jpg" alt="Toate produsele" /></a>
	</div>
	<?php endif; ?>
	<div id="content">
		<h1><?php echo $this->_tpl_vars['titlu_pagina']; ?>
</h1>
		<div class="content-sus"></div>
		<div class="content-mid">