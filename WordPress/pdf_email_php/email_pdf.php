<?php 
$usermail = 'eample@gmail.com';
$usersubject = "Payment Invoice";
$usmessage = "Hello <b> John</b>,  <br><br> Thanks for payment, Please find attached the invoice of payment.";
$headers = "From: info@stonedepotgh.com\r\n";
$headers .= "Reply-To: info@stonedepotgh.com\r\n";
$headers .= "Content-Type: multipart/mixed; boundary=\"PHP-mixed-".md5(time())."\"\r\n";


// Get the contents of the PDF file
$filename = "invoice.pdf";
$pdf_contents = file_get_contents($filename);
$pdf_data = base64_decode($pdf_data); // $pdf_data is the base64-encoded PDF data
$file_path = '/path/to/invoice.pdf';
file_put_contents($file_path, $pdf_data);

// Set up the PDF document with a dummy image
require('fpdf.php');
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(80);
$pdf->Cell(30, 10, 'Invoice', 0, 0, 'R');
$pdf->Ln(20);
$pdf->Image('https://www.stonedepotgh.com/img/welcome/stone-depot-payment-logo.png', 10, 10, 120);
$pdf->Cell(140);
$pdf->Cell(30, 10, 'Date: ' . date('d M, Y'), 0, 0, 'R');
$pdf->Ln(20);


// Add client information and payment details
$pdf->SetFont('Arial', 'B', 12); // Set font to bold for section headings
$pdf->Cell(95, 10, 'Client Information', 0, 0);
$pdf->Cell(95, 10, 'Payment Details', 0, 1);
$pdf->SetFont('Arial', '', 10); // Set font back to regular for content
$pdf->Cell(95, 7, 'Name: John Developed ', 0, 0);
$pdf->Cell(95, 7, 'Payment Type: Online', 0, 1);
$pdf->Cell(95, 7, 'Email: example@gmail.com', 0, 0);
$pdf->Cell(95, 7, 'Name: John Wick', 0, 1);
$pdf->Cell(95, 7, 'Phone: 8945698745 ', 0, 0);
$pdf->Cell(95, 7, '', 0, 1);


// Add horizontal line
$pdf->SetLineWidth(0.5);
$pdf->SetDrawColor(224, 224, 224);
$pdf->Line(10, $pdf->GetY()+5, 200, $pdf->GetY()+5);
$pdf->Ln(10);


// Add padding
$pdf->Cell(190, 0, '', 0, 1);


// Add table header
$pdf->SetFont('Arial','B',14);
$pdf->SetFillColor(229, 229, 229); // Light gray background color
$pdf->Cell(55,10,'ITEM',1,0, '', true);
$pdf->Cell(38,10,'SALES CODE',1,0, '', true);
$pdf->Cell(38,10,'QUANTITY',1,0, '', true);
$pdf->Cell(33,10,'ITEM COST',1,0, '', true);
$pdf->Cell(26,10,'TOTAL',1,1, '', true);


// Add table data
$pdf->SetFont('Arial','',12);
$pdf->Cell(55,10,'Sample item name here',1,0);
$pdf->Cell(38,10,'85965',1,0,'C');
$pdf->Cell(38,10,'1',1,0,'C');
$pdf->Cell(33,10,'$200',1,0,'C');
$pdf->Cell(26,10,'$200',1,1,'C');


// Add horizontal line
$pdf->SetLineWidth(0.5);
$pdf->SetDrawColor(224, 224, 224);
$pdf->Line(10, $pdf->GetY()+5, 200, $pdf->GetY()+5);
$pdf->Ln(10);

// Add last row with background color and text
$pdf->SetFont('Arial','',10);

// Add padding
$pdf->Cell(190, 5, '', 0, 1);

// Add section with background color

$pdf->SetTextColor(0, 0, 0); // Black color for text
$pdf->SetFont('Arial', 'B', 10); // Bold font

$pdf->Cell(190, 10, 'Site_Name', 0, 1, 'L');
$pdf->Cell(190, 5, 'Some Address', 0, 1, 'L');
$pdf->Cell(190, 5, 'phone_no', 0, 1, 'L');
$pdf->Cell(190, 5, 'info@email.com', 0, 1, 'L');
$pdf->Cell(190, 5, 'copyright', 0, 1, 'L');

// Output PDF file
$pdf->Output('invoice.pdf', 'F');
            
// Get the updated contents of the PDF file
$pdf_contents = file_get_contents($filename);

// Build the email message
$email_message = "--PHP-mixed-".md5(time())."\r\n";
$email_message .= "Content-Type: multipart/alternative; boundary=\"PHP-alt-".md5(time())."\"\r\n";
$email_message .= "\r\n--PHP-alt-".md5(time())."\r\n";
$email_message .= "Content-Type: text/plain; charset=\"iso-8859-1\"\r\n";
$email_message .= "Content-Transfer-Encoding: 7bit\r\n";
$email_message .= "\r\n".$usmessage."\r\n";
$email_message .= "\r\n--PHP-alt-".md5(time())."\r\n";
$email_message .= "Content-Type: text/html; charset=\"iso-8859-1\"\r\n";
$email_message .= "Content-Transfer-Encoding: 7bit\r\n";
$email_message .= "\r\n".$usmessage."\r\n";
$email_message .= "\r\n--PHP-alt-".md5(time())."--\r\n";
$email_message .= "\r\n--PHP-mixed-".md5(time())."\r\n";
$email_message .= "Content-Type: application/pdf; name=\"".$filename."\"\r\n";
$email_message .= "Content-Transfer-Encoding: base64\r\n";
$email_message .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n";
$email_message .= "\r\n".chunk_split(base64_encode($pdf_contents))."\r\n";
$email_message .= "\r\n--PHP-mixed-".md5(time())."--";
?>