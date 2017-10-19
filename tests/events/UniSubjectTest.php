<?php

namespace tests\events;

class UniSubjectTest extends \PHPUnit_Framework_TestCase
{
    protected $instance;

    protected function setUp()
    {
        $this->instance = new \lib\events\UniSubject();
    }

    protected function tearDown()
    {
        $this->instance = NULL;
    }

    public function testSubjectInitializesSplObjectStorage()
    {
        $this->assertNotNull(
            $this->instance->getStorage(),
            'Storage failed to initialize, returned NULL'
        );

        $this->assertTrue(
            ( $this->instance->getStorage() instanceof \SplObjectStorage ),
            'Storage is different than Spl Object Storage, subject relies to work with...'
        );
    }

    public function testAttachingObserver()
    {
        $obs = $this->getMock( '\\lib\\events\\observers\\FindSmilies' );

        $this->instance->attach( $obs );

        $this->assertTrue(
            $this->instance->isObserverExists( $obs ),
            'Oops, observer does not exists. Something failed.'
        );
    }

    public function testAttachDetachObservers()
    {
        $obs = $this->getMock( '\\lib\\events\\observers\\FindSmilies' );

        $this->instance->attach( $obs );

        $this->assertTrue(
            $this->instance->isObserverExists( $obs ),
            'Oops, observer does not exists. Something failed in attach-detach test'
        );

        $this->instance->detach( $obs );

        $this->assertFalse(
            $this->instance->isObserverExists( $obs ),
            'Yet, after detaching, observer does not exists. how come?'
        );
    }


    public function testNotifyObserverFunctioningProperly()
    {
        $dataToSend     = array(
             'author'   =>  'Tester'
            ,'email'    =>  'unknown@yahoo.com'
            ,'comment'  =>  'Unit Testing wipes bugs :)'
        );

        $dataToReceive = array(
             'author'   =>  'Tester'
            ,'email'    =>  'unknown@yahoo.com'
            ,'comment'  =>  'Unit Testing wipes bugs <img src="http://www.lampworketc.com/forums/images/smilies/smile.gif"/>'
        );

        $dbAdapterMock = new \tests\models\DbAdapterMock();
        $observer = new \lib\events\observers\FindSmilies();

        $this->instance->setDataLink( $dbAdapterMock );
        $this->assertTrue(
            $this->instance->getDataLink() instanceof \lib\interfaces\DataLinkInterface,
            'Our DB Adapter Mock is not implements DataLink Interface
            Ensure subject->setDataLink sets dependency injection.'
        );

        $this->instance->attach( $observer );
        $this->assertTrue(
            $this->instance->isObserverExists( $observer ),
            'Could not complete test. Observer did not attached.'
        );

        $this->instance->setData( $dataToSend );
        $this->instance->notify();

        $this->assertEquals(
            $this->instance->getData(),
            $dataToReceive,
            'Smile is not replaced by observer, or, improper image supported in Db Adapter Mock'
        );
    }
}