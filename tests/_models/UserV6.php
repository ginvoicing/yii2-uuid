<?php

namespace yii\Uuid\Tests\_models;

use yii\db\ActiveRecord;
use yii\Uuid\behaviors\V1;
use yii\Uuid\behaviors\V6;
use yii\Uuid\UuidValidator;

class UserV6 extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%user}}';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => V6::class,
                'primaryKeyAttribute' => 'uuid',
                'node'=> 121212121213, // optional
                'clockSeq' => 16484, // optional
                'binary' => true // optional
            ]
        ];
    }

    public function rules()
    {
        return [
            ['uuid', UuidValidator::class, 'message' => 'Wrong uuid.']
        ];
    }
}

