<?php

namespace CodebaseHq\Repository;

use CodebaseHq\Entity\TicketNote as TicketNoteEntity;
use CodebaseHq\Entity\Ticket as TicketEntity;
use CodebaseHq\Hydrator\TicketNote as TicketNoteHydrator;
use CodebaseHq\Exception;

use SimpleXMLElement;

class TicketNote extends BaseRepository
{
	
	/**
     * Find notes matching given ticket ID.
     *
     *
     * @param int $ticketId
     * @return TicketNoteEntity[]
     */

    public function find($ticketId)
    {
        $project = $this->api->getProject();

        try {
            $result = $this->api->api("/$project/tickets/$ticketId/notes");
        } catch (Exception\RecordNotFoundException $e) {
            return array();
        }

        $xml = new SimpleXMLElement($result);
        $hydrator = new TicketNoteHydrator();
        $ret = array();

        foreach ($xml as $t) {
            $ticketNote = new TicketNoteEntity();
            $hydrator->hydrateXml($t, $ticketNote);
            $ret[] = $ticketNote;
        }
		
        return $ret;
    }
	
	/**
     * Find ticket-note by its ID
     *
     * @param $id
     * @return \CodebaseHq\Entity\TicketNote
     */
    public function findOneById($ticketId, $ticketNoteId)
    {
        $project = $this->api->getProject();
        $result = $this->api->api("/$project/tickets/$ticketId/notes/$ticketNoteId");
        $xml = new SimpleXMLElement($result);
        $hydrator = new TicketNoteHydrator();
        $ticketNote = new TicketNoteEntity();
        $hydrator->hydrateXml($xml, $ticketNote);
        return $ticketNote;
    }
	
    /**
     * @param int|TicketEntity $ticket
     * @param string $content
     * @param array $changes
     * @param string $timeAdded
     * @return \CodebaseHq\Entity\TicketNote
     */
    public function create($ticket, $content='', $changes = array(), $timeAdded = '')
    {
        if ($ticket instanceof TicketEntity) {
            $ticketId = $ticket->getId();
        } else {
            $ticketId = $ticket;
        }

        $xml =
"<ticket-note>
    <content>$content</content>
    <time-added>$timeAdded</time-added>
    <changes>";

        foreach ($changes as $change => $value) {
            $xml .= "<$change>$value</$change>";
        }

        $xml .= "</changes>\n</ticket-note>";

        $project = $this->api->getProject();
        $xmlElement = new SimpleXMLElement($this->api->api("/$project/tickets/$ticketId/notes", 'POST', $xml));
        $hydrator = new TicketNoteHydrator();
        $ticket = new TicketNoteEntity();
        $hydrator->hydrateXml($xmlElement, $ticket);
        return $ticket;
    }

}
