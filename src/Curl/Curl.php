<?php

declare(strict_types = 1);

namespace RestClient\Curl;

use Noodlehaus\Config;
use RestClient\Curl\CurlInterface;
use RestClient\Auth;

/**
 * Abstract cURL class
 *
 * @author Darek Dawidowicz
 */
class Curl implements CurlInterface {

    /**
     *
     * @var resource
     */
    private $ch;

    /**
     *
     * @var Config
     */
    private $config;

    /**
     *
     * @var Auth
     */
    private $auth;

    /**
     *
     * @var string
     */
    private $methodName;

    /**
     *
     * @var mixed
     */
    private $postfields;

    /**
     *
     * @var mixed
     */
    private $curlResult;

    /**
     * 
     * @param string $methodName
     * @param mixed $params
     * @param Config $config
     */
    public function __construct(string $methodName, $params, Config &$config, Auth &$auth) {
        $this->methodName = $methodName;
        if (!is_null($params)) {
            $this->postfields = $params;
        }
        $this->config = $config;
        $this->auth = $auth;
        $this->ch = curl_init();
        $this->setOptions();
    }

    /**
     * 
     */
    private function setOptions() {
        curl_setopt($this->ch, CURLOPT_URL, $this->config->get('host') . $this->config->get('api.' . $this->methodName . '.url'));
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer " . $this->auth->getAccessToken()));
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, TRUE);
    }

    /**
     * Execute cURL
     */
    public function execute() {
        $this->curlResult = curl_exec($this->ch);
    }

    /**
     * 
     */
    public function __destruct() {
        curl_close($this->ch);
    }

    /**
     * 
     * @return resource
     */
    public function getHandler() {
        return $this->ch;
    }

    /**
     * 
     * @return string
     */
    public function getPostfields() {
        return $this->postfields;
    }

    /**
     * 
     * @return string
     */
    public function getMethodName() {
        return $this->methodName;
    }

    /**
     * 
     * @return mixed
     */
    public function getResult() {
        return $this->curlResult;
    }

    /**
     * 
     * @return Auth
     */
    public function getAuth() {
        return $this->auth;
    }

    /**
     * @return Config
     */
    public function getConfig() {
        return $this->config;
    }

}
