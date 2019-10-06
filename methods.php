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



function CheckMessage($message)
{
    //$message = mb_strtolower($userdata->object->text);
    //return "Извини, {$user_name}, я тебя не понял &#128532; Напиши \"Справка\", чтобы узнать доступные команды";
    global $user_id, $que;
    $words = preg_split("/[\s,]+/", mb_strtolower($message)); // Разбиваем полученное сообщение на слова
    $cnt = count($words);
    for ($i = 0; $i < $cnt; $i++) {
        /*logging($i . ' ' . $words[$i]);
        if (in_array(words[$i], $que)) {
            return "и тебе доброго времени суток, {$user_name} &#128540;";
        } else {
            return "Извини, {$user_name}, я тебя не понял &#128532; Напиши \"Справка\", чтобы узнать доступные команды";
        }*/
        return "hmm";
    }
}

function SetActivity($type)
{
    global $botToken, $user_id, $groupID;
    file_get_contents("https://api.vk.com/method/messages.setActivity?user_id={$user_id}&type={$type}&access_token={$botToken}&v=5.101");
    file_get_contents("https://api.vk.com/method/messages.markAsRead?peer_id={$user_id}&group_id={$groupID}&access_token={$botToken}&v=5.101");
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
    SetActivity("typing");
    sleep(1.5);
    file_get_contents("https://api.vk.com/method/messages.send?" . $get_params);
}
