{strip}
<html>
	<head>
		<title>Newsletter</title>		
 		<link href="{$DIR_TEMPLATE}stylesheet.css" type="text/css" rel="stylesheet">
	</head>
	<script src="/javascript/jslib/overlib.js" type="text/javascript"></script>
	<script>
		var email_parinte=opener.document.getElementById('email');
	</script>
	<body style="margin-left:5px;margin-top:5px;margin-right:5px">
		<table cellpadding="5" cellspacing="0" width="100%" class="box">
			<tr>
				<td height="80" style="padding:10px"><img src="{$DIR_TEMPLATE}img/sigla.jpg" alt="{$NUME_FIRMA}"></td>
				<td class="eroare_text"><b>{$mesaj}</b></td>
			</tr>
			<tr><td colspan="2" height="1" class="bg_spatiu"></td></tr>			
			<tr>
				<td colspan="2" align="right">
					<a href="#" onClick="email_parinte.value='';email_parinte.focus();window.self.close()" class="link_default">Inchide fereastra</a>
				</td>
			</tr>			
		</table>
		<br />
		<p align="center">&copy; 2006 {$NUME_FIRMA}</p>
	</body>
</html>
{/strip}