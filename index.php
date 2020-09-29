<?php

function h2p($url, $jpg)
{
    require 'vendor/autoload.php';
    use JonnyW\PhantomJs\Client;

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
}

    $url = $_POST['aimurl'];
    $tmp = sys_get_temp_dir();
    $jpg = $tmp . '/tmp.jpg';
    unlink($base);
    if ($url!='') {
        h2p($url, $jpg);
    }
?>
<form method="post">
    <input type="text" name="aimurl"></input>
    <input type="submit"></input>
</form>
    <img src="<?php if ($url!='') echo $jpg;?>"></img>
    
