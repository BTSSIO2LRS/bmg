DELIMITER $
DROP PROCEDURE IF EXISTS sp_prets$

CREATE PROCEDURE sp_prets(
IN critere INT,
IN id INT,
IN etat VARCHAR(15))
BEGIN
	IF critere = 0 THEN
		IF ISNULL(etat) AND ISNULL(id) THEN
			SELECT * FROM v_prets;
        END IF;
		IF ISNULL(id) AND !ISNULL(etat) THEN
			IF etat = "ONGOING" THEN
				SELECT * FROM v_prets_en_cours;
			END IF;
			IF etat = "DELIVE" THEN
				SELECT * FROM v_prets WHERE date_ret IS NOT NULL;
            END IF;
            IF etat = "LATEDELIV" THEN
				SELECT * FROM v_prets WHERE duree>15 AND date_ret IS NOT NULL;
            END IF;
            IF etat = "DELIVONTIME" THEN
				SELECT * FROM v_prets WHERE duree<=15 AND date_ret IS NOT NULL;
			END IF;
            IF etat = "LATE" THEN
				SELECT * FROM v_prets_en_cours WHERE nb_jours_retard > 0 AND date_ret IS NULL;
			END IF;
		END IF;
    END IF;
    IF critere = 1 THEN
		SELECT * FROM pret WHERE id_pret = id;
	END IF;
	IF critere = 2 THEN
			IF etat = "ONGOING" THEN
				SELECT * FROM v_prets_en_cours WHERE no_client = id;
			END IF;
			IF etat = "DELIVE" THEN
				SELECT * FROM v_prets WHERE date_ret IS NOT NULL AND no_client = id;
            END IF;
            IF etat = "LATEDELIV" THEN
				SELECT * FROM v_prets WHERE duree>15 AND date_ret IS NOT NULL AND no_client = id;
            END IF;
            IF etat = "DELIVONTIME" THEN
				SELECT * FROM v_prets WHERE duree<=15 AND date_ret IS NOT NULL AND no_client = id;
			END IF;
            IF etat = "LATE" THEN
				SELECT * FROM v_prets_en_cours WHERE nb_jours_retard > 0 AND date_ret IS NULL AND no_client = id;
			END IF;
	END IF;
END$