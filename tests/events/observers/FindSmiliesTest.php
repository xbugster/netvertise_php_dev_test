<?php
namespace tests\events\observers;

class FindSmiliesTest extends \PHPUnit_Framework_TestCase
{
    public function testVerifyObserverProperlyRetrievesSmiles()
    {
        $observer = new \lib\events\observers\FindSmilies();

        $smiles = $observer->getSmilies( new \tests\models\DbAdapterMock() );

        $this->assertEquals(
            $smiles[ 3 ],
            array(
                'smile'         =>':-P'
            ,   'replacement'   => '<img src="http://www.lampworketc.com/forums/images/smilies/smiley_tongue.gif"/>'
            ),
            'Oh, no! Jim, he\'s dead! Third smile is not equals to what we expected.'
        );
    }

    public function testFindSmiliesObserverFunctioningProperly()
    {
        $dataToSend     = array(
         'author'   =>  'Tester'
        ,'email'    =>  'unknown@yahoo.com'
        ,'comment'  =>  'Unit Testing wipes bugs :)'
        );

        $dataToExpect = array(
         'author'   =>  'Tester'
        ,'email'    =>  'unknown@yahoo.com'
        ,'comment'  =>  'Unit Testing wipes bugs <img src="http://www.lampworketc.com/forums/images/smilies/smile.gif"/>'
        );

        $subject = new \lib\events\UniSubject();
        $dbAdapterMock = new \tests\models\DbAdapterMock();
        $observer = new \lib\events\observers\FindSmilies();

        $subject->setDataLink( $dbAdapterMock );
        $this->assertTrue(
            $subject->getDataLink() instanceof \lib\interfaces\DataLinkInterface,
            'Our DB Adapter Mock is not implements DataLink Interface
            Ensure subject->setDataLink sets dependency injection.'
        );

        $subject->attach( $observer );
        $this->assertTrue(
            $subject->isObserverExists( $observer ),
            'Could not complete test. Observer did not attached.'
        );

        $subject->setData( $dataToSend );
        $subject->notify();

        $this->assertEquals(
            $subject->getData(),
            $dataToExpect,
            'Smile is not replaced by observer, or, improper image supported in Db Adapter Mock'
        );
    }
}