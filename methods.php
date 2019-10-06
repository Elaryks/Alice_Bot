<?php

function logging($log_msg)
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

function CheckMessage($userdata)
{
    global $botToken;
    $from_id = $userdata->object->from_id
    //$message = mb_strtolower($userdata->object->text);
    $user_info = json_decode(file_get_contents("https://api.vk.com/method/users.get?user_ids={$from_id}&access_token={$botToken}&v=5.101"), true);
    $user_name = $user_info['response'][0]['first_name'];
    return "Извини, {$user_name}, я тебя не понял &#128532; Напиши \"Справка\", чтобы узнать доступные команды";
}

function SendTextMessage($from_id, $message)
{
    global $botToken;
    global $groupID;
    $user_info = json_decode(file_get_contents("https://api.vk.com/method/users.get?user_ids={$from_id}&access_token={$botToken}&v=5.101"), true);
    $user_name = $user_info['response'][0]['first_name'];
    $msg = $user_name . ", " . $message;
    $request_params = array(
        'user_id' => $from_id,
        'random_id' => strval(random_int(1, 100000000)),
        'message' => $msg,
        'access_token' => $botToken,
        'v' => '5.101'
    );
    $get_params = http_build_query($request_params);
    file_get_contents("https://api.vk.com/method/messages.setActivity?user_id={$from_id}&type=typing&access_token={$botToken}&v=5.101");
    file_get_contents("https://api.vk.com/method/messages.markAsRead?peer_id={$from_id}&group_id={$groupID}&access_token={$botToken}&v=5.101");
    sleep(1.5);
    file_get_contents("https://api.vk.com/method/messages.send?" . $get_params);
}
