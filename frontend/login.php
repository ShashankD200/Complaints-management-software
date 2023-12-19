<?php
session_start();
if (isset($_SESSION["is_admin"])) {
    header("location: ./admin/dashboard.php");
}
?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Complaints App - Business Management Software</title>
    <meta name="description" content="My Complaints App is a business management software that is helpful for startups and businessess. We help you to manage like a baniya.">
    <link rel="shortcut icon"  href="./images/favicon/favicon.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
   

    <script src="https://kit.fontawesome.com/1788c719dd.js" crossorigin="anonymous"></script>

    <style>
        @media (min-width:0px) and (max-width:400px) {
            .ourLogo{
                display: none;
            }
        }
        @media (min-width:401px) and (max-width:600px) {
            .ourLogo{
                width: 50px;
            }
        }
        @media (min-width:601px) and (max-width:870px) {
            .ourLogo{
                width: 63px;
            }
        }
        @media (min-width:871px) and (max-width:1000px) {
            .ourLogo{
                width: 120px;
            }
        }
    </style>
    <link rel="stylesheet" href="./css/user_login.css">

</head>

<body>
    <div id="loader" class="center"></div>
    <div class="container">
        <div class="container__forms">
            <div class="form">
                <!-- Sign In Form  -->
                <form action="../backend/login_signup/login.php" method="post" onsubmit="return showloader()"
                    class="form__sign-in">
                    <h2 class="form__title">Sign In</h2>
                    <div class="form__input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" name="email" placeholder="Email" required />
                    </div>
                    <div class="form__input-field">
                        <i class="fas fa-eye-slash" id="lockicon" onclick="make_it_visible()"></i>
                        <input type="password" placeholder="Password" name="password" id="mypassword" required />
                        <!-- <input type="checkbox"> -->
                    </div>
                    <input class="form__submit" type="submit" style="background-color: #FF3859; border: 0px;"
                        value="Sign In" />
                    <div class="new-user-box">
                        <span>Forgot Password ? </span>
                        <a type="button" href="./enter_mail.php" id="btn1">Reset</a>
                    </div>

                </form>

                <!-- Sign Up Form -->
                <form action="../backend/login_signup/sign_up.php" onsubmit="return showloader()" method="post"
                    class="form__sign-up">
                    <h2 class="form__title">Sign Up</h2>
                    <div class="form__input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" placeholder="Name" name="name" required />
                    </div>
                    <div class="form__input-field">
                        <i class="fas fa-envelope"></i>
                        <input type="email" placeholder="Email" name="email" required />
                    </div>
                    <div class="form__input-field">
                        <i class="fas fa-phone"></i>
                        <input type="tel" minlength="10" placeholder="Phone Number" name="phone" required />
                    </div>
                    <div class="form__input-field">
                        <i class="fas fa-eye-slash" id="lockicon2" onclick="make_it_visible2()"></i>
                        <input type="password" placeholder="Password" min="8" name="password" id="mypassword2" required />
                    </div>

                    <input class="form__submit" type="submit" style="background-color: #FF3859; border: 0px;"
                        value="Sign Up" />

                </form>
            </div>
        </div>
        <div class="container__panels">
            <div class="panel panel__left">
                <div class="panel__content">
                    
                    <h3 class="panel__title" style="color: white;">New user ?</h3>
                    <p class="panel__paragraph" style="color: white;">
                       Signup and get started to My Complaints App, where you can manage all complaints !
                    </p>
                    <br>

                    <button class="btn" style="background-color: #FF3859; border: 0px;" id="sign-up-btn">
                        Sign Up
                    </button>
                </div>
                <!-- <img class="panel__image" src="./images/login.png" alt="login_img" /> -->
            </div>
            <div class="panel panel__right">
                <div class="panel__content"> 
                    <h3 class="panel__title" style="color: white;">Already have a account ?</h3>
                    <p class="panel__paragraph" style="color: white;">
                    Sign In and start managing your complaints !
                    </p>
                    <button class="btn" style="background-color: #FF3859; border: 0px;" id="sign-in-btn">
                        Sign In
                    </button>
                </div>
                <!-- <img class="panel__image" src="./images/signup.png" alt="signup_img" /> -->
            </div>
        </div>
    </div>

    <script>
        var passwordClick=1;

        function make_it_visible(){
            if (passwordClick==1) {
                document.getElementById('lockicon').classList.remove('fa-eye-slash');
                document.getElementById('lockicon').classList.add('fa-eye');
                document.getElementById('mypassword').type="text";
                passwordClick=2;
            } 
            else {
                document.getElementById('lockicon').classList.add('fa-eye-slash');
                document.getElementById('lockicon').classList.remove('fa-eye');
                document.getElementById('mypassword').type="password";
                passwordClick=1;
            }
        }
    </script>

<script>
    var passwordClick2=1;

    function make_it_visible2(){
        if (passwordClick2==1) {
            document.getElementById('lockicon2').classList.remove('fa-eye-slash');
            document.getElementById('lockicon2').classList.add('fa-eye');
            document.getElementById('mypassword2').type="text";
            passwordClick2=2;
        } 
        else {
            document.getElementById('lockicon2').classList.add('fa-eye-slash');
            document.getElementById('lockicon2').classList.remove('fa-eye');
            document.getElementById('mypassword2').type="password";
            passwordClick2=1;
        }
    }
</script>

    <script>
        document.onreadystatechange = function () {
            if (document.readyState !== "complete") {
                document.querySelector(
                    "body").style.visibility = "hidden";
                document.querySelector(
                    "#loader").style.visibility = "visible";
            } else {
                document.querySelector(
                    "#loader").style.display = "hidden";
                document.querySelector(
                    "body").style.visibility = "visible";

            }
        };
    </script>

    <script>
        function showloader() {

            document.querySelector(
                "body").style.visibility = "hidden";
            document.querySelector(
                "#loader").style.visibility = "visible";
            document.querySelector(
                "#loader").style.zIndex = "2";

            return true;
        }
    </script>

    <script>
        const signInBtn = document.querySelector("#sign-in-btn");
        const signUpBtn = document.querySelector("#sign-up-btn");
        const container = document.querySelector(".container");

        signUpBtn.addEventListener("click", () => {
            container.classList.add("sign-up-mode");
        });

        signInBtn.addEventListener("click", () => {
            container.classList.remove("sign-up-mode");
        });

    </script>

</body>

</html>