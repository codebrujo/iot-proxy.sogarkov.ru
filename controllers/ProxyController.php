<?php

namespace app\controllers;

use app\models\tables\Proxy;
use yii\web\Controller;
use Yii;

class ProxyController extends Controller
{

  private function validateAppToken()
  {
    $appTokenHeader = Yii::$app->params['externalAppTokenHeader'];
    $token = Yii::$app->request->headers[$appTokenHeader];
    $appToken = Yii::$app->params['externalAppToken'];
    if ($token === $appToken) {
      return true;
    }
    return false;
  }

  public function actionIndex()
  {
    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    if (!$this->validateAppToken()) {
      return Yii::$app->response->setStatusCode(401, 'Forbidden');
    }
    if (\Yii::$app->request->isGet) {
      $recordset = Proxy::getAll();
      return $recordset;
    }
  }
}
