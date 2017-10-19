<?php
namespace lib\controllers
{

/**
 * Class EventManager
 * Repsonsible for managing events(subject)
 * and observers being bound to.
 *
 * @package lib
 */
class EventManager
{
    /**
     * Subjects Storage
     *
     * @var array
     */
    private $_storage = array();

    /**
     * Singleton's Instance container
     *
     * @var null|object
     */
    private static $_instance=null;

    /**
     * Deny direct instantiation
     *
     * Part of singleton
     */
    private function __construct() { }

    /**
     * Deny Instance Cloning
     *
     * Part of singleton
     */
    private function __clone() { }

    /**
     * Get Instance
     * Part of Singleton implementation
     *
     * @return object EventManager
     */
    public static function getInstance()
    {
        if ( self::$_instance === null
        ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Attach event
     *
     * @param string $event Event Name
     * @param \SplSubject $subject
     */
    public function attachEvent( $event, \SplSubject $subject )
    {
        $this->_storage[ $event ] = $subject;
    }

    /**
     * Detach event
     *
     * @param string $event Event Name
     */
    public function detachEvent( $event )
    {
        unset( $this->_storage[ $event ] );
    }

    /**
     * Attach observer to specified event
     *
     * @param string $event Event Name
     * @param \SplObserver $observer
     * @return bool
     */
    public function attachObserver( $event, \SplObserver $observer )
    {
        if ( isset( $this->_storage[ $event ] )
        ) {
            $this->_storage[ $event ]->attach( $observer );
        }
    }

    /**
     * Detach specified observer from event
     *
     * @param string $event Event Name
     * @param \SplObserver $observer
     */
    public function detachObserver( $event, \SplObserver $observer )
    {
        if ( isset( $this->_storage[ $event ] )
        ) {
            $this->_storage[ $event ]->detach( $observer );
        }
    }

    /**
     * Triggers specified event execution using subjects' method notify.
     *
     * @param $event Event Name
     * @return bool Not Necessary, but for unit testing
     */
    public function fireEvent( $event )
    {
        if ( isset( $this->_storage[ $event ] )
        ) {
            $this->_storage[ $event ]->notify();
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Bulk Attachment
     *      Structure : array(
     *                      Event => array (observer, observer, observer),
     *                      Event => array (observer, observer )
     *                  )
     *
     * @param array $data
     * @return bool
     */
    public function bulkAttach( $data = array() )
    {

        if ( $data !== (array) $data
        ) {
            return FALSE;
        }

        foreach ( $data AS $subject => $observersList
        ) {
            $this->attachEvent( $subject, new \lib\events\UniSubject() );

            if( $observersList === (array) $observersList
            ) {
                foreach( $observersList AS $observer )
                {
                    $obs = '\\lib\\events\\observers\\' . $observer;
                    $this->attachObserver( $subject, new $obs() );
                }
            }
        }
    }

    /**
     * Setter for $link to Data Link to pass to each subject
     *
     * @param \lib\interfaces\DataLinkInterface $link
     */
    public function setDataLink( \lib\interfaces\DataLinkInterface $link )
    {
       foreach ( $this->_storage AS $subject )
       {
           $subject->setDataLink( $link );
       }
    }

    /**
     * Method to pass some required data to subjects
     * that may be required to use by observers.
     *
     * @param array $data
     */
    public function attachData( $data = array() )
    {
        foreach( $this->_storage AS $subject )
        {
                $subject->setData( $data );
        }
    }

    /**
     * Singleton reset for unit testing purposes
     */
    public function reset()
    {
        self::$_instance = NULL;
    }

    /**
     * Is Event Exists ?
     *
     * @param string $event Event Name
     * @return bool
     */
    public function isEventExists( $event )
    {
        return isset( $this->_storage[ $event ] );
    }

    /**
     * Get Specified event or False if not exists
     *
     * @param string $event Event Name
     * @return bool|object
     */
    public function getEvent( $event )
    {
        return ( isset( $this->_storage[ $event ] )
               ? $this->_storage[ $event ]
               : FALSE
               );
    }

    /**
     * Method to allow better testing.
     * Verifies whether supplied observer is bound to
     * specified event.
     *
     * @param string $event Event Name
     * @param object $observer Observer Object
     * @return bool
     */
    public function getObserver( $event, $observer )
    {
        if ( ! $this->isEventExists( $event )
        ) {
            return FALSE;
        }

        return $this->getEvent( $event )
                     ->isObserverExists( $observer );
    }
}

}
