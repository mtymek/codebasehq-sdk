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
