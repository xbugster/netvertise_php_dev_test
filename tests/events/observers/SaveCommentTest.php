<?php

namespace tests\events\observers;

class SaveCommentTest extends \PHPUnit_Framework_TestCase
{

   public function testIsSaveCommentReturnsExpectedDataForMyPDO()
   {
       $subject     =   new \lib\events\UniSubject();
       $observer    =   new \lib\events\observers\SaveComment();
       $dataToSend  =   array(
                            'author'   =>  'VR'
                           ,'email'    =>  'xbug@gmail.com'
                           ,'comment'  =>  'Smurfs, go away ! :-)'
       );
       $dataToExpect=   array(
                            ':author'  =>  'VR'
                           ,':email'   =>  'xbug@gmail.com'
                           ,':comment' =>  'Smurfs, go away ! :-)'
       );
       $subject->attach( $observer );

       $this->assertTrue(
           $subject->isObserverExists( $observer ),
           'SaveComment Observer Failed to attach to Subject'
       );

       $subject->setDataLink( new \tests\models\DbAdapterMock() );

       $this->assertNotNull(
           $subject->getDataLink(),
           'DataLink returned null, indicates that not initialized somehow.'
       );

       $subject->setData( $dataToSend );

       $this->assertEquals(
           $subject->getData(),
           $dataToSend,
           'Data that just sent seems not to be equal'
       );

       $this->assertEquals(
           $observer->update( $subject ),
           $dataToExpect,
           'Returned data did not met required format...'
       );
   }
}