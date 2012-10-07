<?php

namespace CodebaseHq\Hydrator;

use CodebaseHq\Entity;

use CodebaseHq\Hydrator\Category as CategoryHydrator;
use CodebaseHq\Hydrator\Priority as PriorityHydrator;
use CodebaseHq\Hydrator\Status as StatusHydrator;

use DateTime;
use SimpleXMLElement;

/**
 * Helper class that converts XML into Ticket entity
 */
class Ticket
{

    public function hydrateXml(SimpleXMLElement $xml, Entity\Ticket $object)
    {
        $object->setId((int)$xml->{'ticket-id'});
        $object->setSummary((string)$xml->{'summary'});
        $object->setTicketType((string)$xml->{'ticket-type'});
        $object->setReporterId((int)$xml->{'reporter-id'});
        $object->setReporter((string)$xml->{'reporter'});
        $object->setAssigneeId((int)$xml->{'assignee-id'});
        $object->setAssignee((string)$xml->{'assignee'});
        $object->setUpdatedAt(new DateTime((string)$xml->{'updated-at'}));
        $object->setCreatedAt(new DateTime((string)$xml->{'created-at'}));
        $object->setProjectId((int)$xml->{'project-id'});

        if ($xml->category) {
            $categoryHydrator = new CategoryHydrator();
            $category = new Entity\Category();
            $categoryHydrator->hydrateXml($xml->category, $category);
            $object->setCategory($category);
        }

        if ($xml->status) {
            $statusHydrator = new StatusHydrator();
            $category = new Entity\Status();
            $statusHydrator->hydrateXml($xml->status, $category);
            $object->setStatus($category);
        }

        if ($xml->priority) {
            $statusHydrator = new PriorityHydrator();
            $category = new Entity\Priority();
            $statusHydrator->hydrateXml($xml->priority, $category);
            $object->setPriority($category);
        }
    }


}
