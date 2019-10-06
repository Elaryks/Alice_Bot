<?php

function wh_log($log_msg)
{
    $log_filename = "log";
    if (!file_exists($log_filename)) {
        // create directory/folder uploads.
        mkdir($log_filename, 0777, true);
    }
    $log_file_data = $log_filename . '/log_' . date('d-M-Y') . '.log';
    // if you don't add `FILE_APPEND`, the file will be erased each time you add a log
    file_put_contents($log_file_data, $log_msg . "\n", FILE_APPEND);
}

function SendMessage($from_id, $message)
{
    global $botToken;
    $user_info = json_decode(file_get_contents("https://api.vk.com/method/users.get?user_ids={$from_id}&{$botToken}&v=5.101"));
    $user_name = $user_info->response[0]->first_name;
    wh_log($user_name);
    $msg = $user_name . ", " . $message;
    $request_params = array(
        'message' => $msg,
        'user_id' => $from_id,
        'access_token' => $botToken,
        'v' => '5.101'
    );
    $get_params = http_build_query($request_params);
    wh_log($get_params);
    file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);
}
