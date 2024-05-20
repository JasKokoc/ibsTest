<?php

namespace Module\Notebook;

use Bitrix\Main\Entity\DataManager;
use Bitrix\Main\Entity\IntegerField;
use Bitrix\Main\Entity\StringField;
use Bitrix\Main\Entity\DatetimeField;
use Bitrix\Main\Entity\Validator;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Fields\Relations\OneToMany;

Loc::loadMessages(__FILE__);

class NotebookOptionTable extends DataManager
{
    public static function getTableName(): string
    {
        return 'notebook_option';
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
                    'validation' => function () {
                        return [
                            new Validator\Length(null, 255),
                        ];
                    },
                ]
            ),
            new OneToMany(
                'NOTEBOOK',
                NotebookTable::class,
                'OPTION'
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