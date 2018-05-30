<?php

declare(strict_types = 1);

require 'vendor/autoload.php';

use Noodlehaus\Config;
use RestClient\Client;
use RestClient\Auth;
use RestClient\Db;
use RestClient\Ajax;
use RestClient\Curl\CurlBuilder;

$config = Config::load('config/config.yml');

$db = new Db(Config::load('config/connect.yml'));

$auth = new Auth($db, $config);

$builder = new CurlBuilder($config);

$client = new Client($builder, $auth);

$ajax = new Ajax($client, filter_input(INPUT_SERVER, 'REQUEST_METHOD'));

$ajax->run();
