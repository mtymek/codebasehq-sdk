<?php

namespace CodebaseHq\Repository;

use CodebaseHq\Entity\Ticket as TicketEntity;
use CodebaseHq\Hydrator\Ticket as TicketHydrator;
use CodebaseHq\Exception;

use SimpleXMLElement;

class Ticket extends BaseRepository
{

    /**
     * Find tickets
     *
     * @param string $query
     * @return TicketEntity[]
     */
    public function find($query = '')
    {
        $project = $this->api->getProject();
        try {
            $result = $this->api->api("/$project/tickets?query=" . urlencode($query));
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

}
