<?php

namespace app\models\tables;


/**
 * This is the model class for table "device".
 *
 * @property int $id
 * @property string $name
 * @property int $created_at
 * @property int $updated_at
 *
 */
class Device extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'device';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'required'],
            [['id'], 'integer'],
            [['name'], 'string', 'max' => 255],
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

    public static function getByName($name)
    {
        $val = static::find()
            ->where(['name' => $name])
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
