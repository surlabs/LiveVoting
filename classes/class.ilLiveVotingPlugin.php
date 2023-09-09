<?php

require_once __DIR__ . '/../vendor/autoload.php';

use LiveVoting\Conf\xlvoConf;
use LiveVoting\Conf\xlvoConfOld;
use LiveVoting\Option\xlvoData;
use LiveVoting\Option\xlvoOption;
use LiveVoting\Option\xlvoOptionOld;
use LiveVoting\Player\xlvoPlayer;
use LiveVoting\Round\xlvoRound;
use LiveVoting\User\xlvoVoteHistoryObject;
use LiveVoting\Utils\LiveVotingTrait;
use LiveVoting\Vote\xlvoVote;
use LiveVoting\Vote\xlvoVoteOld;
use LiveVoting\Voter\xlvoVoter;
use LiveVoting\Voting\xlvoVoting;
use LiveVoting\Voting\xlvoVotingConfig;
use srag\RemovePluginDataConfirm\LiveVoting\RepositoryObjectPluginUninstallTrait;

/**
 * LiveVoting repository object plugin
 *
 * @author  Fabian Schmid <fs@studer-raimann.ch>
 * @version $Id$
 *
 */
class ilLiveVotingPlugin extends ilRepositoryObjectPlugin
{

    use RepositoryObjectPluginUninstallTrait;
    use LiveVotingTrait;

    protected ?ilPlugin $plugin = null;
    protected ilComponentFactory $component_factory;

    const PLUGIN_ID = 'xlvo';
    const PLUGIN_NAME = 'LiveVoting';
    const PLUGIN_CLASS_NAME = self::class;
    const REMOVE_PLUGIN_DATA_CONFIRM_CLASS_NAME = LiveVotingRemoveDataConfirm::class;
    /**
     * @var ilLiveVotingPlugin
     */
    protected static $instance;


    /**
     * @return ilLiveVotingPlugin
     */
    public static function getInstance()
    {
        GLOBAL $DIC;
        /** @var ilComponentFactory $component_factory */
        $component_factory = $DIC["component.factory"];
        return $component_factory->getPlugin('xlvo');

        if (!isset(self::$instance)) {

            self::$instance = new self(array(), 0, true);
        }

        return self::$instance;
    }


    /**
     * @return string
     */
    public function getPluginName(): string
    {
        return self::PLUGIN_NAME;
    }


    /**
     * @return bool
     */
    public function allowCopy(): bool
    {
        return true;
    }


    /**
     * @inheritdoc
     */
    protected function deleteData(): void
    {
        self::dic()->database()->dropTable(xlvoConfOld::TABLE_NAME, false);
        self::dic()->database()->dropTable(xlvoVotingConfig::TABLE_NAME, false);
        self::dic()->database()->dropTable(xlvoData::TABLE_NAME, false);
        self::dic()->database()->dropTable(xlvoOption::TABLE_NAME, false);
        self::dic()->database()->dropTable(xlvoOptionOld::TABLE_NAME, false);
        self::dic()->database()->dropTable(xlvoPlayer::TABLE_NAME, false);
        self::dic()->database()->dropTable(xlvoRound::TABLE_NAME, false);
        self::dic()->database()->dropTable(xlvoVote::TABLE_NAME, false);
        self::dic()->database()->dropTable(xlvoVoteOld::TABLE_NAME, false);
        self::dic()->database()->dropTable(xlvoVoteHistoryObject::TABLE_NAME, false);
        self::dic()->database()->dropTable(xlvoVoting::TABLE_NAME, false);
        self::dic()->database()->dropTable(xlvoConf::TABLE_NAME, false);
        self::dic()->database()->dropTable(xlvoVoter::TABLE_NAME, false);
    }

    protected function shouldUseOneUpdateStepOnly() : bool
    {
        return false;
    }

    protected function initType(): void
    {
        $this->type = 'cld';
    }

    /**
     * Send Info Message to Screen.
     *
     * @param	string	message
     * @static
     *
     */
    public static function sendInfo($a_info = "")
    {
        global $DIC;
        $message = $DIC->ui()->factory()->messageBox()->info($a_info);
        $DIC->ui()->renderer()->render($message);
    }

    /**
     * Send Failure Message to Screen.
     *
     * @param	string	message
     * @static
     *
     */
    public static function sendFailure($a_info = "")
    {
        global $DIC;
        $message = $DIC->ui()->factory()->messageBox()->failure($a_info);
        $DIC->ui()->renderer()->render($message);
    }

    /**
     * Send Question to Screen.
     *
     * @param	string	message
     * @static	*/
    public static function sendQuestion($a_info = "")
    {
        global $DIC;
        $message = $DIC->ui()->factory()->messageBox()->confirmation($a_info);
        $DIC->ui()->renderer()->render($message);
    }

    /**
     * Send Success Message to Screen.
     *
     * @param	string	message
     * @static
     *
     */
    public static function sendSuccess($a_info = "")
    {
        global $DIC;
        $message = $DIC->ui()->factory()->messageBox()->success($a_info);
        $DIC->ui()->renderer()->render($message);
    }
}

}
