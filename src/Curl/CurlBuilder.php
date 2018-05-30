<?php

namespace RestClient\Curl;

use Noodlehaus\Config;
use RestClient\Auth;
use RestClient\Curl\Curl;
use RestClient\Curl\CurlInterface;

/**
 * Description of CurlBuilder
 *
 * @author darek
 */
class CurlBuilder {

    /**
     * 
     */
    const REQUEST_TYPE_GET = 'GET';

    /**
     * 
     */
    const REQUEST_TYPE_POST = 'POST';

    /**
     * 
     */
    const REQUEST_TYPE_PUT = 'PUT';

    /**
     * 
     */
    const REQUEST_TYPE_DELETE = 'DELETE';

    /**
     *
     * @var Config
     */
    private $config;

    /**
     * 
     * @param Config $config
     */
    public function __construct(Config &$config) {
        $this->config = $config;
    }

    /**
     * Simple factory
     * 
     * @param string $methodName
     * @param mixed $params
     * @param Auth $auth
     * 
     * @return CurlInterface
     */
    public function create(string $methodName, $params, Auth &$auth): CurlInterface {
        $curl = new Curl($methodName, $params, $this->config, $auth);

        switch ($this->config->get('api.' . $methodName . '.type')) {
            case self::REQUEST_TYPE_GET:
                return new GetCurl($curl);
            case self::REQUEST_TYPE_POST:
                return new PostCurl($curl);
            case self::REQUEST_TYPE_PUT:
                return new PutCurl($curl);
            case self::REQUEST_TYPE_DELETE:
                return new DeleteCurl($curl);
        }
    }

}
