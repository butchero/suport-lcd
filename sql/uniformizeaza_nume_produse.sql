-- Uniformizare nume_produs. Nu a fost executat.
START TRANSACTION;
UPDATE t_produse SET nume_produs='Suport LCD 237 (vechi)' WHERE id_produs=2; -- Suport LCD 237 vechi => Suport LCD 237 (vechi)
UPDATE t_produse SET nume_produs='Suport LCD 282 (fix)' WHERE id_produs=7; -- Suport LCD 282 (FIX) => Suport LCD 282 (fix)
UPDATE t_produse SET nume_produs='Suport LCD 296 (fix)' WHERE id_produs=8; -- Suport LCD 296 (FIX) => Suport LCD 296 (fix)
UPDATE t_produse SET nume_produs='Suport LCD LED 299 - suport LCD LED si receiver de plafon' WHERE id_produs=10; -- Suport LCD LED 299 - Suport LCD LED si Receiver de plafon => Suport LCD LED 299 - suport LCD LED si receiver de plafon
UPDATE t_produse SET nume_produs='Suport LCD LED 275 - suport LCD LED de plafon' WHERE id_produs=11; -- Suport LCD LED 275 - Suport LCD LED de plafon => Suport LCD LED 275 - suport LCD LED de plafon
UPDATE t_produse SET nume_produs='Suport LCD LED 213 - suport LCD LED de plafon (cu rotire)' WHERE id_produs=12; -- Suport LCD LED 213 - Suport LCD LED de plafon (cu rotire) => Suport LCD LED 213 - suport LCD LED de plafon (cu rotire)
UPDATE t_produse SET nume_produs='Suport LCD LED plasma 329 (cu blocare jos)' WHERE id_produs=13; -- Suport LCD LED - PLASMA 329 (cu blocare jos) => Suport LCD LED plasma 329 (cu blocare jos)
UPDATE t_produse SET nume_produs='Suport LCD LED plasma 343 (fix)' WHERE id_produs=14; -- Suport LCD LED - PLASMA 343 (fix) => Suport LCD LED plasma 343 (fix)
UPDATE t_produse SET nume_produs='Suport rotativ pentru LCD LED plasma cu prindere de plafon BRC 60 D' WHERE id_produs=15; -- Suport rotativ pt. LCD LED - PLASMA cu prindere de plafon BRC 60 D => Suport rotativ pentru LCD LED plasma cu prindere de plafon BRC 60 D
UPDATE t_produse SET nume_produs='Suport fix pentru LCD LED plasma cu prindere de plafon BRC 60 S' WHERE id_produs=16; -- Suport fix pt. LCD LED - PLASMA cu prindere de plafon BRC 60 S => Suport fix pentru LCD LED plasma cu prindere de plafon BRC 60 S
UPDATE t_produse SET nume_produs='Suport TVS 121 Kobra (stand TV, nu este pe stoc)' WHERE id_produs=23; -- Suport TVS 121 Kobra (stand TV) - NU ESTE PE STOC => Suport TVS 121 Kobra (stand TV, nu este pe stoc)
UPDATE t_produse SET nume_produs='Stand LCD plasma CD 96' WHERE id_produs=41; -- Stand LCD-PLASMA CD 96 => Stand LCD plasma CD 96
UPDATE t_produse SET nume_produs='Stand LCD plasma CDW 120' WHERE id_produs=42; -- Stand LCD-PLASMA CDW 120 => Stand LCD plasma CDW 120
UPDATE t_produse SET nume_produs='Stand LCD plasma CG 120' WHERE id_produs=44; -- Stand LCD-PLASMA CG 120 => Stand LCD plasma CG 120
UPDATE t_produse SET nume_produs='Stand LCD plasma CPX 120' WHERE id_produs=46; -- Stand LCD-PLASMA CPX 120 => Stand LCD plasma CPX 120
UPDATE t_produse SET nume_produs='Stand LCD plasma G 120 H' WHERE id_produs=47; -- Stand LCD-PLASMA G 120H => Stand LCD plasma G 120 H
UPDATE t_produse SET nume_produs='Suport LCD LED plasma DVD receiver 4540 cu 2 geamuri' WHERE id_produs=61; -- Suport LCD LED - PLASMA DVD Receiver 4540 cu 2 geamuri => Suport LCD LED plasma DVD receiver 4540 cu 2 geamuri
UPDATE t_produse SET nume_produs='Suport stand pentru 6 monitoare PRO 5600' WHERE id_produs=64; -- Suport  stand pentru 6 monitoare PRO 5600 => Suport stand pentru 6 monitoare PRO 5600
UPDATE t_produse SET nume_produs='Stand pentru 2 monitoare ST 534 (orizontale)' WHERE id_produs=65; -- Stand pentru 2 monitoare (orizontale) ST 534 => Stand pentru 2 monitoare ST 534 (orizontale)
UPDATE t_produse SET nume_produs='Stand pentru 4 monitoare ST 541 (versiunea 2)' WHERE id_produs=67; -- Stand pentru 4 monitoare ST 541 (vers 2) => Stand pentru 4 monitoare ST 541 (versiunea 2)
UPDATE t_produse SET nume_produs='Suport de perete PRO 3006 D pentru 6 monitoare' WHERE id_produs=72; -- Suport de perete PRO 3006 D pt. 6 monitoare => Suport de perete PRO 3006 D pentru 6 monitoare
UPDATE t_produse SET nume_produs='Suport pentru 8 monitoare PRO 3008 D' WHERE id_produs=80; -- Suport pt. 8 monitoare PRO 3008 D => Suport pentru 8 monitoare PRO 3008 D
UPDATE t_produse SET nume_produs='Suport LCD LED TV PLZ 360' WHERE id_produs=96; -- Suport LCD , LED TV PLZ 360 => Suport LCD LED TV PLZ 360
UPDATE t_produse SET nume_produs='Suport LCD LED TV 2231' WHERE id_produs=97; -- SUPORT LCD , LED TV 2231 => Suport LCD LED TV 2231
UPDATE t_produse SET nume_produs='Suport LCD LED TV SD 740' WHERE id_produs=98; -- SUPORT LCD , LED TV SD 740 => Suport LCD LED TV SD 740
UPDATE t_produse SET nume_produs='Suport LCD LED TV 923' WHERE id_produs=99; -- SUPORT LCD , LED TV 923 => Suport LCD LED TV 923
UPDATE t_produse SET nume_produs='Suport LCD LED TV de plafon TA 6090' WHERE id_produs=100; -- SUPORT LCD , LED TV DE PLAFON TA 6090 => Suport LCD LED TV de plafon TA 6090
UPDATE t_produse SET nume_produs='Suport pentru 1 monitor MS 100' WHERE id_produs=101; -- SUPORT PT. 1 MONITOR MS 100 => Suport pentru 1 monitor MS 100
UPDATE t_produse SET nume_produs='Suport pentru 2 monitoare MS 200' WHERE id_produs=102; -- SUPORT PT. 2 MONITOARE MS 200 => Suport pentru 2 monitoare MS 200
UPDATE t_produse SET nume_produs='Suport LCD LED TV H 190' WHERE id_produs=104; -- SUPORT LCD , LED TV H 190 => Suport LCD LED TV H 190
UPDATE t_produse SET nume_produs='Suport LCD LED TV H 260' WHERE id_produs=105; -- SUPORT LCD , LED TV H 260 => Suport LCD LED TV H 260
UPDATE t_produse SET nume_produs='Suport LCD LED TV H 480' WHERE id_produs=106; -- SUPORT LCD , LED TV H 480 => Suport LCD LED TV H 480
UPDATE t_produse SET nume_produs='Suport LCD LED TV 343' WHERE id_produs=107; -- SUPORT LCD , LED TV 343 => Suport LCD LED TV 343
UPDATE t_produse SET nume_produs='Suport LCD LED TV 329' WHERE id_produs=108; -- SUPORT LCD , LED TV 329 => Suport LCD LED TV 329
UPDATE t_produse SET nume_produs='Suport LCD 115' WHERE id_produs=110; -- SUPORT LCD 115 => Suport LCD 115
UPDATE t_produse SET nume_produs='Suport receiver DVD VT 404' WHERE id_produs=111; -- SUPORT RECEIVER DVD VT 404 => Suport receiver DVD VT 404
UPDATE t_produse SET nume_produs='Birou si scaun gri pentru copii C 5' WHERE id_produs=117; -- Birou si scaun gri pt. copii C5 => Birou si scaun gri pentru copii C 5
UPDATE t_produse SET nume_produs='Birou si scaun roz pentru copii C 3' WHERE id_produs=118; -- Birou si scaun roz pt. copii C3 => Birou si scaun roz pentru copii C 3
UPDATE t_produse SET nume_produs='Birou si scaun albastru pentru copii C 4' WHERE id_produs=119; -- Birou si scaun albastru pt. copii C4 => Birou si scaun albastru pentru copii C 4
UPDATE t_produse SET nume_produs='Suport LCD LED TV 2323' WHERE id_produs=120; -- SUPORT LCD LED TV 2323 => Suport LCD LED TV 2323
UPDATE t_produse SET nume_produs='Suport LCD LED TV 2316' WHERE id_produs=121; -- SUPORT LCD LED TV 2316 => Suport LCD LED TV 2316
UPDATE t_produse SET nume_produs='Suport LCD LED TV 115' WHERE id_produs=122; -- SUPORT LCD LED TV 115 => Suport LCD LED TV 115
UPDATE t_produse SET nume_produs='Suport pentru pixuri' WHERE id_produs=124; -- Suport pt. pixuri => Suport pentru pixuri
UPDATE t_produse SET nume_produs='Suport pentru pixuri, agrafe, postic' WHERE id_produs=125; -- Suport pt. pixuri, agrafe, postic => Suport pentru pixuri, agrafe, postic
UPDATE t_produse SET nume_produs='Suport vertical pentru documente' WHERE id_produs=126; -- Suport vertical pt. documente => Suport vertical pentru documente
UPDATE t_produse SET nume_produs='Suport pentru documente vertical' WHERE id_produs=128; -- Suport pt. documente vertical => Suport pentru documente vertical
UPDATE t_produse SET nume_produs='Suport LCD LED TV 116' WHERE id_produs=134; -- Suport lcd led tv 116 => Suport LCD LED TV 116
UPDATE t_produse SET nume_produs='Suport LCD LED TV 117' WHERE id_produs=135; -- Suport lcd led tv 117 => Suport LCD LED TV 117
UPDATE t_produse SET nume_produs='Suport desktop pentru 2 monitoare' WHERE id_produs=139; -- Suport desktop pentru 2 Monitoare => Suport desktop pentru 2 monitoare
UPDATE t_produse SET nume_produs='Cuier haine C 6' WHERE id_produs=140; -- Cuier haine C6 => Cuier haine C 6
UPDATE t_produse SET nume_produs='Cuier haine C 9' WHERE id_produs=141; -- Cuier haine C9 => Cuier haine C 9
UPDATE t_produse SET nume_produs='Stand TV TP 1004 L' WHERE id_produs=143; -- Stand TV TP1004L => Stand TV TP 1004 L
UPDATE t_produse SET nume_produs='Stand TV T 4003 S' WHERE id_produs=144; -- Stand TV T4003S => Stand TV T 4003 S
UPDATE t_produse SET nume_produs='Set 3 masute cafea Erda ZS 01' WHERE id_produs=145; -- Set 3 masute cafea Erda ZS-01 => Set 3 masute cafea Erda ZS 01
UPDATE t_produse SET nume_produs='Set 3 masute cafea Alfa ZS 04' WHERE id_produs=146; -- Set 3 masute cafea Alfa ZS-04 => Set 3 masute cafea Alfa ZS 04
UPDATE t_produse SET nume_produs='Raft pentru incaltaminte Istanbul AKA 01 4' WHERE id_produs=147; -- Raft pt. incaltaminte Istanbul AKA-01-4 => Raft pentru incaltaminte Istanbul AKA 01 4
UPDATE t_produse SET nume_produs='Raft pentru baie Irmak BR 01' WHERE id_produs=148; -- Raft pt. baie Irmak BR-01 => Raft pentru baie Irmak BR 01
UPDATE t_produse SET nume_produs='Raft pentru bucatarie Damla MR 01' WHERE id_produs=149; -- Raft pt. bucatarie Damla MR-01 => Raft pentru bucatarie Damla MR 01
UPDATE t_produse SET nume_produs='Cuier haine Nil VS 01' WHERE id_produs=150; -- Cuier haine Nil VS-01 => Cuier haine Nil VS 01
UPDATE t_produse SET nume_produs='Cuier haine Tuna VS 02' WHERE id_produs=151; -- Cuier haine Tuna VS-02 => Cuier haine Tuna VS 02
UPDATE t_produse SET nume_produs='Raft Delhi EKT 09' WHERE id_produs=152; -- Raft Delhi EKT-09 => Raft Delhi EKT 09
UPDATE t_produse SET nume_produs='Birou Elmas MS 01' WHERE id_produs=153; -- Birou Elmas MS-01 => Birou Elmas MS 01
UPDATE t_produse SET nume_produs='Birou Safir MS 03' WHERE id_produs=154; -- Birou Safir MS-03 => Birou Safir MS 03
UPDATE t_produse SET nume_produs='Raft colt baie Selanik EKT 11' WHERE id_produs=155; -- Raft colt baie Selanik EKT-11 => Raft colt baie Selanik EKT 11
UPDATE t_produse SET nume_produs='Cuier haine C 3' WHERE id_produs=156; -- Cuier haine C3 => Cuier haine C 3
UPDATE t_produse SET nume_produs='Birou si scaun gri copii C 5 (new)' WHERE id_produs=157; -- Birou si scaun gri copii C5 new => Birou si scaun gri copii C 5 (new)
UPDATE t_produse SET nume_produs='Cuier haine C 7 alb' WHERE id_produs=158; -- Cuier haine C7 Alb => Cuier haine C 7 alb
UPDATE t_produse SET nume_produs='Cuier haine C 10 argintiu' WHERE id_produs=159; -- Cuier haine C10 Argintiu => Cuier haine C 10 argintiu
UPDATE t_produse SET nume_produs='Suport LCD S 200' WHERE id_produs=164; -- Suport LCD S200 => Suport LCD S 200
UPDATE t_produse SET nume_produs='Suport LCD LED 216' WHERE id_produs=167; -- Suport lcd LED 216 => Suport LCD LED 216
UPDATE t_produse SET nume_produs='Suport LCD plasma PLZ 909' WHERE id_produs=173; -- Suport LCD PLASMA PLZ 909 => Suport LCD plasma PLZ 909
COMMIT;
