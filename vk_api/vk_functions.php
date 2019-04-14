<?php 
  
    function request_api($method, $params) 
    {

       $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => http_build_query($params)
            )
        );

        $context  = stream_context_create($opts);
   
        

        $result = file_get_contents("https://api.vk.com/method/".$method."?", false, $context);
        
        return json_decode($result);
            
	}
