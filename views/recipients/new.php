<?php
/**
 * /views/recipients/new.php
 *
 * Form for creating a new recipient. Since it's used only inside a modal in the
 * main application page, it doesn't need the standard HTML page tags.
 *
 */
?>

<form id="new-recipient-form">

    <div class="form-group ui-widget">
        <label for="new-recipient-name">Name</label>
        <input type="text" class="form-control" id="new-recipient-name" name="name" placeholder="John Snow">
    </div>

    <div class="form-group ui-widget">
        <label for="new-recipient-email">Email</label>
        <input type="email" class="form-control" id="new-recipient-email" name="email" placeholder="name@example.com">
    </div>

</form>
