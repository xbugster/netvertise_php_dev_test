<?php
namespace lib\events
{

class UniSubject implements \SplSubject
{
    /**
     * SPL Object Storage to store observers in
     *
     * @var SplObjectStorage|null
     */
    private $_storage = null;

    /**
     * Data container
     *
     * @var mixed Array by default
     */
    private $data = array();

    /**
     * Link To Data Adapter
     *      pdo, file handler, xml
     * .
     * @var null
     */
    private $dataLink = null;
    /**
     * Constructor
     *      Is a must for initializing object storage
     */
    public function __construct()
    {
        $this->_storage = new \SplObjectStorage();
    }

    /**
     * Part of SPL Subject interface implementation
     *      Observers attachment
     *
     * @param \SplObserver $observer
     */
    public function attach( \SplObserver $observer )
    {
        $this->_storage->attach( $observer );
    }

    /**
     * Part of SPL Subject interface implementation
     *      Observers detachment
     *
     * @param \SplObserver $observer
     */
    public function detach( \SplObserver $observer )
    {
        $this->_storage->detach( $observer );
    }

    /**
     * Part of SPL Subject interface implementation
     *      Notify observers of changed occurred
     */
    public function notify()
    {
        foreach($this->_storage AS $observer) {
            $observer->update($this);
        }
    }

    /**
     * Setter for data for observers to use
     *
     * @param array $data
     */
    public function setData( $data )
    {
        $this->data = $data;
    }

    /**
     * Getter for data. Used by observers
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Setter for Data Link to use for observers
     *
     * @param \lib\interfaces\DataLinkInterface $link
     */
    public function setDataLink( \lib\interfaces\DataLinkInterface $link )
    {
        $this->dataLink = $link;
    }

    /**
     * Returns Data Link, used by Observers
     *
     * @return object|resource
     */
    public function getDataLink()
    {
        return $this->dataLink;
    }

    /**
     * Method for unit testing.
     * Name says it all: "Is Observer Exists ?"
     *
     * @param $observer
     * @return bool
     */
    public function isObserverExists( $observer )
    {
        return $this->_storage->contains( $observer );
    }

    /**
     * For unit testing the storage initialization
     *
     * @return SplObjectStorage|null
     */
    public function getStorage()
    {
        return $this->_storage;
    }
}

}