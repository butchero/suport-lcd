{strip}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Autentificare administrator</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="description" content="Magazin online">	
	<meta name="ROBOTS" content="nofollow">
	<link href="{$DIR_TEMPLATE}admin/stylesheet.css" type="text/css" rel="stylesheet">
</head>
<body>
<center>
	<div style="margin-top:50px">
		<div style="margin:10px">
			<font class="eroare_form"><b>{$acces_check.eroare}</b></font>
		</div>
		<table>
			<tr>
				<td>
					<form action="" method="POST">
					<table cellpadding="2" cellspacing="0" class="box">
						<tr>
							<td align="center"><img src="{$DIR_TEMPLATE}img_admin/sigla.png" alt="{$NUME_FIRMA} - ADMINISTRARE" style="margin:10px"></td>
						</tr>
						<tr>
							<td class="bg_spatiu" align="center">
								<table>
									<tr>
										<td align="right"><b>Username:</b></td>
										<td><input type="text" name="admin_username"></td>
									</tr>
									<tr>
										<td align="right"><b>Parola:</b></td>
										<td><input type="password" name="admin_parola"></td>
									</tr>
									<tr>
										<td></td>
										<td align="left"><input type="submit" name="admin_login" value="LOGIN"></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					</form>
					<div class="box" style="margin-top:10px;padding:2px;text-align:center;background-color:#F2F2F2">
						<a href="{$URL_BASE}" class="link_default">Pagina principala</a>
					</div>
				</td>
			</tr>		
		</table>
	</div>
	<br />
	&copy 2010 {$NUME_FIRMA}	
</center>			
{/strip}	