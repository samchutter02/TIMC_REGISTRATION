<?php
require_once __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendRegistrationConfirmation(
    string $toEmail,
    string $toName,
    string $groupName,
    string $poNumber,
    float  $totalCost,
    int    $performerCount,
    array  $formData
): bool {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'localhost';
        $mail->SMTPAuth   = false;
        $mail->Username   = '';
        $mail->Password   = '';
        $mail->SMTPSecure = '';
        $mail->Port       = 25;

        $mail->setFrom('regsystem@tucsonmariachi.org', 'Tucson Mariachi Registration');
        $mail->addAddress($toEmail, $toName);
        $mail->addBCC('info@tucsonmariachi.org', 'Registration Admin');

        $mail->isHTML(true);
        $mail->Subject = 'Registration Received - PO #' . htmlspecialchars($poNumber);

        // ────────────────────────────────────────────────
        // Build improved, consistent HTML body
        // ────────────────────────────────────────────────
        $body = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Registration Confirmation</title>
            <style type="text/css">
                body { font-family: Arial, Helvetica, sans-serif; line-height: 1.6; color: #333; margin:0; padding:0; background:#f9f9f9; }
                .container { max-width: 620px; margin: 20px auto; background: #fff; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; }
                .header { background: #b22222; color: white; padding: 20px 30px; text-align: center; }
                .header h1 { margin: 0; font-size: 24px; }
                .content { padding: 30px; }
                h2 { color: #b22222; margin-top: 1.5em; border-bottom: 2px solid #d4a017; padding-bottom: 8px; font-size: 20px; }
                h3 { color: #444; margin-top: 1.8em; font-size: 18px; border-left: 5px solid #d4a017; padding-left: 12px; }
                table { width: 100%; max-width: 600px; border-collapse: collapse; margin: 1.2em 0; font-size: 15px; }
                th, td { padding: 10px 12px; border: 1px solid #e0e0e0; text-align: left; }
                th { background: #f5f5f5; color: #444; font-weight: bold; }
                .highlight { background: #fff8e1; font-weight: bold; }
                .total-row td { background: #fdf2e9; font-size: 1.1em; }
                .footer { background: #f5f5f5; padding: 20px; text-align: center; font-size: 13px; color: #666; border-top: 1px solid #eee; }
                .footer a { color: #b22222; text-decoration: none; }

                ul { margin: 0.6em 0 1.2em 1.8em; padding-left: 0; }
                ul li { margin-bottom: 0.5em; }
            </style>
        </head>
        <body>
        <div class="container">
            <div class="header">
                <h1>2026 Tucson International Mariachi Conference</h1>
                <p>Registration Confirmation</p>
            </div>

            <div class="content">
                <h2>Thank you, ' . htmlspecialchars($toName) . '!</h2>
                <p>We have successfully received your registration. Below is a summary of your submission.</p>

                <h3>Registration Summary</h3>
                <table>
                    <tr><td><strong>Registration Type</strong></td><td>' . htmlspecialchars($formData['registration_type'] ?? '—') . '</td></tr>
                    <tr><td><strong>' . ($formData['registration_type'] === 'individual' ? 'Individual Name' : 'Group Name') . '</strong></td><td>' . htmlspecialchars($groupName) . '</td></tr>';

        if (!empty($formData['school_name'] ?? '')) {
            $body .= '<tr><td><strong>School Name</strong></td><td>' . htmlspecialchars($formData['school_name']) . '</td></tr>';
        }

        $body .= '
                    <tr><td><strong>PO / Invoice Number</strong></td><td>' . htmlspecialchars($poNumber) . '</td></tr>
                    <tr><td><strong>Total Performers</strong></td><td>' . $performerCount . '</td></tr>
                    <tr class="total-row"><td><strong>Total Amount Due</strong></td><td class="highlight">$' . number_format($totalCost, 2) . '</td></tr>
                </table>

                <h3>Director & Contact Information</h3>
                <table>
                    <tr><td style="width:38%;"><strong>Director</strong></td><td>' 
                    . htmlspecialchars(trim(($formData['director_first'] ?? '') . ' ' . ($formData['director_last'] ?? ''))) . '</td></tr>
                    <tr><td><strong>Email</strong></td><td>' . htmlspecialchars($toEmail) . '</td></tr>
                    <tr><td><strong>Cell Phone</strong></td><td>' . htmlspecialchars($formData['cell_phone'] ?? '—') . '</td></tr>';

        if (!empty($formData['daytime_phone'] ?? '')) {
            $body .= '<tr><td><strong>Day Phone</strong></td><td>' . htmlspecialchars($formData['daytime_phone']) . '</td></tr>';
        }

        $body .= '
                    <tr><td><strong>Address</strong></td><td>' 
                    . htmlspecialchars(trim(($formData['street_address'] ?? '') . '  ' . ($formData['city'] ?? '') . ', ' . ($formData['state'] ?? '') . ' ' . ($formData['zip_code'] ?? ''))) 
                    . '</td></tr>
                </table>';

        // Assistant Director
        if (!empty($formData['has_assistant_director']) && $formData['has_assistant_director'] === 'yes') {
            $body .= '
            <h3>Assistant Director</h3>
            <table>
                <tr><td style="width:38%;"><strong>Name</strong></td><td>' 
                . htmlspecialchars(trim(($formData['d2_first_name'] ?? '') . ' ' . ($formData['d2_last_name'] ?? ''))) . '</td></tr>';

            if (!empty($formData['d2_cell_phone'] ?? '')) {
                $body .= '<tr><td><strong>Cell Phone</strong></td><td>' . htmlspecialchars($formData['d2_cell_phone']) . '</td></tr>';
            }
            if (!empty($formData['d2_email'] ?? '')) {
                $body .= '<tr><td><strong>Email</strong></td><td>' . htmlspecialchars($formData['d2_email']) . '</td></tr>';
            }
            $body .= '</table>';
        }

        // Participants Table
        $body .= '
                <h3>Participants</h3>
                <table>
                    <thead>
                        <tr style="background:#b22222; color:white;">
                            <th>Name</th>
                            <th>Instrument</th>
                            <th>Level</th>
                        </tr>
                    </thead>
                    <tbody>';

        $hasParticipants = false;
        if (!empty($formData['performers']) && is_array($formData['performers'])) {
            foreach ($formData['performers'] as $performer) {
                $first = trim($performer['first_name'] ?? '');
                $last  = trim($performer['last_name']  ?? '');
                if ($first === '' && $last === '') continue;

                $hasParticipants = true;
                $name = htmlspecialchars($first . ($first && $last ? ' ' : '') . $last);
                $instrument = htmlspecialchars($performer['class'] ?? '—');
                $level = htmlspecialchars($performer['level'] ?? '—');

                $body .= "
                        <tr>
                            <td>$name</td>
                            <td>$instrument</td>
                            <td>$level</td>
                        </tr>";
            }
        }

        if (!$hasParticipants) {
            $body .= '
                        <tr>
                            <td colspan="3" style="text-align:center; padding:20px; color:#777; font-style:italic;">
                                No performers listed
                            </td>
                        </tr>';
        }

        $body .= '
                    </tbody>
                </table>

                <h3>Conference Choices</h3>
                <table>
                    <tr><td style="width:45%;"><strong>Workshop Type</strong></td><td>' . htmlspecialchars($formData['workshop_type'] ?? '-') . '</td></tr>
                    <tr><td><strong>Group Type</strong></td><td>' . htmlspecialchars($formData['group_type'] ?? '-') . '</td></tr>
                    <tr><td><strong>Exclude from competition?</strong></td><td>' 
                    . (($formData['competition_exclusion'] ?? '') === 'yes' 
                        ? '<span class="yes">YES - exclude from competition</span>' 
                        : '<span class="no">No - want to compete</span>') 
                    . '</td></tr>
                    <tr><td><strong>Showcase Performance?</strong></td><td>' . htmlspecialchars($formData['showcase_performance'] ?? 'No') . '</td></tr>';

        if (($formData['showcase_performance'] ?? 'No') === 'Yes' && !empty($formData['showcase_songs'] ?? [])) {
            $body .= '
                    <tr><td><strong>Showcase Songs</strong></td><td><ul style="margin:4px 0; padding-left:18px;">';
            foreach ($formData['showcase_songs'] as $i => $song) {
                if (empty($song['title'])) continue;
                $secs = (int)($song['seconds'] ?? 0);
                $time = ($secs > 0) ? floor($secs/60) . ':' . str_pad($secs % 60, 2, '0', STR_PAD_LEFT) : '';
                $body .= '<li>' . htmlspecialchars($song['title']) . ($time ? " ($time)" : '') . '</li>';
            }
            $body .= '</ul></td></tr>';
        }

        $body .= '
                    <tr><td><strong>Garibaldi Performance?</strong></td><td>' 
                    . (($formData['garibaldi_performance'] ?? '') === 'yes' ? '<span class="yes">Yes</span>' : '<span class="no">No</span>') 
                    . '</td></tr>
                    <tr><td><strong>Staying at hotel?</strong></td><td>' 
                    . (($formData['hotel'] ?? '') === 'yes' 
                        ? '<span class="yes">Yes - ' . htmlspecialchars($formData['hotel_name'] ?? 'not specified') . '</span>' 
                        : '<span class="no">No</span>') 
                    . '</td></tr>
                </table>

                <p style="margin-top:2em; font-style:italic; color:#555;">
                    <strong>Number of performers registered:</strong> ' . $performerCount . '
                </p>

                <hr style="border:none; border-top:1px solid #eee; margin:2.5em 0 1.5em;">

                <p style="font-size:14px; color:#555; text-align:center;">
                    This is an automated confirmation from the Tucson Mariachi Registration System.<br>
                    Questions? Reply to this email or contact 
                    <a href="mailto:info@tucsonmariachi.org">info@tucsonmariachi.org</a>
                </p>
            </div>

            <div class="footer">
                <p>2026 Tucson Mariachi Conference | tucsonmariachi.org</p>
            </div>
        </div>
        </body>
        </html>';

        $mail->Body    = $body;
        $mail->AltBody = strip_tags(str_replace(
            ['<br>', '</p>', '</li>', '</tr>', '</td>', '</h', '<table', '<div'],
            ["\n", "\n\n", "\n- ", "\n", " | ", "\n\n", "\n\n---\n", "\n\n"],
            $body
        ));

        $mail->send();
        return true;

    } catch (Exception $e) {
        error_log("Registration email failed for $toEmail (PO $poNumber): " . $mail->ErrorInfo);
        return false;
    }

}