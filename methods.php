<?php

function SendMessage($user_id, $message)
{
    global $botToken;
    $user_info = json_decode(file_get_contents("https://api.vk.com/method/users.get?user_ids={$user_id}&{$botToken}&v=5.101"));
    $user_name = $user_info->response[0]->first_name;
    $msg = $user_name . ", " . $message;
    $request_params = array(
        'message' => $msg,
        'user_id' => $user_id,
        'access_token' => $botToken,
        'v' => '5.101'
    );
    $get_params = http_build_query($request_params);
    file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);
}
