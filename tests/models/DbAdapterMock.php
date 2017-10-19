<?php
namespace tests\models;

class DbAdapterMock implements \lib\interfaces\DataLinkInterface
{
    public function fetchSmilies()
    {
        return array(
             0  =>  array(
                  'smile'       =>  ':)'
                 ,'replacement' => '<img src="http://www.lampworketc.com/forums/images/smilies/smile.gif"/>'
             )
            ,1  =>  array(
                 'smile'        =>  ':-)'
                ,'replacement'  => '<img src="http://www.lampworketc.com/forums/images/smilies/smile.gif"/>'
            )
            ,2  =>  array(
                'smile'         =>':P'
                ,'replacement'  => '<img src="http://www.lampworketc.com/forums/images/smilies/smiley_tongue.gif"/>'
            )
            ,3  =>  array(
                'smile'         =>':-P'
            ,   'replacement'   => '<img src="http://www.lampworketc.com/forums/images/smilies/smiley_tongue.gif"/>'
            )
        );
    }

    public function fetchComments()
    {
        return array(
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
    }

    /**
     * Enforce implementation of comments saving way.
     * @param array $data
     * @return array $data
     */
    public function storeComment($data = array())
    {
        return $data;
    }

    /**
     * Enforce implementation of fetching event
     * to prevent event manager failing.
     * @return mixed
     */
    public function fetchEvents()
    {
        // TODO: Implement fetchEvents() method.
    }

    /**
     * Enforce set resource/object of Data Link
     * @param $link
     * @return mixed
     */
    public function setConnection($link)
    {
        // TODO: Implement setConnection() method.
    }
}