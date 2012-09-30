<?php

namespace CodebaseHq\Transport;

class Curl extends AbstractTransport
{

    protected $codebaseUrl = 'https://api3.codebasehq.com';

    /**
     * Perform API call
     *
     * @param $username
     * @param $apiKey
     * @param $api
     * @param string $method
     * @param null $data
     * @return mixed
     */
    public function call($username, $apiKey, $api, $method = 'GET', $data = null)
    {
        $api = '/' . ltrim($api, '/');

        $curl = curl_init($this->codebaseUrl . $api);
        curl_setopt_array($curl, array(
            CURLOPT_HTTPHEADER => array(
                "Accept: application/xml",
                "Content-type: application/xml",
            ),
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_USERPWD => $username . ':' . $apiKey,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $method
        ));

        if (null !== $data) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }

        $ret = curl_exec($curl);
        return array(
            'code' => curl_getinfo($curl, CURLINFO_HTTP_CODE),
            'data' => $ret
        );
    }
}
