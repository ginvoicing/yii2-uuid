<?php

namespace yii\Uuid\Tests\_models;

use yii\db\ActiveRecord;
use yii\Uuid\behaviors\V1;
use yii\Uuid\UuidValidator;

class UserV1 extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%user}}';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => V1::class,
                'primaryKeyAttribute' => 'uuid',
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

