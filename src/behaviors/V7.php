<?php

namespace yii\Uuid\behaviors;

use yii\behaviors\AttributeBehavior;
use yii\db\BaseActiveRecord;
use Ramsey\Uuid\Uuid;

/**
 * ```php
 * use yii\Uuid\behaviors\V7;
 *
 * public function behaviors()
 * {
 *     return [
 *         [
 *             '__class' => V1::class,
 *             'dateTime' => new DateTimeImmutable('@281474976710.655'),
 *         ],
 *     ];
 * }
 * ```
 *
 * @author Tarun Jangra <tarun.jangra@hotmail.com>
 * @since 1.0
 */
class V7 extends AttributeBehavior
{
    public string $defaultAttribute = 'id';

    public \DateTime|null $dateTime = null;
    public int|null $clockSeq = null;
    public bool $binary = false;


    /**
     * @inheritdoc
     */
    public function init()
    {
        if (!$this->attributes) {
            $this->attributes = [
                BaseActiveRecord::EVENT_BEFORE_INSERT => [$this->defaultAttribute]
            ];
        }
    }

    /**
     * @inheritDoc
     */
    protected function getValue($event)
    {
        $uuid = Uuid::uuid7($this?->dateTime);
        $this->value = $this->binary ? $uuid->getBytes() : $uuid->toString();
        return $this->value;
    }
}
