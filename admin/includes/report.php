<?php
ob_start();
include("header.php");
include("../../config/config.php");
require_once('../TCPDF_admin/tcpdf.php'); // Ensure you include TCPDF

// Fetch boarding house data
$bh_query = "SELECT * FROM boarding_house_registration";
$bh_query_run = mysqli_query($con, $bh_query);

$boardinghouses = [];

if (mysqli_num_rows($bh_query_run) > 0) {
    while ($data = mysqli_fetch_assoc($bh_query_run)) {
        $boardinghouses[] = $data;
    }
}

// Check if Generate PDF button is clicked
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


    $pdf->Image('../assets/images/pdf_logo.jpg', 15, 15, 29, 29, 'JPG'); // Logo

    $pdf->SetXY(50, 15); 
    $pdf->SetFont('helvetica', '', 10);
    $pdf->MultiCell(60, 5, 'Republic of the Philippines', 0, 'L', 0, 1, '', '', true);

    $pdf->SetXY(50, 20); 
    $pdf->SetFont('helvetica', 'B', 11); 
    $pdf->MultiCell(80, 5, 'DR. EMILIO B. ESPINOSA SR. MEMORIAL', 0, 'L', 0, 1, '', '', true);

    $pdf->SetXY(50, 25); 
    $pdf->SetFont('helvetica', 'B', 11); 
    $pdf->MultiCell(120, 5, 'STATE COLLEGE OF AGRICULTURE AND TECHNOLOGY', 0, 'L', 0, 1, '', '', true);

    $pdf->SetXY(50, 30); 
    $pdf->SetFont('helvetica', '', 11); 
    $pdf->MultiCell(120, 5, 'Office of Student Housing and Residential Services', 0, 'L', 0, 1, '', '', true);

    $pdf->SetXY(50, 35); 
    $pdf->SetFont('helvetica', '', 10); 
    $pdf->MultiCell(120, 5, 'www.debesmscat.edu.ph | Cabitan, Mandaon, Masbate', 0, 'L', 0, 1, '', '', true);


    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(0, 10, '____________________________________________________________________________________________', 0, 1, 'C');

    $pdf->Ln(5);

    $pdf->SetFont('helvetica', 'B', 15);
    $pdf->Cell(0, 10, 'Directory of Boarding House/Dormitory', 0, 1, 'C');
    $pdf->SetFont('helvetica', 'I', 12); // Set font to italic
    $pdf->Cell(0, 10, 'For the Month of ____________', 0, 1, 'C');
    $pdf->SetFont('helvetica', '', 12); // Reset font to regular

    $pdf->Ln(5);

    // Set X position for headers
    $pdf->SetX(12); // Adjust this value to move headers to the left
    // Add table headers
    $pdf->SetFont('helvetica', 'B', 9);
    // Use MultiCell for text wrapping
    $pdf->MultiCell(10, 12, 'No', 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(30, 12, 'Name of Boardinghouse', 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(28, 12, 'BH Owner/Dormitory Incharge', 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 12, 'Monthly Rent', 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(26, 12, 'Total Number of occupants', 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(26, 12, 'Total Amount of Rent per Month', 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(25, 12, 'Remittance to College (2.5%)', 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 12, 'Remarks', 1, 'C', 0, 1, '', '', true); // Add Remarks column

    
     
    // Add boarding house data
    $count = 1;
    $rowHeight = 10; // Define the row height (in your case, it's 10)
    
    $pdf->SetX(12);
    $pdf->SetFont('dejavusans', '', 9);
    
    foreach ($boardinghouses as $bh) {
        $bh_id = $bh['bh_id'];
        $occupants_query = "
            SELECT 
                monthly_rent, 
                COUNT(*) as count_occupants 
            FROM 
                occupants 
            WHERE 
                bh_id = '$bh_id' 
            GROUP BY 
                monthly_rent
        ";
        $occupants_query_run = mysqli_query($con, $occupants_query);
    
        $total_occupants = 0;
        $total_rent_per_month = 0;
        $rents_list = [];
    
        while ($rents_data = mysqli_fetch_assoc($occupants_query_run)) {
            $rent_amount = $rents_data['monthly_rent'];
            $count_occupants = $rents_data['count_occupants'];
    
            $total_occupants += $count_occupants;
            $total_rent_per_month += $rent_amount * $count_occupants;
    
            $rents_list[] = '₱' . number_format($rent_amount, 2);
        }
    
        $rents_display = !empty($rents_list) ? implode('  ', array_unique($rents_list)) : '0';
        $remittance = $total_rent_per_month * 0.025;
        $remarks = '';
    
        // Store the current Y position
        $currentY = $pdf->GetY();

        $pdf->SetX(12);
    
        // Use MultiCell for text wrapping
        $pdf->Cell(10, $rowHeight, $count++, 1, 0, 'C');
        
        $pdf->SetXY($pdf->GetX(), $currentY); // Set to the next cell X position but same Y
        $pdf->MultiCell(30, $rowHeight, htmlspecialchars($bh['house_name']), 1, 'L',  0, 0, '', '', true);
    
        $pdf->SetXY($pdf->GetX(), $currentY);
        $pdf->MultiCell(28, $rowHeight, htmlspecialchars($bh['owner_name']), 1, 'L',  0, 0, '', '', true);
    
        $pdf->SetXY($pdf->GetX(), $currentY);
        $pdf->MultiCell(20, $rowHeight, $rents_display, 1, 'C',  0, 0, '', '', true);
    
        $pdf->SetXY($pdf->GetX(), $currentY);
        $pdf->MultiCell(26, $rowHeight, number_format($total_occupants), 1, 'C',  0, 0, '', '', true);
    
        $pdf->SetXY($pdf->GetX(), $currentY);
        $pdf->MultiCell(26, $rowHeight, '₱' . number_format($total_rent_per_month, 2), 1, 'C',  0, 0, '', '', true);
    
        $pdf->SetXY($pdf->GetX(), $currentY);
        $pdf->MultiCell(25, $rowHeight, '₱' . number_format($remittance, 2), 1, 'C',  0, 0, '', '', true);
    
        $pdf->SetXY($pdf->GetX(), $currentY);
        $pdf->MultiCell(20, $rowHeight, $remarks, 1, 'L',  0, 0, '', '', true); // Add Remarks cell
    
        // Move down by the row height after each row
        $pdf->Ln($rowHeight);
    }
    

    $pdf->Ln(5);

    $pdf->SetXY(12,230);
    $pdf->SetFont('helvetica', 'I', 10); 
    $pdf->Cell(0, 10, 'Prepared by:', 0, 1, 'L');

    $pdf->SetXY(100,230);
    $pdf->SetFont('helvetica', 'I', 10); 
    $pdf->Cell(0, 10, 'Noted:', 0, 1, 'L');

    $pdf->SetXY(25,240);
    $pdf->SetFont('helvetica', '', 10); 
    $pdf->Cell(0, 10, '_______________________', 0, 1, 'L');

    $pdf->SetXY(25,245);
    $pdf->SetFont('helvetica', '', 10); 
    $pdf->Cell(0, 10, '       SHARS Coordinator', 0, 1, 'L');

    $pdf->SetXY(110,240);
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(0, 10, '_______________________', 0, 1, 'L');

    $pdf->SetXY(110,245);
    $pdf->SetFont('helvetica', '', 10); 
    $pdf->Cell(0, 10, '           OSAS Director', 0, 1, 'L');


    
    $pdf->SetXY(12,262);
    $pdf->SetFont('helvetica', '', 10); 
    $pdf->Cell(0, 10, 'FM-SHARS-03', 0, 1, 'L');

    $currentDate = date('F j, Y'); // e.g., "month day year"
    $pdf->SetXY(0, 262);
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(0, 10, $currentDate, 0, 1, 'R');

    // Output the PDF
    ob_end_clean(); // Clean the output buffer
    $pdf->Output('boarding_house_report.pdf', 'I');
    exit();
}



ob_end_flush();
?>

<style>
/* Global Styles */
body {
    font-family: 'Poppins', sans-serif;
    background-color: #f5f5f5;
}

h3 {
    font-weight: bold;
    color: #08614E;
}

/* Table Section */
.table-responsive {
    overflow-x: auto;
    white-space: nowrap;
}

table {
    width: 100%;
    border-collapse: collapse;
}

table th {
    color: white;
    background-color: #08614E;
    font-size: 11px;
    padding: 10px;
    text-align: center;
}

table td {
    padding: 10px;
    font-size: 12px;
    text-align: center;
    color: #333;
}

table tbody tr:nth-child(even) {
    background-color: #f2f2f2;
}

table tbody tr:hover {
    background-color: #e0e0e0;
}

/* Buttons and Icons */
.btn-outline-primary {
    color: #08614E;
    border-color: #08614E;
    font-size: 12px;
}

.btn-outline-primary:hover {
    background-color: #08614E;
    color: white;
}

/* Responsive Layout */
@media (max-width: 767px) {
    .table th, .table td {
        font-size: 12px;
    }
}
</style>

<div class="container my-4">
    <h3 class="mb-4">Boarding House Report</h3>
    <div class="row">
        <div class="col-sm-12 col-md-10 col-lg-12">
            <div class="d-flex justify-content-end mb-4">
                <form method="POST">
                    <button type="submit" name="generate_pdf" class="btn "  style="background-color: #08614e; color: white"> <i class="fas fa-download  me-2"></i>Generate PDF</button>
                </form>
            </div>
            <!-- Card to wrap the table -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="myTable" class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Name of Boardinghouse</th>
                                    <th>BH Owner/Dormitory Incharge</th>
                                    <th>Monthly Rent</th>
                                    <th>Total Number of Occupants</th>
                                    <th>Total Amount of Rent per Month</th>
                                    <th>Remittance to College (2.5%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 1;
                                foreach ($boardinghouses as $bh) {
                                    $bh_id = $bh['bh_id'];
                                    $occupants_query = "
                                        SELECT 
                                            monthly_rent, 
                                            COUNT(*) as count_occupants 
                                        FROM 
                                            occupants 
                                        WHERE 
                                            bh_id = '$bh_id' 
                                        GROUP BY 
                                            monthly_rent
                                    ";
                                    $occupants_query_run = mysqli_query($con, $occupants_query);

                                    $total_occupants = 0;
                                    $total_rent_per_month = 0;
                                    $rents_list = [];

                                    while ($rents_data = mysqli_fetch_assoc($occupants_query_run)) {
                                        $rent_amount = $rents_data['monthly_rent'];
                                        $count_occupants = $rents_data['count_occupants'];

                                        $total_occupants += $count_occupants;
                                        $total_rent_per_month += $rent_amount * $count_occupants;

                                        $rents_list[] = '₱ ' . number_format($rent_amount, 2);
                                    }

                                    $rents_display = !empty($rents_list) ? implode('<br>', array_unique($rents_list)) : '₱ 0.00';
                                    $remittance = $total_rent_per_month * 0.025;
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $count; ?></td>
                                    <td><?php echo htmlspecialchars($bh['house_name']); ?></td>
                                    <td><?php echo htmlspecialchars($bh['owner_name']); ?></td>
                                    <td><?php echo $rents_display; ?></td>
                                    <td><?php echo number_format($total_occupants); ?></td>
                                    <td><?php echo '₱ ' . number_format($total_rent_per_month, 2); ?></td>
                                    <td><?php echo '₱ ' . number_format($remittance, 2); ?></td>
                                </tr>
                                <?php
                                    $count++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- End of card -->
        </div>
    </div>
</div>



<?php
include("footer.php");
?>