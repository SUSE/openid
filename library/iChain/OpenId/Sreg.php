<?php

require_once(APPLICATION_PATH."/library/Zend/OpenId/Extension/Sreg.php");

class iChain_OpenId_Sreg extends Zend_OpenId_Extension_Sreg
{


    private $_policy_url;
    private $_version;

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


    /**
     * Parses OpenId 'checkid_immediate' or 'checkid_setup' request,
     * extracts SREG variables and sets ovject properties to corresponding
     * values.
     *
     * @param array $params request's var/val pairs
     * @return bool
     */
    public function parseRequest($params)
    {
        if (isset($params['openid_ns_sreg']) &&
            $params['openid_ns_sreg'] === Zend_OpenId_Extension_Sreg::NAMESPACE_1_1) {
            $this->_version= 1.1;
        } else {
            $this->_version= 1.0;
        }
        if (!empty($params['openid_sreg_policy_url'])) {
            $this->_policy_url = $params['openid_sreg_policy_url'];
        } else {
            $this->_policy_url = null;
        }
        return true;
    }


    /**
     * Adds additional SREG data to OpenId 'id_res' response.
     *
     * @param array &$params response's var/val pairs
     * @return bool
     */
    public function prepareResponse(&$params)
    {
        $props = $this->getProperties();
        if (is_array($props) && count($props) > 0) {
            if ($this->_version >= 1.1) {
                $params['openid.ns.sreg'] = Zend_OpenId_Extension_Sreg::NAMESPACE_1_1;
            }
            foreach (self::getSregProperties() as $prop) {
                if (!empty($props[$prop])) {
                    $params['openid.sreg.' . $prop] = $props[$prop];
                }
            }
        }
        return true;
    }


}

