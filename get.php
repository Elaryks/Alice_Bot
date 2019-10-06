<?

require("settings.php");
require("methods.php");

if (!isset($_REQUEST)) {
    return;
}

$userdata = json_decode(file_get_contents('php://input'));

if (strcmp($userdata->secret, $secretKey) !== 0 && strcmp($userdata->type, 'confirmation') !== 0) {
    die(json_encode(array("response" => 0, "error" => array("error_id" => 1, "error_message" => "Bad secret key"))));
}

switch ($userdata->type) {
    case 'confirmation':
        die($confirmationKey);
        break;
    case 'message_new':
        SendTextMessage($userdata->object->conversation_message_id, $userdata->object->from_id, 'привет! это тестовое сообщение!');
        die("ok");
        break;
}
