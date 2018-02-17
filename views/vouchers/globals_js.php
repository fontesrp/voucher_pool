<?php
/**
 * /views/vouchers/globals_js.php
 *
 * Generates global variables for the applications JavaScripts that mus be
 * acquired from the server
 *
 */
?>

<script type="text/javascript">

    const icons = {
        check: "<?= request_vendor("img/open-iconic/svg/check.svg") ?>",
        x: "<?= request_vendor("img/open-iconic/svg/x.svg") ?>"
    };

    const root_path = "<?= request_absolute("") ?>";

</script>
