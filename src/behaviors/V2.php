<?php

namespace yii\Uuid\behaviors;

use Ramsey\Uuid\Provider\Node\StaticNodeProvider;
use Ramsey\Uuid\Type\Hexadecimal;
use Ramsey\Uuid\Type\Integer;
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
    public string $defaultAttribute = 'id';

    public int|null $node = null;
    public int|null $clockSeq = null;
    public int|null $localIdentifier = null;
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
        $localIdentifier = null;

        if ($this->node) {
            $nodeProvider = new StaticNodeProvider(new Hexadecimal($this->node));
        }

        if ($this->localIdentifier) {
            $localIdentifier = new Integer($this->localIdentifier);
        }

        $uuid = Uuid::uuid2(
            Uuid::DCE_DOMAIN_ORG,
            $localIdentifier,
            $nodeProvider?->getNode(),
            $this->clockSeq
        );

        $this->value = $this->binary ? $uuid->getBytes() : $uuid->toString();
        return $this->value;
    }
}
