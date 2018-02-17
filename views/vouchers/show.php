<?php
/**
 * /views/vouchers/show
 *
 * This is the main page for the application
 *
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Voucher Pool</title>
    <?= include_dependencies() ?>
    <?php require_once request_view("vouchers/globals_js.php"); ?>
    <?= include_application() ?>
</head>
<body>

    <header>
        <?php require request_view("vouchers/report.php"); ?>
    </header>

    <main>

        <?php require request_view("vouchers/new_modal.php"); ?>
        <?php require request_view("vouchers/update_modal.php"); ?>
        <?php require request_view("recipients/new_modal.php"); ?>
        <?php require request_view("special_offers/new_modal.php"); ?>
        <?php require request_view("vouchers/gen_modal.php"); ?>

        <div class="jumbotron bg-white m-3">

            <div id="table-toolbar">

                <form class="form-inline">

                    <button type="button" id="add-voucher-btn" class="btn btn-primary mr-3" data-toggle="modal" data-target="#add-voucher-modal">
                        <strong>+</strong> Add voucher
                    </button>

                    <div class="input-group mr-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">
                                <img class="icon" src="<?= request_vendor("img/open-iconic/svg/magnifying-glass.svg") ?>">
                            </span>
                        </div>
                        <input id="vouchers-table-search" type="search" class="form-control" placeholder="Search">
                    </div>

                    <div class="dropdown">
                        <button type="button" class="btn btn-outline-secondary" data-toggle="dropdown">
                            <img class="icon" src="<?= request_vendor("img/open-iconic/svg/cog.svg") ?>">
                        </button>
                        <div class="dropdown-menu">
                            <a id="link-mark-as-used" class="dropdown-item" href="#">Mark as used</a>
                            <a id="link-new-recipient" class="dropdown-item" href="#">New recipient</a>
                            <a id="link-new-special-offer" class="dropdown-item" href="#">New special offer</a>
                            <a id="link-generate-vouchers" class="dropdown-item" href="#">Generate vouchers</a>
                        </div>
                    </div>
                </form>

            </div>

            <table id="vouchers-table" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th><input type="checkbox" name="check-all" id="check-all"></th>
                        <th>Code</th>
                        <th>Used</th>
                        <th>Recipient</th>
                        <th>Used at</th>
                    </tr>
                </thead>
            </table>

        </div>
    </main>
</body>
</html>
