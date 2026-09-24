{strip}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Onoreaza comanda</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="ROBOTS" content="nofollow">
	<style type="text/css" media="all">
		@import "{$DIR_TEMPLATE}admin/stylesheet.css";
	</style>
</head>
<body>
<form action="{$URL_ADMIN}onoreaza_comanda.php?id_comanda={$id_comanda}" method="POST">
	<table cellpadding="10" cellspacing="0">
		<tr><td style="padding:5px"><img src="{$DIR_TEMPLATE}img_admin/sigla.jpg" alt="{$NUME_FIRMA}"></td></tr>
		<tr>
			<td>
				Mesaj confirmare comanda: <br />				
				<textarea rows="30" cols="90" name="main_text"></textarea>
			</td>
		</tr>		
		<tr>
			<td>			
				<center><input type="submit" name="trimite" value="TRIMITE" class="buton_cool"></center>
			</td>
		</tr>	
	</table>
</form>
</body>
</html>
{/strip}