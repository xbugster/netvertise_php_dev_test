<?php
namespace lib\events\observers
{
/**
 *  Class FindSmilies : Observer
 *  Implements \SplObserver interface.
 *  Observer responsible for replacing smiles in string.
 *
 * @package lib\events\observers
 */
class FindSmilies implements \SplObserver
{

    /**
     * Update() - Part of \SplObserver Implementation
     * Replaces smiles and sets modified data back to subject.
     *
     * @param \SplSubject $subject
     */
    public function update( \SplSubject $subject )
    {
        $smilies = $this->getSmilies( $subject->getDataLink() );
        $data = $subject->getData();

        foreach( $smilies AS $smile )
        {
            $data[ 'comment' ] = str_replace(
                $smile[ 'smile' ],
                $smile[ 'replacement' ],
                $data[ 'comment' ]
            );
        }

        $subject->setData($data);
    }

    /**
     * Method to get smilies from database using existing $link
     * Allows better unit testing
     *
     * @param \lib\interfaces\DataLinkInterface $link
     * @return array
     */
    public function getSmilies( \lib\interfaces\DataLinkInterface $link ){
        return $link->fetchSmilies();
    }
}

}