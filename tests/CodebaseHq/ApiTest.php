<?php

namespace CodebaseHqTest;
use CodebaseHq\Api;

class ApiTest extends \PHPUnit_Framework_TestCase
{
    public function testApiAllowsSettingsAccountUserAndApiKey()
    {
        $api = new Api();
        $api->setAccount('account_name');
        $api->setUsername('johndoe');
        $api->setApiKey('secret_key');

        $this->assertEquals('account_name', $api->getAccount());
        $this->assertEquals('johndoe', $api->getUsername());
        $this->assertEquals('secret_key', $api->getApiKey());
    }

    public function testCredentialsCanBeSetWithConstructor()
    {
        $api = new Api('account', 'user', 'key');
        $this->assertEquals('account', $api->getAccount());
        $this->assertEquals('user', $api->getUsername());
        $this->assertEquals('key', $api->getApiKey());
    }

    public function testApiCallsTransport()
    {
        $mock = $this->getMock('CodebaseHq\Tranport\AbstractTransport', array('call'));
        $mock->expects($this->once())->method('call')
            ->with('a/u', 'k', '/projects', 'GET', null)
            ->will($this->returnValue(
                array(
                    'code' => 200,
                    'data' => '<project><name>Test Project</name></project>'
                )
            ));

        $api = new Api('a', 'u', 'k');
        $api->setTransport($mock);
        $result = $api->api('/projects');
        $this->assertEquals('<project><name>Test Project</name></project>', $result);
    }

    public function testApiUsesCurlTransportByDefault()
    {
        $api = new Api();
        $transport = $api->getTransport();
        $this->assertInstanceOf('CodebaseHq\Transport\Curl', $transport);
    }

    public function testExceptionIsThrownWhenAccountIsNotGiven()
    {
        $mock = $this->getMock('CodebaseHq\Tranport\AbstractTransport', array('call'));
        $api = new Api(null, 'u', 'k');
        $api->setTransport($mock);
        $this->setExpectedException('CodebaseHq\Exception\RuntimeException');
        $api->api('/projects');
    }

    public function testExceptionIsThrownWhenUsernameIsNotGiven()
    {
        $mock = $this->getMock('CodebaseHq\Tranport\AbstractTransport', array('call'));
        $api = new Api('a', null, 'k');
        $api->setTransport($mock);
        $this->setExpectedException('CodebaseHq\Exception\RuntimeException');
        $api->api('/projects');
    }

    public function testExceptionIsThrownWhenApiKeyIsNotGiven()
    {
        $mock = $this->getMock('CodebaseHq\Tranport\AbstractTransport', array('call'));
        $api = new Api('a', 'u', null);
        $api->setTransport($mock);
        $this->setExpectedException('CodebaseHq\Exception\RuntimeException');
        $api->api('/projects');
    }

    public function testApiThrowsForbiddenExceptionWhen403IsReturned()
    {
        $mock = $this->getMock('CodebaseHq\Tranport\AbstractTransport', array('call'));
        $mock->expects($this->once())->method('call')
            ->with('a/u', 'k', '/project/time_sessions', 'GET')
            ->will($this->returnValue(
                array(
                    'code' => 403,
                    'data' => null
                )
            ));
        $api = new Api('a', 'u', 'k');
        $api->setTransport($mock);
        $this->setExpectedException('CodebaseHq\Exception\ForbiddenException');
        $api->api('/project/time_sessions', 'GET');
    }

    public function testApiThrowsNotAcceptableExceptionWhen406IsReturned()
    {
        $mock = $this->getMock('CodebaseHq\Tranport\AbstractTransport', array('call'));
        $mock->expects($this->once())->method('call')
            ->with('a/u', 'k', '/project/time_sessions', 'GET')
            ->will($this->returnValue(
                array(
                    'code' => 406,
                    'data' => null
                )
            ));
        $api = new Api('a', 'u', 'k');
        $api->setTransport($mock);
        $this->setExpectedException('CodebaseHq\Exception\NotAcceptableException');
        $api->api('/project/time_sessions', 'GET');
    }

