<?php

namespace yii\Uuid\behaviors;

use yii\behaviors\AttributeBehavior;
use yii\db\BaseActiveRecord;
use Ramsey\Uuid\Uuid;
use yii\Uuid\enums\V3Namespace;

/**
 * ```php
 * use yii\Uuid\behaviors\V3;
 *
 * public function behaviors()
 * {
 *     return [
 *         [
 *             '__class' => V1::class,
 *             'namespace' => V3Namespace::NAMESPACE_URL,
 *             'name' => 'https://www.example.com/'
 *         ],
 *     ];
 * }
 * ```
 *
 * @author Tarun Jangra <tarun.jangra@hotmail.com>
 * @since 1.0
 */
class V3 extends AttributeBehavior
{
    /**
     * @var string the attribute that will receive uuid value
     * Set this property to other primary key attribute name.
     */
    public string $primaryKeyAttribute = 'id';
    /**
     * {@inheritdoc}
     *
     * In case, when the value is `null`, the result UUID [uuid3()](https://uuid.ramsey.dev/en/stable/rfc4122/version3.html)
     * will be used as value.
     */
    public $value;

    public bool $binary = false;
    public string $name = 'https://ginvoicing.com';

    private string|null $_namespace = V3Namespace::NAMESPACE_URL;

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

    public function setNamespace(string $ns)
    {
        $this->_namespace = $ns;
    }

    /**
     * @inheritDoc
     */
    protected function getValue($event)
    {
        if ($this->value === null) {
            $uuid = Uuid::uuid3($this->_namespace, $this->name);
            return $this->binary ? $uuid->getBytes() : $uuid->toString();
        }
        return parent::getValue($event);
    }
}
