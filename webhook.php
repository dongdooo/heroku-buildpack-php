<?php

// parameters
$hubVerifyToken = 'doctorray_dong_8888';
$accessToken =   "EAADuhTfMOlMBABedxMYM8oDxELTfe3rl2N8foCslDepFfbhVF01fFvuZBOkjOBad2OuNgcos0ofW3e9vXxwZCUurpF6YiYFyLBZC0TcvfYG67SZBNZBo8miMjzohdizBgO3NAycZCch4RQTA67fzwtq3SlnTRSSJfsgRZBtET1nKwZDZD";

// In case of bug : https://developers.facebook.com/tools/debug/sharing/ for debugger

// check token at setup
if ($_REQUEST['hub_verify_token'] === $hubVerifyToken) {
    echo $_REQUEST['hub_challenge'];
  exit;
}

///// Set Array Welcome value 

$wel = array();

//////// Update Get Started of Chatbot

  $wel[0] = ["setting_type"=>"call_to_actions",
              "thread_state"=>"new_thread",
                "call_to_actions"=>[
                  [
                    "payload"=>"welcomee" 
                  ]
                ]
          ];
////////{"result":"Successfully added new_thread's CTAs"} 

//////// Update Greeting Text Here

  $wel[1] = ["setting_type"=>"greeting",
              "thread_state"=>"new_thread",
                "greeting"=>
                  [
                    "text"=>"Hi {{user_first_name}}, welcome to this bottttt." 
                  ]
          ];

////////{"result":"Successfully updated greeting"}