    public function testApiThrowsNotFoundExceptionWhenNonExistentObjectIsRequested()
    {
        $mock = $this->getMock('CodebaseHq\Tranport\AbstractTransport', array('call'));
        $mock->expects($this->once())->method('call')
            ->with('a/u', 'k', '/nonexisting_project', 'GET', null)
            ->will($this->returnValue(
                array(
                    'code' => 404,
                    'data' => null
                )
            ));
        $api = new Api('a', 'u', 'k');
        $api->setTransport($mock);
        $this->setExpectedException('CodebaseHq\Exception\RecordNotFoundException');
        $api->api('/nonexisting_project');
    }

    public function testApiThrowsUnprocessableEntityExceptionWhenParametersAreInvalidForPostMethod()
    {
        $mock = $this->getMock('CodebaseHq\Tranport\AbstractTransport', array('call'));
        $mock->expects($this->once())->method('call')
            ->with('a/u', 'k', '/project/time_sessions', 'POST', '<time-session><invalid /></time-session>')
            ->will($this->returnValue(
                array(
                    'code' => 422,
                    'data' => null
                )
            ));
        $api = new Api('a', 'u', 'k');
        $api->setTransport($mock);
        $this->setExpectedException('CodebaseHq\Exception\UnprocessableEntityException');
        $api->api('/project/time_sessions', 'POST', '<time-session><invalid /></time-session>');
    }

    public function testApiThrowsUnprocessableEntityExceptionWhenParametersAreInvalidForPutMethod()
    {
        $mock = $this->getMock('CodebaseHq\Tranport\AbstractTransport', array('call'));
        $mock->expects($this->once())->method('call')
            ->with('a/u', 'k', '/project/time_sessions', 'POST', '<time-session><invalid /></time-session>')
            ->will($this->returnValue(
                array(
                    'code' => 422,
                    'data' => null
                )
            ));
        $api = new Api('a', 'u', 'k');
        $api->setTransport($mock);
        $this->setExpectedException('CodebaseHq\Exception\UnprocessableEntityException');
        $api->api('/project/time_sessions', 'POST', '<time-session><invalid /></time-session>');
    }

    public function testBuildXmlConvertsArrayToXml()
    {
        $api = new Api();

        $xml = $api->buildXml('time-session', array(
            'id' => 1234,
            'summary' => 'Lorem Ipsum'
        ));
        $this->assertEquals('<time-session><id>1234</id><summary>Lorem Ipsum</summary></time-session>', $xml);
    }

    public function testFindTickets()
    {
        $mock = $this->getMock('CodebaseHq\Tranport\AbstractTransport', array('call'));
        $mock->expects($this->once())->method('call')
            ->with('a/u', 'k', '/project/tickets?query=', 'GET')
            ->will($this->returnValue(array(
                'code' => 200,
                'data' =>
                    '<tickets><ticket><ticket-id type="integer">1</ticket-id><summary>Foo</summary></ticket>
                    <ticket><ticket-id type="integer">2</ticket-id><summary>Bar</summary></ticket></tickets>'
            )));
        $api = new Api('a', 'u', 'k');
        $api->setTransport($mock);

        $api->setProject('project');
        $tickets = $api->findTickets();

        $this->assertInstanceOf('CodebaseHq\Entity\Ticket', $tickets[0]);
        $this->assertEquals(1, $tickets[0]->getId());
        $this->assertEquals('Foo', $tickets[0]->getSummary());
        $this->assertInstanceOf('CodebaseHq\Entity\Ticket', $tickets[1]);
        $this->assertEquals(2, $tickets[1]->getId());
        $this->assertEquals('Bar', $tickets[1]->getSummary());
    }

    public function testGetTicket()
    {
    $mock = $this->getMock('CodebaseHq\Tranport\AbstractTransport', array('call'));
        $mock->expects($this->once())->method('call')
            ->with('a/u', 'k', '/project/tickets/124', 'GET')
            ->will($this->returnValue(array(
                'code' => 200,
                'data' => '<ticket><ticket-id type="integer">124</ticket-id><summary>Foo</summary></ticket>'
            )));
        $api = new Api('a', 'u', 'k');
        $api->setTransport($mock);

        $api->setProject('project');
        $ticket = $api->getTicket(124);

        $this->assertInstanceOf('CodebaseHq\Entity\Ticket', $ticket);
        $this->assertEquals(124, $ticket->getId());
        $this->assertEquals('Foo', $ticket->getSummary());
    }
}
