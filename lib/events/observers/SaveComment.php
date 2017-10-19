<?php
namespace lib\events\observers
{
    /**
     * Class SaveComment
     * Observer responsible for saving the comment using
     * specified Data Link by developer.
     *
     * @package lib\events\observers
     */
class SaveComment implements \SplObserver
{
    /**
     * Required Fields Setting
     *
     * @var array
     */
    private $_requiredFields = array(
         'author'=>0
        ,'email'=>0
        ,'comment'=>0
    );

    /**
     * Part of Implementation of SPL Observer interface
     *      Calls DataLink to store comment
     *
     * @param \SplSubject $subject
     * @return array of refactured data for Data Link, after submitting it
     */
    public function update( \SplSubject $subject )
    {
        $data = $this->prepareArrayKeysForPDO( $subject->getData() );
        return $subject->getDataLink()->storeComment( $data );
    }

    /**
     * Decorate received data (POST at most, expected)
     * for our data link (now it is PDO)
     *      Array key must begin with ":" to successfully
     *      participate in prepare-exec
     *
     * @param array $data
     * @return array
     */
    private function prepareArrayKeysForPDO( $data = array() )
    {
        $array = array();
        foreach($data as $k=>$v)
        {
            if( isset( $this->_requiredFields[ $k ] )
            ) {
                $array[ ':' . $k ] = $v;
            }
        }

        return $array;
    }
}

}