<?php
namespace lib
{
/**
 * Class Commander
 *
 * @author Valentin Ruskvych
 * @package lib
 */
class Commander {
    /**
     * Data Link Object|resource Container
     *
     * @var null
     */
    private $_dataLink = null;

    /**
     * Router Container
     *
     * @var null
     */
    private $_router = null;

    /**
     * Event Manager Container
     *
     * @var null
     */
    private $_eventManager = null;

    /**
     * INIT speaks for itself.
     *      Initializing all necessary modules.
     *      DataLink, Router and Event Manager
     * .
     * @return object $this for chaining methods
     */
    public function init()
    {
        $this->establishDataLink();
        $this->establishRouter();
        $this->loadEventManager();
        return $this;
    }

    /**
     * Establishing DataLink
     *      Developer may specify any DataLink, but,
     *      Will be required to adopt own DbLayer
     *      and rely on DataLinkInterface
     */
    private function establishDataLink()
    {
        $this->_dataLink = new \lib\models\DbLayer();
        $this->_dataLink->setConnection( new \PDO(
            'mysql:dbname=' . DB_NAME . ';host=' . DB_HOST
            ,DB_USER
            ,DB_PWD
        ) );
    }

    /**
     * Instantiate Router
     *      In total, router just finds the event name to fire.
     */
    private function establishRouter()
    {
        $this->_router = new \lib\helpers\Router();
    }

    /**
     * Initialize Event Manager and load with
     * all necessary data. Events, Post data if sent,
     * DataLink to transfer for subject,observers.
     */
    private function loadEventManager()
    {
        $this->_eventManager = \lib\controllers\EventManager::getInstance();

        $this->_eventManager->bulkAttach( $this->_dataLink->fetchEvents() );
        $this->_eventManager->setDataLink( $this->_dataLink );
        if ( isset( $_POST )
        ) {
            $this->_eventManager->attachData($_POST);
        }
    }

    /**
     * Handle Request
     *      Firing event specified by router->findRoute()
     *      Event Firing in event manager expects to return boolean.
     *
     * @return mixed
     */
    public function handleRequest()
    {
        return $this->_eventManager->fireEvent( $this->_router->findRoute() );
    }

    /**
     * Getter for data link. Unit Testing made easy.
     *
     * @return null|object
     */
    public function getDataLink()
    {
        return $this->_dataLink;
    }

    /**
     * Getter for event manager.
     *
     * @return null|object
     */
    public function getEventManager()
    {
        return $this->_eventManager;
    }

    /**
     * Getter for Router Object
     *
     * @return null|object
     */
    public function getRouter()
    {
        return $this->_router;
    }
}
}