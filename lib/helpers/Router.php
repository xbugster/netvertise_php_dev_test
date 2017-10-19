<?php

namespace lib\helpers
{

/**
 * Class Router
 *      Responsible to find events based on GET
 *      received
 * Note: Router may go through refactoring process
 *       to allow better routing, 404 catchings, etc.
 *
 * @package lib\hrelpers
 */
class Router
{
    /**
     * Current Event container
     *
     * @access private
     * @var null
     */
    private $_event = null;

    /**
     * Trying to find event based on $_GET params received
     * If action(event) found, prepend with "On", otherwise set Default Event.
     *
     * @return string
     */
    public function findRoute()
    {

        if( isset( $_GET[ 'action' ] )
        ) {
            $this->_event = str_replace( chr( 0 ), '', $_GET[ 'action' ] );
        } else {
            $this->_event = DEFAULT_EVENT;
        }

        $this->_event = ( $this->_event !== DEFAULT_EVENT )
                        ? 'On' . $this->_event
                        : DEFAULT_EVENT;

        return $this->_event;
    }
}

}