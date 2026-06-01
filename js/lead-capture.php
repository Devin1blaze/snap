<?php
/**
 * Snap Marketing - Lead Capture and B2B Script
 */
?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Lead Capture Logic: Detect when user stops typing in quote fields
    const quoteFields = document.querySelectorAll('.snap-quote-field');
    let captureTimeout;

    quoteFields.forEach(field => {
        field.addEventListener('input', function() {
            clearTimeout(captureTimeout);
            captureTimeout = setTimeout(() => {
                const formData = new FormData();
                formData.append('action', 'snap_capture_lead');
                formData.append('field_name', field.name);
                formData.append('field_value', field.value);
                formData.append('product_id', field.dataset.productId || '');

                fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                    method: 'POST',
                    body: formData
                });
            }, 2000); // Capture after 2 seconds of inactivity
        });
    });
});
</script>
