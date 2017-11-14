<?php

namespace mrssoft\redirect;

use Yii;
use yii\base\Behavior;
use yii\web\Response;

class UrlBehavior extends Behavior
{
    /**
     * @var string
     */
    public $redirect = 'redirect';

    public function events()
    {
        return [
            Response::EVENT_BEFORE_SEND => 'beforeSend'
        ];
    }

    public function beforeSend()
    {
        if (Yii::$app->response->statusCode == 404) {

            $pathInfo = Yii::$app->request->pathInfo;
            if (!empty($pathInfo)) {

                /** @var \mrssoft\redirect\UrlRedirect $redirect */
                $redirect = Yii::$app->get($this->redirect);

                if ($redirect) {
                    $new = $redirect->find('/' . $pathInfo);
                    if ($new) {
                        header('Location: ' . $new, true, $redirect->code);
                        exit;
                    }
                }
            }
        }
    }
}