<?

require("settings.php");
require("methods.php");

if (!isset($_REQUEST)) {
    return;
}

$userdata = json_decode(file_get_contents('php://input'));

if (strcmp($data->secret, $secretKey) !== 0 && strcmp($data->type, 'confirmation') !== 0) {
    die(json_encode(array("response" => 0, "error" => array("error_id" => 1, "error_message" => "Bad secret key"))));
}

switch ($userdata->type) {
    case 'confirmation':
        die($confirmationKey);
        break;
    case 'message_new':
        SendMessage($userdata->object->user_id, CheckMessage($userdata));
        die("ok");
        break;
}
