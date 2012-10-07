<?php

namespace CodebaseHq\Repository;

use CodebaseHq\Entity\TicketNote as TicketNoteEntity;
use CodebaseHq\Hydrator\TicketNote as TicketNoteHydrator;
use CodebaseHq\Exception;

use SimpleXMLElement;

class TicketNote extends BaseRepository
{

    public function create($ticketId, TicketNoteEntity $note)
    {
        $project = $this->api->getProject();
        $hydrator = new TicketNoteHydrator();
        $xml = $hydrator->extractXml($note);
        $this->api->api("/$project/tickets/$ticketId/notes", 'POST', $xml);
    }

}
