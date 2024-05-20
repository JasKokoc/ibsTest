<?php

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Config\Option;
use Bitrix\Main\EventManager;
use Bitrix\Main\Application;
use Bitrix\Main\IO\Directory;
use Module\Notebook\NotebookTable;
use Module\Notebook\ManufacturerTable;
use Module\Notebook\NotebookModelTable;
use Module\Notebook\NotebookOptionTable;
use Notebookshop\DataFixtures\ModuleFixtures;


Loc::loadMessages(__FILE__);

class notebookshop extends CModule
{

    public function __construct()
    {
        if (!is_file(__DIR__.'/version.php')) {
            CAdminMessage::showMessage(
                Loc::getMessage('NOTEBOOKSHOP_FILE_NOT_FOUND') . ' version.php'
            );
        }
            include_once(__DIR__.'/version.php');

            $this->MODULE_ID = get_class($this);
            $this->MODULE_VERSION = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
            $this->MODULE_NAME = Loc::getMessage('NOTEBOOKSHOP_MODULE_NAME');
            $this->MODULE_DESCRIPTION = Loc::getMessage('NOTEBOOKSHOP_MODULE_DESCRIPTION');

    }

    public function doInstall(): void
    {
        global $APPLICATION;

        if (CheckVersion(ModuleManager::getVersion('main'), '14.00.00')) {
            $this->installFiles();
            $this->installDB();
            $this->loadFixtures();
            ModuleManager::registerModule($this->MODULE_ID);
        } else {
            CAdminMessage::showMessage(
                Loc::getMessage('NOTEBOOKSHOP_INSTALL_ERROR')
            );
            return;
        }

        $APPLICATION->includeAdminFile(
            Loc::getMessage('NOTEBOOKSHOP_INSTALL_TITLE').' «'.Loc::getMessage('NOTEBOOKSHOP_MODULE_NAME').'»',
            __DIR__.'/step.php'
        );
    }

    public function installFiles(): void
    {
        CopyDirFiles(
            __DIR__.'/assets/scripts',
            Application::getDocumentRoot().'/bitrix/js/'.$this->MODULE_ID.'/',
            true,
            true
        );
        CopyDirFiles(
            __DIR__.'/assets/styles',
            Application::getDocumentRoot().'/bitrix/css/'.$this->MODULE_ID.'/',
            true,
            true
        );
    }

    public function installDB(): void
    {
        ManufacturerTable::getEntity()->createDbTable();
        NotebookModelTable::getEntity()->createDbTable();
        NotebookTable::getEntity()->createDbTable();
        NotebookOptionTable::getEntity()->createDbTable();
    }

    public function loadFixtures(): void
    {
        $fixture = new ModuleFixtures();

        $fixture->loadManufacturers();
        $fixture->loadModels();
        $fixture->loadOptions();
        $fixture->loadNotebooks();
    }

    public function doUninstall(): void
    {

        global $APPLICATION;

        $this->uninstallFiles();
        $this->uninstallDB();

        ModuleManager::unRegisterModule($this->MODULE_ID);

        $APPLICATION->includeAdminFile(
            Loc::getMessage('NOTEBOOKSHOP_UNINSTALL_TITLE').' «'.Loc::getMessage('NOTEBOOKSHOP_MODULE_NAME').'»',
            __DIR__.'/unstep.php'
        );

    }

    public function uninstallFiles(): void
    {
        Directory::deleteDirectory(
            Application::getDocumentRoot().'/bitrix/js/'.$this->MODULE_ID
        );
        Directory::deleteDirectory(
            Application::getDocumentRoot().'/bitrix/css/'.$this->MODULE_ID
        );
        Option::delete($this->MODULE_ID);
    }

    public function uninstallDB(): void
    {
        //TODO: вынести листинг таблиц в конфиг

        $tableList = [
            'manufacturer',
            'notebook_model',
            'notebook',
            'notebook_option',
        ];

        $connection = Application::getConnection();

        foreach ($tableList as $table)
        {
            $sql = 'drop table if exists ' . $table;
            $connection->queryExecute($sql);
        }

    }

}