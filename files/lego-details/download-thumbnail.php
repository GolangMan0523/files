<?php
$imageData = @file_get_contents('https://www.ldraw.org/library/official/images/parts/' .$_GET['brickId']. '.png');
// https://www.ldraw.org/library/official/images/parts/3004d01.png

if (!$imageData) {
    // try unofficial
    // /library/unofficial/images/parts/32905.png
    $imageData = @file_get_contents('https://www.ldraw.org/library/unofficial/images/parts/' .$_GET['brickId']. '.png');
}

$imageIsLoaded = !!$imageData;

if ($imageIsLoaded) {
    if (file_put_contents(realpath(dirname(__FILE__)) . '/thumbnails/' . $_GET['brickId'] . '.png', $imageData) === false) {
        header("TB-Storage-failure: true");
        // echo "failed to write image data";
        // exit(0);
    }
} else {
    $imageData = file_get_contents('./not-found.jpg');
}

if (!headers_sent()) {
    header("Content-type: image/png");
    header("Content-Length: " .strlen($imageData));
    if ($imageIsLoaded) {
        header("Cache-Control: max-age=604800");
    }
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET,OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type,X-Requested-With");
}

echo $imageData;
