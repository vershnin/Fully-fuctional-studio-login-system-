<?php
/*
    include('link.php');
    if (isset($_POST['submit'])) {
        $username = $_POST['user'];
        $password = $_POST['pass'];

        $sql = "select * from login where username = '$username' and password = '$password'";  
        $result = mysqli_query($conn, $sql);  
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
        $count = mysqli_num_rows($result);  
        
        if($count == 1){  
            header("Location: welcome.php");
        }  
        else{  
            echo  '<script>
                        window.location.href = "index.php";
                        alert("Login failed. Invalid username or password!!")
                    </script>';
        }     
    }
    ?>*/

    include('link.php');

// Check if the submit button was clicked
if (isset($_POST['submit'])) { 
    $username = mysqli_real_escape_string($conn, $_POST['user']); // Escape user input for security
    $password = mysqli_real_escape_string($conn, $_POST['pass']); // Escape password for security

    // Prepare a SQL statement using prepared statements (recommended)
    $sql = "SELECT * FROM login WHERE username = ? AND password = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // Bind parameters to prevent SQL injection
        mysqli_stmt_bind_param($stmt, "ss", $username, $password); // 's' for string types

        // Execute the prepared statement
        mysqli_stmt_execute($stmt);

        // Get the result (if any exists)
        $result = mysqli_stmt_get_result($stmt);

        // Check if a user record was found
        if (mysqli_num_rows($result) === 1) {
            header("Location: welcome.php"); // Use header redirection for cleaner approach
        } else {
            echo "Login failed. Invalid username or password."; // Simpler error message
        }

        // Close the statement (important for resource management)
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome!</title>
    <link rel="stylesheet" href="pagestyle.css">
</head>
<body>

    <header>
        <h1>Welcome!</h1>
    </header>

    <main>
        <section class="introduction">
            <p>This is a welcome page. You can customize it to display any information you want to present to visitors.</p>
        </section>

        <section class="call-to-action">
            <h2>What would you like to do next?</h2>
            <ul>
                <li><a href="#">Learn more about us</a></li>
                <li><a href="#">Explore our services</a></li>
                <li><a href="#">Contact Us</a></li>
            </ul>
        </section>
    </main>

</body>
</html>


