<?php

namespace LiveVoting\Context;

use ilException;

/**
 * Class xlvoILIAS
 *
 * @package LiveVoting\Context
 * @author  nschaefli
 */
class xlvoILIAS extends \ILIAS
{
    private \ilSetting $settings;
    
    public function __construct()
    {
        global $DIC;
        parent::__construct();
        $this->settings = $DIC->settings();
    }
    
    /**
     * @param $key
     *
     * @return mixed
     */
    public function getSetting(string $a_keyword, ?string $a_default_value = null) : ?string
    {
        return $this->settings->get($a_keyword, $a_default_value);
    }
    
    /**
     * wrapper for downward compability
     *
     * @throws ilException
     */
    public function raiseError(string $a_msg, int $a_err_obj) : void
    {
        throw new ilException($a_msg);
    }
}
