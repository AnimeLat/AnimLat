<?php
//Para la lista de animes
$url      = 'https://docs.google.com/spreadsheets/d/1Ofhoa9d0CDoWcMK1CDhdTXTb_9h5_7J35pIiYmsMXdo/gviz/tq?tqx=out:json&gid=0';
$response = file_get_contents($url);
$json     = substr($response, 47, -2);
$animes   = json_decode($json, true)['table']['rows'];

$lanin = array();

for ($i = 0; $i < count($animes); $i++) {

    $dato = array(
        "name"   => $animes[$i]['c'][0]['v'],
        "image"  => $animes[$i]['c'][1]['v'],
        "fld_id" => $animes[$i]['c'][2]['v'],
    );

    array_push($lanin, $dato);
}

//Para los capitulos subidos
$urln      = 'https://filemoon.sx/api/file/list?key=18056hkzovzjvogmav4qb';
$responsen = file_get_contents($urln);
$nuevos    = json_decode($responsen, true)['result']['files'];

$lreci = array();

for ($i = 0; $i < count($nuevos); $i++) {

    $title = preg_replace('/C+/', 'C', $nuevos[$i]['title']);

    $dato = array(
        "fld_id" => $nuevos[$i]['fld_id'],
        "title"  => $title,
    );

    array_push($lreci, $dato);
}

$lnuev = array();

for ($i = 0; $i < count($lreci); $i++) {
    for ($j = 0; $j < count($lanin); $j++) {
        if ($lreci[$i]["fld_id"] == $lanin[$j]["fld_id"]) {

            $capit = "";

            if ($lreci[$i]["title"][0] == 'O') {
                $capit = $capit . "Ova " . substr($lreci[$i]["title"], 1);
            } elseif ($lreci[$i]["title"][0] == 'E') {
                $capit = $capit . "Especial " . substr($lreci[$i]["title"], 1);
            } elseif ($lreci[$i]["title"][0] == 'C') {
                $capit = $capit . "Capitulo " . substr($lreci[$i]["title"], 1);
            }

            $dato = array(
                "fld_id" => $lreci[$i]["fld_id"],
                "image"  => $lanin[$j]["image"],
                "name"   => $lanin[$j]["name"],
                "capi"   => $capit,
            );
            array_push($lnuev, $dato);
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Anime Lat</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="styles.css">
        <link rel="shortcut icon" href="img/fav-icon.png" type="image/x-icon">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    </head>
    <body>
        <div class="page">
            <div class="cabecera">
                <div class="logo">
                    <a href="index.php" class="logo1">
                        Anime<span>Lat</span>
                    </a>
                </div>
                <div class="buscador">
                    <div class="buscador1">
                        <input type="search" name="search" id="buscartexto" placeholder="Buscar Anime">
                        <i class="icono-search"></i>
                    </div>
                </div>
            </div>
            <div class="nav-cont">
                <div class="navegacion">
                    <a href="index.php" class="nav-link nav-active">
                        <i class="icono-home"></i>
                        <span class="titulo-link">Inicio</span>
                    </a>
                    <a href="subti.php" class="nav-link">
                        <i class="icono-subti"></i>
                        <span class="titulo-link">Subti</span>
                    </a>
                    <a href="latino.php" class="nav-link">
                        <i class="icono-latin"></i>
                        <span class="titulo-link">Latino</span>
                    </a>
                    <a href="https://www.mediafire.com/file/xwumlrx8190dxh6/AnimLat.apk/file" target="_blank" class="nav-link">
                        <i class="icono-down"></i>
                        <span class="titulo-link">APK</span>
                    </a>
                </div>

                <div class="contenido" id="contenido1">
                    <div class="etiqueta">
                        <h2 class="titulo-pag">Capitulos Recientes</h2>
                    </div>
                    <div class="capi">
                        <div class="elementos" id="element">
                            <?php

for ($i = 0; $i < count($lnuev); $i++) {
    echo '<a class="itemanime" href="detalle.php?id=' . $lnuev[$i]["fld_id"] . '"><div class="item"><img loading="lazy" src="' . $lnuev[$i]["image"] . '" alt="" class="item-img"><div class="item-txt"><h3>' . $lnuev[$i]["name"] . '</h3><p>' . $lnuev[$i]["capi"] . '</p></div></div></a>';
}
?>
                        </div>
                    </div>
                </div>
                <div class="contenido" id="buscador" style="display: none;">
                    <div class="etiqueta">
                        <h2 class="titulo-pag">Resultados de Busqueda</h2>
                    </div>
                    <div class="capi">
                        <div class="elementos" id="element1">
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </body>
</html>
