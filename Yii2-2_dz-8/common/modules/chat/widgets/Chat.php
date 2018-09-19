<?php
namespace common\modules\chat\widgets;

use Yii;
use common\modules\chat\widgets\assets\ChatAsset;

class Chat extends \yii\bootstrap\Widget
{
    public $port = 8080;

    public function init()
    {
        ChatAsset::register($this->view);
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $this->view->registerJsVar('wsPort', $this->port);
        return $this->render('chat');
    }
}
