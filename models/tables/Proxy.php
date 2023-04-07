<?php

namespace app\models\tables;


/**
 * This is the model class for table "proxy".
 *
 * @property int $id
 * @property int $valueInt
 * @property string $valueStr
 * @property float $valueFloat
 * @property int $created_at
 * @property int $updated_at
 *
 */
class Proxy extends ActiveRecord
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
            [['id'], 'required'],
            [['id'], 'integer'],
            [['valueInt'], 'integer'],
            [['valueStr'], 'string', 'max' => 255],
            [['valueFloat'], 'float'],
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
            'valueStr' => 'String Value',
            'valueInt' => 'Integer Value',
            'valueFloat' => 'Float Value',
        ];
    }

    public static function getAll()
    {
        $val = static::find()
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
