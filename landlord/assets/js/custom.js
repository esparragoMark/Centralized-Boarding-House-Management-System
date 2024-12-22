

// FOR EDIT ROOM FORM
$(document).ready(function(){
    $('.editBtn').on('click', function(){
        // Get values from data attributes
        var roomId = $(this).data('room_id');
        var roomName = $(this).data('room_name');
        var gender = $(this).data('gender');
        var capacity = $(this).data('capacity');
        var monthlyRent = $(this).data('monthly_rent');
        var amenities = $(this).data('amenities') ? $(this).data('amenities').split(',') : [];

        // Log all values to the console
        console.log("Room ID:", roomId);
        console.log("Room Name:", roomName);
        console.log("Gender:", gender);
        console.log("Capacity:", capacity);
        console.log("Monthly Rent:", monthlyRent);
        console.log("Amenities:", amenities);

        // Set form values
        $('#editRoomId').val(roomId);
        $('#editRoomName').val(roomName);
        $('#editGender').val(gender);
        $('#editCapacity').val(capacity);
        $('#editMonthlyRent').val(monthlyRent);

        // Set amenities checkboxes
        $('input[name="amenities2[]"]').prop('checked', false); // Uncheck all first
        amenities.forEach(function(amenity) {
            $('input[name="amenities2[]"][value="' + amenity.trim() + '"]').prop('checked', true);
        });

        // Show the modal (ensure modal ID is correct)
        $('#editModal').modal('show');
    });
});




// // Delete With Sweet Alert for room
// $(document).ready(function() {
//     $('.deleteBtn').on('click', function(e) {

//         e.preventDefault();
//         var roomId = $(this).data('room_id');
       
//         swal({
//             title: "Are you sure?",
//             text: "Once deleted, you will not be able to recover",
//             icon: "warning",
//             buttons: true,
//             dangerMode: true,
//           })
//           .then((willDelete) => {
//             if (willDelete) {
//                 $.ajax({
//                     type: 'POST',
//                     url: 'delete_room.php',
//                     data: {'room_id': roomId,
//                          'deleteBtn': true
//                          },
//                     success: function(response) {
//                         console.log(response);
//                         if(response == 200)
//                          {
//                             swal("Success!", "Room deleted Successfully!", "success");
//                             $("#room_refresh").load(location.href + " #room_refresh");
//                         }
//                         else if(response == 500){
//                             swal("Error!", "Something went wrong!", "error");
//                         }
//                     },
//               });
//             }
//           });


//     });
// });

// ######################################################################################################################################################

// FOR EDIT BED FORM
$(document).ready(function(){
    $('.bed_editBtn').on('click', function(){
        // Retrieve data attributes from the clicked button
        var bedId = $(this).data('bed_id');
        var bedNumber = $(this).data('bed_number');
        var status = $(this).data('status');
        var roomNumber = $(this).data('room_name');
        var bedImage = $(this).data('bed_image'); // Assuming this data attribute contains the image filename


        console.log("Bed ID:", bedId);
        console.log("Bed Number:", bedNumber);
        console.log("Status:", status);
        console.log("Room Number:", roomNumber);
        console.log("Bed Image:", bedImage);

        // Set form values
        $('#editBedId').val(bedId);
        $('#editRoomId').val(roomId);
        $('#editBedNumber').val(bedNumber);
        $('#editStatus').val(status);

        // for current room number
        $('#currentRoomNumber').text(roomNumber);
        $('#current_room_name').val(roomNumber);

        // Set the current image URL
        if (bedImage) {
            var imagePath = '../room_bed_uploads/' + bedImage; // Construct the correct image path
            $('#currentBedImage').attr('src', imagePath).show();
        } else {
            $('#currentBedImage').hide(); // Hide if no image
        }

        // Show the modal
        $('#editBedModal').modal('show');
    });
});





// // SWEET ALERT FOR DELETING BED

// $(document).ready(function() {
//     $('.deleteBedBtn').on('click', function(e) {

//         e.preventDefault();
//         var bedId = $(this).data('bed_id');
       
//         swal({
//             title: "Are you sure?",
//             text: "Once deleted, you will not be able to recover",
//             icon: "warning",
//             buttons: true,
//             dangerMode: true,
//           })
//           .then((willDelete) => {
//             if (willDelete) {
//                 $.ajax({
//                     type: 'POST',
//                     url: 'delete_bed.php',
//                     data: {'bed_id': bedId,
//                          'deleteBedBtn': true
//                          },
//                     success: function(response) {
//                         console.log(response);
//                         if(response == 200)
//                          {
//                             swal("Success!", "Bed deleted Successfully!", "success");
//                             $("#bed_refresh").load(location.href + " #bed_refresh");
//                         }
//                         else if(response == 500){
//                             swal("Error!", "Something went wrong!", "error");
//                         }
//                     },
//               });
//             }
//           });


//     });
// });


// // SWEET ALERT FOR DELETING TENANT

// $(document).ready(function() {
//     $('.deleteTenant').on('click', function(e) {

//         e.preventDefault();
//         var tenant_id = $(this).data('occupant_id');
       
//         swal({
//             title: "Are you sure?",
//             text: "Once deleted, you will not be able to recover",
//             icon: "warning",
//             buttons: true,
//             dangerMode: true,
//           })
//           .then((willDelete) => {
//             if (willDelete) {
//                 $.ajax({
//                     type: 'POST',
//                     url: 'delete_tenant.php',
//                     data: {'occupant_id': tenant_id,
//                          'deleteTenant': true
//                          },
//                     success: function(response) {
//                         console.log(response);
//                         if(response == 200)
//                          {
//                             swal("Success!", "Tenant deleted Successfully!", "success");
//                             $("#tenant_refresh").load(location.href + " #tenant_refresh");
//                         }
//                         else if(response == 500){
//                             swal("Error!", "Something went wrong!", "error");
//                         }
//                     },
//               });
//             }
//           });

//     });
// });

