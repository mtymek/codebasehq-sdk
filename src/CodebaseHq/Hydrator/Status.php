<?php

namespace CodebaseHq\Hydrator;

use CodebaseHq\Entity;

use SimpleXMLElement;

/**
 * Helper class that converts XML into Ticket entity
 */
class Status
{

    public function hydrateXml(SimpleXMLElement $xml, Entity\Status $object)
    {
        $object->setId((int)$xml->{'id'});
        $object->setName((string)$xml->{'name'});
        $object->setColour((string)$xml->{'colour'});
        $object->setOrder((int)$xml->{'order'});
        $object->setTreatAsClosed((bool)$xml->{'treat-as-closed'});
    }

}
