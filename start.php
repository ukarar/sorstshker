<?php
if (!file_exists("admin.json"))
{
    $token = readline('Enter Token : ');
    $id = readline('Enter iD : ');
    file_put_contents('admin.json', json_encode(['token' => $token, 'id' => $id]));
}
shell_exec('pm2 stop bot');
shell_exec('pm2 start bot.php');
