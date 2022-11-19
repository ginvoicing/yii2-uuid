<?php

namespace yii\Uuid\Tests\_models;

use yii\db\ActiveRecord;
use yii\Uuid\behaviors\V7;
use yii\Uuid\UuidValidator;

class UserV7 extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%user}}';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => V7::class,
                'defaultAttribute' => 'uuid',
                'dateTime' => new \DateTime(),
                'binary' => true
            ]
        ];
    }
    public function rules()
    {
        return [
            ['uuid', UuidValidator::class]
        ];
    }
}

