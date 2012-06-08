<?php

require_once(APPLICATION_PATH."/library/Zend/OpenId/Extension/Sreg.php");

class iChain_OpenId_Sreg extends Zend_OpenId_Extension_Sreg
{

	public function __construct(array $props=null, $policy_url=null, $version=1.0)
    {
        parent::__construct($props, $policy_url, $version);
    }


    /**
     * Returns array of allowed SREG variable names.
     *
     * @return array
     */
    public static function getSregProperties()
    {
        return array(
            "nickname",
            "email",
            "fullname",
            "dob",
            "gender",
            "postcode",
            "country",
            "language",
            "timezone",
            "username",
            "websynchid",
            "first_name",
            "last_name"
        );
    }


}


