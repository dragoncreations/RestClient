<?php

declare(strict_types = 1);

namespace RestClient\Curl;

use RestClient\Curl\AbstractCurl;

/**
 * Curl for GET request
 *
 * @author Darek Dawidowicz
 */
class GetCurl extends AbstractCurl {

    /**
     * Set cURL options
     */
    protected function setOptions() {
        $params = $this->curl->getPostfields();
        if (!is_null($params) && is_string($params)) {
            curl_setopt($this->curl->getHandler(), CURLOPT_URL, $this->curl->getConfig()->get('host') . $this->curl->getConfig()->get('api.' . $this->curl->getMethodName() . '.url') . '/' . $params);
        }
        curl_setopt($this->curl->getHandler(), CURLOPT_HEADER, false);
    }

    /**
     * Get cURL result
     * 
     * @return mixed
     */
    protected function getResult() {
        return json_decode($this->curl->getResult());
    }

}
