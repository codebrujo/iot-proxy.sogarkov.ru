<?php

namespace app\controllers;

use app\models\tables\Command;
use app\models\tables\Proxy;
use yii\web\Controller;
use Yii;

class CommandController extends Controller
{
  
  private function processPostRequest()
  {
    $modelData = json_decode(Yii::$app->request->getRawBody(), true);
    if (!$modelData) {
      return Yii::$app->response->setStatusCode(400, 'Bad format');
    }
    $modelProxy = Proxy::getByPk(1);
    $modelProxy->valueInt = $modelProxy->valueInt + 1;
  
    $model = new Command();
    $model->attributes = $modelData;
    $model->id = $modelProxy->valueInt;
    if (!$model->validate()) {
      return Yii::$app->response->setStatusCode(400, 'Validation failed');
    }

    $existingCommands = Command::getByDeviceIdAndType($model->deviceId, $model->type);

    foreach ($existingCommands as &$existingCommand) {
      $existingCommand->delete();
    };
    unset($existingCommand);

    $model->save();
    $modelProxy->save();
    return Command::getByPk($model->id);
  }

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

  public function beforeAction($action)
  {
    $this->enableCsrfValidation = false;
    return parent::beforeAction($action);
  }

  private function returnList()
  {
    $commands = Command::getAll();
    return $commands;
  }

  public function actionConsume()
  {
    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    if (!$this->validateAppToken()) {
      return Yii::$app->response->setStatusCode(401, 'Forbidden');
    }
    $recordset = $this->returnList();
    $commands = array();
    foreach ($recordset as &$existingCommand) {
      array_push($commands, (object) [
        "id" => $existingCommand->id,
        "deviceId" => $existingCommand->deviceId,
        "type" => $existingCommand->type,
        "value" => $existingCommand->value,
      ]);
      $existingCommand->delete();
    };
    unset($existingCommand);
    return $commands;
  }

  public function actionDevice()
  {
    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    if (!$this->validateAppToken()) {
      return Yii::$app->response->setStatusCode(401, 'Forbidden');
    }
    $options = json_decode(Yii::$app->request->getRawBody(), true);
    $recordset = Command::getByDeviceId($options["deviceId"]);
    return $recordset;
  }

  public function actionIndex()
  {
    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    $request = Yii::$app->request;
    if (!$this->validateAppToken()) {
      return Yii::$app->response->setStatusCode(401, 'Forbidden');
    }
    if ($request->isGet) {
      return $this->returnList();
    }
    if ($request->isPost) {
      return $this->processPostRequest();
    }
  }
}
