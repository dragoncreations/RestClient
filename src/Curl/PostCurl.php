<?php

declare(strict_types = 1);

namespace RestClient\Curl;

use RestClient\Curl\AbstractCurl;

/**
 * Curl for POST request
 *
 * @author Darek Dawidowicz
 */
class PostCurl extends AbstractCurl {

    /**
     * Set cURL options
     */
    protected function setOptions() {
        curl_setopt($this->curl->getHandler(), CURLOPT_POST, 1);
        curl_setopt($this->curl->getHandler(), CURLOPT_HTTPHEADER, array(
            'Content-Length: ' . strlen($this->curl->getPostfields()))
        );
        curl_setopt($this->curl->getHandler(), CURLOPT_POSTFIELDS, $this->curl->getPostfields());
    }

    /**
     * Get cURL result
     * 
     * @return boolean
     */
    protected function getResult() {
        return TRUE;
    }

}
