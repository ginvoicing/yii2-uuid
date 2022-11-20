<?php

namespace yii\Uuid\Tests\_models;

use yii\db\ActiveRecord;
use yii\Uuid\behaviors\V3;
use yii\Uuid\UuidValidator;

/** @var string $uuid; */

class UserV3 extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%user}}';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => V3::class,
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

