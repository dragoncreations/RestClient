<?php

namespace RestClient;

use Noodlehaus\Config;

/**
 * Description of Db
 *
 * @author darek
 */
class Db {

    /**
     * Connection
     *
     * @var \mysqli 
     */
    private $connection;

    /**
     * 
     * @param Config $config
     */
    public function __construct(Config &$config) {
        $this->connection = mysqli_connect($config->get('host'), $config->get('user'), $config->get('password'), $config->get('dbname'));
    }

    /**
     * Get connection
     * 
     * @return \mysqli
     */
    public function getConnection() {
        return $this->connection;
    }

}
