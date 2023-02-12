<?php

namespace yii\Uuid\behaviors;

use Ramsey\Uuid\Provider\Node\StaticNodeProvider;
use Ramsey\Uuid\Type\Hexadecimal;
use Ramsey\Uuid\Type\Integer as IntegerObject;
use yii\behaviors\AttributeBehavior;
use yii\db\BaseActiveRecord;
use Ramsey\Uuid\Uuid;
use yii\Uuid\enums\V2Domain;

/**
 * ```php
 * use yii\Uuid\behaviors\V2;
 *
 * public function behaviors()
 * {
 *     return [
 *         [
 *             'class' => v2::class,
 *             'node' => 121212121212,
 *             'clockSeq' => 12233,
 *             'domain' => V2Domain::DCE_DOMAIN_PERSON
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

    private V2Domain $_domain = V2Domain::DCE_DOMAIN_ORG;
    private StaticNodeProvider|null $_nodeProvider = null;
    private IntegerObject|null $_localIdentifier = null;


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

    public function setDomain(V2Domain $domain)
    {
        $this->_domain = $domain;
    }

    /**
     * @inheritDoc
     */
    protected function getValue($event)
    {
        if ($this->value === null) {
            $uuid = Uuid::uuid2(
                $this->_domain->value,
                $this->_localIdentifier,
                $this->_nodeProvider?->getNode(),
                $this->clockSeq
            );
            return $this->binary ? $uuid->getBytes() : $uuid->toString();
        }

        return parent::getValue($event);
    }
}
