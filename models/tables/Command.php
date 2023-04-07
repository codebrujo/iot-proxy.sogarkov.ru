<?php

namespace app\models\tables;


/**
 * This is the model class for table "command".
 *
 * @property int $id
 * @property int $deviceId
 * @property int $type
 * @property string $value
 * @property int $created_at
 * @property int $updated_at
 *
 */
class Command extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'command';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'deviceId', 'type', 'value'], 'required'],
            [['id'], 'integer'],
            [['deviceId'], 'integer'],
            [['type'], 'integer'],
            [['value'], 'string', 'max' => 255],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    public static function getAll()
    {
        $val = static::find()
            ->all();

        return $val;
    }

    public static function getByDeviceId($deviceId)
    {
        $val = static::find()
            ->where(['deviceId' => $deviceId])
            ->all();
        return $val;
    }

    public static function getByPk($id)
    {
        $val = static::find()
            ->where(['id' => $id])->one();
        return $val;
    }

}
