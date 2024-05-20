<?php

namespace Module\Notebook;

use Bitrix\Main\Entity\DataManager;
use Bitrix\Main\Entity\IntegerField;
use Bitrix\Main\Entity\StringField;
use Bitrix\Main\Entity\DatetimeField;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;
use Bitrix\Main\Entity\Validator;
use Bitrix\Main\Localization\Loc;


Loc::loadMessages(__FILE__);

class NotebookModelTable extends DataManager
{
    // название таблицы
    public static function getTableName(): string
    {
        return 'notebook_model';
    }

    // создаем поля таблицы
    public static function getMap(): array
    {
        return [
            new IntegerField(
                'ID', [
                'autocomplete' => true,
                'primary' => true
            ]),
            new StringField(
                'NAME', [
                    'required' => true,
                    'title' => Loc::getMessage('MODULE_NAME'),
                    'validation' => function () {
                        return [
                            new Validator\Length(null, 255),
                        ];
                    },
                ]
            ),
            new IntegerField(
                'MANUFACTURER_ID', [
                    'required' => true,
                    'title' => Loc::getMessage('MANUFACTURER_ID'),
                ]
            ),
            new Reference(
                'MANUFACTURER',
                ManufacturerTable::class,
                Join::on('this.MANUFACTURER_ID', 'ref.ID')
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