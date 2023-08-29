<?php

namespace LiveVoting\GUI;

use ilLinkButton;
use ilLiveVotingPlugin;
use LiveVoting\Utils\LiveVotingTrait;
use srag\DIC\LiveVoting\DICTrait;

/**
 * Class xlvoLinkButton
 *
 * @package LiveVoting\GUI
 * @author  Fabian Schmid <fs@studer-raimann.ch>
 * @version 1.0.0
 */
class xlvoLinkButton extends ilLinkButton
{

    use DICTrait;
    use LiveVotingTrait;
    const PLUGIN_CLASS_NAME = ilLiveVotingPlugin::class;
    const TYPE_XLVO_LINK = 'xlvo_link';


    public function clearClasses()
    {
        $this->css = array();
    }


    /**
     * Prepare render
     */
    protected function prepareRender():void
    {
        $this->addCSSClass('btn');
    }


    /**
     * @return xlvoLinkButton
     */
    public static function getInstance():ilLinkButton
    {
        return new self((int)self::TYPE_XLVO_LINK);
    }
}
