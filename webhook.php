<?php

// parameters
$hubVerifyToken = 'doctorray_dong_8888';
$accessToken =   "EAADuhTfMOlMBABedxMYM8oDxELTfe3rl2N8foCslDepFfbhVF01fFvuZBOkjOBad2OuNgcos0ofW3e9vXxwZCUurpF6YiYFyLBZC0TcvfYG67SZBNZBo8miMjzohdizBgO3NAycZCch4RQTA67fzwtq3SlnTRSSJfsgRZBtET1nKwZDZD";

// check token at setup
if ($_REQUEST['hub_verify_token'] === $hubVerifyToken) {
    echo $_REQUEST['hub_challenge'];
  exit;
}

// handle bot's answer
$input = json_decode(file_get_contents('php://input'), true);
$senderId = $input['entry'][0]['messaging'][0]['sender']['id'];
$messageText = $input['entry'][0]['messaging'][0]['message']['text'];
$response = null;

//set Message


//set Message
for($i = 0; $i < count($messageText); $i++) {

    if($messageText == "hi" ) { 


      $answer = 'Hi ho';

      $response = [
        'recipient' => [ 'id' => $senderId ],
        'message' => [ 'text' => $answer ]
    ];

  } else if ($messageText == 'yo')

        {
          $answer = 'wtf';

      $response = [
        'recipient' => [ 'id' => $senderId ],
        'message' => [ 'text' => $answer ]
    ];

    } else if($messageText == "blog"){
         $answer = ["attachment"=>[
          "type"=>"template",
          "payload"=>[
            "template_type"=>"generic",
            "elements"=>[
              [
                "title"=>"Welcome to PetInsure.co",
                "item_url"=>"https://www.cloudways.com/blog/migrate-symfony-from-cpanel-to-cloud-hosting/",
                "image_url"=>"https://www.cloudways.com/blog/wp-content/uploads/Migrating-Your-Symfony-Website-To-Cloudways-Banner.jpg",
                "subtitle"=>"We've got the right hat for everyone.",
                "buttons"=>[
                  [
                    "type"=>"web_url",
                    "url"=>"https://petinsure.co",
                    "title"=>"View Website"
                  ],
                  [
                    "type"=>"postback",
                    "title"=>"Start Chatting",
                    "payload"=>"DEVELOPER_DEFINED_PAYLOAD"

                  ]              
                ]
              ]
            ]
          ] // payload
        ] // type
      ]; // attachment


        
         $response = [
        'recipient' => [ 'id' => $senderId ],
        'message' => $answer 
      ];

  } else if ($messageText == 'Start Chatting')

        {
          $answer = 'raiws';

      $response = [
        'recipient' => [ 'id' => $senderId ],
        'message' => [ 'text' => $answer ]
    ];

    } 

}
//send message to facebook bot





////////// CURL ////////////

$ch = curl_init('https://graph.facebook.com/v2.6/me/messages?access_token='.$accessToken);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
if(!empty($input)){
$result = curl_exec($ch);
}
curl_close($ch);

?>
