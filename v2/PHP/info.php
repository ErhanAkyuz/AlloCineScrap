<!DOCTYPE html>
<html lang="en">
<head>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css"></script>
    <link rel="stylesheet" type="text/css" href="../CSS/info.css">
    <meta charset="UTF-8">
    <title>Info</title>
</head>
<body>
<div class="site-wrap">

    <?php
    require 'simple_html_dom.php';

    $q = $_REQUEST["q"];
    $q = str_replace(" ", "%20", $q);

//    echo $q;

    $websiteUrl = "https://www.allocine.fr/". $q . ".html";
    $id = (int) filter_var($q, FILTER_SANITIZE_NUMBER_INT);
    $websiteJson = "https://www.allocine.fr/_/autocomplete/". $id;

//    echo $websiteJson;

    $html = file_get_html($websiteUrl);
    $json = file_get_contents($websiteJson);
    $json = json_decode($json, true);

    //    echo $json;
    echo "<h1>";
//    echo $json['results'][0]['label'];
    echo $html->find('h1',0);
    echo "</h1>";

    $img = $html->find('.thumbnail-img',0);
    echo "<img class=\"align-left\" src=\"" . $img->getAttribute('src') . "\">";

    $a = $html->find('.meta  ',0);
    echo $a;

    $syn = $html->find('section[id=synopsis-details]',0);
    echo $syn;

    $se = $html->find('.section',9);
    echo $se;

    ?>
</div>

</body>
</html>