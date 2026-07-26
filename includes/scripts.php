<script>
    window.KNIYOT = {
        lang: <?php echo json_encode($_SESSION['lang']); ?>,
        currency: <?php echo json_encode($_SESSION['currency']); ?>,
        isLoggedIn: <?php echo is_logged_in() ? 'true' : 'false'; ?>
    };
</script>
<script src="assets/app.js"></script>