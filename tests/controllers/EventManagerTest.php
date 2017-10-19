<?php
namespace tests\controllers;

class EventManagerTest extends \PHPUnit_Framework_TestCase
{
    protected $instance = null;

    protected function setUp()
    {
        $this->instance = \lib\controllers\EventManager::getInstance();
    }

    protected function tearDown()
    {
        $this->instance->reset();
    }

    private function helperGetSubjectMock(){
        return $this->getMock('\\lib\\events\\UniSubject');
    }

    public function testVerifyThatGetEventKnowsToReturnFalseWhenNoEventsInInside()
    {
        $this->assertFalse(
                          $this->instance->getEvent( 'EventToFail' ),
                          'How do the getEvent returned other value than False
                           on unexisting event?'
        );
    }

    public function testVerifyThatGetEventKnowsToReturnFalseWhenEventsInButUnexsistingRequested()
    {
        $eventName = 'exsistingEvent';
        $fakeEvent = 'failEvent';
        $stubSubject = $this->helperGetSubjectMock();
        $this->instance->attachEvent( $eventName, $stubSubject );

        $this->assertFalse(
                          $this->instance->getEvent( $fakeEvent ),
                          'getEvent returned value different than FALSE on request
                           of unexisting event when events attached'
        );
    }

    public function testIsEventExistsKnowsToFail()
    {
        $this->assertFalse(
                           $this->instance->isEventExists( 'FailEvent' ),
                           'How Come IsEventExists returned true on unexisting event? Check this.'
        );
    }

    public function testAttachAndDetachEvents()
    {
        $eventName = 'TryFailingEventManager';
        $stubSubject = $this->helperGetSubjectMock();
        $this->instance->attachEvent( $eventName, $stubSubject );

        $this->assertTrue(
                         $this->instance->isEventExists( $eventName ),
                         'Uhm, Mock is failed to attach to event manager.'
        );

        $this->assertEquals(
                           $this->instance->getEvent( $eventName ),
                           $stubSubject,
                           'O.o Stub is not equals to attached Stub? Something going wrong'
        );

        $this->instance->detachEvent( $eventName );

        $this->assertFalse(
                          $this->instance->isEventExists( $eventName ),
                          'After event detachement - isEventExists yet reports of existing event.'
        );
    }

    public function testFireUnexsistantEvent()
    {
        $eventName = 'theEvent';
        $fakeEvent = 'unexistantEvent';
        $stubSubject = $this->helperGetSubjectMock();
        $this->instance->attachEvent( $eventName, $stubSubject );

        $this->assertFalse(
                          $this->instance->fireEvent( $fakeEvent ),
                          'How come unexsisting event fired and returned true? Check the flow'
        );
    }

    public function testFireExistingEvent()
    {
        $eventName = 'testEvent';
        $stubSubject = $this->helperGetSubjectMock();
        $this->instance->attachEvent( $eventName, $stubSubject );

        $this->assertTrue(
                         $this->instance->fireEvent( $eventName ),
                         'Why false returned on firing existing event?'
        );
    }

    public function testBulkAttachmentOfSubjectOccursProperly()
    {
        $eventsArray = array(
            'eventOne'=>array()
           ,'eventTwo'=>array()
           ,'eventThree'=>array()
        );

        $this->instance->bulkAttach( $eventsArray );

        foreach( $eventsArray AS $k=>$v )
        {
            $this->assertTrue(
                $this->instance->getEvent( $k ) instanceof \lib\events\UniSubject,
                'How come just bound event already null?'
            );
        }
    }

    public function testBulkAttachmentFailsOnNonArrayPass()
    {
        $eventsArray = 'string:)';

        $this->assertFalse(
                          $this->instance->bulkAttach( $eventsArray ),
                          'Assert ended up without false, bound string? Inspect it.'
        );
    }

    public function dataProviderForObserver()
    {
        return array(
            array( '\\lib\\events\\observers\\FindSmilies' ),
            array( '\\lib\\events\\observers\\RenderComments' ),
            array( '\\lib\\events\\observers\\RenderForm' ),
            array( '\\lib\\events\\observers\\RenderThankYou' ),
            array( '\\lib\\events\\observers\\SaveComment' )
        );
    }

    /**
     * @dataProvider dataProviderForObserver
     */
    public function testSingleObserversOneByOneIsSuccessfullyAttached( $observerNamespace )
    {
        $eventName = 'DummyEvent';
        $observer  = new $observerNamespace;

        $subject = new \lib\events\UniSubject;

        $this->instance->attachEvent( $eventName, $subject );

        $this->assertTrue(
                          $this->instance->getEvent( $eventName ) instanceof \lib\events\UniSubject,
                          'Probably event is not bound in Single Observer Attachment Test'
        );

        $this->instance->attachObserver( $eventName, $observer );

        $this->assertTrue(
                          $this->instance->getObserver( $eventName, $observer ),
                          'Failed asserting that observer exists is true.'
        );
    }

    /**
     * @dataProvider dataProviderForObserver
     */
    public function testSingleObserversOneByOneIsSuccessfullyAttachedThenDetached( $observerNamespace )
    {
        $eventName = 'DummyEvent';
        $observer  = new $observerNamespace;

        $subject = new \lib\events\UniSubject;

        $this->instance->attachEvent( $eventName, $subject );

        $this->assertTrue(
            $this->instance->getEvent( $eventName ) instanceof \lib\events\UniSubject,
            'Probably event is not bound in Single Observer Attachment-Detachment Test'
        );

        $this->instance->attachObserver( $eventName, $observer );

        $this->assertTrue(
            $this->instance->getObserver( $eventName, $observer ),
            'Failed asserting that observer exists is true and inside subject\'s storage'
        );

        $this->instance->detachObserver( $eventName, $observer );

        $this->assertFalse(
            $this->instance->getObserver( $eventName, $observer ),
            'Event Manager failed detaching Observer.'
        );
    }

    public function testIsEventManagerAttachesDataToSubjectsProperly()
    {
        $eventName = 'testableEvent';
        $subject = new \lib\events\UniSubject;

        $testData = array(
            0=>'a',
            1=>'b',
            2=>'c',
            'a'=>1,
            'b'=>2,
            'c'=>3
        );

        $this->instance->attachEvent( $eventName, $subject );

        $this->assertTrue(
            $this->instance->getEvent( $eventName ) instanceof \lib\events\UniSubject,
            'Probably event is not bound in attachData test'
        );

        $this->instance->attachData( $testData );

        $this->assertEquals(
            $this->instance->getEvent( $eventName )->getData(),
            $testData,
            'uhm? Event manager screwed up the data while assigning to subjects...'
        );
    }

    public function testDataLinkSetsToSubjectsProperlyThroughEventManager()
    {
        $eventName = 'testEvent';
        $subject = new \lib\events\UniSubject;
        $stubDataLink = $this->getMock('\\lib\\models\\DbLayer');


        $this->instance->attachEvent( $eventName, $subject );

        $this->assertTrue(
            $this->instance->getEvent( $eventName ) instanceof \lib\events\UniSubject,
            'Probably event is not bound in setDataLink test'
        );

        $this->instance->setDataLink( $stubDataLink );

        $this->assertEquals(
            $this->instance->getEvent( $eventName )->getDataLink(),
            $stubDataLink,
            'Oops. Event Manager test received different data link object than sent'
        );
    }

}