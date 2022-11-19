<?php
namespace yii\Uuid\exceptions;

class InvalidUuidException extends Exception
{
    public function getName(): string
    {
        return 'Invalid UUID Exception';
    }
}
