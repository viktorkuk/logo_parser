<?php

header('Content-Type: text/html; charset=UTF-8');
require 'simple_html_dom.php';
echo 'aaa!<br>';

$offset = $_GET['offset'] ? $_GET['offset'] : 0;
$limit = $_GET['limit'] ? $_GET['limit'] : 30;

$domains = explode("\n",file_get_contents('./csv/1.csv'));

$domains = array_slice($domains, $offset, $limit);


$domainLogos = [];


foreach ($domains as $domain) {
    if (!empty($domain)) {
        $domainLogos[$domain] = getImage($domain);
    }
}


/*
foreach ($domainLogos as  $dom => $imgs) {

    echo "<b>$dom</b><br>";

    foreach ($imgs as $img) {
        echo "<img src='$img'> <br>";
    }

    echo '<hr><br><br>';
}*/





//------------------------------------
function getImage($url)
{

    echo "<h2><a href='$url' target='_blank'>$url</a></h2><br>";

    if (!$res = file_get_contents('http://' . $url)) {
        $res = file_get_contents('https://' . $url);
    }

    if (!$res) {
        echo $url . ' SKIPPED!<br>';
        return;
    }


    $html = str_get_html($res);

    if (!$html) {
        echo $url . ' SKIPPED! no html<br>';
        return;
    }

    $imgSrc = [];

    $elements = array_merge($html->find('div'), $html->find('a'));
    foreach ($elements as $element) {
        if ((!empty($element->class) && strpos($element->class, 'logo') !== false) || (!empty($element->id) && strpos($element->id, 'logo') !== false)) {
            $imgs = $element->find('img');
            foreach ($imgs as $img) {
                $imgSrc[] = $img->src;
            }
        }
    }
    unset($elements);

    $elements = $html->find('img');
    foreach ($elements as $element) {
        if ((!empty($element->class) && strpos($element->class, 'logo') !== false) || (!empty($element->id) && strpos($element->id, 'logo') !== false)) {
            $imgSrc[] = $element->src;
        }
    }

    //last chance
    if ($imgSrc && !empty($elements)) {
        $imgSrc[] = $elements[0]->src;
    }
    unset($elements);


    if (!empty($imgSrc)) {

        $imgSrc = array_unique($imgSrc);



        foreach ($imgSrc as $img) {
            echo "<img src='$img'><br>
                <a href='process_image.php?img=".urlencode($img)."&color=255'><b>ON White</b></a>
                <a href='process_image.php?img=".urlencode($img)."&color=127'><b>ON Grey</b></a>
                <hr><br>";
        }

    }

    echo "<hr><hr><hr>";

    return $imgSrc;
}

function curl_get($url, array $get = [], array $options = array())
{
    $defaults = array(
        CURLOPT_URL => $url. (strpos($url, '?') === FALSE ? '?' : ''). http_build_query($get),
        CURLOPT_HEADER => 0,
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_TIMEOUT => 4
    );

    $ch = curl_init();
    curl_setopt_array($ch, ($options + $defaults));
    if( ! $result = curl_exec($ch))
    {
        throw new Exception(curl_error($ch));
    }
    curl_close($ch);
    return $result;
}



die('here!');
