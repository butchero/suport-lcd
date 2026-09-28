-- Scoate linia "Garantie: 2 ani" pusa manual in descriere.
-- Nu a fost executat.
-- In baza locala apare la produsele 62, 81, 82, 83 si 84.

START TRANSACTION;

UPDATE t_produse
SET descriere_produs = TRIM(BOTH '\r\n' FROM
	REPLACE(
	REPLACE(
	REPLACE(
	REPLACE(
	REPLACE(
	REPLACE(descriere_produs,
		'Garantie: 2 ani \r\n', ''),
		'Garantie: 2 ani\r\n', ''),
		'Garantie: 2 ani<br />\r\n', ''),
		'Garantie: 2 ani<br/>\r\n', ''),
		'Garantie: 2 ani<br />', ''),
		'Garantie: 2 ani<br/>', '')
)
WHERE descriere_produs LIKE '%Garantie: 2 ani%';

COMMIT;
