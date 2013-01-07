<?php

namespace CodebaseHq\Hydrator;

use CodebaseHq\Entity;
use SimpleXMLElement;
use DateTime;

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

    public function hydrateXml(SimpleXMLElement $xml, Entity\TicketNote $object)
    {
        $object->setId((int)$xml->id);
        $object->setContent((string)$xml->content);
		$object->setTimeAdded(new DateTime((string)$xml->{'time-added'}));
		$object->setTimeUpdated(new DateTime((string)$xml->{'time-updated'}));
		$object->setUserId((int)$xml->{'user-id'});
		$object->setChanges($xml->{'updates'});
    }

}
