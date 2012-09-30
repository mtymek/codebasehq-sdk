<?php

namespace CodebaseHq\Hydrator;

use CodebaseHq\Entity;

use SimpleXMLElement;

/**
 * Helper class that converts XML into Ticket entity
 */
class Category
{

    public function hydrateXml(SimpleXMLElement $xml, Entity\Category $object)
    {
        $object->setId((int)$xml->{'id'});
        $object->setName((string)$xml->{'name'});
    }

}
