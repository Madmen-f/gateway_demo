<?php

use \GatewayWorker\Lib\Gateway;

class hh{

    public static function pp($client_id, $message) {
        Gateway::sendToClient($client_id, "niubi找到了\r\n");
    }
}