<?php
/**
 * Konstati.php
 *
 * PHP version 5
 *
 * @category Konstati
 * @package  Konstati
 * @author   Pedro Padron <ppadron@w3p.com.br>
 * @license  BSD <http://www.opensource.org/licenses/bsd-license.php>
 * @link     http://github.com/w3p/konstati-client-php
 * @see      http://konstati.co/api
 */

/**
 * Class that acts as an wrapper around the other ones that represent endpoints.
 *
 * Allows lazy-loading resources through __get() magic method.
 *
 * @category Konstati
 * @package  Konstati
 * @author   Pedro Padron <ppadron@w3p.com.br>
 * @license  BSD <http://www.opensource.org/licenses/bsd-license.php>
 * @link     http://github.com/w3p/konstati-client-php
 * @see      http://konstati.co/api
 * @property Konstati_Account $account
 * @property Konstati_Tests   $tests
 */
class Konstati
{
    /**
     * @var string API username
     */
    protected $username;

    /**
     * @var string API key
     */
    protected $apiKey;

    /**
     * @var string API endpoint (without trailing slash)
     */
    protected $endpoint;

    /**
     * @var string API endpoint versio
    */
    protected $version;

    /**
     * @var array Lazily-loaded instances
     */
    protected $instances;

    /**
     * @var array Array of API resources that will be mapped to classes
     */
    protected $resources = array('account', 'tests');

    /**
     * Class constructor
     *
     * @param type $username API username
     * @param type $apiKey   API key
     * @param type $endpoint API endpoint
     * @param type $version  API endpoint version
     */
    public function __construct($username, $apiKey, $endpoint = 'https://api.konstati.co', $version = 'v1')
    {
        $this->username = $username;
        $this->apiKey   = $apiKey;
        $this->endpoint = $endpoint . '/' . $version;
        $this->version  = $version;
    }

    /**
     * Allows lazy-loading resources.
     *
     * @param string $name Resource name
     *
     * @return mixed Resource instance
     */
    public function __get($name)
    {
        if (!in_array($name, $this->resources)) {
            return null;
        }

        if (isset($instances[$name])) {
            return $instances[$name];
        }

        $className = 'Konstati_' . ucfirst($name);
        require_once 'Konstati/' . ucfirst($name) . '.php';
        $instances[$name] = new $className($this->username, $this->apiKey, $this->endpoint);

        return $instances[$name];
    }
}
