<?php
ob_start(); // Start output buffering

// Include necessary files
include("header.php");
include("../../config/config.php");
include('../../middleware/middleware.php');
require_once('../TCPDF_landlord/tcpdf.php');

// Check if session variable is set and retrieve landlord ID
if (!isset($_SESSION['auth_landlord']['id'])) {
    $_SESSION['message'] = "Landlord ID is missing. Please log in again.";
    $_SESSION['message_type'] = "danger";
    header("Location: login.php");
    exit();
}

$landlord_id = $_SESSION['auth_landlord']['id'];
$landlord_id = $con->real_escape_string($landlord_id);

// Query to fetch boarding house details
$query = "SELECT owner_name, owner_phone, bh_id, house_name FROM boarding_house_registration WHERE landlord_id = '$landlord_id'";
$result = $con->query($query);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['BH-OWNER'] = $row['owner_name'];
    $_SESSION['BH-NUMBER'] = $row['owner_phone'];
    $_SESSION['BH-ID'] = $row['bh_id'];
    $_SESSION['BH-NAME'] = $row['house_name'];
    $bh_id = $_SESSION['BH-ID'];
    $bh_name = $con->real_escape_string($_SESSION['BH-NAME']);
} else {
    $_SESSION['message'] = "No boarding house found. Please submit your credentials.";
    $_SESSION['message_type'] = "warning";
    header("Location: credential.php");
    exit();
}

$bh_id = $con->real_escape_string($bh_id);

// Query to fetch occupants data
$sql = "SELECT * FROM occupants WHERE bh_name = '$bh_name' AND bh_id = '$bh_id'";
$result = $con->query($sql);

$occupants = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $occupants[] = $row;
    }
}

