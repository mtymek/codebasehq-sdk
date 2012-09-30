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

}
