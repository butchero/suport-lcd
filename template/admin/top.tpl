{strip}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Administrare</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="ROBOTS" content="noindex, nofollow">
	<style type="text/css" media="all">
		@import "{$DIR_TEMPLATE}admin/stylesheet.css";
	</style>
</head>
<body>
<script type="text/javascript" src="{$URL_BASE}javascript/functii_admin.js"></script>
<script type="text/javascript" src="{$URL_BASE}javascript/functii.js"></script>
<a name="top"></a>
{*--DIV-ul CARE ACOPERA TOATA FEREASTRA SI INCHIDE CULOAREA--*}
<div id="cover_all"></div>
{*--CASUTA CONFIRMARE PT STERGERE, LOGOUT, ETC--*}
<div id="casuta_confirmare"></div> 
<center>
<script type="text/javascript" language="javascript">
	var loader = "<table><tr><td><img src=\"{$DIR_TEMPLATE}img/loader.gif\" alt=\"\"></td><td>Actualizez...</td></tr></table>";
</script>
<table cellpadding="0" cellspacing="0">
	<tr>
		<td align="center">			
		<table width="932" cellpadding="0" cellspacing="0">
			<tr>
				<td align="center"></td>
				<td align="right" valign="middle" colspan="2">
					<div id="indicator_top" style="display:none;margin-top:20px;">
						<table>
							<tr>
								<td><img src="{$DIR_TEMPLATE}img/loader.gif" alt=""></td>
								<td>Actualizez...</td>
							</tr>	
						</table>
					</div>
				</td>								
			</tr>
			<tr>
				<td align="center" colspan="3" style="padding:2px">	
					<table width="100%" cellpadding="0" cellspacing="0" class="box">
						<tr>
							<td class="bg_spatiu" style="padding:5px" align="left">
								Bine ai revenit {if $super_admin eq "1"}super-administrator{else}administrator{/if} <b>{$username}</b> ! - Ultima logare: <b>{$ultima_logare}</b>
							</td>
							<td class="bg_spatiu" style="padding:5px" align="right">
								<a href="{$URL_ADMIN}" title="Revino pe prima pagina a administrarii" class="link_default">Prima pagina admin</a>
								&nbsp;-&nbsp;
								<a href="{$URL_BASE}" title="Revino pe prima pagina a administrarii" class="link_default" target="_blank">Prima pagina site</a>								
								&nbsp;-&nbsp;
								<a href="#" onclick="casutaConfirmare('Sunteti sigur ca doriti sa iesiti ?', '400', '{$URL_ADMIN}logout.php'); return false;" class="link_default">Iesire</a>
							</td>								
						</tr>
					</table>					
				</td>
			</tr>
			<tr><td colspan="3" height="3"></td></tr>			
{/strip}			