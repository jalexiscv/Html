<?php if (isset($errors) && $errors !== []) : ?>
    <div class="errors" role="alert">
        <ul>
            <?php foreach ($errors as $error) : ?>
                <li><?= ($error) ?></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif ?>
