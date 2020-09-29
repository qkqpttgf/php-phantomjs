<?php

    require 'vendor/autoload.php';
    use JonnyW\PhantomJs\Client;

function h2p($url, $jpg)
{

    $client = Client::getInstance();
    
    $width  = 800;
    $height = 600;
    $top    = 0;
    $left   = 0;

    /** 
     * @see JonnyW\PhantomJs\Http\CaptureRequest
     **/
    $request = $client->getMessageFactory()->createCaptureRequest($url, 'GET');
    $request->setOutputFile($jpg);
    $request->setViewportSize($width, $height);
    $request->setCaptureDimensions($width, $height, $top, $left);

    /** 
     * @see JonnyW\PhantomJs\Http\Response 
     **/
    $response = $client->getMessageFactory()->createResponse();

    // Send the request
    $client->send($request, $response);
    
    $r['stat'] = $response->getStatus();
    $r['head'] = $response->getHeaders();
    $r['body'] = $response->getContent();

    return $r;
}

function base64EncodeImage($image_file)
{
    $base64_image = '';
    $image_info = getimagesize($image_file);
    $f = fopen($image_file, 'r');
    if (!$f) return '';
    $image_data = fread($f, filesize($image_file));
    //$base64_image = 'data:' . $image_info['mime'] . ';base64,' . chunk_split(base64_encode($image_data));
    $base64_image = 'data:' . $image_info['mime'] . ';base64,' . base64_encode($image_data);
    return $base64_image;
}

    $url = $_POST['aimurl'];
    if ($url!=''&&substr($url, 0, 7)!='http://'&&substr($url, 0, 8)!='https://') $url = 'http://' . $url; 
    $tmp = sys_get_temp_dir();
    $jpg = $tmp . '/tmp.jpg';
    unlink($jpg);

?>
<form method="post">
    <input type="text" name="aimurl" value="<?php echo $url;?>"></input>
    <input type="submit"></input>
</form>
<?php
    if ($url!='') {
        $r = h2p($url, $jpg);
        $b = base64EncodeImage($jpg);
        if ($b!='') echo '<img src="' . $b . '"></img>';
        else echo '<pre>' . json_encode($r, JSON_PRETTY_PRINT) . '</pre>';
    }
    
