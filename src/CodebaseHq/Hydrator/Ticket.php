<?php

namespace CodebaseHq\Hydrator;

use CodebaseHq\Entity;

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
//        $object->setCategory((string)$xml->{'category'});
        $object->setUpdatedAt(new DateTime((string)$xml->{'updated-at'}));
        $object->setCreatedAt(new DateTime((string)$xml->{'created-at'}));
        $object->setProjectId((int)$xml->{'project-id'});
    }

}
