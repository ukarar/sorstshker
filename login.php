<?php
require('conf.php'); 
$nn = json_decode(file_get_contents('mode.json'),true)['login'];
system("rm *$nn.ma*");
date_default_timezone_set("Asia/Baghdad");
$json = json_decode(file_get_contents('mode.json'),true);
if (!file_exists('madeline.php')) {
 copy('https://phar.madelineproto.xyz/madeline.php', 'madeline.php');
}
define('MADELINE_BRANCH', 'deprecated');
include 'madeline.php';  
$settings['app_info']['api_id'] = 210897;
$settings['app_info']['api_hash'] = 'c7d2d161d83ce18d56c1a8a54437f5ff'; 
$MadelineProto = new \danog\MadelineProto\API(''.$json['login'].'.madeline', $settings);  
$token = json_decode(file_get_contents('admin.json'),true)['token'];
$id = json_decode(file_get_contents('admin.json'),true)['id'];
$phone = $json['number'.$json['login']]['phone'];
$tg = new Telegram($token);
$lastupdid = 1; 
$step = 0;
while(true){ 
    $upd = $tg->vtcor("getUpdates", ["offset" => $lastupdid]); 
    if(isset($upd['result'][0])){ 
        $text = $upd['result'][0]['message']['text']; 
        $chat_id = $upd['result'][0]['message']['chat']['id']; 
        $from_id = $upd['result'][0]['message']['from']['id']; 
        if($from_id == $id){
            try{
                if($step == 0){
                    $MadelineProto->phonelogin($phone);
                    $tg->vtcor('sendMessage',[
                    'chat_id' => $id,
                    'text' => 'Ok, Now Please Send The Code',
                ]);
                $step = 1;
                }elseif($step == 1) {
                    if($text){
                        $authorization = $MadelineProto->completephonelogin($text);
                        if ($authorization['_'] === 'account.password') {
                            $tg->vtcor('sendmessage',[
                                'chat_id'=>$chat_id, 
                                'text'=>"Ok, Send The Password !",
                            ]);
                            $step = 2;
                        } else {
                            $tg->vtcor('sendmessage',[
                                'chat_id'=>$chat_id, 
                                'text'=>"Ok, Done Login Checker Number : ".$json['login'],
                                ]);
                                $json['login'] = null;
                                file_put_contents('mode.json',json_encode($json));
                                exit;
                        }
                    }
                } elseif($step == 2) {
                    if($text){
                        $authorization = $MadelineProto->complete2falogin($text);
                        $tg->vtcor('sendmessage',[
                            'chat_id'=>$chat_id, 
                            'text'=>"Ok, Done Login Checker Number : ".$json['login'],
                        ]);
                        exit;
                    }
                }
            }catch(Exception $e) {
                $tg->vtcor('sendmessage',[
                    'chat_id'=>$chat_id, 
                    'text' => 'There Was An Error : '.$e->getMessage(),
                ]);
                exit;
            }
        }
        $lastupdid = $upd['result'][0]['update_id'] + 1;
    }
}
