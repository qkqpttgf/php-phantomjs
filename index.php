<?php

    use JonnyW\PhantomJs\Client;

    $client = Client::getInstance();
    
    $width  = 800;
    $height = 600;
    $top    = 0;
    $left   = 0;
    
    /** 
     * @see JonnyW\PhantomJs\Http\CaptureRequest
     **/
    $request = $client->getMessageFactory()->createCaptureRequest('http://baidu.com', 'GET');
    $request->setOutputFile('baidu.jpg');
    $request->setViewportSize($width, $height);
    $request->setCaptureDimensions($width, $height, $top, $left);

    /** 
     * @see JonnyW\PhantomJs\Http\Response 
     **/
    $response = $client->getMessageFactory()->createResponse();

    // Send the request
    $client->send($request, $response);
    
    ?>
    <img src="baidu.jpg"></img>
    
