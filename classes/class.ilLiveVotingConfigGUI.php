<?php

require_once __DIR__ . '/../vendor/autoload.php';

use LiveVoting\Utils\LiveVotingTrait;
use srag\DIC\LiveVoting\DICTrait;

/**
 * ilLiveVotingConfigGUI
 *
 * @author             Fabian Schmid <fs@studer-raimann.ch>
 *
 * @ilCtrl_IsCalledBy  ilLiveVotingConfigGUI: ilObjComponentSettingsGUI
 */
class ilLiveVotingConfigGUI extends ilObjectGUI
{

    use DICTrait;
    use LiveVotingTrait;
    const PLUGIN_CLASS_NAME = ilLiveVotingPlugin::class;
    protected ?ilPlugin $plugin = null;


    public function __construct()
    {
        global $DIC;

        parent::__construct(array(), 0, true, true);

        /** @var ilComponentFactory $component_factory */
        $component_factory = $DIC["component.factory"];
        $this->setPluginObject($component_factory->getPlugin('xlvo'));


        //#ILIAS8 Set plugin name in ilObjComponentSettingsGUI
        $this->ctrl->setParameter($this, ilObjComponentSettingsGUI::P_PLUGIN_NAME, 'LiveVoting');
    }


    /**
     * @return ilLiveVotingConfigGUI
     */
    public function getPlugin(): ilLiveVotingConfigGUI
    {
        /** @var ilLiveVotingConfigGUI $plugin */
        $plugin = $this->plugin;
        return $plugin;
    }

    /**
     * #ILIAS8 Add Object to setPlugin to fit the current ilObjComponentSettingsGUI implementation
     * @param ilPlugin|null $plugin
     */
    public function setPluginObject(?ilPlugin $plugin): void
    {
        $this->plugin = $plugin;
    }

    public function executeCommand(): void
    {
        // TODO: Refactoring
        self::dic()->ctrl()->setParameterByClass(ilObjComponentSettingsGUI::class, "ctype", $_GET["ctype"]);
        self::dic()->ctrl()->setParameterByClass(ilObjComponentSettingsGUI::class, "cname", $_GET["cname"]);
        self::dic()->ctrl()->setParameterByClass(ilObjComponentSettingsGUI::class, "slot_id", $_GET["slot_id"]);
        self::dic()->ctrl()->setParameterByClass(ilObjComponentSettingsGUI::class, "plugin_id", $_GET["plugin_id"]);
        self::dic()->ctrl()->setParameterByClass(ilObjComponentSettingsGUI::class, "pname", $_GET["pname"]);

        self::dic()->ui()->mainTemplate()->setTitle(self::dic()->language()->txt("cmps_plugin") . ": " . $_GET["pname"]);
        self::dic()->ui()->mainTemplate()->setDescription("");

        self::dic()->tabs()->clearTargets();

        if ($_GET["plugin_id"]) {
            self::dic()->tabs()->setBackTarget(self::dic()->language()->txt("cmps_plugin"), self::dic()->ctrl()
                ->getLinkTargetByClass(ilObjComponentSettingsGUI::class, "showPlugin"));
        } else {
            self::dic()->tabs()->setBackTarget(self::dic()->language()->txt("cmps_plugins"), self::dic()->ctrl()
                ->getLinkTargetByClass(ilObjComponentSettingsGUI::class, "listPlugins"));
        }

        $nextClass = self::dic()->ctrl()->getNextClass();

        if ($nextClass) {
            $a_gui_object = new xlvoMainGUI();
            self::dic()->ctrl()->forwardCommand($a_gui_object);
        } else {
            self::dic()->ctrl()->redirectByClass(array(
                xlvoMainGUI::class,
                xlvoConfGUI::class
            ));
        }
    }


    public function performCommand($cmd): void
    {
    }
}
