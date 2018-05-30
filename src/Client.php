<?php

namespace RestClient;

use RestClient\Auth;
use RestClient\Curl\CurlBuilder;

/**
 * Description of Client
 *
 * @author darek
 */
class Client {

    /**
     *
     * @var CurlBuilder
     */
    private $builder;

    /**
     *
     * @var Auth
     */
    private $auth;

    /**
     * 
     * @param CurlBuilder $builder
     * @param Auth $auth
     */
    public function __construct(CurlBuilder &$builder, Auth &$auth) {
        $this->builder = $builder;
        $this->auth = $auth;
    }

    /**
     * 
     * @param string $params
     * @return mixed
     */
    public function getPeople($params) {
        return $this->builder->create('getPeople', $params, $this->auth)->execute();
    }

    /**
     * 
     * @param string $params
     * @return boolean
     */
    public function postPerson($params) {
        return $this->builder->create('postPerson', $params, $this->auth)->execute();
    }

    /**
     * 
     * @param string $params
     * @return boolean
     */
    public function putPerson($params) {
        return $this->builder->create('putPerson', $params, $this->auth)->execute();
    }

    /**
     * 
     * @param string $params
     * @return boolean
     */
    public function deletePerson($params) {
        return $this->builder->create('deletePerson', $params, $this->auth)->execute();
    }

}
