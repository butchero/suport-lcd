<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xml:lang="en" lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>{$titlu_pagina|default:""}</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="description" content="{$titlu_pagina|default:""} - Catalog suporti LCD, suporti LED, suporti plasma, suporti TV marca Serend si Mobuler" />
	<meta name="keywords" content="{$keywords}" />
	<meta name="robots" content="index, follow" />
	<style type="text/css" media="all">
		@import "{$DIR_TEMPLATE}style.css";
		<!--[if IE 6]>@import "{$DIR_TEMPLATE}ie6.css";<![endif]-->
		<!--[if IE 7]>@import "{$DIR_TEMPLATE}ie7.css";<![endif]-->
	</style>
	<link rel="shortcut icon" href="{$DIR_TEMPLATE}img/favicon.ico" />
</head>
<body>
<div id="container">
	<a name="top"></a>
	<div id="header">
		<div id="logo" onclick="document.location.href='{$URL_BASE}'"><a href="{$URL_BASE}" title="Suport LCD, Suporti LCD TV Plasma, Suporturi LCD TV Plasma">Suport LCD</a></div>
		<div id="meniu">
			<a href="#" title="Suport LCD" class="home" onclick="document.location.href='{$URL_BASE}'" rel="nofollow"></a>
			<a href="{$LINK_DESPRE_NOI}" title="Despre noi" class="despre" rel="nofollow"></a>
			<a href="{$LINK_CONTACT}" title="Contact" class="contact" rel="nofollow"></a>
			<a href="{$LINK_SITEMAP}" title="Sitemap" class="sitemap"></a>
		</div>
	</div>
	{if $show_promo eq 1}
	<div id="suport">
		<a href="{$LINK_TOATE_PRODUSELE}" title="Toate produsele"><img src="{$DIR_TEMPLATE}img/suport.jpg" alt="Toate produsele" /></a>
	</div>
	{/if}
	<div id="content">
		<h1>{$titlu_pagina}</h1>
		<div class="content-sus"></div>
		<div class="content-mid">