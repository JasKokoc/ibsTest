<?php

namespace Notebookshop\DataFixtures;

use Faker\Factory;
use Module\Notebook\NotebookTable;
use Module\Notebook\ManufacturerTable;
use Module\Notebook\NotebookModelTable;
use Module\Notebook\NotebookOptionTable;
use Bitrix\Main\Type;

class ModuleFixtures
{
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function loadManufacturers(): void
    {
        for ($i = 1; $i < 20; $i++) {

            $manufacturer = new ManufacturerTable();

            $manufacturer::add(
                [
                    'NAME' => $this->faker->text(30),
                    'UPDATED_AT' => new Type\Date(),
                    'CREATED_AT' => new Type\Date(),
                ]);
        }
    }

    public function loadModels(): void
    {
        for ($i = 1; $i < 20; $i++) {

            $model = new NotebookModelTable();

            $model::add(
                [
                    'NAME' => $this->faker->text(30),
                    'MANUFACTURER_ID' => $this->faker->numberBetween(1, 20),
                    'UPDATED_AT' => new Type\Date(),
                    'CREATED_AT' => new Type\Date(),
                ]);
        }
    }

    public function loadOptions(): void
    {
        for ($i = 1; $i < 20; $i++) {

            $option = new NotebookOptionTable();

            $option::add(
                [
                    'NAME' => $this->faker->text(30),
                    'UPDATED_AT' => new Type\Date(),
                    'CREATED_AT' => new Type\Date(),
                ]);
        }
    }

    public function loadNotebooks(): void
    {
        for ($i = 1; $i < 20; $i++) {

            $notebook = new NotebookTable();

            $notebook::add(
                [
                    'NAME' => $this->faker->text(30),
                    'PRICE' => $this->faker->randomFloat(2),
                    'YEAR' => $this->faker->numberBetween(2015, 2024),
                    'MODEL_ID' => $this->faker->numberBetween(1, 20),
                    'OPTION_ID' =>
                        implode(',' , [
                            $this->faker->numberBetween(1, 5),
                            $this->faker->numberBetween(6, 10),
                            $this->faker->numberBetween(11, 20)
                        ]),
                    'UPDATED_AT' => new Type\Date(),
                    'CREATED_AT' => new Type\Date(),
                ]);
        }
    }
}
