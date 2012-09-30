<?php

namespace CodebaseHq\Hydrator;

use CodebaseHq\Entity;

class TicketNote
{

    public function extractXml(Entity\TicketNote $note)
    {
        $changes = $note->getChanges();
        $xml =
"<ticket-note>
    <content>{$note->getContent()}</content>
    <time-added>{$note->getTimeAdded()}</time-added>
    <changes>";

        foreach ($changes as $change => $value) {
            $xml .= "<$change>$value</$change>";
        }

        $xml .= "</changes>\n</ticket-note>";
        return $xml;

    }

}
