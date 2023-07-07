<?php

require_once('session.php');

function getMessageClassName(Message $m) {
    switch($m->getType()) {
        case Type::Error:
            return 'error';
        case Type::Warning:
            return 'warning';
        case Type::Success:
            return 'success';
        case Type::Info:
            return 'info';
        case Type::Debug:
            return 'debug';
        default:
            return '';
    }
}

function displayMessages(?Type $type = null) {
    $messages = Session::getMessages($type);

    if(!empty($messages)):
?>
        <div class="messages">
<?php   foreach($messages as $m): ?>
            <p class="<?= getMessageClassName($m) ?>"><?= $m->getText() ?></p>
<?php   endforeach; ?>
        </div>
<?php
    endif;
}