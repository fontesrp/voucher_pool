<div class="modal fade" id="upd-voucher-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Update voucher</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <?php require_once request_view("vouchers/update.php"); ?>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="upd-voucher-modal-close">Close</button>
                <button type="button" class="btn btn-primary" id="upd-voucher-modal-save">Save</button>
            </div>

        </div>
    </div>
</div>
