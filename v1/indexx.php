<?php
/***
Code d'un scraper avec file_get_contents, réalisé par Insimule.com
 ***/
require 'simple_html_dom.php';

$q = $_REQUEST["q"];

$websiteUrl = "https://www.allocine.fr/rechercher/?q=". $q;//. $q
$websiteJson = "https://www.allocine.fr/_/autocomplete/". $q;//. $q;

$json = file_get_contents($websiteJson);
$html = file_get_html($websiteUrl);

$json = json_encode($json);
$json = json_decode($json);
$json = json_decode($json, true);

$gr = 0;

echo "<ul>";
foreach ($html->find('.mdl') as $postDiv) {

    echo "<li>";

    foreach ($postDiv->find('.thumbnail-img') as $a) {
        echo "<img class=\"imgSearch\" src=\"" . $a->getAttribute('data-src') . "\">";
    }

    echo "<div class=\"cont\">";
    foreach ($postDiv->find('.meta-title-link ') as $a) {
        echo $a->plaintext;
    }

    echo "<span>";
    foreach ($postDiv->find('.date') as $a) {
        $genre = $json['results'][$gr]['genres'];
        $rea = $json['results'][$gr]['data']['director_name'];

        echo "</br>Date de sortie : " . $a->plaintext . "</br>Genre : ";
        foreach ($genre as $valeur) {
            echo $valeur . ", ";
        }
        echo "</br>De : ";
        foreach ($rea as $val) {
            echo $val . ", ";
        }
    }
    echo "</span>";

    echo "<div class=\"desc\">";
    foreach ($postDiv->find('.content-txt') as $a) {
        echo $a->plaintext;
    }
    echo "</div>";
    echo "</div>";

    echo "</li>";
    $gr++;
}
echo "</ul>";

?>

