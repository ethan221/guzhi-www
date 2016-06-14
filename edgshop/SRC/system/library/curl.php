<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Curl {

    private $logger;
    private static $instance;

    /**
     * @param  object  $registry  Registry Object
     */
    public static function get_instance($registry) {
        if (is_null(static::$instance)) {
            static::$instance = new static($registry);
        }

        return static::$instance;
    }

    /**
     * @param  object  $registry  Registry Object
     * 
     * You could load some useful libraries, few examples:
     *
     *   $registry->get('db');
     *   $registry->get('cache');
     *   $registry->get('session');
     *   $registry->get('config');
     *   and more... 
     */
    protected function __construct($registry) {
        // load the "Log" library from the "Registry"
        $this->logger = $registry->get('log');
    }

    /**
     * @param  string  $url     Url
     * @param  array  $params  Key-value pair
     */
    public function do_request($url, $params = array()) {
        // log the request
        $this->logger->write("Initiated CURL request for: {$url}");

        // init curl object
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // prepare post array if available
        $params_string = '';
        if (is_array($params) && count($params)) {
            foreach ($params as $key => $value) {
                $params_string .= $key . '=' . $value . '&';
            }
            rtrim($params_string, '&');

            curl_setopt($ch, CURLOPT_POST, count($params));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params_string);
        }

        // execute request
        $result = curl_exec($ch);

        // close connection
        curl_close($ch);

        return $result;
    }

}
