<?php
namespace tests;

class CommanderTest extends \PHPUnit_Framework_TestCase
{
    protected $_commander = NULL;

    protected function setUp()
    {
        $this->_commander = new \lib\Commander;
    }

    protected function tearDown()
    {
        $this->_commander = NULL;
    }

    public function testIsCommanderInstantiates()
    {
        $this->assertNotNull( $this->_commander );
    }

    public function testCommanderInitializationDoneAndBasementEstablished()
    {
        $this->assertTrue   (
                            $this->_commander->init() instanceof $this->_commander,
                            'Seems like Commander\'s Init() did not return Instance (Fails).'
                            );

        $this->assertNotNull(
                            $this->_commander->getDataLink(),
                            'Data Link Is Not Initialized by Commander'
                            );

        $this->assertNotNull(
                            $this->_commander->getEventManager(),
                            'Event Manager is Not Initialized by Commander'
                            );

        $this->assertNotNull(
                            $this->_commander->getRouter(),
                            'Router is Failed to Initialize by Commander'
                            );
    }

    public function testCommanderFireEvent()
    {
        $this->_commander->init();
        $this->assertTrue(
                          $this->_commander->handleRequest(),
                          'Event Firing. Failed, Event Manager returned False'
                         );
    }
}