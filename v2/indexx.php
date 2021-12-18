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
foreach ($json['results'] as $val) {

    echo "<li>";
    echo "<img class=\"imgSearch\" src=\"https://fr.web.img2.acsta.net/c_310_420/" . $json['results'][$gr]['data']['poster_path'] . "\">";

    echo "<div class=\"cont\">";
    echo "<div class=\"titre\">";
    echo  $json['results'][$gr]['label'];
    echo "</div>";

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
    echo "</span>";
    echo "</div>";

    echo "</li>";
    $gr++;
}
echo "</ul>";
?>

