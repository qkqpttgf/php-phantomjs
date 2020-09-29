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
}

function base64EncodeImage($image_file)
{
  $base64_image = '';
  $image_info = getimagesize($image_file);
  $image_data = fread(fopen($image_file, 'r'), filesize($image_file));
  //$base64_image = 'data:' . $image_info['mime'] . ';base64,' . chunk_split(base64_encode($image_data));
  $base64_image = 'data:' . $image_info['mime'] . ';base64,' . base64_encode($image_data);
  return $base64_image;
}

    $url = $_POST['aimurl'];
    $tmp = sys_get_temp_dir();
    $jpg = $tmp . '/tmp.jpg';
    unlink($jpg);
    if ($url!='') {
        h2p($url, $jpg);
    }
?>
<form method="post">
    <input type="text" name="aimurl"></input>
    <input type="submit"></input>
</form>
<img src="<?php if ($url!='') echo base64EncodeImage($jpg);?>"></img>
    
