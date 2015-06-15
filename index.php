<?php
require_once 'config'.DIRECTORY_SEPARATOR.'init.php';

$pagTitle = "Ciudades con nombres de verduras";
$pagDesc = 'Ok, en vista de que no había resultados pertinentes para la búsqueda de "ciudades con nombres de verduras", y ya que sin esta vital información la internet no está completa, acá tenemos una linda lista.';
$pagDesc = SuperFuncs::htmlent($pagDesc);

$lista = dbFuncs::traerTablaCiudades(0);

$ciudad = $pais = $subidoX = "";

if (isset($_POST['ciudad']) && isset($_POST['pais'])) {

    $ciudad = $_POST['ciudad'];
    $pais = $_POST['pais'];

    if (isset($_POST['subidoX'])) {
        $subidoX = $_POST['subidoX'];
    } else {
        $subidoX = "El gran Mengano";
    }

    $funca = dbFuncs::ingresarTablaCiudades($ciudad, $pais, $subidoX);

    if ($funca) $lista = dbFuncs::traerTablaCiudades(0);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?= $pagTitle ?></title>

    <meta name="title" content="<?= $pagTitle ?>" />
    <meta name="keywords" content="ciudades, ciudad, verduras, verdura, nombres, nombre" />
    <meta name="description" content="Lista de ciudades con nombres de verduras" />
    <meta name="lang" content="ES" />
    <meta http-equiv="content-language" content="ES" />

    <link rel="stylesheet" type="text/css" href="othersLib/bootstrap.css" />
    <script type="text/javascript" src="othersLib/jquery.min.js"></script>

    <style>
        #contenido {

            padding: 30px 0 0 0;
        }
        #laTabla {
            padding: 5px;
            background-color: #fcfcfc;
            border-radius: 5px;
        }

        .dispNone {
            display: none;
        }

        .eructito {
            -webkit-box-shadow:  0 0 10px 0 rgba(0, 0, 0, 0.3);
            box-shadow:  0 0 10px 0 rgba(0, 0, 0, 0.3);
        }

        .controlos {
            margin: 0;
            padding: 0;
            -webkit-box-shadow:  0 0 10px 0 rgba(0, 0, 0, 0.3);
            box-shadow:  0 0 10px 0 rgba(0, 0, 0, 0.3);
        }

        .textCenter { text-align: center; }
        .textRight { text-align: right; }

        .bold { font-weight: bolder; }

        .colAzul { color: #005580; }
        .colVerde { color: #499249; }
        .colRojo { color: #993300; }
        .colNaranja { color: #df8505; }

    </style>
</head>
<body>

<!--<div id="d_nueva" class="navbar-fixed-bottom textCenter dispNone">
    <form id="f_nueva" action="index.php" method="post" class="">
        <div id="controlos" class="eructito control-group input-prepend input-append">
            <span id="spanTodo" class="add-on">Una nueva&nbsp;</span>
            <span id="spanCiudad" class="add-on"><i class="icon-home"></i></span>
            <input type="text" class="span2 validameElI" id="inp_ciudad" name="ciudad" value="<?= $ciudad ?>" placeholder="Ciudad">
            <span id="spanPais" class="add-on"><i class="icon-flag"></i></span>
            <input type="text" class="span2 validameElI" id="inp_pais" name="pais" value="<?= $pais ?>" placeholder="Pa&iacute;s">
            <span id="spanSubidoX" class="add-on">tu nombre:</span>
            <input type="text" class="span2" id="inp_subidoX" name="subidoX" value="<?= $subidoX ?>" placeholder="El Gran Mengano">
            <button id="btn_submit" type="submit" class="btn"><i class="icon-circle-arrow-right"></i></button>
        </div>
    </form>
</div>-->

<div id="contenido">
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="hero-unit">
                <h1><?= $pagTitle ?></h1>
                <p class=""><?= $pagDesc ?></p>
                <p class="textRight"><a id="btn_agregate" class="btn btn-success btn-large">&iexcl;Agregate una!</a></p>
            </div>
                <div id="d_nueva" class="textCenter dispNone">
                    <form id="f_nueva" action="index.php" method="post">
                        <div id="controlos" class="control-group input-prepend input-append">
                            <span id="spanCiudad" class="eructito add-on"><i class="icon-home"></i></span>
                            <input type="text" class="eructito span2 validameElI" id="inp_ciudad" name="ciudad" value="<?= $ciudad ?>" placeholder="Ciudad">
                            <span id="spanPais" class="eructito add-on"><i class="icon-flag"></i></span>
                            <input type="text" class="eructito span2 validameElI" id="inp_pais" name="pais" value="<?= $pais ?>" placeholder="Pa&iacute;s">
                            <span id="spanSubidoX" class="eructito add-on">tu nombre:</span>
                            <input type="text" class="eructito span2" id="inp_subidoX" name="subidoX" value="<?= $subidoX ?>" placeholder="El Gran Mengano">
                            <button id="btn_submit" type="submit" class="eructito btn"><i class="icon-circle-arrow-right"></i></button>
                        </div>
                    </form>
                </div>



            <div id="laTabla" class="">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Ciudad</th>
                        <th>Pa&iacute;s</th>
                        <th>agregado por</th>
                        <th>agregado el</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (null != $lista && is_array($lista)) {
                        $cols = array("colRojo", "colVerde", "colNaranja", "colAzul");
                        //$subi = "";
                        $i = 0;

                        foreach ($lista as $it) {
                            //if ($it['subidoX'] != $subi) {
                                //$subi = $it['subidoX'];
                                $i += 1;
                                if ($i > (count($cols) - 1)) $i = 0;
                            //}


                            ?>
                        <tr>
                            <td class="<?= $cols[$i] ?> bold"><?= $it['ciudad'] ?></td>
                            <td><?= $it['pais'] ?></td>
                            <td class="<?= $cols[$i] ?>"><?= $it['subidoX'] ?></td>
                            <td><?= date("d/m/Y H:i:s", $it['time']) ?></td>
                        </tr>
                            <?php
                        }
                    } ?>
                    </tbody>
                </table>
            </div>



        </div>
    </div>
</div>

<script type="text/javascript">

    $('#btn_agregate').on('click', function(evt) {
        evt.stopImmediatePropagation();
        evt.preventDefault();

        $('#d_nueva').toggleClass('dispNone');
    });

    function rojoOverde(verde) {
        var controlos = $('.controlos');
        controlos.removeClass("error");

        var btn = $('#btn_submit');
        btn.removeClass("btn-success");
        btn.removeClass("btn-error");

        if (!verde) {
            controlos.addClass("error");
            btn.addClass("btn-error");
        }
        controlos.addClass("success");
        btn.addClass("btn-success");
    }

    /**
     * @return {boolean}
     */
    function ValidameInps() {
        if (validame($('#inp_ciudad').val()) && validame($('#inp_pais').val())) {
            console.log("ValidameInps() true");

            rojoOverde(true);
            return true;
        }
        console.log("ValidameInps() false");

        rojoOverde(false);
        return false;
    }

    function validame(esta) {
        var estaSinEsp = esta.replace(/ |&nbsp;/ig, "");

        return (estaSinEsp.length > 2) && (estaSinEsp.length < 150);

    }

    $('.validameElI').keyup(function () {
        ValidameInps();
    });

    $('#btn_submit').on('click', function(evt) {
        evt.stopImmediatePropagation();
        evt.preventDefault();

        var sacarTags = /(<([^>]+)>)/ig;

        var i_ciu = $('#inp_ciudad');
        var ciu = i_ciu.val().replace(sacarTags, "");

        var i_pai = $('#inp_pais');
        var pai = i_pai.val().replace(sacarTags, "");

        var i_subi = $('#inp_subidoX');
        var subi = "El Gran Mengano";
        if (i_subi.val() != "") {
            subi = i_subi.val().replace(sacarTags, "");
        }

        if (ValidameInps()) {
            i_ciu.val(ciu);
            i_pai.val(pai);
            i_subi.val(subi);

            console.log("1|" + i_ciu.val() + "  2|" + i_pai.val() + "  3|" + i_subi.val());
            $('#f_nueva').submit();
        }
    });

</script>
</body>
</html>