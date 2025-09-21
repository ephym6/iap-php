<?php

require_once __DIR__ . '/../ClassAutoLoad.php';
$conn = require __DIR__ . '/../config/db_conn.php';

// Fetch users with their creation date
$result = $conn->query("SELECT id, name, email, password, created_at FROM users ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Users – ICS 2.2</title>
    <style rel="stylesheet" href="../css/list_users.css" >
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            padding: 40px;
            display: flex;
            justify-content: center;
        }
        .container {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            max-width: 650px;
            width: 100%;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        ol {
            padding-left: 20px;
            font-size: 16px;
        }
        li {
            margin: 12px 0;
            line-height: 1.4;
        }
        .joined {
            font-size: 14px;
            color: #666;
        }
        .back-links {
            margin-top: 25px;
            text-align: center;
        }
        a {
            display: inline-block;
            margin: 5px;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            color: #fff;
        }
        .home-btn {
            background: #007bff;
        }
        .signup-btn {
            background: #28a745;
        }
        a:hover {
            opacity: 0.85;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Registered Users</h2>

    <?php if ($result && $result->num_rows > 0): ?>
        <ol>
            <?php while ($row = $result->fetch_assoc()): ?>
                <li>
                    <strong><?php echo htmlspecialchars($row['name']); ?></strong> –
                    <?php echo htmlspecialchars($row['email']); ?><br>
                    <span class="joined">Joined: <?php echo date('d M Y, H:i', strtotime($row['created_at'])); ?></span>
                </li>
            <?php endwhile; ?>
        </ol>
    <?php else: ?>
        <p style="text-align:center;">No users have signed up yet.</p>
    <?php endif; ?>

    <div class="back-links">
        <a href="/index.php" class="home-btn">Back to Home</a>
        <a href="/thankyou.php" class="signup-btn">Back to Thank You</a>
    </div>
</div>
</body>
</html>
