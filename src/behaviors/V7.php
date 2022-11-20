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
    public string $primaryKeyAttribute = 'id';

    public int|null $clockSeq = null;
    public bool $binary = false;

    private \DateTime|null $_dateTime = null;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (empty($this->attributes)) {
            $this->attributes = [
                BaseActiveRecord::EVENT_BEFORE_INSERT => [$this->primaryKeyAttribute]
            ];
        }
    }

    public function setDateTime(\DateTime $dateTime)
    {
        $this->_dateTime = $dateTime;
    }

    /**
     * @inheritDoc
     */
    protected function getValue($event)
    {
        if ($this->value === null) {
            $uuid = Uuid::uuid7($this?->_dateTime);
            return $this->binary ? $uuid->getBytes() : $uuid->toString();
        }
        return parent::getValue($event);
    }
}
