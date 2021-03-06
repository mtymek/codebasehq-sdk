<?php

namespace CodebaseHq;

use CodebaseHq\Exception;
use CodebaseHq\Repository\Ticket as TicketRepository;
use CodebaseHq\Repository\TicketNote as TicketNoteRepository;
use CodebaseHq\Transport\AbstractTransport;

use SimpleXMLElement;

class Api
{

    /**
     * @var string
     */
    protected $account;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * Name of current project
     *
     * @var string
     */
    protected $project;

    /**
     * @var AbstractTransport
     */
    protected $transport;

    /**
     * @var TicketRepository
     */
    protected $ticketRepository;

    /**
     * @var TicketNoteRepository
     */
    protected $ticketNoteRepository;

    /**
     * Class constructor
     *
     * Allows setting credentials
     *
     * @param string|null $account
     * @param string|null $username
     * @param string|null $apiKey
     */
    public function __construct($account = null, $username = null, $apiKey = null)
    {
        if ($account) {
            $this->setAccount($account);
        }
        if ($username) {
            $this->setUsername($username);
        }
        if ($apiKey) {
            $this->setApiKey($apiKey);
        }
    }

    /**
     * Make request to CodebaseHQ API
     *
     * @param $endpoint
     * @param string $method
     * @param null $data
     * @return mixed
     * @throws \RuntimeException
     * @throws Exception\NotAcceptableException
     * @throws Exception\UnprocessableEntityException
     * @throws Exception\ForbiddenException
     * @throws Exception\RuntimeException
     * @throws Exception\RecordNotFoundException
     */
    public function api($endpoint, $method = 'GET', $data = null)
    {
        $account = $this->getAccount();
        if (!$account) {
            throw new Exception\RuntimeException("Account is not provided.");
        }
        $username = $this->getUsername();
        if (!$username) {
            throw new Exception\RuntimeException("Username is not provided.");
        }
        $apiKey = $this->getApiKey();
        if (!$apiKey) {
            throw new Exception\RuntimeException("API key is not provided.");
        }

        $result = $this->getTransport()->call($account . '/' . $username, $apiKey, $endpoint, $method, $data);

        if ($result['code'] == 403) {
            throw new Exception\ForbiddenException("Current user does not have access to requested resource");
        }

        if ($result['code'] == 406) {
            throw new Exception\NotAcceptableException("The HTTP verb supplied is not suitable for this action OR the action is not available using the API at this time.");
        }

        switch ($method) {
            case 'GET':
                if ($result['code'] == '404') {
                    throw new Exception\RecordNotFoundException("Requested record not found.", 404);
                } elseif ($result['code'] == '200') {
                    return $result['data'];
                }
                break;
            case 'POST':
                if ($result['code'] == '422') {
                    throw new Exception\UnprocessableEntityException("Unable to process entity.", 422);
                } elseif ($result['code'] == '201') {
                    return $result['data'];
                }
            case 'PUT':
                if ($result['code'] == '422') {
                    throw new Exception\UnprocessableEntityException("Unable to process entity.", 422);
                } elseif ($result['code'] == '200') {
                    return $result['data'];
                }
            case 'DELETE':
                if ($result['code'] == '409') {
                    throw new Exception\UnprocessableEntityException("Conflict: record has dependencies which block the deletion.", 409);
                } elseif ($result['code'] == '200') {
                    return $result['data'];
                }

        }
        throw new \RuntimeException("Unexpected response code ($result[code]) for method $method.");
    }

    /**
     * Helper method that converts PHP array into XML that can be sent to API
     */
    public function buildXml($recordName, $data)
    {
        $xml = "<$recordName>";
        foreach ($data as $key => $value) {
            $xml .= "<$key>$value</$key>";
        }
        $xml .= "</$recordName>";
        return $xml;
    }

    /**
     * @param string $account
     * @return Api provides fluent interface
     */
    public function setAccount($account)
    {
        $this->account = $account;
        return $this;
    }

    /**
     * @return string
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @param string $apiKey
     * @return Api provides fluent interface
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
        return $this;
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param string $username
     * @return Api provides fluent interface
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param AbstractTransport $transport
     * @return Api provides fluent interface
     */
    public function setTransport($transport)
    {
        $this->transport = $transport;
        return $this;
    }

    /**
     * @return AbstractTransport
     */
    public function getTransport()
    {
        if (null === $this->transport) {
            $this->transport = new Transport\Curl();
        }
        return $this->transport;
    }

    /**
     * @param string $projectName
     * @return Api provides fluent interface
     */
    public function setProject($projectName)
    {
        $this->project = $projectName;
        return $this;
    }

    /**
     * @return string
     */
    public function getProject()
    {
        return $this->project;
    }

    // Repository accessors

    /**
     * @return \CodebaseHq\Repository\TicketNote
     */
    public function ticketNotes()
    {
        if (null === $this->ticketNoteRepository) {
            $this->ticketNoteRepository = new TicketNoteRepository($this);
        }
        return $this->ticketNoteRepository;
    }

    /**
     * @return \CodebaseHq\Repository\Ticket
     */
    public function tickets()
    {
        if (null === $this->ticketRepository) {
            $this->ticketRepository = new TicketRepository($this);
        }
        return $this->ticketRepository;
    }

}
