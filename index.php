<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./styles/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <?php
  session_start();
  if (isset($_SESSION['authenticated']) !== true) {
    header('Location: login.php');
    exit();
  }
  ?>
    <header>
        <h1 class="title" id="title">Weather Getter</h1>
        <div class="bar">&nbsp;</div>
        <span class="h6" id="loggedintext"><?php echo $_SESSION['user_username']; ?></span>
        <a class="btn btn-light" id="logoutbtn" href="logout.php">Logout</a>
    </header>
    <section class="homepage visible">
        <img src="./images/SL_042221_42420_05.jpg" style="height:100%; width: 100%">
        <div class="weather-container">
            <input type="text" class="input_text" placeholder="Enter city name">
            <button class="btn btn-primary submit">Search</button>
            <div class="weather-info">
                <h2 id="name"></h2>
                <p class="desc"></p>
                <p class="temp"></p>
                <p class="clouds"></p>
            </div>
        </div>
        <script>
        var input = document.querySelector(".input_text");
        var button = document.querySelector(".submit");
        var cityName = document.getElementById("name");
        var desc = document.querySelector(".desc");
        var temp = document.querySelector(".temp");
        var clouds = document.querySelector(".clouds");
        button.addEventListener("click", function() {
            var city = input.value;
            var apiUrl = `weather.php?city=${city}`;
            fetch(apiUrl)
                .then((response) => response.json())
                .then((data) => {
                    cityName.textContent = data.name;
                    temperature = (data.main.temp - 273.15).toFixed(2)
                    desc.textContent = "Description: " + data.weather[0].description;
                    temp.textContent = "Temperature: " + temperature + "°C";
                    clouds.textContent = "Clouds: " + data.clouds.all + "%";
                })
                .catch((error) => {
                    console.log("Error:", error);
                    alert("Failed to fetch weather data. Please try again.");
                });
        });
        </script>
        </form>
    </section>
</body>

</html>