<?php

namespace common\modules\chat\controllers;

use yii\console\Controller;
use common\modules\chat\components\Chat;

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

/**
 * Default controller for the `chat` module
 */
class DaemonChatController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new Chat()
                )
            ),
            8080
        );
        echo "Chat server started".PHP_EOL;
        $server->loop->addPeriodicTimer(30, function () {
            echo date('H:i:s').PHP_EOL;
        });
        $server->run();
    }
}
