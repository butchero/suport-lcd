-- Aliniere marca GARAN dupa import productie.
-- Serend = t_categorii.id_cat 5, STAR-LINE = t_categorii.id_cat 25.
-- id_prod din t_produse este id_cat din t_categorii (producator).
-- Furnizorul GENCOM ramane neschimbat (importator, nu marca).
--
-- Nu sunt in catalog (nu se pot alinia): WMS-02M, LCD 115 (EAN 6956745154932), LCD LED 200.
-- #1 (220) si #4 (251) pastreaza codul scurt de model; EAN-urile Dedeman 8013756/8010593 nu inlocuiesc cod_produs.

START TRANSACTION;

-- STAR-LINE (in DB erau pe Serend)
UPDATE t_produse SET id_prod=25 WHERE id_produs IN (160, 167);

-- Serend (in DB aveau id_prod=0)
UPDATE t_produse SET id_prod=5 WHERE id_produs IN (83, 84, 120, 121);

-- Coduri EAN lipsa pe 113 / 114 (GARAN.csv)
UPDATE t_produse SET cod_produs='8030413' WHERE id_produs=83 AND (cod_produs IS NULL OR TRIM(cod_produs)='');
UPDATE t_produse SET cod_produs='8030414' WHERE id_produs=84 AND (cod_produs IS NULL OR TRIM(cod_produs)='');

COMMIT;
