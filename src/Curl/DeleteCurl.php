<?php

declare(strict_types = 1);

namespace RestClient\Curl;

use RestClient\Curl\AbstractCurl;

/**
 * Description of DeleteCurl
 *
 * @author darek
 */
class DeleteCurl extends AbstractCurl {

    /**
     * Set cURL options
     */
    protected function setOptions() {
        curl_setopt($this->curl->getHandler(), CURLOPT_URL, $this->curl->getConfig()->get('host') . $this->curl->getConfig()->get('api.' . $this->curl->getMethodName() . '.url') . '/' . $this->curl->getPostfields());
        curl_setopt($this->curl->getHandler(), CURLOPT_CUSTOMREQUEST, "DELETE");
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
