<?php
//looping through the errors and viewing them in the page
if (count($errors) > 0) : ?>
    <ul class="list-group">
        <?php foreach ($errors as $error) : ?>
            <li class="list-group-item">
                <div class="alert alert-danger">
                    <?php echo $error; ?>
                </div>
            </li>
        <?php endforeach ?>
    </ul>
<?php endif ?>