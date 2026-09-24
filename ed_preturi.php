<?php
	require_once('conectare.php');

    $api_link = 'https://dropshipping.dedeman.ro/api';
    $api_user ='star.line.novelty';
    $api_pass = 'k85*{wUlA{n[[G+[V&h%';

    function getApiToken()
    {
        global $api_link, $api_user, $api_pass;

        $auth_link = $api_link . '/auth/login';

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $auth_link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
            'username' => $api_user,
            'password' => $api_pass
        ]));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: text/plain']);

        $result = curl_exec($ch);
        $arr_result = json_decode($result, true);
        $token = $arr_result['body']['token'];

        return $token;
    }

	if (isset($_POST['afiseaza_stoc'])) {
        $token = getApiToken();

		if (!empty($token)) {
			$stock_link = $api_link . '/suppliers/stocks';
			$authorization = 'Authorization: Bearer ' . $token;

			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, $stock_link);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
			curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json' , $authorization]);

			$result = curl_exec($ch);

			$arr_result = json_decode($result, true);

            $stock = [];

            foreach ($arr_result['body'] as $value) {
                $stock[$value['ean']] = $value['stock'];
            }
		}
	}
	
	if (isset($_REQUEST['modifica'])) {
        $post_fields = [];

        // submit action
        if (isset($_POST['modifica'])) {
            foreach ($_POST['pret_produs'] as $key => $value) {
                $mysqli->query("UPDATE t_produse SET 
                        pret = '" . $mysqli->real_escape_string(str_replace(",", "", $value)) . "',
                        cod_produs = '" . $mysqli->real_escape_string(trim($_POST['cod_produs'][$key])) . "',
                        nr_bucati = '" . intval($_POST['nr_bucati'][$key]) . "'
                    WHERE id_produs='" . intval($key) . "'");

                if (strlen(trim($_POST['cod_produs'][$key])) == 13) {
                    $post_fields[] = [
                        'ean' => trim($_POST['cod_produs'][$key]),
                        'stock' => intval($_POST['nr_bucati'][$key])
                    ];
                }
            }
        }

        // cron action
        if (isset($_GET['modifica'])) {
            $sql = "SELECT * FROM t_produse AS a LEFT JOIN t_categorii AS b ON a.id_cat = b.id_cat WHERE activ = 1 ORDER BY id_produs ASC";
            $result=$mysqli->query($sql);

            while ($row = $result->fetch_assoc()) {
                if (strlen($row['cod_produs']) == 13) {
                    $post_fields[] = [
                        'ean' => $row['cod_produs'],
                        'stock' => $row['nr_bucati']
                    ];
                }
            }
        }

        $token = getApiToken();

        if (!empty($token)) {
            $stock_link = $api_link . '/suppliers/updateStocks';
            $authorization = 'Authorization: Bearer ' . $token;

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $stock_link);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_fields));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json' , $authorization]);

            $result = curl_exec($ch);
            $arr_result = json_decode($result, true);

            $filename = "cron.txt";
            $content = "Cronul a rulat cu succes la ora: " . date('Y-m-d H:i:s');
        }
		
		print "<p style='color:green;font-weight:bold'>Datele au fost modificate cu succes!</p>";

        file_put_contents($filename, $content);
	}
	
	$sql = "SELECT * FROM t_produse AS a LEFT JOIN t_categorii AS b ON a.id_cat = b.id_cat WHERE activ = 1 ORDER BY id_produs ASC";
	$result=$mysqli->query($sql);
?>
<!DOCTYPE HTML>
<html lang="ro">
<head>
</head>
<body>
<?php
	print "<form action='' method='post'>
			<input type='submit' name='modifica' value='Salveaza datele' style='background-color:green;color:#fff;padding:5px;'>
			<input type='submit' name='afiseaza_stoc' value='Afiseaza stoc DEDEMAN' style='background-color:blue;color:#fff;padding:5px;'>
			<a href='/ed_preturi.php'>Vezi toate produsele</a>
			<table border='1' cellpadding='5' style='border-collapse:collapse;margin-top:10px'>
			   <tr><td colspan='4'><i>Preturile se introduc fara TVA! Site-ul adauga tva-ul!</td></tr>
			   <tr><td colspan='4'><i>Cand se actualizeaza datele se trimite stocul in DEDEMAN!</td></tr>
			   <tr>
			   	   <td><b>Nume produs</b></td>
			   	   <td><b>Cod EAN - 13 caractere numerice</b></td>
			   	   <td><b>Pret produs</b></td>
			   	   <td><b>Nr. bucati</b></td>";

    if (isset($_POST['afiseaza_stoc'])) {
        print "<td><b>Stoc DEDEMAN</b></td>";
    }

	print " 	</tr>";
	
	while ($row = $result->fetch_assoc()) {
        if (isset($_POST['afiseaza_stoc']) && !array_key_exists($row['cod_produs'], $stock)) {
            continue;
        }

		print "<tr>
		           <td>" . $row['nume_produs'] . "</td>
		           <td><input type='text' name='cod_produs[" . $row['id_produs'] . "]' value='" . $row['cod_produs'] . "'></td>
				   <td><input type='text' name='pret_produs[" . $row['id_produs'] . "]' value='" . number_format($row['pret'], 2) . "'></td>
				   <td><input type='text' name='nr_bucati[" . $row['id_produs'] . "]' value='" . $row['nr_bucati'] . "'></td>";

        if (isset($_POST['afiseaza_stoc'])) {
            print "<td><b style='color:blue'>" . $stock[$row['cod_produs']] . "</b></td>";
        }

		print "	   </tr>";
	}
	
	print "</table>";
?>
</body>
</html>

