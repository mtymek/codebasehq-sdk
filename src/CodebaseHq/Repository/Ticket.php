<?php

namespace CodebaseHq\Repository;

use CodebaseHq\Entity\Ticket as TicketEntity;
use CodebaseHq\Hydrator\Ticket as TicketHydrator;
use CodebaseHq\Exception;

use SimpleXMLElement;

class Ticket extends BaseRepository
{

    /**
     * Find tickets matching given query.
     *
     * Query is the same string that you can put in Codebase HQ search form,
     * Example query: "assignee:will status:closed".
     *
     * @param string $query
     * @return TicketEntity[]
     */
    public function find($query = '', $page = 1)
    {
        $project = $this->api->getProject();
        try {
            $params = array(
                'query' => $query,
                'page' => $page
            );
            $result = $this->api->api("/$project/tickets?" . http_build_query($params));
        } catch (Exception\RecordNotFoundException $e) {
            return array();
        }
        $xml = new SimpleXMLElement($result);
        $hydrator = new TicketHydrator();
        $ret = array();
        foreach ($xml->ticket as $t) {
            $ticket = new TicketEntity();
            $hydrator->hydrateXml($t, $ticket);
            $ret[] = $ticket;
        }
        return $ret;
    }

    /**
     * Find ticket by its ID
     *
     * @param $id
     * @return \CodebaseHq\Entity\Ticket
     */
    public function findOneById($id)
    {
        $project = $this->api->getProject();
        $result = $this->api->api("/$project/tickets/$id");
        $xml = new SimpleXMLElement($result);
        $hydrator = new TicketHydrator();
        $ticket = new TicketEntity();
        $hydrator->hydrateXml($xml, $ticket);
        return $ticket;
    }

    /**
     * Create new ticket
     *
     * @param $summary
     * @param string $description
     * @return \CodebaseHq\Entity\Ticket
     */
    public function create($summary, $description='')
    {
        $project = $this->api->getProject();
        $xml =
"<ticket><summary>$summary</summary><description>$description</description></ticket>";
        $xmlElement = new SimpleXMLElement($this->api->api("/$project/tickets", 'POST', $xml));
        $hydrator = new TicketHydrator();
        $ticket = new TicketEntity();
        $hydrator->hydrateXml($xmlElement, $ticket);
        return $ticket;
    }

}
