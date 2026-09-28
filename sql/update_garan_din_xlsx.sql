-- Update GARAN din private/GARAN.xlsx. Nu a fost executat.
-- Potrivire: token de model din denumire, intai cod_produs, apoi nume_produs daca potrivirea este unica.
START TRANSACTION;
UPDATE t_produse SET furnizor='GENCOM STAR E-M SRL', cod_produs='8693640000237', warranty_months=60, garan_eligible=1 WHERE id_produs=2; -- SUPORT LCD 01 237 => Suport LCD 237 vechi [cod_produs 237]
UPDATE t_produse SET furnizor='GENCOM STAR E-M SRL', cod_produs='8693640000718', warranty_months=60, garan_eligible=1 WHERE id_produs=165; -- SUPORT ARAGAZ/FRIGIDER BT 02 => Suport aragaz frigider BT 02 [cod_produs BT02]
UPDATE t_produse SET furnizor='GENCOM STAR E-M SRL', cod_produs='8693640000503', warranty_months=60, garan_eligible=1 WHERE id_produs=34; -- SUPORT CUPTOR MICROUNDE DK503 => Suport cuptor microunde DK 503 [nume_produs DK503]
UPDATE t_produse SET furnizor='GENCOM STAR E-M SRL', warranty_months=60, garan_eligible=1 WHERE id_produs=4; -- SUPORT LCD 251 DL => Suport LCD LED 251; EAN din Excel este 8010593 (7 cifre), codul nu se schimba
UPDATE t_produse SET furnizor='GENCOM STAR E-M SRL', cod_produs='8693640000428', warranty_months=60, garan_eligible=1 WHERE id_produs=33; -- SUPORT RECEIVER / DVD RS 428 => Suport receiver RS 428 [nume_produs RS428]
UPDATE t_produse SET furnizor='GENCOM STAR E-M SRL', cod_produs='8693640000909', warranty_months=60, garan_eligible=1 WHERE id_produs=173; -- SUPORT LCD PLASMA PLZ 909 => Suport LCD PLASMA PLZ 909 [cod_produs PLZ909]
UPDATE t_produse SET furnizor='GENCOM STAR E-M SRL', warranty_months=60, garan_eligible=1 WHERE id_produs=1; -- SUPORT LCD 220 25-68CM => Suport LCD LED 220; EAN din Excel este 8013756 (7 cifre), codul nu se schimba
UPDATE t_produse SET furnizor='GENCOM STAR E-M SRL', cod_produs='8693640005379', warranty_months=60, garan_eligible=1 WHERE id_produs=106; -- SUPORT LCD H 480 => SUPORT LCD , LED TV H 480 [nume_produs H480]
UPDATE t_produse SET furnizor='GENCOM STAR E-M SRL', cod_produs='8693640005355', warranty_months=60, garan_eligible=1 WHERE id_produs=104; -- SUPORT LCD H 190 => SUPORT LCD , LED TV H 190 [nume_produs H190]
UPDATE t_produse SET furnizor='GENCOM STAR E-M SRL', cod_produs='8693640005362', warranty_months=60, garan_eligible=1 WHERE id_produs=105; -- SUPORT LCD H 260 => SUPORT LCD , LED TV H 260 [nume_produs H260]
UPDATE t_produse SET furnizor='GENCOM STAR E-M SRL', cod_produs='8693640005300', warranty_months=60, garan_eligible=1 WHERE id_produs=164; -- SUPORT LCD S 200 ZZ => Suport LCD S200 [cod_produs S200]
UPDATE t_produse SET furnizor='GENCOM STAR E-M SRL', warranty_months=60, garan_eligible=1 WHERE id_produs=83; -- SUPORT LCD 113 DL => Suport LCD LED 113; EAN din Excel este 8030413 (7 cifre), codul nu se schimba
UPDATE t_produse SET furnizor='GENCOM STAR E-M SRL', warranty_months=60, garan_eligible=1 WHERE id_produs=84; -- SUPORT LCD 114 DL => Suport LCD LED 114; EAN din Excel este 8030414 (7 cifre), codul nu se schimba
UPDATE t_produse SET furnizor='GENCOM STAR E-M SRL', cod_produs='8693640000367', warranty_months=60, garan_eligible=1 WHERE id_produs=96; -- SUPORT LCD COD PLZ 360 => Suport LCD , LED TV PLZ 360 [nume_produs PLZ360]
UPDATE t_produse SET furnizor='GENCOM STAR E-M SRL', cod_produs='8693640002231', warranty_months=60, garan_eligible=1 WHERE id_produs=97; -- SUPORT LCD 2231 => SUPORT LCD , LED TV 2231 [cod_produs 2231]
UPDATE t_produse SET furnizor='GENCOM STAR E-M SRL', cod_produs='8693640000886', warranty_months=60, garan_eligible=1 WHERE id_produs=98; -- SUPORT LCD SD 740 => SUPORT LCD , LED TV SD 740 [nume_produs SD740]
UPDATE t_produse SET furnizor='GENCOM STAR E-M SRL', cod_produs='8693640000923', warranty_months=60, garan_eligible=1 WHERE id_produs=99; -- SUPORT LCD PLZ-923 => SUPORT LCD , LED TV 923 [cod_produs 923]
UPDATE t_produse SET furnizor='GENCOM STAR E-M SRL', cod_produs='8693640002316', warranty_months=60, garan_eligible=1 WHERE id_produs=121; -- SUPORT LCD 2316 => SUPORT LCD LED TV 2316 [cod_produs 2316]
UPDATE t_produse SET furnizor='GENCOM STAR E-M SRL', cod_produs='8693640002323', warranty_months=60, garan_eligible=1 WHERE id_produs=120; -- SUPORT LCD 2323 => SUPORT LCD LED TV 2323 [cod_produs 2323]
UPDATE t_produse SET furnizor='GENCOM STAR E-M SRL', cod_produs='6956745154925', warranty_months=60, garan_eligible=1 WHERE id_produs=134; -- SUPORT LCD 116 DL => Suport lcd led tv 116 [cod_produs 116]
UPDATE t_produse SET furnizor='GENCOM STAR E-M SRL', cod_produs='6974215089782', warranty_months=60, garan_eligible=1 WHERE id_produs=167; -- SUPORT TV LED 216 => Suport lcd LED 216 [nume_produs 216]
UPDATE t_produse SET furnizor='GENCOM STAR E-M SRL', cod_produs='6974215089799', warranty_months=60, garan_eligible=1 WHERE id_produs=160; -- SUPORT TV LED 215 => Suport TV 215 [cod_produs 215]
UPDATE t_produse SET furnizor='GENCOM STAR E-M SRL', cod_produs='8693640000848', warranty_months=60, garan_eligible=1 WHERE id_produs=166; -- SUPORT LCD CU PRINDERE DE TAVAN TA6095 => Suport cu prindere de tavan TA 6095 [cod_produs TA6095]
COMMIT;
