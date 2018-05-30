<?php

namespace RestClient;

use Noodlehaus\Config;
use RestClient\Db;

/**
 * Description of Auth
 *
 * @author darek
 */
class Auth {

    /**
     *
     * @var int
     */
    private $id;

    /**
     *
     * @var string
     */
    private $accessToken;

    /**
     *
     * @var string
     */
    private $refreshToken;

    /**
     *
     * @var Db;
     */
    private $db;

    /**
     *
     * @var Config
     */
    private $config;

    /**
     * 
     */
    public function __construct(Db &$db, Config &$config) {
        $this->db = $db;
        $this->config = $config;
        $this->setTokens();
    }

    /**
     * Get access token
     * 
     * @return string
     */
    public function getAccessToken() {
        return $this->accessToken;
    }

    /**
     * Set tokens
     */
    private function setTokens() {
        $query = "SELECT * FROM tokens LIMIT 1";

        $result = mysqli_query($this->db->getConnection(), $query);
        $tokens = mysqli_fetch_assoc($result);

        if (empty($tokens)) {
            $this->insertTokens();
        } else {
            $this->id = $tokens['id'];
            $this->accessToken = $tokens['access_token'];
            $this->refreshToken = $tokens['refresh_token'];
        }
    }

    /**
     * Insert tokens into DB
     */
    private function insertTokens() {
        $postData = [
            'grant_type' => 'password',
            'client_id' => $this->config->get('auth.client_id'),
            'client_secret' => $this->config->get('auth.client_secret'),
            'username' => $this->config->get('auth.username'),
            'password' => $this->config->get('auth.password')
        ];

        $outputData = $this->connect($postData);

        if (is_object($outputData)) {
            $query = "INSERT INTO tokens (access_token, refresh_token) "
                    . "VALUES ('" . $outputData->access_token . "', '" . $outputData->refresh_token . "')";
            if (!mysqli_query($this->db->getConnection(), $query)) {
                die('Error');
            }
        }

        $this->id = mysqli_insert_id($this->db->getConnection());
        $this->accessToken = $outputData->access_token;
        $this->refreshToken = $outputData->refresh_token;
    }

    /**
     * Update tokens
     */
    public function updateTokens() {
        $postData = [
            'grant_type' => 'refresh_token',
            'client_id' => $this->config->get('auth.client_id'),
            'client_secret' => $this->config->get('auth.client_secret'),
            'refresh_token' => $this->refreshToken
        ];

        $outputData = $this->connect($postData);

        if (is_object($outputData)) {
            $query = "UPDATE tokens "
                    . "SET access_token='" . $outputData->access_token . "', refresh_token='" . $outputData->refresh_token . "' "
                    . "WHERE id = " . $this->id;
            if (!mysqli_query($this->db->getConnection(), $query)) {
                die('Error');
            }
        }

        $this->accessToken = $outputData->access_token;
        $this->refreshToken = $outputData->refresh_token;
    }

    /**
     * 
     * @param array $postData
     * @return \stdClass
     */
    private function connect($postData) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_URL, $this->config->get('host') . $this->config->get('auth.url'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return json_decode($output);
    }

}
