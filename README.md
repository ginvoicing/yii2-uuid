yii2-uuid
===

Yii2 UUID extension using [ramsey/uuid](https://github.com/ramsey/uuid)

You just need to define behaviour in your model like below. It will start saving binary of uuid in defined column. 
Write now it supports version 1, version 6 and version 7 of the uuid.  To see all samples, visit `tests/_models` and Unit Tests.

```php
class Table extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%table}}';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => V7::class,
                'defaultAttribute' => 'uuid',
                'dateTime' => new \DateTime(),
                'binary' => true
            ]
        ];
    }
    public function rules()
    {
        return [
            ['uuid', UuidValidator::class]
        ];
    }
}
```
