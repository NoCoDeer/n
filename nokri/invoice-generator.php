<?php
/*
Template Name: PDF Generation Template
*/
$price="";
$description="";
if (!session_id()) {
    session_start();
}

// Check if the session variable is set
if (isset($_SESSION['description']) && isset($_SESSION['price']) && isset($_SESSION['rowid'])) {
    $description = $_SESSION['description'];
    $price = $_SESSION['price'];
    $rowid = $_SESSION['rowid'];

    unset($_SESSION['description']);
    unset($_SESSION['price']);
    unset($_SESSION['rowid']);
}

$jobId = isset($_GET['job_id']) ? $_GET['job_id'] : '';
$candidateId = isset($_GET['candidate_id']) ? $_GET['candidate_id'] : '';
$employerId = isset($_GET['employer_id']) ? $_GET['employer_id'] : '';

// Get the job title from the job ID using WordPress function
$jobTitle = get_the_title($jobId); // Replace with your actual custom field name
$employerData = get_userdata($employerId);
// Get candidate data using candidate ID
$candidateData = get_userdata($candidateId);
$candidateEmail = $candidateData ? $candidateData->user_email : '';
$candidateName = $candidateData ? esc_html($candidateData->display_name) : 'Candidate Name Not Found';
$employerName = $employerData ? esc_html($employerData->display_name) : 'Employer Name Not Found';

// Define company details
$companyName = (isset($nokri['hc_campany_name'])) ? $nokri['hc_campany_name'] : '';
$companyAddress = (isset($nokri['hc_campany_address'])) ? $nokri['hc_campany_address'] : '';
$companyEmail = (isset($nokri['hc_campany_email'])) ? $nokri['hc_campany_email'] : '';
$companyPhone = (isset($nokri['hc_phone_number'])) ? $nokri['hc_phone_number'] : '';
$companyWebsite = (isset($nokri['hc_company_website'])) ? $nokri['hc_company_website'] : '';

$pdfFileName = 'invoice_' . time() . '.pdf';

$upload_dir = wp_upload_dir();

// Construct the full local file path
$pdfFilePath = $upload_dir['basedir'] . '/invoices/' . $pdfFileName;

// Create the "invoices" folder if it doesn't exist
$invoices_dir = $upload_dir['basedir'] . '/invoices/';
if (!file_exists($invoices_dir)) {
    wp_mkdir_p($invoices_dir);
}

// Create a new PDF instance
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetMargins(10, 15, 10);
// Set document information
$pdf->SetCreator('Your PDF Creator Name');
$pdf->SetAuthor('Author Name');
$pdf->SetTitle('Invoice');
$pdf->SetSubject('Invoice');
$pdf->SetKeywords('Invoice, PDF');

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', '', 12);

// Sample content with dynamic data and Bootstrap styling
$html = '< class="container" style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; background-color: #f9f9f9; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
<h2 style="background-color: #007bff; color: #fff; text-align: center; padding: 10px; border-radius: 5px;">Invoice</h2>

<div style="margin-top: 20px;"></div> <!-- Gap of at least two rows -->

<div style="padding: 10px; border-top-right-radius: 5px; border-bottom-right-radius: 5px;">Job Title: ' . $jobTitle . '</div>
<div style="padding: 10px; border-top-right-radius: 5px; border-bottom-right-radius: 5px;">Job ID: ' . $jobId . '</div>
<div style="padding: 10px; border-top-right-radius: 5px; border-bottom-right-radius: 5px;">Candidate ID: ' . $candidateId . '</div>
<div style="padding: 10px; border-top-right-radius: 5px; border-bottom-right-radius: 5px;">Candidate Name: ' . $candidateName . '</div>
<div style="padding: 10px; border-top-right-radius: 5px; border-bottom-right-radius: 5px;">Employer Name: ' . $employerName . '</div>
</div>

<div style="margin-top: 20px;"></div> <!-- Gap of at least two rows -->

<table style="width: 100%; margin-top: 20px; border-collapse: collapse; border-radius: 5px; overflow: hidden; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
<tr>
    <th style="background-color: #f2f2f2; padding: 15px; text-align: left; width: 40%; border: 1px solid #ddd; border-right: none; height: 20px;">Amount:</th>
    <td style="padding: 15px; border: 1px solid #ddd; border-left: none; height: 20px;">$' . esc_html($price) . '</td>
</tr>
<tr>
    <th style="background-color: #f2f2f2; padding: 15px; text-align: left; width: 40%; border: 1px solid #ddd; border-right: none; height: 20px;">Description:</th>
    <td style="padding: 15px; border: 1px solid #ddd; border-left: none; height: 20px;">' . nl2br(esc_html($description)) . '</td>
</tr>
</table>

<p style="margin: 20px;">Make the payment to ' . esc_html($companyName) . ' to complete the transaction.</p>

<div class="company-details" >
<div class="company-details-left" style="width: 100%; text-align: right; margin-right:10px;">
<h4>Company Details:</h4>
<p><strong>Name:</strong> ' . $companyName . '</p>
<p><strong>Address:</strong> ' . $companyAddress . '</p>
<p><strong>Email:</strong> ' . $companyEmail . '</p>
</div>
<div class="company-details-right" style="width: 100%; text-align:right; margin-right:10px;">
<p><strong>Phone:</strong> ' . $companyPhone . '</p>
<p><strong>Website:</strong> ' . $companyWebsite . '</p>
</div>
</div>
</div>';

$pdf->writeHTML($html, true, false, true, false, '');

// Output the PDF to the specified directory
$pdf->Output($pdfFilePath, 'F'); // 'F' saves the PDF to a file

if (!empty($candidateEmail)) {
    $subject = 'Invoice for Job Application';

    // Email message
    $message = 'Dear ' . $candidateName . ',<br><br>';
    $message .= 'Please find attached the invoice for the job application.<br><br>';
    $message .= 'Thank you for using our platform.<br><br>';
    $message .= 'Best regards,<br>Your Company';

    $headers = '';
    $headers .= "MIME-Version: 1.0 \r\n";
    $headers .= "Content-type: text/html; charset=\"UTF-8\" \r\n";

    // Attach the PDF file
    $attachments = array($pdfFilePath);
    
    // Send the email
    $sent = wp_mail($candidateEmail, $subject, $message, $headers, $attachments);
    
    // Check if the email was sent successfully
    if ($sent) {
       
        // Email sent successfully, you can do something here
        echo esc_html('Email sent successfully to ' . $candidateEmail);
        global $wpdb;
        $table_name = $wpdb->prefix . 'custom_data_fields';
        $row_exists = $wpdb->get_var(
            $wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE rowid = %d", $rowid)
        );

        // Update the status to 'yes' for the row with the specified $rowid
        if ($row_exists) {
            $update = $wpdb->update(
                $table_name,
                array(
                    'status' => 'yes',
                    'file_path' => $pdfFileName,
                ),
                array('rowid' => $rowid),
                array('%s', '%s'),
                array('%d')
            );
        }
      
    } else {
       
        // Email sending failed, you can handle the error here
        echo esc_html('Email sending failed');

    }
} else {
    echo esc_html('Candidate email not found.');
}