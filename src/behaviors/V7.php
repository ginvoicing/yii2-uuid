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
 *             'class' => V7::class,
 *             'dateTime' => new DateTime(),
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
    /**
     * @var string the attribute that will receive uuid value
     * Set this property to other primary key attribute name.
     */
    public string $primaryKeyAttribute = 'id';
    /**
     * {@inheritdoc}
     *
     * In case, when the value is `null`, the result UUID [uuid1()](https://uuid.ramsey.dev/en/stable/rfc4122/version1.html)
     * will be used as value.
     */
    public $value;

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
