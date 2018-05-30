<?php

namespace RestClient\Curl;

use RestClient\Curl\CurlInterface;
use RestClient\Curl\Curl;

/**
 * Description of AbstractCurl
 *
 * @author darek
 */
abstract class AbstractCurl implements CurlInterface {

    /**
     *
     * @var Curl
     */
    protected $curl;

    /**
     * 
     * @param Curl $curl
     */
    public function __construct(Curl &$curl) {
        $this->curl = $curl;
        $this->setOptions();
    }

    /**
     * 
     * @return mixed
     * @throws \Exception
     */
    public function execute() {
        $this->curl->execute();
        $code = (int) curl_getinfo($this->curl->getHandler(), CURLINFO_HTTP_CODE);
        if (200 == $code || (204 == $code && $this->curl->getMethodName() == 'deletePerson')) {
            return $this->getResult();
        } elseif (401 == $code) {
            $this->curl->getAuth()->updateTokens();
            curl_setopt($this->curl->getHandler(), CURLOPT_HTTPHEADER, array("Authorization: Bearer " . $this->curl->getAuth()->getAccessToken()));
            $this->execute();
        } else {
            throw new \Exception('Error', $code);
        }
    }

    /**
     * Set cURL options
     */
    protected abstract function setOptions();

    /**
     * Get cURL result
     */
    protected abstract function getResult();
}