foreach($wel as $value) {
 
////////// CURL ////////////

$cha = curl_init('https://graph.facebook.com/v2.6/587221591431576/thread_settings?access_token='.$accessToken);
curl_setopt($cha, CURLOPT_POST, 1);
curl_setopt($cha, CURLOPT_POSTFIELDS, json_encode($value));
curl_setopt($cha, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
if($value){
$result = curl_exec($cha);
}
curl_close($cha);

} //// end foreach

///////// end welcome message

// handle bot's answer
$input = json_decode(file_get_contents('php://input'), true); // get content in php
$senderId = $input['entry'][0]['messaging'][0]['sender']['id']; //sender ID
$messageText = $input['entry'][0]['messaging'][0]['message']['text']; //text receive
//$messageImage = $input['entry'][0]['messaging'][0]['message']['attachments'][0]['type']['image']; //receive attachment
$postback = $input['entry'][0]['messaging'][0]['postback']['payload']; //get postback payload
$callback = $input['entry'][0]['messaging'][0]['message']['attachments'][0]['payload']['coordinates'];


    if (isset($callback) && !empty($callback))  {

      $lat = $callback['lat'];
      $long = $callback['long'];

      $msg = $lat . ',' . $long;

      $sql = "UPDATE fbchatbot SET message='$msg' WHERE id='1'";

      $localDB = mysqli_query($conn, $sql);

          if($localDB) {

                $answer =  'Location : ' . $lat .','. $long; 

                $response = [
                  'recipient' => [ 'id' => $senderId ],
                  'message' => [ 'text' => $answer ]
              ];


            } else {

              echo 'error woiiiiiiiii WTF' ;
            }

          }



      

    // if (isset($lat) && !empty($lat)) {

    //     //$lat = $callback['lat'];
    //     //$long = $callback['long'];

    //   $answer =  'your is'.$lat; 

    //         $response = [
    //           'recipient' => [ 'id' => $senderId ],
    //           'message' => [ 'text' => $answer ]
    //       ];

    // } 


//Handle postback & payload Message

for($i = 0; $i < count($postback); $i++) {

  if ($postback=='bbbb') {

    $answer = 'aaaaa';

        $response = [
          'recipient' => [ 'id' => $senderId ],
          'message' => [ 'text' => $answer ]
      ];
  }

  if ($postback=='welcomee') {

    $answer = 'hello ja fuckyou';

        $response = [
          'recipient' => [ 'id' => $senderId ],
          'message' => [ 'text' => $answer ]
      ];
  }

}

//Set incoming Message

for($i = 0; $i < count($messageText); $i++) {

    if($messageText == "hi" ) { 

      $sql = "UPDATE fbchatbot SET info='$messageText' WHERE id='1'";

      $localDB = mysqli_query($conn, $sql);

          if($localDB) { 

                $answer = 'Hi ho';

                $response = [
                  'recipient' => [ 'id' => $senderId ],
                  'message' => [ 'text' => $answer ]
              ];


            } else {

              echo 'error woiiiiiiiii WTF' ;
            }


  } else if ($messageText == 'yo')

        {
          $answer = 'wtf';

      $response = [
        'recipient' => [ 'id' => $senderId ],
        'message' => [ 'text' => $answer ]
    ];

    } else if($messageText == "more") {  
  $answer = ["attachment"=>[
      "type"=>"template",
      "payload"=>[
        "template_type"=>"button",
        "text"=>"What do you want to do next?",
        "buttons"=>[
          [
            "type"=>"web_url",
            "url"=>"https://petersapparel.parseapp.com",
            "title"=>"Show Website"
          ],
          [
            "type"=>"postback",
            "title"=>"start",
            "payload"=>"bbbb"
          ]
        ]
      ]
      ]];

        $response = [
          'recipient' => [ 'id' => $senderId ],
          'message' => $answer
      ];

} else if($messageText == "qqq"){
          $answer = 
            [
              "text"=>"Pick a color:",
                "quick_replies"=>[
                [
                  "content_type"=>"text",
                  "title"=>"Red",
                  "image_url"=>"https://petersfantastichats.com/img/red.png",
                  "payload"=>"DEVELOPER_DEFINED_PAYLOAD_FOR_PICKING_RED"
                ],
                [
                  "content_type"=>"text",
                  "title"=>"Green",
                  "image_url"=>"https://petersfantastichats.com/img/green.png",
                  "payload"=>"DEVELOPER_DEFINED_PAYLOAD_FOR_PICKING_GREEN"
                ]
              ]
            ];
               
         $response = [
        'recipient' => [ 'id' => $senderId ],
        'message' => $answer 
      ];

  } else if($messageText == "wru"){
          $answer = 
            [
              "text"=>"Please share your location:",
                "quick_replies"=>[
                [
                  "content_type"=>"location",
                ]
              ]
            ];
               
         $response = [
        'recipient' => [ 'id' => $senderId ],
        'message' => $answer 
      ];

  }


    else if ($messageText == 'eeee')

        {
          $answer = 'raiws';

      $response = [
        'recipient' => [ 'id' => $senderId ],
        'message' => [ 'text' => $answer ]
    ];

    } 

    else if ($messageText == 'Red')

        {
          $answer = 'แดงดิ';

      $response = [
        'recipient' => [ 'id' => $senderId ],
        'message' => [ 'text' => $answer ]
    ];

    } 

    else if ($messageText == 'start')

        {
          $answer = 'starttttttt';

      $response = [
        'recipient' => [ 'id' => $senderId ],
        'message' => [ 'text' => $answer ]
    ];

    } else if($messageText == "login"){
           $answer = ["attachment"=>[
            "type"=>"template",
            "payload"=>[
              "template_type"=>"generic",
              "elements"=>[
                [
                  "title"=>"ยินดีต้อนรับเข้าสู่ PetInsure",
                  "item_url"=>"https://www.petinsure.co",
                  "image_url"=>"https://petinsure.co/images/petinsure_step1.png",
                  "subtitle"=>"ประกันภัยสัตว์เลี้ยงออนไลน์เจ้าแรกในประเทศไทย",
                  "buttons"=>[
                    [
                      "type"=>"account_link",
                      "url"=>"https://petinsure.co"
                    ]              
                  ]
                ]
              ]
            ]
          ]];

           $response = [
          'recipient' => [ 'id' => $senderId ],
          'message' => $answer 

      ];

    } else 

        {
          $answer = 'กรอกผิดนะจ๊ะ';

      $response = [
        'recipient' => [ 'id' => $senderId ],
        'message' => [ 'text' => $answer ]
    ];

      }
}
//send message to facebook bot


//Set incoming Message

    if (isset($messageImage)&& !empty($messageImage))

        {
          $answer = 'ส่งรูปมาหาพ่อง';

      $response = [
        'recipient' => [ 'id' => $senderId ],
        'message' => [ 'text' => $answer ]
    ];

    } 

    



////////// CURL ////////////

$ch = curl_init('https://graph.facebook.com/v2.6/587221591431576/messages?access_token='.$accessToken);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
if(!empty($input)){
$result = curl_exec($ch);
}
curl_close($ch);



  mysqli_close ($conn); // Connection Closed.

  exit();


?>
