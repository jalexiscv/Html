<?php if (get_LoggedIn()) { ?>
    ${aside_content}
    {% include 'partials/right/messenger.php' %}
<?php } else { ?>
    {% include 'partials/right/session.php' %}
<?php } ?>