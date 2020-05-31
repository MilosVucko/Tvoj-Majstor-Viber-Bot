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


   $type = $input['message']['type']; //type of message received (text/picture)
  $text = $input['message']['text']; //actual message the user has sent
  $sender_id = $input['sender']['id']; //unique viber id of user who sent the message
  $sender_name = $input['sender']['name']; //name of the user who sent the message


 $data['auth_token']='4b9930f4ace7d35b-d123dd553b0a5914-a46f7c2f0dba7188';
  $data['receiver']=$sender_id;
  $data['BgColor']="#ffffff";
  $data['type']='text';
  $data['text']="IZABERITE KOJU PRETRAGU ŽELITE DA IZVRŠITE: ";
  
  $keyboard_array['Type']='keyboard';
  $keyboard_array['DefaultHeight']=false;
  $keyboard_array['BgColor']="#ffffff";
  $keyboard['keyboard']=$keyboard_array;

    $posao['Columns']=3;
  $posao['Rows']=2;
  $posao['TextVAlign']="middle";
  $posao['TextHAlign']="center";
  $posao['TextOpacity']="100";
  $posao['Text']="<font color=\"#ffffff\">Posao</font>";
  $posao['BgColor']="#6B62B5";
  $posao['TextSize']="regular";
  $posao['ActionType']="reply";
  $posao['ActionBody']="posao";
  $keyboard['keyboard']['Buttons'][]=$posao;

  $majstor['Columns']=3;
  $majstor['Rows']=2;
  $majstor['TextVAlign']="middle";
  $majstor['TextHAlign']="center";
  $majstor['TextOpacity']="100";
  $majstor['Text']="<font color=\"#ffffff\">Majstor</font>";
  $majstor['BgColor']="#6B62B5";
  $majstor['TextSize']="regular";
  $majstor['ActionType']="reply";
  $majstor['ActionBody']="majstor";
  $keyboard['keyboard']['Buttons'][]=$majstor;

  $data['keyboard']=$keyboard['keyboard'];
 

if ($text == 'posao') {

 $data['auth_token']='4b9930f4ace7d35b-d123dd553b0a5914-a46f7c2f0dba7188';
  $data['receiver']=$sender_id;
  $data['BgColor']="#ffffff";
  $data['type']='text';
  $data['text']="IZABERITE GRAD U KOJEM ŽELITE DA NADJETE POSAO: ";
  
  $keyboard_array['Type']='keyboard';
  $keyboard_array['DefaultHeight']=false;
  $keyboard_array['BgColor']="#ffffff";
  $keyboard['keyboard']=$keyboard_array;



$url_api = 'https://dobarmajstor.w3lab.cloud/wp-json/wp/v2/lokacijaposlovi'; 
$data_api = file_get_contents($url_api); 
$job_locations = json_decode($data_api); 


 foreach ($job_locations as $job_location) { 
  $locations['Columns']=3;
  $locations['Rows']=2;
  $locations['TextVAlign']="middle";
  $locations['TextHAlign']="center";
  $locations['TextOpacity']="100";
  $locations['Text']="<font color=\"#ffffff\">" . $job_location->name . "</font>";
  $locations['BgColor']="#6B62B5";
  $locations['TextSize']="regular";
  $locations['ActionType']="reply";
  $locations['ActionBody']=$job_location->slug;
  $keyboard['keyboard']['Buttons'][]=$locations;

  $data['keyboard']=$keyboard['keyboard'];

}
  
} 
if ($text == 'majstor') {

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

if($text == 'mitrovica' || $text == 'pristina' || $text == 'zvecan' || $text == 'sve-lokacije'){


$url_api_2 = 'https://dobarmajstor.w3lab.cloud/wp-json/wp/v2/poslovi?filter[lokacijaposlovi]='.$text; 
$data_api_2 = file_get_contents($url_api_2); 
$jobs_list = json_decode($data_api_2); 


  $data['auth_token']='4b9930f4ace7d35b-d123dd553b0a5914-a46f7c2f0dba7188';
  $data['receiver']=$sender_id;
  $data['BgColor']="#ffffff";
  $data['type']='text';
  $data['text']="IZABERITE POSAO:  ";

  $keyboard_array['Type']='keyboard';
  $keyboard_array['DefaultHeight']=false;
  $keyboard_array['BgColor']="#ffffff";
  $keyboard['keyboard']=$keyboard_array;

 foreach ($jobs_list  as $jobs_lis) {
  $url_api_num = 'https://dobarmajstor.w3lab.cloud/wp-json/acf/v3/radnici/'.$jobs_lis->id; 
$data_api_num = file_get_contents($url_api_num); 
$job_numbers = json_decode($data_api_num); 

   foreach ($job_numbers as $job_number) {
    $news['Columns']=6;
  $news['Rows']=1;
  $news['TextVAlign']="middle";
  $news['TextHAlign']="center";
  $news['TextOpacity']="100";
  $news['Text']="<font color=\"#ffffff\">" . $jobs_lis->title->rendered ."</font>";
  $news['BgColor']="#6B62B5";
  $news['TextSize']="regular";
  $news['ActionType']="open-url";
  $news['ActionBody']='tel:'.$job_number->broj_telefona;
  $keyboard['keyboard']['Buttons'][]=$news;

}

}
 $website['Columns']=6;
  $website['Rows']=2;
  $website['TextVAlign']="middle";
  $website['TextHAlign']="center";
  $website['TextOpacity']="100";
  $website['Text']="<font color=\"#ffffff\">Za više informacija posetite naš sajt</font>";
  $website['BgColor']="#6B62B5";
  $website['TextSize']="regular";
  $website['ActionType']="open-url";
  $website['ActionBody']="https://dobarmajstor.w3lab.cloud/";
  $keyboard['keyboard']['Buttons'][]=$website;
   $data['keyboard']=$keyboard['keyboard'];

}


if($text == 'automehanicar' || $text == 'elektricar' || $text == 'klima-majstor'|| $text == 'vodoinstalater' || $text == 'moler'|| $text == 'keramicar'){


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