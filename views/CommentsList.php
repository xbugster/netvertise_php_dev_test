<?php
/**
 * Comments List view
 */
?>
<h1>Here is our comments</h1>

<?php

foreach ( $data AS $comment ) {
?>
    <div style="height:10px;width:100%;"></div>
    <div>
        <div><strong>Author:</strong> <?php echo $comment[ 'author' ];?></div>
        <div><strong>Email:</strong> <?php echo $comment[ 'email' ];?></div>
        <div><strong>Comment:</strong></div>
        <div><?php echo $comment[ 'comment' ];?></div>
    </div>
<?
}

?>