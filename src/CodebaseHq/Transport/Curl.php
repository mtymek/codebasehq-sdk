<?php

namespace CodebaseHq\Transport;

class Curl extends AbstractTransport
{

    /**
     * Perform API call
     *
     * @param $endpoint
     * @param string $method
     * @param null $data
     * @return mixed
     */
    public function call($username, $apiKey, $endpoint, $method = 'GET', $data = null)
    {
        // TODO: Implement call() method.
    }
}
