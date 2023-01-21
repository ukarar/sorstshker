<?php
require('conf.php');
if (!file_exists("admin.json")) {$token =  readline("- Enter Token : ");$id = readline("- Enter iD : ");file_put_contents('admin.json',json_encode(['token' => $token, 'id' => $id]));}
$token = json_decode(file_get_contents('admin.json'),true)['token'];
$id = json_decode(file_get_contents('admin.json'),true)['id'];
$tg = new Telegram($token);
$lastupdid = 1;
while(true){
    $upd = $tg->vtcor("getUpdates", ["offset" => $lastupdid]);
    if(isset($upd['result'][0])){
        $message = $upd['result'][0]['message'];
        $text = $message['text'];
        $chat_id = $message['chat']['id'];
        $from_id = $message['from']['id'];
        $first_name = $message['from']['first_name'];
        $json = json_decode(file_get_contents('mode.json'),true);
        if($from_id == $id){
            if($text == '/start' or $text == 'Go Back'){
                $tg->vtcor('sendMessage',[
                    'chat_id' => $chat_id,
                    'text' => "Welcome $first_name 🦖 \n To The Checker 🐉 \n - - - - - - - - - - - - -  \nChannel : @ALMASLAWI",
                    'reply_markup' => json_encode([
                        'resize_keyboard' => true,
                        'keyboard' => [
                            [['text' => 'Run A Specefic Checker'],['text' => 'Stop A Specefic Checker']],
                            [['text' => 'Run All Checkers'],['text' => 'Stop All Checkers']],
                            [['text' => 'Add A Number'],['text' => 'Checkers Info']],
                            [['text' => 'Pin A Username'],['text' => 'Clear A Specefic List']],
                            [['text' => 'Pin In All'],['text' => 'Clear All List']],
                            [['text' => 'Specefic Checker Info'],['text' => 'List Of Users']],
                        ]
                    ])
                ]);
                $json['mode'] = null;
                file_put_contents('mode.json',json_encode($json));
            }elseif($text == 'Run A Specefic Checker'){
                $tg->vtcor('sendMessage',[
                    'chat_id' => $chat_id,
                    'text' => 'Choose The Checker You Want To Run',
                    'reply_markup' => json_encode([
                        'resize_keyboard' => true,
                        'keyboard' => [
                            [['text' => 'Run Checker Number 1'],['text' => 'Run Checker Number 2']],
                            [['text' => 'Run Checker Number 3'],['text' => 'Run Checker Number 4']],
                            [['text' => 'Run Checker Number 5']],
                        ],
                    ])
                ]);
            }elseif($text == 'Stop A Specefic Checker'){
                $tg->vtcor('sendMessage',[
                    'chat_id' => $chat_id,
                    'text' => 'Choose The Checker You Want To Stop',
                    'reply_markup' => json_encode([
                        'resize_keyboard' => true,
                        'keyboard' => [
                            [['text' => 'Stop Checker Number 1'],['text' => 'Stop Checker Number 2']],
                            [['text' => 'Stop Checker Number 3'],['text' => 'Stop Checker Number 4']],
                            [['text' => 'Stop Checker Number 5']],
                        ]
                    ])
                ]);
            }elseif($text == 'Run All Checkers'){
                $tg->vtcor('sendMessage',[
                    'chat_id' => $chat_id,
                    'text' => 'Ok! Now Choose The Running Method',
                    'reply_markup' => json_encode([
                        'resize_keyboard' => true,
                        'keyboard' => [
                            [['text' => 'All Run Account'],['text' => 'All Run New Channel']],
                            [['text' => 'Go Back']],
                        ]
                    ])
                ]);
            }elseif($text == 'All Run Account'){
                $tg->vtcor('sendMessage',[
                    'chat_id' => $chat_id,
                    'text' => 'Done Ran All Checkers Method : Account',
                    'reply_markup' => json_encode([
                        'resize_keyboard' => true,
                        'keyboard' => [
                            [['text' => 'Go Back']],
                        ]
                    ])
                ]);
                for($i = 1; $i < 6 ; $i++){
                    if(file_exists($i.".madeline")){
                        $users = file_get_contents('users'.$i);
                        if(!empty($users)){
                            $json['number'.$i]['method'] = 'account';
                            file_put_contents('mode.json',json_encode($json));
                            shell_exec("screen -S $i -X kill");
                            shell_exec("screen -dmS $i php $i.php");
                        }else{
                            $tg->vtcor('sendMessage',[
                                'chat_id' => $chat_id,
                                'text' => "Could Not Run $i, No Users Have Been Found !"
                            ]);
                        }
                    }else{
                        $tg->vtcor('sendMessage',[
                            'chat_id' => $chat_id,
                            'text' => "Could Not Run $i, Because You Haven't Logged In !"
                        ]);
                    }
                }
            }elseif($text == 'All Run New Channel'){
                $tg->vtcor('sendMessage',[
                    'chat_id' => $chat_id,
                    'text' => 'Done Ran All Checkers Method : New Channel',
                    'reply_markup' => json_encode([
                        'resize_keyboard' => true,
                        'keyboard' => [
                            [['text' => 'Go Back']],
                        ]
                    ])
                ]);
                for($i = 1; $i < 6 ; $i++){
                    if(file_exists($i.".madeline")){
                        $users = file_get_contents('users'.$i);
                        if(!empty($users)){
                            $json['number'.$i]['method'] = 'channel';
                            file_put_contents('mode.json',json_encode($json));
                            shell_exec("screen -S $i -X kill");
                            shell_exec("screen -dmS $i php $i.php");
                        }else{
                            $tg->vtcor('sendMessage',[
                                'chat_id' => $chat_id,
                                'text' => "Could Not Run $i, No Users Have Been Found !"
                            ]);
                        }
                    }else{
                        $tg->vtcor('sendMessage',[
                            'chat_id' => $chat_id,
                            'text' => "Could Not Run $i, Because You Haven't Logged In !"
                        ]);
                    }
                }
            }elseif($text == 'Stop All Checkers'){
                $tg->vtcor('sendMessage',[
                    'chat_id' => $chat_id,
                    'text' => 'Ok! Stopping All Checkers',
                    'reply_markup' => json_encode([
                        'resize_keyboard' => true,
                        'keyboard' => [
                            [['text' => 'Go Back']],
                        ]
                    ])
                ]);
                for($i = 1; $i < 6 ; $i++){
                    if(file_exists($i.".madeline")){
                    if(online($i) == 'Running'){
                        $tg->vtcor('sendMessage',[
                            'chat_id' => $chat_id,
                            'text' => "Done Stopped : ".$i,
                        ]);
                        shell_exec("screen -S $i -X kill");
                        }else{
                            $tg->vtcor('sendMessage',[
                                'chat_id' => $chat_id,
                                'text' => "Could Not Stop $i, It's Not Running !"
                            ]);
                        }
                    }else{
                        $tg->vtcor('sendMessage',[
                            'chat_id' => $chat_id,
                            'text' => "Could Not Stop $i, You Haven't Logged In Yet !"
                        ]);
                    }
                }
            }elseif($text == 'Add A Number'){
                $tg->vtcor('sendMessage',[
                    'chat_id' => $chat_id,
                    'text' => 'Ok, Now What Checker Do You Want To Login With',
                    'reply_markup' => json_encode([
                        'resize_keyboard' => true,
                        'keyboard' => [
                            [['text' => 'Login Checker Number 1'],['text' => 'Login Checker Number 2']],
                            [['text' => 'Login Checker Number 3'],['text' => 'Login Checker Number 4']],
                            [['text' => 'Login Checker Number 5']],
                        ]
                    ])
                ]);
            }elseif($text == 'Checkers Info'){
                for($i = 1; $i < 6 ; $i++){
                    if(file_exists($i.".madeline")){
                        if(online($i) == 'Running'){
                            $tg->vtcor('sendMessage',[
                                'chat_id' => $chat_id,
                                'text' => "Checker Info \n Stauts ".online($i)." \n Phone : ".$json['number'.$i]['phone']." \n Method : ".$json['number'.$i]['method']." \n UsersCount : ".count(explode("\n", file_get_contents('users'.$i)))
                            ]);
                        }else{
                            $tg->vtcor('sendMessage',[
                                'chat_id' => $chat_id,
                                'text' => "Checker Info \n Stauts ".online($i)." \n Phone : ".$json['number'.$i]['phone']." \n UsersCount : ".count(explode("\n", file_get_contents('users'.$i)))
                            ]);
                        }
                    }else{
                        $tg->vtcor('sendMessage',[
                            'chat_id' => $chat_id,
                            'text' => "Could Not Fetch $i, You Haven't Logged In Yet",
                        ]);
                    }
                }
            }elseif($text == 'Pin A Username'){
                $tg->vtcor('sendMessage',[
                    'chat_id' => $chat_id,
                    'text' => 'Ok, Now Please Select The Wanted Checker',
                    'reply_markup' => json_encode([
                        'resize_keyboard' => true,
                        'keyboard' => [
                            [['text' => 'Pin Username Checker Number 1'],['text' => 'Pin Username Checker Number 2']],
                            [['text' => 'Pin Username Checker Number 3'],['text' => 'Pin Username Checker Number 4']],
                            [['text' => 'Pin Username Checker Number 5']],
                        ]
                    ])
                ]);
            }elseif($text == 'Clear A Specefic List'){
                $tg->vtcor('sendMessage',[
                    'chat_id' => $chat_id,
                    'text' => 'Ok, Now Please Select The Wanted Checker',
                    'reply_markup' => json_encode([
                        'resize_keyboard' => true,
                        'keyboard' => [
                            [['text' => 'Clear Specefic Checker Number 1'],['text' => 'Clear Specefic Checker Number 2']],
                            [['text' => 'Clear Specefic Checker Number 3'],['text' => 'Clear Specefic Checker Number 4']],
                            [['text' => 'Clear Specefic Checker Number 5']],
                        ]
                    ])
                ]); 
            }elseif($text == 'Pin In All'){
                $tg->vtcor('sendMessage',[
                    'chat_id' => $chat_id,
                    'text' => 'Ok, Now Please Send Me The Username',
                    'reply_markup' => json_encode([
                        'resize_keyboard' => true,
                        'keyboard' => [
                            [['text' => 'Go Back']],
                        ]
                    ])
                ]);
                $json['mode'] = 'PinAll';
                file_put_contents('mode.json',json_encode($json));
            }elseif($text and $json['mode'] == 'PinAll'){
                $text = str_replace('@',null,$text);
                $tg->vtcor('sendMessage',[
                    'chat_id' => $chat_id,
                    'text' => 'Ok, Pinning In All Checkers',
                ]);
                $json['mode'] = null;
                file_put_contents('mode.json',json_encode($json));
                for($i = 1 ; $i < 6 ; $i++){
                    $ex = explode("\n",file_get_contents('users'.$i));
                    if(file_exists($i.".madeline")){
                        if(!in_array($text,$ex)){
                            file_put_contents("users".$i,$text . "\n",FILE_APPEND);
                        }
                    }else{
                        $tg->vtcor('sendMessage',[
                            'chat_id' => $chat_id,
                            'text' => "Could Not Save List $i, You Haven't Logged In Yet",
                        ]);
                    }
                }
            }elseif($text == 'Clear All List'){
                $tg->vtcor('sendMessage',[
                    'chat_id' => $chat_id,
                    'text' => 'Ok, Cleared All Lists Successfully',
                    'reply_markup' => json_encode([
                        'resize_keyboard' => true,
                        'keyboard' => [
                            [['text' => 'Go Back']],
                        ]
                    ])
                ]);
                for($i = 1; $i < 6 ; $i++){
                    if(file_exists($i.".madeline")){
                        if(file_exists($i.".madeline")){
                            shell_exec("screen -S $i -X kill");
                            unlink('users'.$i);
                        }else{
                            $tg->vtcor('sendMessage',[
                                'chat_id' => $chat_id,
                                'text' => "Could Not Clear List $i, There Was Not A List To Begin With"
                            ]);
                        }
                    }else{
                        $tg->vtcor('sendMessage',[
                            'chat_id' => $chat_id,
                            'text' => "Could Not Clear List $i, You Haven't Logged In Yet !"
                        ]);
                    }
                }
            }elseif($text == 'Specefic Checker Info'){
                $tg->vtcor('sendMessage',[
                    'chat_id' => $chat_id,
                    'text' => 'Ok, Select The Desired Checker',
                    'reply_markup' => json_encode([
                        'resize_keyboard' => true,
                        'keyboard' => [
                            [['text' => 'Info Checker Number 1'],['text' => 'Info Checker Number 2']],
                            [['text' => 'Info Checker Number 3'],['text' => 'Info Checker Number 4']],
                            [['text' => 'Info Checker Number 5']], 
                        ]
                    ])
                ]);
            }elseif($text == 'List Of Users'){
                $tg->vtcor('sendMessage',[
                    'chat_id' => $chat_id,
                    'text' => 'Ok, Now Choose The Desired Checker',
                    'reply_markup' => json_encode([
                        'resize_keyboard' => true,
                        'keyboard' => [
                            [['text' => 'List Checker Number 1'],['text' => 'List Checker Number 2']],
                            [['text' => 'List Checker Number 3'],['text' => 'List Checker Number 4']],
                            [['text' => 'List Checker Number 5']],
                        ]
                    ])
                ]);
            }elseif(preg_match('/Login Checker Number \d+/',$text)){
                $ex = explode('Login Checker Number ',$text);
                $tg->vtcor('sendMessage',[
                    'chat_id' => $chat_id,
                    'text' => 'Ok, Now Please Send Me The Number',
                    'reply_markup' => json_encode([
                        'resize_keyboard' => true,
                        'keyboard' => [
                            [['text' => 'Go Back']],
                        ]
                    ])
                ]);
                $json['mode'] = 'login_'.$ex[1];
                file_put_contents('mode.json',json_encode($json));
            }elseif($text and strstr($json['mode'],'login_')){
                $json['mode'] = null;
                $json['number'.$ex[1]]['phone'] = $text;
                $json['login'] = $ex[1];
                file_put_contents('mode.json',json_encode($json));
                shell_exec('php login.php');
            }elseif(preg_match('/Pin Username Checker Number \d+/',$text)){
                $ex = explode('Pin Username Checker Number ',$text);
                $tg->vtcor('sendMessage',[
                    'chat_id' => $chat_id,
                    'text' => 'Ok, Now Please Send Me The Username',
                    'reply_markup' => json_encode([
                        'resize_keyboard' => true,
                        'keyboard' => [
                            [['text' => 'Go Back']],
                        ]
                    ])
                ]);
                $json['mode'] = 'pin_'.$ex[1];
                file_put_contents('mode.json',json_encode($json));
            }elseif($text and strstr($json['mode'],'pin_')){
                $text = str_replace('@',null,$text);
                $ex = explode('_',$json['mode'])[1];
                if(file_exists($ex.".madeline")){
                    $users = explode("\n",file_get_contents('users'.$ex));
                    if(!in_array($text,$users)){
                        $tg->vtcor('sendMessage',[
                            'chat_id' => $chat_id,
                            'text' => 'Ok, Pinned '.$text.' In : '.$ex,
                            'reply_markup' => json_encode([
                                'resize_keyboard' => true,
                                'keyboard' => [
                                    [['text' => 'Go Back']],
                                ]
                            ])
                        ]);
                        $json['mode'] = null;
                        file_put_contents('mode.json',json_encode($json));
                        file_put_contents("users".$ex,$text . "\n",FILE_APPEND);
                    }
                }else{
                    $tg->vtcor('sendMessage',[
                        'chat_id' => $chat_id,
                        'text' => "Could Not Save The List $ex, You Haven't Logged In Yet",
                    ]);
                }
            }elseif(preg_match('/Clear Specefic Checker Number \d+/',$text)){
                $ex = explode('Clear Specefic Checker Number ',$text);
                $i = $ex[1];
                if(file_exists($i.".madeline")){
                    if(file_exists('users'.$i)){
                        $tg->vtcor('sendMessage',[
                            'chat_id' => $chat_id,
                            'text' => 'Ok, Cleared The List : '.$ex[1],
                            'reply_markup' => json_encode([
                            'resize_keyboard' => true,
                            'keyboard' => [
                                [['text' => 'Go Back']],
                            ]
                        ])
                    ]);
                    unlink('users'.$i);
                    }else{
                        $tg->vtcor('sendMessage',[
                            'chat_id' => $chat_id,
                            'text' => "Could Not Clear List $i, There Was No List To Begin With"
                        ]);
                    }
                }else{
                    $tg->vtcor('sendMessage',[
                        'chat_id' => $chat_id,
                        'text' => "Could Not Clear List $i, You Haven't Logged In Yet"
                    ]);
                }
            }elseif(preg_match('/Info Checker Number \d+/',$text)){
                $ex = explode('Info Checker Number ',$text);
                $i = $ex[1];
                if(file_exists($i.".madeline")){
                    if(online($i) == 'Running'){
                        $tg->vtcor('sendMessage',[
                            'chat_id' => $chat_id,
                            'text' => "Checker Info \n Stauts ".online($i)." \n Phone : ".$json['number'.$i]['phone']." \n Method : ".$json['number'.$i]['method']." \n UsersCount : ".count(explode("\n", file_get_contents('users'.$i)))
                        ]);
                    }else{
                        $tg->vtcor('sendMessage',[
                            'chat_id' => $chat_id,
                            'text' => "Checker Info \n Stauts ".online($i)." \n Phone : ".$json['number'.$i]['phone']." \n UsersCount : ".count(explode("\n", file_get_contents('users'.$i)))
                        ]);
                    }
                }else{
                    $tg->vtcor('sendMessage',[
                        'chat_id' => $chat_id,
                        'text' => "Couldn't Fetch Info, You Haven't Logged In Yet"
                        
                    ]);
                }
            }elseif(preg_match('/List Checker Number \d+/',$text)){
                $ex = explode('List Checker Number ',$text);
                $tg->vtcor('sendMessage',[
                    'chat_id' => $chat_id,
                    'text' => "List : \n".getList($ex[1]),
                    'reply_markup' => json_encode([
                        'resize_keyboard' => true,
                        'keyboard' => [
                            [['text' => 'Go Back']],
                        ]
                    ])
                ]);
            }elseif(preg_match('/Run Checker Number \d+/',$text)){
                $ex = explode('Run Checker Number ',$text);
                $tg->vtcor('sendMessage',[
                    'chat_id' => $chat_id,
                    'text' => 'Ok, Send Me The Running Method Checker : '.$ex[1],
                    'reply_markup' => json_encode([
                        'resize_keyboard' => true,
                        'keyboard' => [
                            [['text' => 'Run Account Checker '.$ex[1]],['text' => 'Run New Channel Checker '.$ex[1]]],
                            [['text' => 'Go Back']],
                        ]
                    ])                
                ]);
            }elseif(preg_match('/Stop Checker Number \d+/',$text)){
                $ex = explode('Stop Checker Number ',$text);
                $i = $ex[1];
                if(file_exists($i.".madeline")){
                    if(online($i) == 'Running'){
                        $tg->vtcor('sendMessage',[
                            'chat_id' => $chat_id,
                            'text' => "Done Stopped : ".$i,
                        ]);
                        shell_exec("screen -S $i -X kill");
                    }else{
                        $tg->vtcor('sendMessage',[
                            'chat_id' => $chat_id,
                            'text' => "Could Not Stop $i, It's Not Running !"
                        ]);
                    }
                }else{
                    $tg->vtcor('sendMessage',[
                        'chat_id' => $chat_id,
                        'text' => "Could Not Stop $i, You Haven't Logged In Yet !"
                    ]);
                }
            }elseif(preg_match('/Run Account Checker \d+/',$text)){
                $ex = explode("Run Account Checker ",$text);
                $i = $ex[1];
                if(file_exists($i.".madeline")){
                    $users = file_get_contents('users'.$i);
                    if(!empty($users)){
                        $json['number'.$i]['method'] = 'account';
                        file_put_contents('mode.json',json_encode($json));
                        shell_exec("screen -S $i -X kill");
                        shell_exec("screen -dmS $i php $i.php");
                    }else{
                        $tg->vtcor('sendMessage',[
                            'chat_id' => $chat_id,
                            'text' => "Could Not Run $i, No Users Have Been Found !"
                        ]);
                    }
                }else{
                    $tg->vtcor('sendMessage',[
                        'chat_id' => $chat_id,
                        'text' => "Could Not Run $i, Because You Haven't Logged In !"
                    ]);
                }
            }elseif(preg_match('/Run New Channel Checker \d+/',$text)){
                $ex = explode("Run New Channel Checker ",$text);
                $i = $ex[1];
                if(file_exists($i.".madeline")){
                    $users = file_get_contents('users'.$i);
                    if(!empty($users)){
                        $json['number'.$i]['method'] = 'channel';
                        file_put_contents('mode.json',json_encode($json));
                        shell_exec("screen -S $i -X kill");
                        shell_exec("screen -dmS $i php $i.php");
                    }else{
                        $tg->vtcor('sendMessage',[
                            'chat_id' => $chat_id,
                            'text' => "Could Not Run $i, No Users Have Been Found !"
                        ]);
                    }
                }else{
                    $tg->vtcor('sendMessage',[
                        'chat_id' => $chat_id,
                        'text' => "Could Not Run $i, Because You Haven't Logged In !"
                    ]);
                }
            }
        } else {
            $tg->vtcor('sendMessage',[
                'chat_id' => $chat_id,
                'text' => "Dear $first_name 🦖 \n You Are Not Subscribed \n- - - - - - - - - - - - - - - - \n Check Updates Here : @ALMASLAWI 🐉"
            ]);
        }
        $lastupdid = $upd['result'][0]['update_id'] + 1; 
    }
}
function online($ex) {
	$x = shell_exec("screen -S $ex -Q select . ; echo $?");
	if ($x == '0') {
		$st = "Running";
	} else {
		$st = "Sleeping";
	}
	return $st;
}
function getList($n){
    $users = explode("\n", file_get_contents("users".$n));
    $list = "";
    $i = 1;
    foreach ($users as $user) {
        if ($user != "") {
            $list = $list . "\n$i  @$user";
            $i++;
        }
    }
return $list;
}


