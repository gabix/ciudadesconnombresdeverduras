<?php

class dbFuncs {

    public static function crearTablaCiudades() {
        //no uso el self::crearMysqli porque esa func usa Debuguie, y no puedo debuguear el debug
        $mysqli = self::getDB();
        if (!mysqli_connect_errno()) {
            $q = "SHOW TABLES LIKE 'ciudadesconnombresdeverduras'";
            $ret = $mysqli->query($q);

            if ($ret != false && $ret->num_rows > 0) {
                $mysqli->close();
                return true;
            }

            $q = 'CREATE TABLE IF NOT EXISTS ciudadesconnombresdeverduras (
                    id int(11) NOT NULL AUTO_INCREMENT,
                    ciudad varchar(200) COLLATE utf8_unicode_ci NOT NULL,
                    pais varchar(200) COLLATE utf8_unicode_ci NOT NULL,
                    time int(11) NOT NULL,
                    subidoX varchar(200) COLLATE utf8_unicode_ci NOT NULL,
                    PRIMARY KEY (id),
                    UNIQUE KEY ciudad (ciudad)
                  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;';

            $ret = $mysqli->query($q);

            $mysqli->close();
            return $ret;

        }
        $mysqli->close();
        trigger_error("No se puede conectar a la DB");

        return null;
    }

    /**
     * Falla cuando no se puede conectar a la base de datos.
     */
    private static function fail($error_msg) {
        foreach (ob_list_handlers() as $h) {
            ob_get_clean();
        }
        require('error/noDB.html');
        die();
    }

    public static function traerTablaCiudades($limit) {
        $mysqli = self::getDB();
        if (!mysqli_connect_errno()) {

            $limitPaQ = "";
            if (is_numeric($limit) && $limit > 0 && $limit < 1000) {
                $limitPaQ =  'LIMIT 0 , '.$limit;
            }

            $q = 'SELECT * FROM ciudadesconnombresdeverduras ORDER BY ciudad ASC ' . $limitPaQ;
            $ret = $mysqli->query($q);

            if ($ret != false && $ret->num_rows >= 0) {
                $lista = null;

                while ($row = $ret->fetch_assoc()) {
                    $lista[] = array('id' => $row['id'], 'ciudad' => $row['ciudad'], 'pais' => $row['pais'], 'time' => $row['time'], 'subidoX' => $row['subidoX']);
                }

                $mysqli->close();
                return $lista;
            } else {
                $mysqli->close();

                return null;
            }
        }
        $mysqli->close();
        trigger_error("No se puede conectar a la DB");

        return null;
    }

    /**
     * Intenta traer la DB o pincha bien brutamente.
     * @return mysqli
     */
    public static function getDB() {
        mysqli_report(MYSQLI_REPORT_STRICT);
        try {
            $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        } catch (Exception $puto) {
            self::fail($puto->getMessage());
        }
        return $mysqli;
    }


    public static function ingresarTablaCiudades($ciudad, $pais, $subidoX) {
        $ciudad = SuperFuncs::htmlent($ciudad);
        $pais = SuperFuncs::htmlent($pais);
        $subidoX = SuperFuncs::htmlent($subidoX);
        $time = time();

        $mysqli = self::getDB();
        if (!mysqli_connect_errno()) {

            if ($q = $mysqli->prepare('INSERT INTO ciudadesconnombresdeverduras (ciudad, pais, subidoX, time) VALUES (?, ?, ?, ?)')) {

                $r = $q->bind_param('sssi', $ciudad, $pais, $subidoX, $time);

                $funciono = $q->execute();

                $mysqli->close();

                return true;
            }
        }
        $mysqli->close();
        trigger_error("No se puede conectar a la DB");

        return null;
    }

}
