<?php
namespace tests\events\observers;

class RenderCommentsTest extends \PHPUnit_Framework_TestCase
{
    public function testIsRenderCommentsFetchesExpectedDataFromDataLink()
    {
        $dataToExpect = array(
            0=>array(
                'author'   =>  'VR'
            ,'email'    =>  'xbug@gmail.com'
            ,'comment'  =>  'Smurfs, go away ! :-)'
            ),
            1=>array(
                'author'   =>  'Unidetified Walker'
            ,'email'    =>  'unknown@gmail.com'
            ,'comment'  =>  'Englightened Ownage :P'
            )
        );

        $observer = new \lib\events\observers\RenderComments();

        $this->assertEquals(
            $observer->getComments( new \tests\models\DbAdapterMock() ),
            $dataToExpect,
            'DbAdapterMock returned not expected data.'
        );
    }
}