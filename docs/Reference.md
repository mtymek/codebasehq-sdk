PHP SDK for Codebase HQ API - Reference
=======================================

1. Tickets
----------

### 1.1. Querying tickets

#### findTickets(projectName, query)

Example:

    $tickets = $client->findTickets('my_project', 'assignee:me status:closed');


#### getTicket(projectName, ticketId)

Loads and returns ticket with given ID. Throws exception if it cannot be found.

Example:

    $ticket = $client->getTicket('my_project', 124);
