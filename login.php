<!DOCTYPE html>
<html>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
    integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="./styles/styles.css">

<head>
    <title>Weather Getter - Login </title>
</head>

<body>
    <?php
    session_start();
    $errors = array();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Get form data
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Validate form data

        if (empty($username)) {
            $errors[] = 'Username is required';
        }
        if (empty($password)) {
            $errors[] = 'Password is required';
        }
    }

    if (count($errors) == 0) {
        include 'config.php';
        $conn = connectDb();
        if ($conn->connect_error) {
            die("Connection Failed: " . $conn->connect_error);
        }
        $stmt = $conn->prepare('SELECT * FROM users WHERE username = ? AND password = ?');
        $stmt->bind_param('ss', $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {

            // Start session and store user data
            $user = $result->fetch_assoc();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_username'] = $user['username'];
            $_COOKIE['user'] = $user['username'];
            $_SESSION['authenticated'] = true;
            // Redirect to home page
            header('Location: index.php');
            exit();
        } else {

            // Invalid email or password
            $errors[] = 'Invalid username or password';
        }

        // Close database connection
        $stmt->close();
        $conn->close();
    }
    ?>
    <h1 class="title" id="title">Weather Getter</h1>
    <div class="bar">&nbsp;</div>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <section class="vh-100 loginbackground">
            <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-lg-12 col-xl-11">
                        <div class="card text-black" id="loginstyle">
                            <div class="card-body p-md-5">
                                <div class="row justify-content-center">
                                    <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                                        <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Login</p>

                                        <form class="mx-1 mx-md-4">

                                            <div class="d-flex flex-row align-items-center mb-4">
                                                <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                                <div class="form-outline flex-fill mb-0">
                                                    <form method="POST"
                                                        action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                                        <input type="text" name="username" class="form-control" />
                                                        <label class="form-label" for="username">Username</label>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-row align-items-center mb-4">
                                                <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                                <div class="form-outline flex-fill mb-0">
                                                    <input type="password" name="password" class="form-control" />
                                                    <label class="form-label" for="password">Password</label>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                                <input class="btn btn-primary" type="submit" value="Submit">
                                            </div>
                                            <h6 class="h6">Don't have an account yet?</h6><a href="Register.php"
                                                class="link-primary">Register</a>

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