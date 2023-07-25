<?php

namespace LiveVoting\Context;

use ilContextTemplate;
use ilLiveVotingPlugin;
use LiveVoting\Utils\LiveVotingTrait;
use srag\DIC\LiveVoting\DICTrait;

/**
 * Class xlvoContextLiveVoting
 *
 * @package LiveVoting\Context
 * @author  Fabian Schmid <fs@studer-raimann.ch>
 */
class xlvoContextLiveVoting implements ilContextTemplate
{

    use DICTrait;
    use LiveVotingTrait;
    const PLUGIN_CLASS_NAME = ilLiveVotingPlugin::class;


    /** * #SUR# */
    public static function isSessionMainContext(): bool
    {
       return true;
    }

    /** * #SUR# */
    public static function modifyHttpPath(string $httpPath): string
    {
        return $httpPath;
    }


    /**
     * @return bool
     */
    public static function supportsRedirects():bool
    {
        return false;
    }


    /**
     * @return bool
     */
    public static function hasUser():bool
    {
        return true;
    }


    /**
     * @return bool
     */
    public static function usesHTTP():bool
    {
        return true;
    }


    /**
     * @return bool
     */
    public static function hasHTML():bool
    {
        return true;
    }


    /**
     * @return bool
     */
    public static function usesTemplate(): bool
    {
        return true;
    }


    /**
     * @return bool
     */
    public static function initClient():bool
    {
        return true;
    }


    /**
     * @return bool
     */
    public static function doAuthentication():bool
    {
        return false;
    }


    /**
     * Check if persistent sessions are supported
     * false for context cli
     */
    public static function supportsPersistentSessions():bool
    {
        return false;
    }


    /**
     * Check if push messages are supported, see #0018206
     *
     * @return bool
     */
    public static function supportsPushMessages():bool
    {
        return false;
    }
}
