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

        <div class="jumbotron bg-white m-3">

            <div id="table-toolbar">

                <form class="form-inline">

                    <?php // `add-voucher-modal` is created on vouchers/new_modal.php ?>
                    <button type="button" id="add-voucher-btn" class="btn btn-primary mr-3" data-toggle="modal" data-target="#add-voucher-modal">
                        <strong>+</strong> Add voucher
                    </button>

                    <div class="input-group mr-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">
                                <img class="icon" src="<?= request_public("img/open-iconic/svg/magnifying-glass.svg") ?>">
                            </span>
                        </div>
                        <input type="search" class="form-control" placeholder="Search">
                    </div>

                    <button type="button" class="btn btn-outline-secondary">
                        <img class="icon" src="<?= request_public("img/open-iconic/svg/cog.svg") ?>">
                    </button>
                </form>

            </div>

            <table id="vouchers-table" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th><input type="checkbox" name="check-all" id="chack-all"></th>
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
