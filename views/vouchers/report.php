<?php
/**
 * /views/vouchers/report.php
 *
 * This is the repot shown in the main page of the application. It displays the
 * quantity of vouchers per status.
 *
 */
?>

<div class="jumbotron bg-white m-3">

    <h4>Vouchers status</h4>

    <hr class="my-4">

    <div class="container">
        <div class="row">

            <div class="col text-center">
                <h5 id="generated-vouchers"></h5>
                <small class="text-muted">Generated Vouchers</small>
            </div>

            <div class="col text-center">
                <h5 id="unused-vouchers"></h5>
                <small class="text-muted">Unused Vouchers</small>
            </div>

            <div class="col text-center">
                <h5 id="used-vouchers"></h5>
                <small class="text-muted">Used Vouchers</small>
            </div>

        </div>
    </div>
</div>
