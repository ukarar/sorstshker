<?php
if (!file_exists('madeline.php')) {
    copy('https://phar.madelineproto.xyz/madeline.php', 'madeline.php');
}
define('MADELINE_BRANCH', 'deprecated');
include 'madeline.php';

$token = json_decode(file_get_contents('admin.json'),true)['token'];
$id = json_decode(file_get_contents('admin.json'),true)['id'];

function bot($method, $datas = []) {
    global $token;
	$url = "https://api.telegram.org/bot$token/" . $method;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$res = curl_exec($ch);
	curl_close($ch);
	return json_decode($res, true);
}

function Account(){
    
    global $id;
    
    $settings['app_info']['api_id'] = 210897;
    $settings['app_info']['api_hash'] = 'c7d2d161d83ce18d56c1a8a54437f5ff'; 
    $MadelineProto = new \danog\MadelineProto\API('5.madeline', $settings);
    $MadelineProto->start();
    
    $x = 0;
    
    $usersCount = count(explode("\n",file_get_contents("users5")))-1;
    
    if ($usersCount <= 4) {
        
        bot('sendMessage',['chat_id' => $id, 'text' => 'Starting Turbo ... 5']);
        
        $users = explode("\n",file_get_contents("users5"));
        $users = array_filter($users);
        
        while (true){
            foreach($users as $user){
                try {
                    $MadelineProto->messages->getPeerDialogs(['peers' => [$user] ]);
                    $x++;
                } catch (Exception $e) {
                    try {
                        $MadelineProto->account->updateUsername(['username' => $user]);
                        bot('sendMessage',['chat_id' => $id, 'text' => "He Shoot’s He Scores 🦖 \n- - - - - - - - - - - \nAnother Good Claim : $user 🐉 \nRetries : $x ☘️ \nClaimed In : Account 🌴 \n- - - - - - - - - - \nBy : @ALMASLAWI"]);
                        exit;
                    } catch (Exception $e) {
                        bot('sendMessage',['chat_id' => $id, 'text' => "There Was An Error -> ".$e->getMessage()]);
                        exit;
                    }
                }
            }
        }
    } else {
        
        bot('sendMessage',['chat_id' => $id, 'text' => 'Starting Checker ... 5']);
        
        while (true){
            
            $users = explode("\n",file_get_contents("users5"));
            $users = array_filter($users);
            
            foreach($users as $user){
                try {
                    $MadelineProto->messages->getPeerDialogs(['peers' => [$user] ]);
                    $x++;
                } catch (Exception $e) {
                    try {
                        $MadelineProto->account->updateUsername(['username' => $user]);
                        bot('sendMessage',['chat_id' => $id, 'text' => "He Shoot’s He Scores 🦖 \n- - - - - - - - - - - \nAnother Good Claim : $user 🐉 \nRetries : $x ☘️ \nClaimed In : Account 🌴 \n- - - - - - - - - - \nBy : @ALMASLAWI"]);
                        exit;
                    } catch (Exception $e) {
                        bot('sendMessage',['chat_id' => $id, 'text' => "There Was An Error -> ".$e->getMessage()]);
                        exit;
                    }
                }
            }
        }
    }
}

function Channel(){
    
    global $id;
    
    $settings['app_info']['api_id'] = 210897;
    $settings['app_info']['api_hash'] = 'c7d2d161d83ce18d56c1a8a54437f5ff'; 
    $MadelineProto = new \danog\MadelineProto\API('5.madeline', $settings);
    $MadelineProto->start();
    
    $x = 0;
    
    $usersCount = count(explode("\n",file_get_contents("users5")))-1;
    
    if ($usersCount <= 4) {
        bot('sendMessage',['chat_id' => $id, 'text' => 'Starting Turbo ... 5']);
        
        $users = explode("\n",file_get_contents("users5"));
        $users = array_filter($users);
        
        $crate_channel = $MadelineProto->channels->createChannel(['broadcast' => true,'megagroup' => false,'title' => '- ALMASLAWI .', ]);
        $channel_edit = $crate_channel['updates'][1];        
        
        while (true){
            foreach($users as $user){
                try {
                    $MadelineProto->messages->getPeerDialogs(['peers' => [$user] ]);
                    $x++;
                } catch (Exception $e) {
                    try {
                        $MadelineProto->channels->updateUsername(['channel' => $channel_edit, 'username' => $user]);        
                        bot('sendMessage',['chat_id' => $id, 'text' => "He Shoot’s He Scores 🦖 \n- - - - - - - - - - - \nAnother Good Claim : $user 🐉 \nRetries : $x ☘️ \nClaimed In : Channel 🌴 \n- - - - - - - - - - \nBy : @ALMASLAWI"]);
                        $MadelineProto->messages->sendMessage(['peer' => $channel_edit, 'message' => "He Shoot’s He Scores 🦖 \n- - - - - - - - - - - \nAnother Good Claim : $user 🐉 \nRetries : $x ☘️ \nClaimed In : Channel 🌴 \n- - - - - - - - - - \nBy : @ALMASLAWI"]);                            exit;
                    } catch (Exception $e) {
                        bot('sendMessage',['chat_id' => $id, 'text' => "There Was An Error -> ".$e->getMessage()]);
                        exit;
                    }
                }
            }
        }
    } else {
        bot('sendMessage',['chat_id' => $id, 'text' => 'Starting Checker ... 5']);
        
        $crate_channel = $MadelineProto->channels->createChannel(['broadcast' => true,'megagroup' => false,'title' => '- ALMASLAWI .', ]);
        $channel_edit = $crate_channel['updates'][1];      
        
        while (true){
            
            $users = explode("\n",file_get_contents("users5"));
            $users = array_filter($users);
            
            foreach($users as $user){
                try {
                    $MadelineProto->messages->getPeerDialogs(['peers' => [$user] ]);
                    $x++;
                } catch (Exception $e) {
                    try {
                        $MadelineProto->channels->updateUsername(['channel' => $channel_edit, 'username' => $user]);        
                        bot('sendMessage',['chat_id' => $id, 'text' => "He Shoot’s He Scores 🦖 \n- - - - - - - - - - - \nAnother Good Claim : $user 🐉 \nRetries : $x ☘️ \nClaimed In : Channel 🌴 \n- - - - - - - - - - \nBy : @ALMASLAWI"]);
                        $MadelineProto->messages->sendMessage(['peer' => $channel_edit, 'message' => "He Shoot’s He Scores 🦖 \n- - - - - - - - - - - \nAnother Good Claim : $user 🐉 \nRetries : $x ☘️ \nClaimed In : Channel 🌴 \n- - - - - - - - - - \nBy : @ALMASLAWI"]);                            exit;
                        exit;
                    } catch (Exception $e) {
                        bot('sendMessage',['chat_id' => $id, 'text' => "There Was An Error -> ".$e->getMessage()]);
                        exit;
                    }
                }
            }
        }
    }
}

if(json_decode(file_get_contents('mode.json'),true)['number5']['method'] == 'account'){
    Account();
} else {
    Channel();
}
