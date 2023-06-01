<?php
//include the config.php file that contains database info
include "config.php";
$error = "";

// Check if the form is submitted (POST method)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $email = $_POST["email"];
  $password = $_POST["password"];
  $repassword = $_POST["repassword"];

  // Validate username
  if (!preg_match("/^[a-zA-Z0-9_]+$/", $username)) {
    $error = "Username can only contain letters, numbers, and underscores.";
  }

  // Validate email
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "Invalid email address.";
  }

  // Validate password
  $uppercase = preg_match('@[A-Z]@', $password);
  $lowercase = preg_match('@[a-z]@', $password);
  $number = preg_match('@[0-9]@', $password);

  if (strlen($password) < 8 || !$uppercase || !$lowercase || !$number) {
    $error = "Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one number.";
    echo $error;
  } else if ($password !== $repassword) {
    $error = "Passwords do not match";
    echo $error;
  }

  // If there are any validation errors
  if (!empty($error)) {
    $_POST["username"] = $username;
    $_POST["email"] = $email;
    $error = "<div class='error'>" . $error . "</div>";
  } else {
    // Connect to the database
    $conn = connectDb();
    if (!$conn) {
      $error = "Failed to connect to the database";
    } else {
      session_start();

      // Prepare and execute the SQL statement to insert the user into the database
      $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?,?,?)");
      $stmt->bind_param("sss", $username, $email, $password);
      $_SESSION['user_username'] = $username;
      try {
        $stmt->execute();
      } catch (Exception $e) {
        $error = "Error inserting data into the table: " . $e->getMessage();
      }

      // Clear session data and close database connection
      session_unset();
      session_destroy();
      $stmt->close();
      $conn->close();

      // Redirect the user to the login page
      header("Location: login.php");
      exit();
    }
  }
}
?>

<!DOCTYPE html>
<html>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
    integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="./styles/styles.css">

<head>
    <title>Weather Getter - Register</title>
</head>

<body>

    <h1 class="title" id="title">Weather Getter</h1>
    <div class="bar">&nbsp;</div>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);  ?>" enctype="multipart/form-data">
        <section class="vh-100 loginbackground">
            <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-lg-12 col-xl-11">
                        <div class="card text-black" id="loginstyle">
                            <div class="card-body p-md-5">
                                <div class="row justify-content-center">
                                    <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                                        <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up</p>
                                        <form class="mx-1 mx-md-4">
                                            <div class="d-flex flex-row align-items-center mb-4">
                                                <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                                <div class="form-outline flex-fill mb-0">
                                                    <form method="POST"
                                                        action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                                        <input type="text" name="username" class="form-control"
                                                            value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>" />
                                                        <label class="form-label" for="username">Username</label>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-row align-items-center mb-4">
                                                <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                                <div class="form-outline flex-fill mb-0">
                                                    <input type="email" name="email" class="form-control"
                                                        value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" />
                                                    <label class="form-label" for="email">Email</label>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-row align-items-center mb-4">
                                                <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                                <div class="form-outline flex-fill mb-0">
                                                    <input type="password" name="password" class="form-control" />
                                                    <label class="form-label" for="password">Password</label>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-row align-items-center mb-4">
                                                <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                                <div class="form-outline flex-fill mb-0">
                                                    <input type="password" name="repassword" class="form-control" />
                                                    <label class="form-label" for="repassword">Re-type Password</label>
                                                </div>
                                            </div>
                                            <?php if (!empty($error)) : ?>
                                            <div class="alert alert-danger" class="loginerror"><?php echo $error; ?>
                                            </div>
                                            <?php endif; ?>
                                            <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                                <input class="btn btn-primary" type="submit" value="Submit">
                                            </div>

                                            <h6 class="h6">Already have an account?</h6><a href="login.php"
                                                class="link-primary">Login</a>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
    </div>
    </form>
</body>

</html>