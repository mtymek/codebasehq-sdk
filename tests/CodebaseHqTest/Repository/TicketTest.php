<?php

namespace CodebaseHqTest;

use CodebaseHq\Repository\Ticket as TicketRepo;

class TicketTest extends \PHPUnit_Framework_TestCase
{

    public function testFindCreatesEntitiesFromXml()
    {
        $mock = $this->getMock('CodebaseHq\Api', array('api', 'getProject'));
        $mock->expects($this->once())->method('getProject')
            ->will($this->returnValue('project'));
        $mock->expects($this->once())->method('api')
            ->with('/project/tickets?query=&page=1', 'GET')
            ->will($this->returnValue(
                    '<tickets><ticket><ticket-id type="integer">1</ticket-id><summary>Foo</summary></ticket>
                    <ticket><ticket-id type="integer">2</ticket-id><summary>Bar</summary></ticket></tickets>'
            ));

        $repo = new TicketRepo($mock);

        $tickets = $repo->find();

        $this->assertInstanceOf('CodebaseHq\Entity\Ticket', $tickets[0]);
        $this->assertEquals(1, $tickets[0]->getId());
        $this->assertEquals('Foo', $tickets[0]->getSummary());
        $this->assertInstanceOf('CodebaseHq\Entity\Ticket', $tickets[1]);
        $this->assertEquals(2, $tickets[1]->getId());
        $this->assertEquals('Bar', $tickets[1]->getSummary());
    }

    public function testGetTicket()
    {
        $mock = $this->getMock('CodebaseHq\Api', array('api', 'getProject'));
        $mock->expects($this->once())->method('getProject')
            ->will($this->returnValue('project'));
        $mock->expects($this->once())->method('api')
            ->with('/project/tickets/124', 'GET')
            ->will($this->returnValue(
                    '<ticket><ticket-id type="integer">124</ticket-id><summary>Foo</summary></ticket>'
            ));

        $repo = new TicketRepo($mock);
        $ticket = $repo->findOneById(124);

        $this->assertInstanceOf('CodebaseHq\Entity\Ticket', $ticket);
        $this->assertEquals(124, $ticket->getId());
        $this->assertEquals('Foo', $ticket->getSummary());
    }

}
