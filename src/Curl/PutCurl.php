<?php

declare(strict_types = 1);

namespace RestClient\Curl;

use RestClient\Curl\AbstractCurl;

/**
 * Description of PutCurl
 *
 * @author darek
 */
class PutCurl extends AbstractCurl {

    /**
     * Set cURL options
     */
    protected function setOptions() {
        curl_setopt($this->curl->getHandler(), CURLOPT_CUSTOMREQUEST, "PUT");
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
