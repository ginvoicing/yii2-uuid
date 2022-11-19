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
class V1 extends AttributeBehavior
{
    public string $defaultAttribute = 'id';

    public int|null $node = null;
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

        $nodeProvider = null;

        if ($this->node) {
            $nodeProvider = new StaticNodeProvider(new Hexadecimal($this->node));
        }
        $uuid = Uuid::uuid1($nodeProvider?->getNode(), $this->clockSeq);
        $this->value = $this->binary ? $uuid->getBytes() : $uuid->toString();
        return $this->value;
    }
}
