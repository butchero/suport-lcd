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
				<textarea rows="6" cols="90" name="main_text">
					{$main_text}
				</textarea>
			</td>
		</tr>
		<tr><td>Numarul scrisorii de transport ce insoteste coletul dvs este: <input type="text" name="nr_scrisoare" size="8">.</td></tr>
		<tr><td>Totalul fara TVA al comenzii dumneavoastra este: <input type="text" name="total_comanda" value="{$total_comanda_fara_tva}" size="10"> <b>{$MONEDA}</b>.</td></tr>
		<tr><td>Totalul facturii dumneavoastra este: <input type="text" name="total_factura" size="10"> <b>{$MONEDA}</b>.</td></tr>
		<tr>
			<td>
				<input type="radio" name="opt" value="1" checked> {$opt1} <br />
				<input type="radio" name="opt" value="2"> {$opt2}
			</td>
		</tr>
		<tr><td>Taxa ramburs pe care urmeaza sa o achitati la ridicarea coletului este <input type="text" name="taxa_ramburs" value="" size="4">{$MONEDA}</td></tr>
		<tr><td><input type="checkbox" name="retrimite_proforma" value="1"> Va retrimitem proforma atasata in format pdf, deoarece comanda dvs. a suferit modificari.</td></tr>
		<tr>
			<td>
				<b>Mentiuni:</b> <br />
				<textarea name="mentiuni" rows="3" cols="90"></textarea>
				<br /><br />
				<center><input type="submit" name="trimite" value="TRIMITE" class="buton_cool"></center>
			</td>
		</tr>	
	</table>
</form>
</body>
</html>
{/strip}