<?php

namespace app\controllers;

use app\models\tables\Device;
use yii\web\Controller;
use Yii;

class ProxyController extends Controller
{
  
  private function processPostRequest()
  {
    $modelData = json_decode(Yii::$app->request->getRawBody(), true);
    if (!$modelData) {
      return Yii::$app->response->setStatusCode(400, 'Bad format');
    }
   
    $model = new Stock();
    $model->attributes = $modelData;
    if (!$model->validate()) {
      return Yii::$app->response->setStatusCode(400, 'Validation failed');
    }

    if(Stock::getByTicker($model->ticker)){
      return Yii::$app->response->setStatusCode(400, 'Already exists');
    }

    $model->save();
    return Stock::getByPk($model->id);
  }

  private function processPatchRequest()
  {
    $modelData = json_decode(Yii::$app->request->getRawBody(), true);
    if (!$modelData) {
      return Yii::$app->response->setStatusCode(400, 'Bad format');
    }

    $model = Stock::getByTicker($modelData["ticker"]);
    if (!$model) {
      return Yii::$app->response->setStatusCode(404, 'Ticker not found');
    }

    $isChanged = false;
    if ($modelData["category_id"] !== NULL) {
      $model->category_id = $modelData["category_id"];
      $isChanged = true;
    }

    if ($modelData["name"]) {
      $model->name = $modelData["name"];
      $isChanged = true;
    }

    if ($modelData["price"]) {
      $model->price = $modelData["price"];
      $isChanged = true;
    }

    if ($modelData["change"]) {
      $model->change = $modelData["change"];
      $isChanged = true;
    }

    if ($modelData["week_change"]) {
      $model->week_change = $modelData["week_change"];
      $isChanged = true;
    }

    if($isChanged){
      $model->save();
    }
    
    return Stock::getByPk($model->id);
  }

  private function processPutRequest()
  {
    $modelData = json_decode(Yii::$app->request->getRawBody(), true);
    if (!$modelData) {
      return Yii::$app->response->setStatusCode(400, 'Bad format');
    }

    $model = new Stock();
    $model->attributes = $modelData;
    if (!$model->validate()) {
      return Yii::$app->response->setStatusCode(400, 'Validation failed');
    }

    $model = Stock::getByPk($modelData["id"]);
    if (!$model) {
      return Yii::$app->response->setStatusCode(404, 'Record not found');
    }
    $model->attributes = $modelData;
    $model->save();
    return Stock::getByPk($model->id);
  }

  private function validateAppToken($token)
  {
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

  public function actionIndex()
  {

    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    if (\Yii::$app->request->isGet) {
      $stocks = Stock::getAll();
      return $stocks;
    }
    $appTokenHeader = Yii::$app->params['externalAppTokenHeader'];
    if (!$this->validateAppToken(\Yii::$app->request->headers[$appTokenHeader])) {
      return Yii::$app->response->setStatusCode(401, 'Forbidden');
    }
    if (\Yii::$app->request->isPost) {
      return $this->processPostRequest();
    }
    if (\Yii::$app->request->isPatch) {
      return $this->processPatchRequest();
    }
    if (\Yii::$app->request->isPut) {
      return $this->processPutRequest();
    }
  }
}
