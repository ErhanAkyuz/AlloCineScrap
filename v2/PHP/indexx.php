<?php
/***
Code d'un scraper avec file_get_contents, réalisé par Insimule.com
 ***/
require 'simple_html_dom.php';

$q = $_REQUEST["q"];
$q = str_replace(" ", "%20", $q);

$websiteUrl = "https://www.allocine.fr/rechercher/?q=". $q;
$websiteJson = "https://www.allocine.fr/_/autocomplete/". $q;

$json = file_get_contents($websiteJson);
$html = file_get_html($websiteUrl);

$json = json_decode($json, true);

$gr = 0;

echo "<ul>";
foreach ($json['results'] as $val) {
    //ce if() permet de passer les pubs
    if ($gr == 0) {
        $gr++;
        continue;
    }

    $switch = $json['results'][$gr]['entity_type'];
    switch ($switch) {
        case "person":
            $d = "personne/fichepersonne_gen_cpersonne=". $json['results'][$gr]['entity_id'];
            break;
        case "movie":
            $d = "film/fichefilm_gen_cfilm=". $json['results'][$gr]['entity_id'];
            break;
        case "series":
            $d = "series/ficheserie_gen_cserie=". $json['results'][$gr]['entity_id'];
            break;
    }

    echo "<li>";
    echo "<img class=\"imgSearch\" src=\"https://fr.web.img2.acsta.net/c_310_420/" . $json['results'][$gr]['data']['poster_path'] . "\">";

    echo "<div class=\"cont\">";
    echo "<div>";
    echo "<a class=\"titre\" href=\"../PHP/info.php?q=". $d . "\">";
    echo  $json['results'][$gr]['label'];
    echo "</a>";
    echo "</div>";

    if ($json['results'][$gr]['entity_type'] == "movie") {
    echo "<span>";
    $genre = $json['results'][$gr]['genres'];
    $rea = $json['results'][$gr]['data']['director_name'];
    $date = $json['results'][$gr]['data']['last_release'];

    echo "Date de sortie : " . substr($date, 0, 10) . "</br>Genre : ";
    foreach ($genre as $valeur) {
        echo $valeur . ", ";
    }
    echo "</br>De : ";
    foreach ($rea as $val) {
        echo $val . ", ";
    }

    $dataSerie = "https://www.allocine.fr/film/fichefilm_gen_cfilm=". $json['results'][$gr]['entity_id'] . ".html";
    $html = file_get_html($dataSerie);
    $postDiv = $html->find('.content-txt', 0);
    echo "</br>Synopsis : " . $postDiv;

    echo "</li>";
    } else if ($json['results'][$gr]['entity_type'] == "person") {
        echo "<span>";
        $metier = $json['results'][$gr]['data']['activities'];
        if ($json['results'][$gr]['data']['nationality']['adjective'] != null) {
            $nat = $json['results'][$gr]['data']['nationality']['adjective'];
        } else {
            $nat = null;
        }

        echo "Métiers  : ";
        foreach ($metier as $valeur) {
            if ($valeur == null) {
                echo "?";
            } else {
                echo $valeur . ", ";
            }
        }
        echo "</br>Nationalité : ";
        if ($nat == null) {
            echo "?";
        } else {
            foreach ($nat as $val) {
                echo $val . ", ";
            }
        }
        $dataSerie = "https://www.allocine.fr/personne/fichepersonne_gen_cpersonne=". $json['results'][$gr]['entity_id'] . ".html";
        $html = file_get_html($dataSerie);
        $postDiv = $html->find('.meta-body-item', 4);
        echo $postDiv;

        echo "</span>";
        echo "</div>";

        echo "</li>";
    } else if ($json['results'][$gr]['entity_type'] == "series") {
        $dataSerie = "https://www.allocine.fr/series/ficheserie_gen_cserie=". $json['results'][$gr]['entity_id'] . ".html";
        $html = file_get_html($dataSerie);
        echo "<span>";
        $postDiv = $html->find('.content-txt', 0);
        echo "Synopsis : " . $postDiv;

        echo "</span>";
        echo "</div>";

        echo "</li>";
    }
    $gr++;
}
echo "</ul>";
?>