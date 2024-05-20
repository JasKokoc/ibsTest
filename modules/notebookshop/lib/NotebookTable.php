<?php

namespace Module\Notebook;

use Bitrix\Main\Entity\DataManager;
use Bitrix\Main\Entity\FloatField;
use Bitrix\Main\Entity\IntegerField;
use Bitrix\Main\Entity\StringField;
use Bitrix\Main\Entity\DatetimeField;
use Bitrix\Main\Entity\Validator;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;


Loc::loadMessages(__FILE__);

class NotebookTable extends DataManager
{
    public static function getTableName(): string
    {
        return 'notebook';
    }

    public static function getMap(): array
    {
        return [
            new IntegerField(
                'ID',
                [
                    'autocomplete' => true,
                    'primary' => true
                ]
            ),
            new StringField(
                'NAME',
                [
                    'required' => true,
                    'title' => Loc::getMessage('MODULE_NAME'),
                    'validation' => function () {
                        return [
                            new Validator\Length(null, 255),
                        ];
                    },
                ]
            ),
            new FloatField(
                'PRICE',
                [
                    'required' => true,
                ]
            ),
            new StringField(
                'YEAR',
                [
                    'required' => true,
                    'validation' => function () {
                        return [
                            new Validator\Length(4, 4),
                        ];
                    },
                ]
            ),
            new IntegerField(
                'MODEL_ID',
                [
                    'required' => true,
                ]
            ),
            new Reference(
                'MODEL',
                NotebookModelTable::class,
                ['=this.MODEL_ID' => 'ref.ID']
            ),
            new StringField(
                'OPTION_ID',
            ),
            new Reference(
                'OPTIONS',
                NotebookOptionTable::class,
                ['=this.OPTION_ID' => 'ref.ID'],
            ),
            new DatetimeField(
                'UPDATED_AT',
                [
                    'required' => true
                ]
            ),
            new DatetimeField(
                'CREATED_AT',
                [
                    'required' => true
                ]
            ),
        ];
    }
}