<?php

use \GatewayWorker\Lib\Gateway;

class niubi{

    public static function pp($client_id, $message) {
        Gateway::sendToClient($client_id, "找到了\r\n");
    }
}