<?php
/**
 * Client.php
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

require_once 'Konstati/Exception.php';

/**
 * Simple HTTP client using stream contexts.
 *
 * To avoid requiring additional dependencies, this class only uses
 * file_get_contents() with stream contexts to perform requests.
 *
 * Since Konstati only supports JSON as request/response format, all requests
 * and responses are already encoded/decoded by the send() method.
 *
 * Exceptions will be thrown whenever the response's HTTP status code is not
 * 2xx. If Konstati returns an additional error message in the response body,
 * it will be used as the exception message.
 *
 * @category Konstati
 * @package  Konstati
 * @author   Pedro Padron <ppadron@w3p.com.br>
 * @license  BSD <http://www.opensource.org/licenses/bsd-license.php>
 * @link     http://github.com/w3p/konstati-client-php
 * @see      http://konstati.co/
 */
class Konstati_Http_Client
{
    /**
     * Class constructor.
     *
     * @param type $username API username
     * @param type $apiKey   API key
     * @param type $endpoint API endpoint
     *
     * @return void
     */
    public function __construct($username, $apiKey, $endpoint = 'https://api.konstati.co')
    {
        $this->username = $username;
        $this->apiKey   = $apiKey;
        $this->endpoint = $endpoint;
    }

    /**
     * Sends the request and returns the result as stdClass.
     *
     * @throws Konstati_Exception If request is not successful
     *
     * @param string $url    Path to resource/collection relative to API endpoint
     * @param string $method GET/POST/PUT/DELETE
     * @param array  $params Parameters for the performed action
     *
     * @return stdClass|boolean JSON-decoded response as stdClass or boolean if response is empty.
     */
    public function send($url, $method, array $params = array())
    {
        $context = stream_context_create(array(
            'http' => array(
                'method'          => $method,
                'timeout'         => 5,
                'ignore_errors'   => true,
                'follow_location' => false,
                'content'         => ($method === 'POST') ? json_encode($params) : null,
                'header'          => join("\r\n", array(
                    sprintf("Authorization: Basic %s", base64_encode($this->username . ':' . $this->apiKey)),
                    'Content-type: application/json',
                    'User-Agent: Konstati PHP Client v1.0.0',
                ))
            )
        ));

        $resourceUrl = "{$this->endpoint}{$url}";

        if ($method === 'GET' && !empty($params)) {
            $resourceUrl .= '?' . http_build_query($params);
        }

        $responseBody = @file_get_contents($resourceUrl, null, $context);

        preg_match("|^HTTP/[\d\.x]+ (?<code>\d+) (?<message>.*)|", $http_response_header[0], $httpStatus);

        if (floor((int) $httpStatus['code'] / 100) > 2) {

            $message = $httpStatus['message'];

            if (!empty($responseBody)) {
                $response = json_decode($responseBody);
                $message  = $response->errorMessage;
            }

            throw new Konstati_Exception($message, $httpStatus['code']);
        }

        switch ((int) $httpStatus['code']) {
            case 200:
            case 201:
            case 202:
            default:
                return json_decode($responseBody);
            case 204:
                if ($method === 'DELETE')
                    return true;
                return array();
        }
    }
}