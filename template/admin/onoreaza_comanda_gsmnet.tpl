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
				<b>Buna ziua</b>,
				<br /><br />
				<textarea rows="9" cols="90" name="main_text">
					{$main_text}
				</textarea>
			</td>
		</tr>				
		<tr>
			<td>
				<input type="radio" name="opt" value="1" {if $opt_selectata neq 0}checked{/if}> {$opt1} <br />
				<input type="radio" name="opt" value="2" {if $opt_selectata eq 0}checked{/if}> {$opt2}
			</td>
		</tr>
		<tr><td>Taxa ramburs(<i>valoare comanda cu TVA + transport</i>) pe care urmeaza sa o achitati la ridicarea coletului este <input type="text" name="taxa_ramburs" value="{$total_comanda}" size="8"> <b>{$MONEDA}</b>.</td></tr>
		<tr><td><input type="checkbox" name="retrimite_proforma" value="1"> <b>Va retrimitem proforma atasata in format pdf, deoarece comanda dvs. a suferit modificari.</b></td></tr>
		<tr>
			<td>
				<b>Mentiuni:</b> <br />
				<textarea name="mentiuni" rows="4" cols="90"></textarea>
				<br /><br />
				<center><input type="submit" name="trimite" value="TRIMITE" class="buton_cool"></center>
			</td>
		</tr>	
	</table>
</form>
</body>
</html>
{/strip}