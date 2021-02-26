<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "leads".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string|null $created_at
 */
class Leads extends \yii\db\ActiveRecord
{
    public $verifyCode;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'leads';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'phone'], 'required'],
            [['created_at'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 254],
            [['phone'], 'string', 'max' => 20],
            [['name'], 'unique', 'targetClass' => self::className(), 'message' => 'Такое имя уже есть!'],
            [['email'], 'unique', 'targetClass' => self::className(), 'message' => 'Такой email уже есть!'],
            [['phone'], 'unique', 'targetClass' => self::className(), 'message' => 'Такой номер уже есть!'],
            [['name'], 'match', 'pattern' => '/^[a-zA-Z]+$/', 'message' => 'Имя должно содержать только латинские буквы'],
            [['email'], 'email'],            
            [['phone'], 'match', 'pattern' => '/^\+7\s\([0-9]{3}\)\s[0-9]{3}\-[0-9]{2}\-[0-9]{2}$/', 'message' => 'Неправильный номер телефона'],
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'email' => 'Email',
            'phone' => 'Телефон',
            'created_at' => 'Создано',
            'verifyCode' => 'Капча',
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\BaseActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
                'value' => function(){
                                return date("Y-m-d H:i:s");
                },
            ],
        ];
    }
}
