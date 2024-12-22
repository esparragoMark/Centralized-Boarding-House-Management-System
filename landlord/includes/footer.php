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

<!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> -->

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

<!-- EDIT ROOM JS FILE -->
<script src="../assets/js/custom.js"></script>

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
function goBack() {
    window.history.back(); // Goes back to the previous page
}


// SWEET ALERT FOR DELETING TENANT

$(document).ready(function() {
    $('.deleteTenant').on('click', function(e) {

        e.preventDefault();
        var tenant_id = $(this).data('occupant_id');

        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: 'POST',
                        url: 'delete_tenant.php',
                        data: {
                            'occupant_id': tenant_id,
                            'deleteTenant': true
                        },
                        success: function(response) {
                            console.log(response);
                            if (response == 200) {
                                swal("Success!", "Tenant deleted Successfully!",
                                    "success");
                                // $("#tenant_refresh").load('record.php #tenant_refresh');
                                setTimeout(function() {
                                    location.reload();
                                }, 1500);
                            } else if (response == 500) {
                                swal("Error!", "Something went wrong!", "error");
                            }
                        },
                    });
                }
            });

    });
});


// SWEET ALERT FOR DELETING BED

$(document).ready(function() {
    $('.deleteBedBtn').on('click', function(e) {

        e.preventDefault();
        var bedId = $(this).data('bed_id');

        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: 'POST',
                        url: 'delete_bed.php',
                        data: {
                            'bed_id': bedId,
                            'deleteBedBtn': true
                        },
                        success: function(response) {
                            console.log(response);
                            if (response == 200) {
                                swal("Success!", "Bed deleted Successfully!",
                                "success");
                                // $("#bed_refresh").load(location.href + " #bed_refresh");
                                setTimeout(function() {
                                    location.reload();
                                }, 1500);
                            } else if (response == 500) {
                                swal("Error!", "Something went wrong!", "error");
                            }
                        },
                    });
                }
            });


    });
});

// Delete With Sweet Alert for room
$(document).ready(function() {
    $('.deleteBtn').on('click', function(e) {

        e.preventDefault();
        var roomId = $(this).data('room_id');

        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: 'POST',
                        url: 'delete_room.php',
                        data: {
                            'room_id': roomId,
                            'deleteBtn': true
                        },
                        success: function(response) {
                            console.log(response);
                            if (response == 200) {
                                swal("Success!", "Room deleted Successfully!",
                                    "success");
                                // $("#room_refresh").load(location.href + " #room_refresh");
                                setTimeout(function() {
                                    location.reload();
                                }, 1500);
                            } else if (response == 500) {
                                swal("Error!", "Something went wrong!", "error");
                            }
                        },
                    });
                }
            });


    });
});
</script>

<script>
// this part is for payment modal 
$(document).ready(function() {

    $('.payment_btn').on('click', function() {

        var occupant_id = $(this).data('occupant_id');
        var fullname = $(this).data('fullname');
        var room_number = $(this).data('room_number');
        var bed_number = $(this).data('bed_number');
        var monthly_rent = $(this).data('monthly_rent');

        console.log(occupant_id);
        console.log(fullname);
        console.log(room_number);
        console.log(bed_number);
        console.log(monthly_rent);

        $('#occupantId').val(occupant_id);
        $('#occupantName').val(fullname);
        $('#occupant_room_num').text(room_number);
        $('#occupant_bed_num').text(bed_number);
        $('#occupant_rent').text(monthly_rent);
        $('#monthlyRent').val(monthly_rent);

        $('#payment').modal('show');
    });


});
</script>

<script>
//For Geolocation
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    }
}

function showPosition(position) {
    document.querySelector('.credentialForm input[name = "latitude"]').value = position.coords.latitude;
    document.querySelector('.credentialForm input[name = "longitude"]').value = position.coords.longitude;
}

function showError(error) {
    switch (error.code) {
        case error.PERMISSION_DENIED:
            alert("You Must Allow The Request For Geolocation To Fill Out The Form");
            location.reload();
            break;
    }
}
</script>

<script>
// for deleting room images
var deleteModal = document.getElementById('deleteModal');
deleteModal.addEventListener('show.bs.modal', function(event) {
    var button = event.relatedTarget;
    var image = button.getAttribute('data-image');
    var modalImageInput = deleteModal.querySelector('#delete_image');
    modalImageInput.value = image;
});
</script>

<script src="../assets/js/form.js"></script>


</body>

</html>