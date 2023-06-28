<?php

namespace App\Libraries;

use GuzzleHttp\Client;

class Push {

  private $title;
  private $message;
  private $data;


  /**
   * @param $title
   */
  public function setTitle( $title ) {
     $this->title = $title;
  }

  /**
   * @param $message
   */
  public function setMessage( $message ) {
     $this->message = $message;
  }


  /**
   * @param $data
   */
  public function setPayload( $data ) {
     $this->data = $data;
  }


  /**
   * @return array
   */
  public function getPush() {
     $response                      = array();
     $response['data']['title']     = $this->title;
     $response['data']['message']   = $this->message;
     $response['data']['payload']   = $this->data;
     $response['data']['timestamp'] = date( 'Y-m-d G:i:s' );

     return $response;
  }
}