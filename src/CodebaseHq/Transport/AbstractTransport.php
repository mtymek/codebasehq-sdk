<?php

namespace CodebaseHq\Transport;

abstract class AbstractTransport
{

    /**
     * Perform API call
     *
     * @param $endpoint
     * @param string $method
     * @param null $data
     * @return mixed
     */
    abstract public function call($username, $apiKey, $api, $method = 'GET', $data = null);

}
