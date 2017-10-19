<?php
namespace lib\events\observers
{
/**
 * Class RenderView - Observer
 *
 * @desc Part of OnSubmit event. Shows Thank You for Posting above comments
 * @package lib\events\observers
 */

class RenderThankYou implements \SplObserver
{
    /**
     * Update - part of SplObserver interface implementation
     * Simply renders "thank you for posting" message
     *
     * @param \SplSubject $subject
     */
    public function update( \SplSubject $subject )
    {
        include BASE_PATH . 'views/thankYou.php';
    }
}

}