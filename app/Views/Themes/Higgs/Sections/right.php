<?php
$data = array(
    "messenger" => $messenger,
    "messenger_users" => $messenger_users,
);
?>
<?php if (get_LoggedIn()) { ?>
    <?php echo(view($theme . '\Sections\Right\Header.php', $data)); ?>
    <?php echo(view($theme . '\Sections\Right\Messenger.php', $data)); ?>
<?php } else { ?>
    <?php echo(view($theme . '\Sections\Right\Session.php', $data)); ?>
<?php } ?>