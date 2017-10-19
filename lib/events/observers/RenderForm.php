<?php
namespace lib\events\observers
{
/**
 * Class GetComments Observer
 *
 * @package lib\events\observers
 */
class RenderForm implements \SplObserver
{
    /**
     * Update - Part of SplSubject interface implementation
     * Simply renders comment form view.
     * @param \SplSubject $subject
     */
    public function update( \SplSubject $subject )
    {
        include BASE_PATH . 'views/commentForm.php';
    }
}

}