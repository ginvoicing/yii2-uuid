<?php
namespace yii\Uuid;

use Ramsey\Uuid\Uuid;
use yii\validators\Validator;

/**
 * Class UuidValidator
 * @package yii\Uuid
 */

class UuidValidator extends Validator
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->message === null) {
            $this->message = \Yii::t('app', '{attribute} is not valid UUID.');
        }
    }

    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        if (!Uuid::isValid($model->$attribute)) {
            $this->addError($model, $attribute, $this->message, ['attribute' => $attribute]);
        }
    }
}
