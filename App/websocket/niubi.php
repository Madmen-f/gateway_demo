<?php

use \GatewayWorker\Lib\Gateway;
use \GatewayWorker\Lib\Log;
class niubi{

    public static function pp($client_id, $message) {
        Gateway::sendToClient($client_id, "找到了\r\n");
        Gateway::sendToAll("$client_id said $message\r\n");
    }
}