if (isset($_POST['generate_pdf'])) {
    // Create a new PDF document with A4 size
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT); // Set margins
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM); // Auto page breaks

    $pdf->AddPage();

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Directory of Accredited Boarding House/Dormitory Occupants');

    // Define column widths
    $col1_width = 50; // Width for logo column
    $col2_width = 100; // Width for text columns
    $col3_width = 50;  // Width for document control number column

    // Set font for header
    $pdf->SetFont('helvetica', '', 10);

    // First column - Logo
    $pdf->Image('../assets/images/pdf_logo.jpg', 15, 15, 30, 30, 'JPG'); // Logo

    // Second column - Text with three rows
    $pdf->SetXY(50, 13); // Positioning for the second column
    $pdf->SetFont('helvetica', '', 10); // Regular font for text
    $pdf->MultiCell($col2_width, 5, 'DR. EMILIO B. ESPINOSA, SR. MEMORIAL STATE COLLEGE OF AGRICULTURE AND TECHNOLOGY', 0, 'C', 0, 1, '', '', true);

    $pdf->SetXY(50, 23); // Adjust the Y position accordingly
    $pdf->SetFont('helvetica', 'B', 15); // Bold font for FORM
    $pdf->MultiCell($col2_width, 5, 'FORM', 0, 'C', 0, 1, '', '', true);

    $pdf->SetXY(50, 30); // Adjust the Y position accordingly
    $pdf->SetFont('helvetica', 'B', 15); // Bold font for main title
    $pdf->MultiCell($col2_width, 5, 'DIRECTORY OF ACCREDITED BOARDING HOUSE/DORMITORY OCCUPANTS', 0, 'C', 0, 1, '', '', true);

    // Third column - Document Control Number
    $pdf->SetXY(150, 25); // Positioning for the third column
    $pdf->SetFont('helvetica', '', 10); // Reset font to regular
    $pdf->MultiCell($col3_width, 5, 'DOCUMENT CONTROL NUMBER: DEBESMSCAT      -F- SHRS- 02', 0, 'L', 0, 1, '', '', true);

    // Add a line before the table
    $pdf->Ln(5); // Add some space before the line
    $pdf->SetX(15); // Set X position (start from left margin)
    $pdf->SetFont('helvetica', '', 10); // Set font for the line
    $pdf->Cell(0, 10, '____________________________________________________________________________________________', 0, 1, 'C');

    $pdf->Ln(1); // Add some space after the line
    $pdf->SetX(15); // Set X position (start from left margin)
    $pdf->SetFont('dejavusans', 'I', 8); // Set font for the line
    $pdf->Cell(0, 10, '☐ 1st ☐ 2nd Semester AY ________ ☐ Mid-Year _____', 0, 1, 'C');

    $pdf->Ln(1); // Add some space after the line

    $pdf->SetX(15); // Set X position (start from left margin)
    $pdf->SetFont('dejavusans', '', 9); // Set font for the line
    $pdf->Cell(0, 6, 'Name of Boarding House/Dormitory:  '. $_SESSION['BH-NAME'], 0, 1, 'L');

    $pdf->SetX(15); // Set X position (start from left margin)
    $pdf->SetFont('dejavusans', '', 9); // Set font for the line
    $pdf->Cell(0, 6, 'Name of Land Lady/Landlord/In charge:  '. $_SESSION['BH-OWNER'], 0, 1, 'L');

    $pdf->SetX(15); // Set X position (start from left margin)
    $pdf->SetFont('dejavusans', '', 9); // Set font for the line
    $pdf->Cell(0, 6, 'Contact Number:  ' . $_SESSION['BH-NUMBER'], 0, 1, 'L');
    
    $pdf->Ln(5); // Add some space after the line
    // Add headers for the table

    $pdf->SetX(5);
    $pdf->SetFont('helvetica', 'B', 8);
    // Set line style for table headers (no top line)
    $pdf->SetLineStyle(array('width' => 0, 'color' => array(0, 0, 0))); // No line style
    // Table headers without top border line
    $pdf->Cell(10, 10, 'No', 1, 0, 'C');
    $pdf->Cell(35, 10, 'Name of Occupants', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Course/Year/Section', 1, 0, 'C');
    $pdf->Cell(45, 10, 'Address', 1, 0, 'C');
    $pdf->Cell(20, 10, 'Contact No.', 1, 0, 'C');
    $pdf->Cell(25, 10, 'Date of Moving In', 1, 0, 'C');
    $pdf->Cell(20, 10, 'Monthly Rent', 1, 0, 'C');
    $pdf->Cell(15, 10, 'Remarks', 1, 0, 'C');
    $pdf->Ln();

  
    // Populate table with data
    $count = 1;
    $pdf->SetFont('dejavusans', '', 7);
    foreach ($occupants as $occupant) {
        $pdf->SetX(5);
        $pdf->Cell(10, 10, $count++, 1, 0, 'C');
        $pdf->Cell(35, 10, $occupant['fullname'], 1, 0, 'L');
        $pdf->Cell(30, 10, $occupant['course_year_section'], 1, 0, 'C');
        $pdf->Cell(45, 10, $occupant['address'], 1, 0, 'L');
        $pdf->Cell(20, 10, $occupant['contact_number'], 1, 0, 'C');
        $pdf->Cell(25, 10, $occupant['date_of_moving_in'], 1, 0, 'C');
        $pdf->Cell(20, 10, '₱' . $occupant['monthly_rent'], 1, 0, 'C');
        $pdf->Cell(15, 10, '', 1, 0, 'C');
        $pdf->Ln();
    }

    // Footer details
    $pdf->Ln(10);
    $pdf->Cell(0, 5, '___________________________________________________________', 0, 1, 'C');
    $pdf->Cell(0, 5, 'Signature of Boardinghouse Owner/Dormitory Incharge', 0, 1, 'C');

    // Output the PDF
    ob_end_clean(); // Clean the output buffer
    $pdf->Output('boarding_house_report.pdf', 'I');
    exit();
}


ob_end_flush(); // Flush the output buffer and turn off output buffering
?>

<div class="container my-4" id="tenant_refresh">
    <h3 class="mb-4">Report</h3>
    <div class="card border-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-end mb-4 btn-custom-spacing">
                <div></div>
                <div>
                    <form method="POST">
                        <button type="submit" name="generate_pdf" class="btn" style="background-color: #08614e; color: white" ><i class="fas fa-download me-2"></i>Generate PDF</button>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-custom">
                    <caption>List of Occupants</caption>
                    <thead class="table-secondary">
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">Name of Occupants</th>
                            <th class="text-center">Course/Year/Section</th>
                            <th class="text-center">Address</th>
                            <th class="text-center">Contact No.</th>
                            <th class="text-center">Date of Moving In</th>
                            <th class="text-center">Monthly Rent</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1; ?>
                        <?php foreach ($occupants as $occupant): ?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            <td><?php echo htmlspecialchars($occupant['fullname']); ?></td>
                            <td><?php echo htmlspecialchars($occupant['course_year_section']); ?></td>
                            <td><?php echo htmlspecialchars($occupant['address']); ?></td>
                            <td><?php echo htmlspecialchars($occupant['contact_number']); ?></td>
                            <td><?php echo htmlspecialchars($occupant['date_of_moving_in']); ?></td>
                            <td>₱<?php echo htmlspecialchars($occupant['monthly_rent']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
