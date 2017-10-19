<?php
namespace lib\models
{

/**
 * Class DbLayer - Adapter
 *
 * Implements DataLinkInterface to force developers to create
 *      Methods fetchComments, storeComment, fetchEvents, fetchSmilies
 *      and not less important - set the link to data object.
 *      No matter which way of storing data will be chosen, be it
 *      pdo,xml,plain text, etc.
 *
 * @author Valentin Ruskvych
 * @package lib\models
 */
class DbLayer implements \lib\interfaces\DataLinkInterface
{
    /**
     * DataLink container
     *
     * @var null
     */
    private $_link = null;

    /**
     * fetchComments - Part of DataLinkInterface implementation
     *      In our case, we use PDO, proper fetching mechanism.
     *
     * @return array|bool
     */
    public function fetchComments()
    {
        return $this->_link->query('SELECT * FROM comments ORDER BY id DESC')->fetchAll();
    }

    /**
     * storeComment - Part of DataLinkInterface Implementation
     *      PDO stores the comment into DB
     *
     * @param array $data
     * @return void
     */
    public function storeComment( $data = array() )
    {
        $query = $this->_link->prepare(
            'INSERT INTO comments (`author`, `email`, `comment`)
             VALUES (:author, :email, :comment)'
        );
        $query->execute($data);
    }

    /**
     * fetchEvents - Part of DataLinkInterface Implementation
     *      Responsible for fetch events that later passed
     *      to event manager and bound as subject-observer
     *
     * Note: This function should pass little refactoring to allow
     *       much more flexibility together with improved Router Class
     *
     * @return array|mixed
     */
    public function fetchEvents()
    {
        return $this->normalizeFetchedEvents( $this->_link->query('SELECT * FROM events ORDER BY id ASC')->fetchAll() );
    }

    /**
     * Setter for DataLink
     *
     * @param object|resource $link
     * @return void
     */
    public function setConnection( $link )
    {
        $this->_link = $link;
    }

    /**
     * Refactor fetched events array to array
     * structure accepted by event manager
     *
     * @param $data
     * @return array
     */
    public function normalizeFetchedEvents( $data )
    {
        $array = array();
        foreach( $data AS $events ) {
            if( isset( $events[ 'event' ] )
                && isset( $events[ 'observer' ] )
            ) {
               $array[ $events[ 'event' ] ][] = $events[ 'observer' ];
            }
        }
        return $array;
    }

    /**
     * Fetch Smiles of Data Link
     *
     * @return mixed
     */
    public function fetchSmilies()
    {
        return $this->_link->query('SELECT * FROM smilies')->fetchAll();
    }
}

}