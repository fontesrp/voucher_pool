<div class="modal fade" id="add-special-offer-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add special offer</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <?php require_once request_view("special_offers/new.php"); ?>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="add-special-offer-modal-close">Close</button>
                <button type="button" class="btn btn-primary" id="add-special-offer-modal-save">Save</button>
            </div>

        </div>
    </div>
</div>
