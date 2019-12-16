<?php
/**
 * Class ConsoleRequestParams
 *
 * @package     ServiceConsoleTransport
 * @subpackage  ConsoleRequestParams
 * @author      Dodonov A.A.
 * @version     v.1.0 (2019/08/12)
 * @copyright   Copyright (c) 2019, aeon.org
 */

require_once(__DIR__.'/../../../service-request-params/service-request-params.php');

/**
 * Request params fetcher.
 */
class ConsoleRequestParams implements ServiceRequestParams
{

    /**
     * Router of the transport.
     *
     * @var Router
     */
    protected $Router = false;

    /**
     * Constructor.
     *
     * @param Router $Router
     *            - Router object.
     */
    public function __construct(Router &$Router)
    {
        $this->Router = $Router;
    }

    /**
     * Method returns session id from HTTP header.
     *
     * @return string Session id.
     */
    protected function get_session_id()
    {
        return ('');
    }

    /**
     * Method returns parameter.
     *
     * @param string $Param
     *            - parameter name.
     * @param mixed $Default
     *            - default value.
     * @return string Parameter value.
     */
    public function get_param($Param, $Default = false)
    {
        global $argv;

        if (isset($argv[$Param])) {
            return ($argv[$Param]);
        }

        return ($Default);
    }
}

?>