<?php
$host = 'db';
$dbname = 'challenge_db';
$username = 'challenge_user';
$password = 'challenge_password';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// SECURITY ISSUE 1: Direct user input in SQL query without sanitization
// SECURITY ISSUE 2: Using string concatenation instead of prepared statements
// SECURITY ISSUE 3: Displaying database errors to users
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];  // Raw input - not sanitized
    $user_password = $_POST['password'];  // Raw input - not sanitized
    
    // VULNERABLE QUERY - Direct string concatenation
    // FIX: Use prepared statements with placeholders:
    // $query = "SELECT * FROM users WHERE username = ? AND password = ?";
    // $stmt = $pdo->prepare($query);
    // $stmt->execute([$username, $user_password]);
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$user_password'";
    
    try {
        $result = $pdo->query($query);
        
        // SECURITY ISSUE 4: Different behavior based on query content allows attackers to identify injection success
        if (stripos($username, 'UNION') !== false || stripos($username, 'LIKE') !== false) {
            $users = $result->fetchAll(PDO::FETCH_ASSOC);
            if ($users) {
                // SECURITY ISSUE 5: Displaying sensitive data (passwords, credit cards, SSNs)
                echo "<div class='result'>Found " . count($users) . " users matching the query:<br><br>";
                foreach ($users as $user) {
                    echo "=== User Data ===<br>";
                    echo "Username: " . htmlspecialchars($user['username']) . "<br>";
                    echo "Password: " . htmlspecialchars($user['password']) . "<br>";
                    echo "Credit Card: " . htmlspecialchars($user['credit_card']) . "<br>";
                    echo "SSN: " . htmlspecialchars($user['ssn']) . "<br><br>";
                }
                echo "</div>";
            } else {
                echo "<div class='error'>Invalid username or password.</div>";
            }
        } else {
            $user = $result->fetch(PDO::FETCH_ASSOC);
            if ($user) {
                echo "<div class='result'>Login successful! User data:<br><br>";
                echo "Username: " . htmlspecialchars($user['username']) . "<br>";
                echo "Password: " . htmlspecialchars($user['password']) . "<br>";
                echo "Credit Card: " . htmlspecialchars($user['credit_card']) . "<br>";
                echo "SSN: " . htmlspecialchars($user['ssn']) . "</div>";
            } else {
                echo "<div class='error'>Invalid username or password.</div>";
            }
        }
    } catch(PDOException $e) {
        echo "<div class='error'>Error: " . $e->getMessage() . "</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Secure Login System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f0f0f0;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #45a049;
        }
        .result {
            margin-top: 20px;
            padding: 10px;
            background-color: #dff0d8;
            border: 1px solid #d6e9c6;
            color: #3c763d;
        }
        .error {
            margin-top: 20px;
            padding: 10px;
            background-color: #f2dede;
            border: 1px solid #ebccd1;
            color: #a94442;
        }
        .hint {
            margin-top: 20px;
            padding: 10px;
            background-color: #d9edf7;
            border: 1px solid #bce8f1;
            color: #31708f;
        }
        .levels {
            margin-top: 20px;
            padding: 10px;
            background-color: #fff3cd;
            border: 1px solid #ffeeba;
            color: #856404;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Secure Login System</h1>
        <p>Welcome to our totally secure login system. Nothing could possibly go wrong here! 🔒</p>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>

        <div class="hint">
            <h3>Challenge:</h3>
            <p>Can you bypass our secure login system? Try these levels:</p>
        </div>

        <div class="levels">
            <h4>🎯 Challenge Levels:</h4>
            <p>1. Level One: Can you login without knowing the password?</p>
            <p>2. Level Two: Can you see ALL users and their passwords?</p>
            <p>3. Challenge: Find all admin accounts and their details</p>
            <br>
            <p>Once you have completed the challenge, send a screenshot to w0194127@nscc.ca including the input field with your query, and the successful feedback box.</p>
            <p><em>Hint: SQL uses special characters like ' and --  for a reason... 😈 Investigate the cheet sheat in the README.
            </em></p>
        </div>
    </div>
</body>
</html>