<?php
session_start();
include '../includes/db';

$msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_POST['email'];
  $stmt = $conn->prepare("SELECT * FROM admins WHERE email=?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $admin = $stmt->get_result()->fetch_assoc();

  if ($admin) {
    $token = bin2hex(random_bytes(32));
    $expires = date("Y-m-d H:i:s", strtotime("+30 minutes"));

    $stmt = $conn->prepare("UPDATE admins SET reset_token=?, token_expire=? WHERE email=?");
    $stmt->bind_param("sss", $token, $expires, $email);
    $stmt->execute();

    $mail = new PHPMailer(true);
    try {
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      $mail->Username = 'leonardjjmhone@gmail.com'; // 🔴 your Gmail
      $mail->Password = '@Itecictesolutionz2025'; // 🔴 Gmail password or app password
      $mail->SMTPSecure = 'tls';
      $mail->Port = 587;

      $mail->setFrom('leonardjmhone@gmail.com', 'PSA Admin');
      $mail->addAddress($email);
      $mail->isHTML(true);
      $mail->Subject = 'Password Reset Request';
      $reset_link = "http://localhost/psamalawi/reset_password.php?token=$token";
      $mail->Body = "Click <a href='$reset_link'>here</a> to reset your password. Link expires in 30 minutes.";
      $mail->send();
      $msg = "✅ Reset link sent. Check your email.";
    } catch (Exception $e) {
      $msg = "❌ Mail Error: " . $mail->ErrorInfo;
    }
  } else {
    $msg = "❌ Email not found.";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Forgot Password - PSA Admin</title>
  <link rel="icon" href="../images/favicon.png" type="image/x-icon">
  <style>
    body {
      background: linear-gradient(135deg, #000, #117733, #cc0000);
      font-family: 'Segoe UI', sans-serif;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      margin: 0;
      animation: fadeIn 1s ease-in-out;
    }
    .container {
      background: #fff;
      padding: 30px 40px;
      border-radius: 12px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.2);
      width: 100%;
      max-width: 420px;
      animation: slideIn 0.6s ease-out;
    }
    .container h3 {
      text-align: center;
      color: #117733;
      margin-bottom: 20px;
    }
    input[type="email"] {
      width: 100%;
      padding: 10px 14px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 16px;
      box-sizing: border-box;
    }
    button {
      background: #cc0000;
      color: #fff;
      padding: 12px 16px;
      border: none;
      width: 100%;
      font-size: 16px;
      border-radius: 6px;
      transition: 0.3s ease;
      cursor: pointer;
    }
    button:hover {
      background: #b30000;
    }
    .message {
      text-align: center;
      margin-bottom: 15px;
      color: #333;
    }
    footer {
      text-align: center;
      color: #eee;
      font-size: 13px;
      margin-top: 30px;
    }
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }
    @keyframes slideIn {
      from { transform: translateY(40px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }
  </style>
</head>
<body>
  <div class="container">
    <form method="post">
      <h3>Forgot Password</h3>
      <div class="message"><?= $msg ?></div>
      <input type="email" name="email" placeholder="Enter your email" required>
      <button type="submit">Send Reset Link</button>
    </form>
  </div>
  <footer>&copy; 2026 PSA Admin Portal. All rights reserved.</footer>
</body>
</html>
