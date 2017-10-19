<?php
namespace lib\events\observers
{
/**
 * Class Render Comments
 *
 * @desc Observer that implement \SplSubject interface
 * @package lib\events\observers
 */
class RenderComments implements \SplObserver
{
    /**
     * Update - Part of \SplObserver interface implementation
     * Renders comments received from DB if did.
     * @param \SplSubject $subject
     */
    public function update( \SplSubject $subject )
    {
        $data = $this->getComments( $subject->getDataLink() );
        include BASE_PATH . 'views/CommentsList.php';
    }

    /**
     * Retrieves comments from Data Link (adapter)
     * Unit Testing made easy.
     *
     * @param \lib\interfaces\DataLinkInterface $link
     * @return mixed
     */
    public function getComments( \lib\interfaces\DataLinkInterface $link ){
        return $link->fetchComments();
    }
}

}