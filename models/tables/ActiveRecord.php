<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 10.06.2018
 * Time: 17:19
 */

namespace app\models\tables;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;


class ActiveRecord extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ]
        ];
    }

}