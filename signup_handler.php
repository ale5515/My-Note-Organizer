<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['full_name'])) {
    $name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $name, $email, $password);

    if (mysqli_stmt_execute($stmt)) {
        echo "<div style='text-align:center; margin-top:50px; font-family:sans-serif;'>";
        echo "<h2 style='color: #6c5ce7;'>Database Success!</h2>";
        
        $apiKey = 'mlsn.ed16d03d67cb14b36cba9e8ec96565525ba1edd59e2ddf3d5200b48dada8ac25'; 
        $senderEmail = 'MS_KvKQgB@test-68zxl273vxk4j905.mlsender.net';

        $welcomeData = [
            "from" => ["email" => $senderEmail, "name" => "Ale's Organizer"],
            "to" => [["email" => $email, "name" => $name]],
            "subject" => "Welcome Home! ✨",
            "html" => "
                <div style='font-family: sans-serif; max-width: 500px; margin: auto; border: 1px solid #eee; border-radius: 20px; overflow: hidden;'>
                    <div style='background: #6c5ce7; padding: 20px; text-align: center; color: white;'>
                        <h1 style='margin:0;'>Welcome Home!</h1>
                    </div>
                    <div style='padding: 20px; color: #333;'>
                        <p>Hi $name,</p>
                        <p>I built this for you so you can stay organized and focused. I hope it helps you with everything you're working on!</p>
                        <p><strong>Your Dashboard is ready:</strong></p>
                        <ul>
                            <li>Check your Daily Goals</li>
                            <li>Write in your private Journal</li>
                            <li>Your Focus Bear is waiting for you!</li>
                        </ul>
                        <p style='margin-top: 20px;'>I'm so proud of you.</p>
                        <p><strong>Love, Ale</strong></p>
                    </div>
                </div>"
        ];

        $ch = curl_init('https://api.mailersend.com/v1/email');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($welcomeData));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode == 202) {
            echo "<p style='color:green;'>Account created successfully!</p>";
        } else {
            echo "<p style='color:red;'>MailerSend refused the email. Error Code: $httpCode</p>";
            echo "<pre>Response: $response</pre>";
        }
        echo "<p><a href='login.php'>Go to Login</a></p></div>";
        exit();
    } else {
        echo "Database Error: " . mysqli_error($conn);
    }
}
?>