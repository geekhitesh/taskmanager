<?php


    set_time_limit(20000);
    
    $rest_url = "http://14.102.16.188:8080/taskmanager/public/survey/create";
    
    
    
    #print_r($data);
    
    $cSession = curl_init(); 
    //step2
    curl_setopt($cSession,CURLOPT_URL,$rest_url);
    curl_setopt($cSession,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($cSession,CURLOPT_HEADER, false); 
    //step3
    $result=curl_exec($cSession);
    //step4
    curl_close($cSession);
    //step5
    echo $result;
?>