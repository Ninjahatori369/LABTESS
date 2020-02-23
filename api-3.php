<?php

  $strAccessToken = "49D8U1OE7aQPIW+Wrz6/iRK7Bm7PGZV31W7Lvet4gXZ2fo4TASGRnLoNFDunzxHmHqWfJffvPoNPVYuBD/Ty5Fu89raphr84CePUIk3b4sgsm+b9or0QlJPIWPrre2VadT0R3JYwyi6Um7FT2ZtyGwdB04t89/1O/w1cDnyilFU=";
  
  $content = file_get_contents('php://input');
  $arrJson = json_decode($content, true);

  $strUrl = "https://api.line.me/v2/bot/message/reply";

  $arrHeader = array();
  $arrHeader[] = "Content-Type: application/json";
  $arrHeader[] = "Authorization: Bearer {$strAccessToken}";
  $_msg = $arrJson['events'][0]['message']['text'];


  $api_key="bfed2bd21437ffc0a3adaaf287c9a27f";
  $url = 'https://api.mongolab.com/api/1/databases/data/collections/datas?apiKey='.$api_key.'';
  $json = file_get_contents('https://api.mongolab.com/api/1/databases/data/collections/datas?apiKey='.$api_key.'&q={"question":"'.$_msg.'"}');
  $data = json_decode($json);
  $isData=sizeof($data);

  if (strpos($_msg, 'H.E.L.E.N') !== false) 
  {
    if (strpos($_msg, 'H.E.L.E.N') !== false) 
    {
      $x_tra = str_replace("H.E.L.E.N","", $_msg);
      $pieces = explode("|", $x_tra);
      $_question=str_replace("[","",$pieces[0]);
      $_answer=str_replace("]","",$pieces[1]);
      //Post New Data
      $newData = json_encode(
        array(
          'question' => $_question,
          'answer'=> $_answer
        )
      );
      $opts = array(
        'http' => array(
            'method' => "POST",
            'header' => "Content-type: application/json",
            'content' => $newData
         )
      );
      $context = stream_context_create($opts);
      $returnValue = file_get_contents($url,false,$context);
      $arrPostData = array();
      $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
      $arrPostData['messages'] => array (
  'type' => 'imagemap',
  'baseUrl' => 'https://1.bp.blogspot.com/-U90M8DyKu7Q/W9EtONMCf6I/AAAAAAAAW_4/7L_jB_Rg9oweu2HKhULNdu9WNefw9zf9wCLcBGAs/s1600/',
  'altText' => 'This is an imagemap',
  'baseSize' => 
            array (
              'width' => 1040,
              'height' => 1040,
            ),
            'actions' => 
            array (
              0 => 
              array (
                'type' => 'message',
                'area' => 
                array (
                  'x' => 0,
                  'y' => 0,
                  'width' => 513,
                  'height' => 641,
                ),
                'text' => 'Action 1',
              ),
              1 => 
              array (
                'type' => 'message',
                'area' => 
                array (
                  'x' => 513,
                  'y' => 2,
                  'width' => 527,
                  'height' => 349,
                ),
                'text' => 'Action 2',
              ),
              2 => 
              array (
                'type' => 'message',
                'area' => 
                array (
                  'x' => 509,
                  'y' => 351,
                  'width' => 531,
                  'height' => 292,
                ),
                'text' => 'Action 3',
              ),
            ),
          );
    }
  }
  else
  {
    if($isData >0){
       foreach($data as $rec){
        $arrPostData = array();
        $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
        $arrPostData['messages'][0]['type'] = "text";
        $arrPostData['messages'][0]['text'] = $rec->answer;
       }
    }
    else
    {
        $arrPostData = array();
        $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
        $arrPostData['messages'][0]['type'] = "text";
        $arrPostData['messages'][0]['text'] = 'H.E.L.E.N คุณสามารถสอนให้ฉันฉลาดได้เพียงพิมพ์: H.E.L.E.N[คำถาม|คำตอบ]';
    }
  }

  $channel = curl_init();
  curl_setopt($channel, CURLOPT_URL,$strUrl);
  curl_setopt($channel, CURLOPT_HEADER, false);
  curl_setopt($channel, CURLOPT_POST, true);
  curl_setopt($channel, CURLOPT_HTTPHEADER, $arrHeader);
  curl_setopt($channel, CURLOPT_POSTFIELDS, json_encode($arrPostData));
  curl_setopt($channel, CURLOPT_RETURNTRANSFER,true);
  curl_setopt($channel, CURLOPT_SSL_VERIFYPEER, false);
  $result = curl_exec($channel);
  curl_close ($channel);
  echo "sucess full";
?>
