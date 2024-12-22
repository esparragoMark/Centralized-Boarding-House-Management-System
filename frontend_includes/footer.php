    </div>
    </div>
    <?php
    include("config/config.php"); 
    ?>
    <div class="footer">
        <div class="container">
            <div class="row text-muted">
                <div class="col-12 text-end">
                    <p style="padding-top: 20px; padding-bottom: 10px">
                        <a href="index.php" class="text-muted">
                            <?php
                                $displayConfig = "SELECT * FROM dislay_config";
                                $displayConfig_run = mysqli_query($con, $displayConfig);
                                
                                if(mysqli_num_rows($displayConfig_run) > 0)
                                {
                                    $row = mysqli_fetch_assoc($displayConfig_run);
                                    ?>
                            <strong class="footer-text" style="margin-right: 1rem"><?=$row['footer_text']?></strong>
                            <?php
                                }
                                else {
                                    echo '<p class="text-center">No Display Data Found!</p>';
                                }
                            ?>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>



    <!-- JQUERY FILE -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- BOOTSTRAP JS BUNDLE -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- FONT AWESOME -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

    <!-- JS FILE -->
    <script src="../assets/js/script.js"></script>

    <!-- ALERTIFY JS -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>


    <script>
    // FUNCTION FOR REALTIME TOTAL RENT VALUE
    function calculateRent() {

        const checkInInput = document.getElementById('check-in');
        const checkOutInput = document.getElementById('check-out');
        const monthlyRentInput = document.getElementById('monthly-rent');

        const checkIn = new Date(checkInInput.value);
        const checkOut = new Date(checkOutInput.value);
        const monthlyRent = parseFloat(monthlyRentInput.value) || 0;

        const result = document.getElementById('total-rent');
        const totalRentInput = document.getElementById('total-rent-input');

        if (checkIn && checkOut && checkIn < checkOut) {
            // Calculate the number of months between the dates
            const years = checkOut.getFullYear() - checkIn.getFullYear();
            const months = checkOut.getMonth() - checkIn.getMonth() + (years * 12);

            // Ensure at least one month is calculated
            const totalMonths = Math.max(months, 1);

            // Calculate total rent
            const totalRent = totalMonths * monthlyRent;

            // Display total rent
            result.textContent = `Total Rent: ₱${totalRent.toFixed(2)}`;
            // Update hidden input with total rent
            totalRentInput.value = totalRent.toFixed(2);
        } else {
            // If dates are invalid or not selected, clear the total rent
            result.textContent = 'Total Rent: ₱0.00';
            // Clear hidden input
            totalRentInput.value = '0.00';
        }
    }
    </script>

    <script>
    // FOR STAR RATING 
    $(document).ready(function() {
        var rating_data = 0;

        // Mouse enter event
        $(document).on('mouseenter', '.submit_star', function() {
            var currentRating = $(this).data('rating');
            reset_background();

            for (var count = 1; count <= currentRating; count++) {
                $('#submit_star_' + count).addClass('star-selected');
            }
        });

        // Mouse leave event
        $(document).on('mouseleave', '.submit_star', function() {
            reset_background();

            for (var count = 1; count <= rating_data; count++) {
                $('#submit_star_' + count).addClass('star-selected');
            }
        });

        // Click event
        $(document).on('click', '.submit_star', function() {
            rating_data = $(this).data('rating');
            update_star_colors();
        });

        // Function to reset star colors
        function reset_background() {
            for (var count = 1; count <= 5; count++) {
                $('#submit_star_' + count).removeClass('star-selected').addClass('star-light');
            }
        }

        // Function to update star colors based on selected rating
        function update_star_colors() {
            reset_background();
            for (var count = 1; count <= rating_data; count++) {
                $('#submit_star_' + count).addClass('star-selected');
            }
        }

        $('#save_review').click(function() {
            var user_name = $('#user_name').val();
            var bh_id = $('#bh_id').val();
            var user_review = $('#user_review').val();

            if (user_review === '' || bh_id === '' || user_name === '') {
                alert("Please fill in all fields OR Please Log in");
                return false;
            } else {
                $.ajax({
                    url: "submit_rating.php",
                    method: "POST",
                    data: {
                        rating_data: rating_data,
                        user_name: user_name,
                        bh_id: bh_id,
                        user_review: user_review
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.status === 'success') {
                            alert("Review submitted successfully.");
                            $('#reviewModal').modal('hide');
                            location.reload(); // Refresh the page
                        } else {
                            alert("Error: " + data.message);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('AJAX Error:', textStatus, errorThrown);
                        console.log('Response Text:', jqXHR.responseText); // Debugging
                    }
                });
            }
        });


    });
    </script>

    <script>
    // FOR VIEW MAP
    function viewMap() {
        var mapContainer = document.getElementById('map-container');

        // Toggle the 'show' class for transition
        if (mapContainer.classList.contains('show')) {
            mapContainer.classList.remove('show'); // Hide map
        } else {
            mapContainer.classList.add('show'); // Show map
        }
    }
    </script>

    <script>
    <?php if(isset($_SESSION['message'])) { ?>
    alertify.set('notifier', 'position', 'top-center');
    alertify.<?= $_SESSION['message_type'] ?>('<?= $_SESSION['message'] ?>');
    <?php unset($_SESSION['message']); ?>
    <?php } ?>
    </script>
</body>

</html>