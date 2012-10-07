PHP SDK for Codebase HQ API - Reference
=======================================

1. Tickets
----------

### 1.1. Querying tickets

#### find(query)

Example:

    $client->setProject('project_name');
    $tickets = $client->tickets()->find('assignee:me status:closed');


#### getTicket(projectName, ticketId)

Loads and returns ticket with given ID. Throws exception if it cannot be found.

Example:

    $ticket = $client->tickets()->findOneById(124);


### 1.2. Updating tickets

Example:

    $ticketId = 123;
    $client->ticketNotes()->create($ticketId, 'Note: this will be fixed next month');
