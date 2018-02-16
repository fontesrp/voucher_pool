<div class="modal fade" id="<?= $modal_props["id"] ?>-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title"><?= $modal_props["title"] ?></h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <?php require_once request_view($modal_props["body"]); ?>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="<?= $modal_props["id"] ?>-modal-close">Close</button>
                <button type="button" class="btn btn-primary" id="<?= $modal_props["id"] ?>-modal-save"><?= $modal_props["save"] ?></button>
            </div>

        </div>
    </div>
</div>
