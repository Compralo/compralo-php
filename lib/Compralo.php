<?php

namespace Compralo;

class Compralo {

    /**
     * Configs for API.
     *
     * @return void
     */
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function create($store_name, $value, $description, $postback_url, $back_url=null){

      $data = json_encode([
          'api_key' => $this->apiKey,
          'value' => $value,
          'store_name' => $store_name,
          'postback_url' => $postback_url,
          'description' => $description,
          'back_url' => $back_url,
      ]);

      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => "https://app.compralo.io/api/v1/seller/generateInvoice",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_HTTPHEADER => array(
          "Content-Type: application/json"
        ),
      ));

      $response = curl_exec($curl);
      $err = curl_error($curl);

      curl_close($curl);

      if ($err) {
        return "cURL Error #:" . $err;
      } else {
          $response_data = json_decode($response);
          return $response_data;
      }

    }

    public function check($checkout_token){

      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => "https://app.compralo.io/api/v1/seller/checkStatus/".$checkout_token,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
          "Content-Type: application/json"
        ),
      ));

      $response = curl_exec($curl);
      $err = curl_error($curl);

      curl_close($curl);

      if ($err) {
        return "cURL Error #:" . $err;
      } else {
          $status_data = json_decode($response);

          if($status_data->status == 1){
            return 'complete';
          }elseif($status_data->status == 3){
            return 'expired';
          }

          return 'pending';
      }

    }
    
    public function withdrawal($coin, $value, $destination){

      $data = json_encode([
          'api_key' => $this->apiKey,
          'coin' => $coin,
          'value' => $value,
          'destination' => $destination,
      ]);

      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => "https://app.compralo.io/api/v1/withdrawal/create",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_HTTPHEADER => array(
          "Content-Type: application/json"
        ),
      ));

      $response = curl_exec($curl);
      $err = curl_error($curl);

      curl_close($curl);

      if ($err) {
        return "cURL Error #:" . $err;
      } else {
          $response_data = json_decode($response);
          return $response_data;
      }

    }
    
    public function getCode($email){

      $data = json_encode([
          'email' => $email,
      ]);

      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => "https://app.compralo.io/api/v1/withdrawal/getCode",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_HTTPHEADER => array(
          "Content-Type: application/json"
        ),
      ));

      $response = curl_exec($curl);
      $err = curl_error($curl);

      curl_close($curl);

      if ($err) {
        return "cURL Error #:" . $err;
      } else {
          $response_data = json_decode($response);
          return $response_data;
      }

    }

}
