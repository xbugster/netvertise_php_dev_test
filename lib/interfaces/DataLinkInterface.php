<?php
namespace lib\interfaces
{
/**
 * Data Link Interface - The Data Adapter's Interface
 * To enforce developers follow guidelines
 * Data access must implement ways to store comment,
 * fetch comments, fetch events, and set the Data object/resource as
 * Data Link and fetch smilies.
 * No matter which way used. Be it PDO, XML, Plain Text or any other.
 *
 * @author Valentin Ruskvych
 * @package \lib\interfaces
 */
interface DataLinkInterface
{
    /**
     * Enforce implementation of fetching comments function
     */
    public function fetchComments();

    /**
     * Enforce implementation of comments saving way.
     *
     * @param array $data
     */
    public function storeComment( $data = array() );

    /**
     * Enforce implementation of fetching event
     * to prevent event manager failing.
     */
    public function fetchEvents();

    /**
     * Enforce set resource/object of Data Link
     *
     * @param resource|object $link
     */
    public function setConnection($link);

    /**
     * Enforce developers to set proper smilies fetcher
     */
    public function fetchSmilies();
}

}