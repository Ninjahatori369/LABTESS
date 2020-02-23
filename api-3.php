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
      $arrPostData['messages'][0]['type'] = "text";
      $arrPostData['messages'][0]['text'] = 'Ninja-Thank you.';
      $arrPostData['messages'][1]['type'] = "text";
      $arrPostData['messages'][1]['text'] = 'second Ninja-Thank you.';
      $arrPostData['messages'][2]['type'] = "image";
      $arrPostData['messages'][2]['originalContentUrl'] = 'https://www.googreens.com/img/man.png';
      $arrPostData['messages'][2]['previewImageUrl'] = 'https://www.googreens.com/img/man.png';
      $arrPostData['messages'][3]['type'] = 'imagemap';
      $arrPostData['messages'][3]['baseUrl'] = 'https://1.bp.blogspot.com/-U90M8DyKu7Q/W9EtONMCf6I/AAAAAAAAW_4/7L_jB_Rg9oweu2HKhULNdu9WNefw9zf9wCLcBGAs/s1600/sapo-full.jpg';
      $arrPostData['messages'][3]['altText'] = 'This is an imagemap';
  
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
