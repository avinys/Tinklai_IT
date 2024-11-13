<!-- Alert Popup -->
<?php if (isset($_SESSION['alert_message'])): ?>
    <div class="alert-overlay" id="alert-overlay" onclick="closeAlert()">
        <div class="alert-popup" onclick="event.stopPropagation();">
            <p><?= $_SESSION['alert_message'] ?></p>
            <button onclick="closeAlert()">OK</button>
        </div>
    </div>
    <?php unset($_SESSION['alert_message'], $_SESSION['alert_type']); // Clear message after display ?>
<?php endif; ?>
<script>
function closeAlert() {
    document.getElementById('alert-overlay').style.display = 'none';
}
</script>
