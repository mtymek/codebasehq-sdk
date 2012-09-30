<?php

namespace CodebaseHq\Hydrator;

use CodebaseHq\Entity;

use SimpleXMLElement;

/**
 * Helper class that converts XML into Ticket entity
 */
class Priority
{

    public function hydrateXml(SimpleXMLElement $xml, Entity\Priority $object)
    {
        $object->setId((int)$xml->{'id'});
        $object->setName((string)$xml->{'name'});
        $object->setColour((string)$xml->{'colour'});
        $object->setDefault((bool)$xml->{'default'});
        $object->setPosition((int)$xml->{'position'});
    }

}
