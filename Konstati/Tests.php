<?php
/**
 * Tests.php
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

require_once 'Konstati/Base.php';

/**
 * Class representing the /tests endpoint.
 *
 * @category Konstati
 * @package  Konstati
 * @author   Pedro Padron <ppadron@w3p.com.br>
 * @license  BSD <http://www.opensource.org/licenses/bsd-license.php>
 * @link     http://github.com/w3p/konstati-client-php
 * @see      http://konstati.co/api
 */
class Konstati_Tests extends Konstati_Base
{
    /**
     * Creates a new test and returns the result.
     *
     * @param array $params Associative array containing test parameters
     *
     * @return stdClass Object containing test result.
     */
    public function create(array $params)
    {
        return $this->getHttpClient()->send('/tests', 'POST', $params);
    }

    /**
     * Deletes a test.
     *
     * @param string $id Test ID.
     *
     * @return bool Returns true if test was succesfully deleted, false otherwise.
     */
    public function delete($id)
    {
        return $this->getHttpClient()->send("/tests/{$id}", 'DELETE');
    }

    /**
     * Returns information about a specific test.
     *
     * @param string $id
     *
     * @return stdClass Returns all test information.
     */
    public function get($id)
    {
        return $this->getHttpClient()->send("/tests/{$id}", 'GET');
    }

    /**
     * Queries the Konstati server for a list of tests based on optional params.
     *
     * @see http://konstati.co/api#get-tests
     * @param array $params Search parameters
     *
     * @return array Array of tests (stdClass)
     */
    public function find($params = array())
    {
        return $this->getHttpClient()->send("/tests", 'GET', $params);
    }
}