<?php

namespace yii\Uuid\behaviors;

use Ramsey\Uuid\Provider\Node\StaticNodeProvider;
use Ramsey\Uuid\Type\Hexadecimal;
use Ramsey\Uuid\Type\Integer as IntegerObject;
use yii\behaviors\AttributeBehavior;
use yii\db\BaseActiveRecord;
use Ramsey\Uuid\Uuid;

/**
 * ```php
 * use yii\Uuid\behaviors\V2;
 *
 * public function behaviors()
 * {
 *     return [
 *         [
 *             '__class' => V1::class,
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

class V2 extends AttributeBehavior
{
    /**
     * @var string the attribute that will receive uuid value
     * Set this property to other primary key attribute name.
     */
    public string $primaryKeyAttribute = 'id';
    /**
     * {@inheritdoc}
     *
     * In case, when the value is `null`, the result UUID [uuid2()](https://uuid.ramsey.dev/en/stable/rfc4122/version2.html)
     * will be used as value.
     */
    public $value;
    public int|null $clockSeq = null;
    public bool $binary = false;

    private StaticNodeProvider $_nodeProvider;
    private IntegerObject $_localIdentifier;


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

    public function setLocalIdentifier(int $localIdentifier)
    {
        $this->_localIdentifier = new IntegerObject($localIdentifier);
    }

    /**
     * @inheritDoc
     */
    protected function getValue($event)
    {
        if ($this->value === null) {
            $uuid = Uuid::uuid2(
                Uuid::DCE_DOMAIN_ORG,
                $this->_localIdentifier,
                $this->_nodeProvider?->getNode(),
                $this->clockSeq
            );
            return $this->binary ? $uuid->getBytes() : $uuid->toString();
        }

        return parent::getValue($event);
    }
}
