ALTER TABLE t_produse
	ADD COLUMN warranty_months INT UNSIGNED NOT NULL DEFAULT 24 AFTER cod_produs,
	ADD COLUMN garan_eligible TINYINT(1) NOT NULL DEFAULT 0 AFTER warranty_months;
