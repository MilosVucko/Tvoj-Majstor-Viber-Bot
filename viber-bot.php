<?php
$request = file_get_contents("php://input");
$input = json_decode($request, true);

if($input['event'] == "webhook") {
  $webhook_response['status']=0;
  $webhook_response['status_message']="ok";
  $webhook_response['event_types']='delivered';
  echo json_encode($webhook_response);
  die;
}

else if($input['event'] == "subscribed") {
  // when a user subscribes to the public account
}
else if($input['event'] == "conversation_started"){
  // when a conversation is started
}
elseif($input['event'] == "message") {
  /* when a user message is received */
  $type = $input['message']['type']; //type of message received (text/picture)
  $text = $input['message']['text']; //actual message the user has sent
  $sender_id = $input['sender']['id']; //unique viber id of user who sent the message
  $sender_name = $input['sender']['name']; //name of the user who sent the message

 

if($text == 'automehanicar' || $text == 'elektricar' || $text == 'klima-majstor'|| $text == 'vodoinstalater' || $text == 'moler'|| $text == 'keramicar'){


$type = $input['message']['type']; //type of message received (text/picture)
  $text = $input['message']['text']; //actual message the user has sent
  $sender_id = $input['sender']['id']; //unique viber id of user who sent the message
  $sender_name = $input['sender']['name']; //name of the user who sent the message

$url_api_2 = 'https://dobarmajstor.w3lab.cloud/wp-json/wp/v2/radnici?filter[kategorija-poslova]='.$text; 
$data_api_2 = file_get_contents($url_api_2); 
$worker_names = json_decode($data_api_2); 


  $data['auth_token']='4b9930f4ace7d35b-d123dd553b0a5914-a46f7c2f0dba7188';
  $data['receiver']=$sender_id;
  $data['BgColor']="#ffffff";
  $data['type']='text';
  $data['text']="IZABERITE POUZDANOG LOKALNOG STRUČNJAKA IZ ODABRANE KATEGORIJE:  ";

  $keyboard_array['Type']='keyboard';
  $keyboard_array['DefaultHeight']=false;
  $keyboard_array['BgColor']="#ffffff";
  $keyboard['keyboard']=$keyboard_array;

 foreach ($worker_names as $worker_name) {
  $url_api_num = 'https://dobarmajstor.w3lab.cloud/wp-json/acf/v3/radnici/'.$worker_name->id; 
$data_api_num = file_get_contents($url_api_num); 
$worker_numbers = json_decode($data_api_num); 

   foreach ($worker_numbers as $worker_number) {
    $news['Columns']=6;
  $news['Rows']=1;
  $news['TextVAlign']="middle";
  $news['TextHAlign']="center";
  $news['TextOpacity']="100";
  $news['Text']="<font color=\"#ffffff\">" . $worker_name->title->rendered ."<br> Lokacija: ".$worker_name->acf->lokacija_radnika->name."</font>";
  $news['BgColor']="#6B62B5";
  $news['TextSize']="regular";
  $news['ActionType']="open-url";
  $news['ActionBody']='tel:'.$worker_number->broj_telefona;
  $keyboard['keyboard']['Buttons'][]=$news;

}

}
 $website['Columns']=6;
  $website['Rows']=2;
  $website['TextVAlign']="middle";
  $website['TextHAlign']="center";
  $website['TextOpacity']="100";
  $website['Text']="<font color=\"#ffffff\">Za više informacija posetite nas sajt</font>";
  $website['BgColor']="#6B62B5";
  $website['TextSize']="regular";
  $website['ActionType']="open-url";
  $website['ActionBody']="https://dobarmajstor.w3lab.cloud/";
  $keyboard['keyboard']['Buttons'][]=$website;
   $data['keyboard']=$keyboard['keyboard'];

} else {

 $type = $input['message']['type']; //type of message received (text/picture)
  $text = $input['message']['text']; //actual message the user has sent
  $sender_id = $input['sender']['id']; //unique viber id of user who sent the message
  $sender_name = $input['sender']['name']; //name of the user who sent the message


 $data['auth_token']='4b9930f4ace7d35b-d123dd553b0a5914-a46f7c2f0dba7188';
  $data['receiver']=$sender_id;
  $data['BgColor']="#ffffff";
  $data['type']='text';
  $data['text']="PRONAĐI POUZDANE LOKALNE STRUČNJAKE ZA KATEGORIJU POSLA: ";
  
  $keyboard_array['Type']='keyboard';
  $keyboard_array['DefaultHeight']=false;
  $keyboard_array['BgColor']="#ffffff";
  $keyboard['keyboard']=$keyboard_array;



$url_api = 'https://dobarmajstor.w3lab.cloud/wp-json/wp/v2/kategorija-poslova'; 
$data_api = file_get_contents($url_api); 
$type_job = json_decode($data_api); 


 foreach ($type_job as $type_jobs) {
   if($type_jobs->slug != 'sve-kategorije') { 
  $news['Columns']=3;
  $news['Rows']=2;
  $news['TextVAlign']="middle";
  $news['TextHAlign']="center";
  $news['TextOpacity']="100";
  $news['Text']="<font color=\"#ffffff\">" . $type_jobs->name . "</font>";
  $news['BgColor']="#6B62B5";
  $news['TextSize']="regular";
  $news['ActionType']="reply";
  $news['ActionBody']=$type_jobs->slug;
  $keyboard['keyboard']['Buttons'][]=$news;

  $data['keyboard']=$keyboard['keyboard'];

} else {
  
 }
}

}  

  
  //here goes the curl to send data to user
  $ch = curl_init("https://chatapi.viber.com/pa/send_message");
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
  $result = curl_exec($ch);
  curl_close($ch);
}

?>