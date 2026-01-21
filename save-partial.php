<?php
session_start();
require_once __DIR__ . '/send-email.php';

$pdo = get_custom_db_connection();
$pdo->beginTransaction();

try {
    $data = $_POST;
    $jsonData = json_encode($data);
    $email = $data['email'] ?? ''; // director email
    $userEmail = $data['user_email'] ?? '';
    $token = isset($data['_resume_token']) && !empty($data['_resume_token']) ? $data['_resume_token'] : bin2hex(random_bytes(16));

    if (isset($data['_resume_token']) && !empty($data['_resume_token'])) {
        $stmt = $pdo->prepare("UPDATE partial_registrations SET data = ?, updated_at = NOW() WHERE token = ?");
        $stmt->execute([$jsonData, $token]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO partial_registrations (token, data, email) VALUES (?, ?, ?)");
        $stmt->execute([$token, $jsonData, $email]);
    }

    $pdo->commit();

    // Send email
    $baseUrl = 'https://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
    $resumeLink = $baseUrl . '/index.php?resume=' . $token;

    $directorName = trim(($data['director_first'] ?? '') . ' ' . ($data['director_last'] ?? ''));
    $userName = trim(($data['user_first_name'] ?? '') . ' ' . ($data['user_last_name'] ?? ''));
    $groupName = $data['group_name'] ?? 'Your Registration';

    sendResumeEmail($email, $directorName, $groupName, $resumeLink);
    if ($userEmail && strcasecmp($userEmail, $email) !== 0) {
        sendResumeEmail($userEmail, $userName, $groupName, $resumeLink);
    }
    sendResumeEmail('info@tucsonmariachi.org', 'Admin', $groupName, $resumeLink);

    echo '<h2>Progress Saved</h2><p>An email with a resume link has been sent. You can close this page.</p>';

} catch (Exception $e) {
    $pdo->rollBack();
    echo "Error saving progress: " . $e->getMessage();
}
?>