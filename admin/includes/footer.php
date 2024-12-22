</main>

<!-- <div class="footer">
    <div class="container-fluid">
        <div class="row text=text-muted">
            <div class="col-12 text-end">
                <p style="padding-top: 10px; padding-bottom: 10px">
                    <a href="index.php" class="text-muted">
                        <strong>HausMaster</strong>
                    </a>
                </p>
            </div>
        </div>
    </div>
</div> -->
</div>
</div>

<!-- JQUERY FILE -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

<!-- BOOTSTRAP JS BUNDLE -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- FONT AWESOME -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>


<!-- JS FILE -->
<script src="../assets/js/script.js"></script>

<!-- ALERTIFY JS -->
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>

<!-- DATATABLES URL -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<!-- Dropify JS -->
<script src="https://cdn.jsdelivr.net/npm/dropify@0.2.2/dist/js/dropify.min.js"></script>

<!-- SWEET ALERT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<script>
        // datatable
    $(document).ready(function() {
        $('#myTable').DataTable();
    });

    $(document).ready(function() {
        // Initialize Dropify
        $('.dropify').dropify();
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php if (isset($_SESSION['message'])): ?>
        Swal.fire({
            title: "<?php echo $_SESSION['message']; ?>",
            icon: "<?php echo $_SESSION['message_type']; ?>",
            confirmButtonText: 'OK',
            customClass: {
                popup: 'custom-popup',
                title: 'custom-title',
                content: 'custom-content',
                confirmButton: 'custom-confirm'
            }
        });
        <?php unset($_SESSION['message']); ?>
        <?php endif; ?>
    });
</script>


<script>

    function goBack()
     {
        window.history.back(); // Goes back to the previous page
    }

</script>

</body>

</html>