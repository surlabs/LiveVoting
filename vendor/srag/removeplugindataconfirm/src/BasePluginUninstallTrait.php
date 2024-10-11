<?php

namespace srag\RemovePluginDataConfirm\LiveVoting;

use ilUIPluginRouterGUI;
use srag\DIC\LiveVoting\DICTrait;
use srag\LibraryLanguageInstaller\LiveVoting\LibraryLanguageInstaller;

/**
 * Trait BasePluginUninstallTrait
 *
 * @package srag\RemovePluginDataConfirm\LiveVoting
 *
 * @access  namespace
 */
trait BasePluginUninstallTrait
{

    use DICTrait;

    /*
    protected function updateDatabase() : int
    {
        if ($this->shouldUseOneUpdateStepOnly()) {
            $this->writeDBVersion(0);
        }

        return (int) parent::updateDatabase();
    }*/


    /**
     * Delete your plugin data in this method
     */
    protected abstract function deleteData() : void;


    /**
     *
     */
    protected function installRemovePluginDataConfirmLanguages() : void
    {
        LibraryLanguageInstaller::getInstance()->withPlugin(self::plugin())->withLibraryLanguageDirectory(__DIR__
            . "/../lang")->updateLanguages();
    }


    /**
     * @param bool $remove_data
     *
     * @return bool
     *
     * @internal
     */
    protected final function pluginUninstall(bool $remove_data = true) : bool
    {
        $this->deleteData();
        RemovePluginDataConfirmCtrl::removeUninstallRemovesData();

        return true;
    }


    /**
     * @return bool
     */
    protected abstract function shouldUseOneUpdateStepOnly() : bool;
}
