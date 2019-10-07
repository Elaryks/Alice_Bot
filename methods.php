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

function strbool($value) // Возвращение булевых переменных строкой ("false" / "true")
{
    return $value ? 'true' : 'false';
}

function GetUsername()
{
    global $user_id, $botToken;
    $user_info = json_decode(file_get_contents("https://api.vk.com/method/users.get?user_ids={$user_id}&access_token={$botToken}&v=5.101"), true);
    $user_name = $user_info['response'][0]['first_name'];
    return $user_name;
}

function GetUserInfo() // $info
{
    global $user_id, $botToken;
    $user_info = json_decode(file_get_contents("https://api.vk.com/method/users.get?user_ids={$user_id}&fields=city,country&access_token={$botToken}&lang=en&v=5.101"), true);
    $user_city = $user_info['response'][0]['city']['title'];
    if (strbool(empty($user_city)) === "true") {
        return "Кажется, у Вас не указан город в настройках &#128532; К сожалению, пока что я не могу сообщить Вам погоду.";
    }
    // $user_country = $user_info['response'][0]['country']['title'];
    return $user_city;
}

function GetWeather()
{
    $user_city = GetUserInfo();
    $weather_info = json_decode(file_get_contents("http://api.openweathermap.org/data/2.5/weather?q={$user_city}&units=metric&APPID=3d1a65cde09ddedde287f0a4a4fa39e7"), true);
    if ($weather_info['cod'] == '404') {
        return ("Извини, я почему-то не смог определить температуру в твоём городе, но мой разработчик уже работает над этой проблемой &#128521;");
    }
    $temperature = $weather_info['main']['temp'];
    $pressure = $weather_info['main']['pressure'];
    $humidity = $weather_info['main']['humidity'];
    return "По данным OpenWeatherMap в твоём городе ({$user_city}, ю ноу) вот такая погода:\nТемпература: {$temperature}°C\nДавление: {$pressure} мм рт. ст.\nВлажность: {$humidity}%";
}

function CheckMessage($message)
{

    global $user_name;
    GetUserInfo();
    $message = mb_strtolower($message);
    $message = preg_replace('/[^a-zа-яё0-9]+/iu', '', $message); // Удаляем всё кроме букв и цифр из строки
    for ($i = 0, $cnti = count(QUE); $i < $cnti; $i++) {
        for ($j = 0, $cntj = count(QUE[$i]); $j < $cntj; $j++) {
            if (stristr($message, QUE[$i][$j]) !== FALSE) {
                $str = ANS[$i][array_rand(ANS[$i], 1)];
                switch ($str) {
                    case "user_weather":
                        $str = GetWeather();
                        break;
                }
                return str_replace("user_name", $user_name, $str);
            }
        }
    }
    return "Извини, {$user_name}, я тебя не понял &#128532;"; // Напиши \"Справка\", чтобы узнать доступные команды
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
    $request_params = array(
        'user_id' => $from_id,
        'random_id' => strval(random_int(1, 100000000)),
        'message' => $message,
        'access_token' => $botToken,
        'v' => '5.101'
    );
    $get_params = http_build_query($request_params);
    SetActivity("typing");
    sleep(1.5);
    file_get_contents("https://api.vk.com/method/messages.send?" . $get_params);
}
