<?php

namespace yii\Uuid\Tests\_models;

use yii\db\ActiveRecord;
use yii\Uuid\behaviors\V1;
use yii\Uuid\behaviors\V2;
use yii\Uuid\enums\V2Domain;
use yii\Uuid\UuidValidator;

class UserV2 extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%user}}';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => V2::class,
                'primaryKeyAttribute' => 'uuid',
                'domain' => V2Domain::DCE_DOMAIN_GROUP,
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

