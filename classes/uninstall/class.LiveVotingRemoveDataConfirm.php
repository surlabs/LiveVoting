<?php

require_once __DIR__ . "/../../vendor/autoload.php";

use LiveVoting\Utils\LiveVotingTrait;
use srag\RemovePluginDataConfirm\LiveVoting\RemovePluginDataConfirmCtrl;

/**
 * Class LiveVotingRemoveDataConfirm
 *
 * @ilCtrl_isCalledBy LiveVotingRemoveDataConfirm: ilUIPluginRouterGUI
 */
class LiveVotingRemoveDataConfirm extends RemovePluginDataConfirmCtrl
{

    use LiveVotingTrait;
    const PLUGIN_CLASS_NAME = ilLiveVotingPlugin::class;
}
