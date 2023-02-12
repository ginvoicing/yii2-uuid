<?php

namespace yii\Uuid\behaviors;

use Ramsey\Uuid\Provider\Node\StaticNodeProvider;
use Ramsey\Uuid\Type\Hexadecimal;
use yii\behaviors\AttributeBehavior;
use yii\db\BaseActiveRecord;
use Ramsey\Uuid\Uuid;

/**
 * For more details on attributes Ref: https://uuid.ramsey.dev/en/stable/rfc4122/version1.html
 *
 * ```php
 * use yii\Uuid\behaviors\V1;
 *
 * public function behaviors()
 * {
 *     return [
 *         [
 *             'class' => V1::class,
 *             'node' => 121212121212,
 *             'clockSeq' => 12233
 *         ],
 *     ];
 * }
 * ```
 *
 * @author Tarun Jangra <tarun.jangra@hotmail.com>
 * @since 1.0
 */
class V1 extends AttributeBehavior
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

    private StaticNodeProvider|null $_nodeProvider = null;


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

    public function setNode(int|null $node)
    {
        $this->_nodeProvider = $node ? new StaticNodeProvider(new Hexadecimal($node)) : null;
    }

    /**
     * @inheritDoc
     */
    protected function getValue($event)
    {
        if ($this->value === null) {
            $uuid = Uuid::uuid1($this->_nodeProvider?->getNode(), $this->clockSeq);
            return $this->binary ? $uuid->getBytes() : $uuid->toString();
        }

        return parent::getValue($event);
    }
}
