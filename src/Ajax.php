<?php

declare(strict_types = 1);

namespace RestClient;

use RestClient\Client;

/**
 * Description of Ajax
 *
 * @author darek
 */
class Ajax {

    /**
     *
     * @var Client
     */
    private $client;

    /**
     *
     * @var string
     */
    private $requestMethod;

    /**
     *
     * @var string
     */
    private $methodName;

    /**
     *
     * @var mixed
     */
    private $methodParams;

    /**
     * 
     * @param Client $client
     * @param string $requestMethod
     */
    public function __construct($client, $requestMethod) {
        $this->client = $client;
        $this->requestMethod = $requestMethod;
        switch ($requestMethod) {
            case 'POST':
                $type = INPUT_POST;
                break;
            case 'GET':
                $type = INPUT_GET;
        }
        $this->methodName = filter_input($type, 'actionName');
        $this->methodParams = filter_input($type, 'params');
    }

    /**
     * Process ajax
     */
    public function run() {
        echo $this->getResponse($this->client->{$this->methodName}($this->methodParams));
    }

    /**
     * Get ajax response
     * 
     * @param mixed $result
     * 
     * @return string
     */
    private function getResponse($result) {
        if (is_array($result)) {
            return $this->generateTableRows($result);
        } elseif (is_object($result)) {
            return json_encode($result);
        }
    }

    /**
     * Generate HTML table rows
     * 
     * @param array $list
     * 
     * @return string
     */
    private function generateTableRows($list) {
        $result = "";

        if (is_array($list) && !empty($list)) {
            foreach ($list as $item) {
                $result .= '<tr>'
                        . '<td>' . $item->firstname . '</td>'
                        . '<td>' . $item->lastname . '</td>'
                        . '<td>
                        <a href="#" data-pid="' . $item->id . '" class="btn btn-success" role="button" data-toggle="modal" data-target="#edit">Edytuj</a>
                        <a href="#" data-pid="' . $item->id . '" class="btn btn-danger" role="button" data-toggle="modal" data-target="#confirm-delete">Usuń</a>
                       </td>'
                        . '</tr>';
            }
        }

        return $result;
    }

}
