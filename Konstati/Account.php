<?php
/**
 * Account.php
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
 * Class representing the /account endpoint.
 *
 * @category Konstati
 * @package  Konstati
 * @author   Pedro Padron <ppadron@w3p.com.br>
 * @license  BSD <http://www.opensource.org/licenses/bsd-license.php>
 * @link     http://github.com/w3p/konstati-client-php
 * @see      http://konstati.co/api
 */
class Konstati_Account extends Konstati_Base
{
    /**
     * Returns account information.
     *
     * @return stdClass Account information
     */
    public function getInfo()
    {
        return $this->getHttpClient()->send('/account', 'GET');
    }
}