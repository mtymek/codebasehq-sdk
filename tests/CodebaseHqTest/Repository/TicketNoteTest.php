<?php

namespace CodebaseHqTest;

use CodebaseHq\Repository\TicketNote as TicketNoteRepo;
use CodebaseHq\Entity\TicketNote as TicketNoteEntity;

class TicketNoteTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateSendsValidXml()
    {
        $mock = $this->getMock('CodebaseHq\Api', array('api', 'getProject'));
        $mock->expects($this->once())->method('getProject')
            ->will($this->returnValue('project'));
        $mock->expects($this->once())->method('api')
            ->with('/project/tickets/199/notes', 'POST',
'<ticket-note>
    <content>Lorem Ipsum</content>
    <time-added></time-added>
    <changes></changes>
</ticket-note>');

        $repo = new TicketNoteRepo($mock);
        $entity = new TicketNoteEntity();
        $entity->setContent('Lorem Ipsum');
        $repo->create(199, $entity);
    }

}
