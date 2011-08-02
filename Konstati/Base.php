<?php
/**
 * Base.php
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

require_once 'Konstati/Http/Client.php';

/**
 * Base class that should be inherited by API endpoints.
 *
 * @category Konstati
 * @package  Konstati
 * @author   Pedro Padron <ppadron@w3p.com.br>
 * @license  BSD <http://www.opensource.org/licenses/bsd-license.php>
 * @link     http://github.com/w3p/konstati-client-php
 * @see      http://konstati.co/api
 */
class Konstati_Base
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
     * @var Konstati_Http_Client HTTP client
     */
    protected $httpClient;

    /**
     * Class constructor.
     *
     * @param string $username API username
     * @param string $apiKey   API key
     * @param string $endpoint API endpoint (without trailing slash)
     */
    public function __construct($username, $apiKey, $endpoint = 'https://api.konstati.co')
    {
        $this->username = $username;
        $this->apiKey = $apiKey;
        $this->endpoint = $endpoint;
    }

    /**
     * Sets the HTTP client to be used in requests
     *
     * @param mixed $httpClient HTTP client
     *
     * @return void
     */
    public function setHttpClient($httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Returns an HTTP client object
     *
     * @return Konstati_Http_Client|mixed
     */
    public function getHttpClient()
    {
        if (!$this->httpClient) {
            $this->httpClient = new Konstati_Http_Client(
                $this->username, $this->apiKey, $this->endpoint
            );
        }

        return $this->httpClient;
    }
}