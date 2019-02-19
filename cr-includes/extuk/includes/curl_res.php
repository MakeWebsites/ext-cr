<?php

class curl_res {
   private $_res; 
   
   public function __construct($url) {
    $curlSession = curl_init();
    curl_setopt($curlSession, CURLOPT_URL, $url);
    curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
    curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

    $jsond = json_decode(curl_exec($curlSession));
    $this->_res = $jsond;
    
   curl_close($curlSession); }

public function get_res() {
    return $this->_res; 
    }   

}