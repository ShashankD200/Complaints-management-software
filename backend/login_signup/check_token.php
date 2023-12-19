<?php
session_start();
    function trim_input_value($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        $data=strtolower($data);
        return $data;
    }
    
    if ($_SERVER['REQUEST_METHOD'] != 'POST')
    {  
        echo "
        <script>alert('Sorry!! This type of method is not supported');
            window.location.href='../../frontend/check_token.php';
        </script>";   
        exit;
    }
    
    if (!isset($_POST["code"]) || empty($_POST["code"]) || !isset($_POST["email"]) || empty($_POST["email"])) {
        echo "<script>alert('Please fill all the required information.');
                history.back();
            </script>";
        exit;
    }
    include('../config.php');
    $stmt="SELECT id, forgot_token FROM `users` WHERE email=(?) AND deleted_at IS NULL LIMIT 1";
    $sql=mysqli_prepare($conn, $stmt);

    //binding the parameters to prepard statement
    mysqli_stmt_bind_param($sql,"s",$email);
    $email=trim_input_value($_POST["email"]);
    $code=trim($_POST["code"]);

    $result=mysqli_stmt_execute($sql);
    $data= mysqli_stmt_get_result($sql);
    if ($data->num_rows <=0 ){
        echo "<script>alert('You have entered a wrong email id.');
            history.back();
            </script>";
        exit;
    }

    $row=mysqli_fetch_array($data);
    $forgot_token=$row['forgot_token'];

    if ($forgot_token != $code) {
        
        echo "<script>alert('Fail!! Wrong Code.')
            history.back();
        </script>";
    }
    $user_id=$row["id"]; 
    $_SESSION["user_id_for_password_reset"]=$user_id;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Complaints App - Business Management Software</title>
    <meta name="description" content="My Complaints App is a business management software that is helpful for startups and businessess. We help you to manage like a baniya.">
    <link rel="shortcut icon"  href="../../frontend/images/favicon/favicon.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <script src="https://kit.fontawesome.com/1788c719dd.js" crossorigin="anonymous"></script>

    <style>
        * {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        a {
            text-decoration: none;
        }

        body,
        input {
            font-family: "Poppins", sans-serif;
        }

        .container {
            position: relative;
            width: 100%;
            min-height: 100vh;
            background: #fff;
            overflow: hidden;
        }

        .container::before {
            content: "";
            position: absolute;
            width: 2000px;
            height: 2000px;
            border-radius: 50%;
            background: #03305D;
            right: 48%;
            -webkit-transform: translateY(-50%);
            transform: translateY(-50%);
            z-index: 6;
            -webkit-transition: 1.8s ease-in-out;
            transition: 1.8s ease-in-out;
        }

        .container__forms {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
        }

        .container__panels {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            display: -ms-grid;
            display: grid;
            -ms-grid-columns: (1fr) [2];
            grid-template-columns: repeat(2, 1fr);
        }

        form {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            padding: 0 5rem;
            overflow: hidden;
            -ms-grid-column: 1;
            -ms-grid-column-span: 1;
            grid-column: 1 / 2;
            -ms-grid-row: 1;
            -ms-grid-row-span: 1;
            grid-row: 1 / 2;
            -webkit-transition: 0.2s 0.7s ease-in-out;
            transition: 0.2s 0.7s ease-in-out;
        }

        form.form__sign-in {
            z-index: 2;
        }

        form.form__sign-up {
            z-index: 1;
            opacity: 0;
        }

        .form {
            position: absolute;
            top: 50%;
            left: 75%;
            -webkit-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
            width: 50%;
            display: -ms-grid;
            display: grid;
            -ms-grid-columns: 1fr;
            grid-template-columns: 1fr;
            z-index: 5;
            -webkit-transition: 1s 0.7s ease-in-out;
            transition: 1s 0.7s ease-in-out;
        }

        .form__title {
            font-size: 2.2rem;
            color: #444;
            margin-bottom: 10px;
        }

        .form__input-field {
            max-width: 380px;
            width: 100%;
            height: 3.437rem;
            background-color: #f0f0f0;
            margin: 10px 0;
            border-radius: 3.437rem;
            display: -ms-grid;
            display: grid;
            -ms-grid-columns: 15% 85%;
            grid-template-columns: 15% 85%;
            padding: 0 0.4rem;
        }

        .form__input-field i {
            text-align: center;
            line-height: 3.437rem;
            color: #acacac;
            font-size: 1.1rem;
        }

        .form__input-field input {
            background: none;
            outline: none;
            border: none;
            line-height: 1;
            font-weight: 600;
            font-size: 1.1rem;
            color: #333;
            border-radius: inherit;
        }

        .form__input-field input::-webkit-input-placeholder {
            color: #aaa;
            font-weight: 500;
        }

        .form__input-field input:-ms-input-placeholder {
            color: #aaa;
            font-weight: 500;
        }

        .form__input-field input::-ms-input-placeholder {
            color: #aaa;
            font-weight: 500;
        }

        .form__input-field input::placeholder {
            color: #aaa;
            font-weight: 500;
        }

        .form__submit {
            width: 9.375rem;
            height: 3.0625rem;
            border: none;
            outline: none;
            border-radius: 3.0625rem;
            cursor: pointer;
            background-color: #b538d1;
            color: #fff;
            text-transform: uppercase;
            font-weight: 600;
            margin: 10px 0;
            -webkit-transition: 0.5s;
            transition: 0.5s;
        }

        .form__submit:hover {
            background-color: #5a1369;
        }

        .form__social-text {
            padding: 0.7rem 0;
            font-size: 1rem;
        }

        .form__social-media {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
        }

        .form__social-icons {
            height: 2.875rem;
            width: 2.875rem;
            border: 1px solid #333;
            border-radius: 50%;
            margin: 0 0.45rem;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            color: #333;
            font-size: 1.1rem;
            -webkit-transition: 0.3s;
            transition: 0.3s;
        }

        .form__social-icons:hover {
            color: #d672ec;
            border-color: #d672ec;
        }

        .panel {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            -webkit-box-align: end;
            -ms-flex-align: end;
            align-items: flex-end;
            -ms-flex-pack: distribute;
            justify-content: space-around;
            text-align: center;
            z-index: 7;
        }

        .panel__content {
            color: #fff;
            -webkit-transition: 0.9s 0.6s ease-in-out;
            transition: 0.9s 0.6s ease-in-out;
        }

        .panel__left {
            pointer-events: all;
            padding: 3rem 17% 2rem 12%;
        }

        .panel__right {
            pointer-events: none;
            padding: 3rem 12% 2rem 17%;
        }

        .panel__title {
            font-weight: 600;
            line-height: 1;
            font-size: 1.5rem;
        }

        .panel__paragraph {
            font-size: 0.95rem;
            padding: 0.7rem 0;
            max-width: 560px;
        }

        .panel__image {
            width: 100%;
            -webkit-transition: 1.1s 0.4s ease-in-out;
            transition: 1.1s 0.4s ease-in-out;
        }

        .btn {
            border: none;
            outline: none;
            border-radius: 3.0625rem;
            cursor: pointer;
            color: #fff;
            text-transform: uppercase;
            font-weight: 600;
            -webkit-transition: 0.5s;
            transition: 0.5s;
            margin: 0;
            background: none;
            border: 2px solid #fff;
            width: 130px;
            height: 41px;
            font-size: 0.8rem;
        }

        /*Animation*/
        .panel__right .panel__content,
        .panel__right .panel__image {
            -webkit-transform: translateX(800px);
            transform: translateX(800px);
        }

        .container.sign-up-mode .panel__right .panel__content,
        .container.sign-up-mode .panel__right .panel__image {
            -webkit-transform: translateX(0px);
            transform: translateX(0px);
        }

        .container.sign-up-mode::before {
            -webkit-transform: translate(100%, -50%);
            transform: translate(100%, -50%);
            right: 52%;
        }

        .container.sign-up-mode .panel__left .panel__image,
        .container.sign-up-mode .panel__left .panel__content {
            -webkit-transform: translateX(-800px);
            transform: translateX(-800px);
        }

        .container.sign-up-mode .panel__left {
            pointer-events: none;
        }

        .container.sign-up-mode .panel__right {
            pointer-events: all;
        }

        .container.sign-up-mode .form {
            left: 25%;
        }

        .container.sign-up-mode form.form__sign-in {
            z-index: 1;
            opacity: 0;
        }

        .container.sign-up-mode form.form__sign-up {
            z-index: 2;
            opacity: 1;
        }

        @media (max-width: 870px) {
            .container {
                min-height: 800px;
                height: 100vh;
            }

            .container::before {
                width: 1500px;
                height: 1500px;
                left: 30%;
                bottom: 68%;
                -webkit-transform: translateX(-50%);
                transform: translateX(-50%);
                right: initial;
                top: initial;
                -webkit-transition: 2s ease-in-out;
                transition: 2s ease-in-out;
            }

            .form {
                width: 100%;
                left: 50%;
                top: 95%;
                -webkit-transform: translate(-50%, -100%);
                transform: translate(-50%, -100%);
                -webkit-transition: 1s 0.8s ease-in-out;
                transition: 1s 0.8s ease-in-out;
            }

            .container__panels {
                -ms-grid-columns: 1fr;
                grid-template-columns: 1fr;
                -ms-grid-rows: 1fr 2fr 1fr;
                grid-template-rows: 1fr 2fr 1fr;
            }

            .panel {
                -webkit-box-orient: horizontal;
                -webkit-box-direction: normal;
                -ms-flex-direction: row;
                flex-direction: row;
                -ms-flex-pack: distribute;
                justify-content: space-around;
                -webkit-box-align: center;
                -ms-flex-align: center;
                align-items: center;
                padding: 2.5rem 8%;
            }

            .panel__left {
                -ms-grid-row: 1;
                -ms-grid-row-span: 1;
                grid-row: 1 / 2;
            }

            .panel__right {
                -ms-grid-row: 3;
                -ms-grid-row-span: 1;
                grid-row: 3 / 4;
            }

            .panel__image {
                width: 200px;
                -webkit-transition: 0.9s 0.6s ease-in-out;
                transition: 0.9s 0.6s ease-in-out;
            }

            .panel__content {
                padding-right: 15%;
                -webkit-transition: 0.9s 0.8s ease-in-out;
                transition: 0.9s 0.8s ease-in-out;
            }

            .panel__title {
                font-size: 1.2rem;
            }

            .panel__paragraph {
                font-size: 0.7rem;
                padding: 0.5rem 0;
            }

            .panel__right .panel__content,
            .panel__right .panel__image {
                -webkit-transform: translateY(300px);
                transform: translateY(300px);
            }

            .btn {
                width: 6.875rem;
                height: 2.187rem;
                font-size: 0.7rem;
            }

            .container.sign-up-mode::before {
                -webkit-transform: translate(-50%, 100%);
                transform: translate(-50%, 100%);
                bottom: 32%;
                right: initial;
            }

            .container.container.sign-up-mode .panel__left .panel__image,
            .container.container.sign-up-mode .panel__left .panel__content {
                -webkit-transform: translateY(-300px);
                transform: translateY(-300px);
            }

            .container.sign-up-mode .form {
                top: 5%;
                -webkit-transform: translate(-50%, 0);
                transform: translate(-50%, 0);
                left: 50%;
            }
        }

        @media (max-width: 570px) {
            form {
                padding: 0 1.5rem;
            }

            .panel__image {
                display: none;
            }

            .panel__content {
                padding: 0.5rem 1rem;
            }

            .container::before {
                bottom: 72%;
                left: 50%;
            }

            .container.sign-up-mode::before {
                bottom: 28%;
                left: 50%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="container__forms">
            <div class="form">
                <form action="./set_new_password.php" method="post" class="form__sign-in" onsubmit="return confirm()">
                    <h2 class="form__title">Reset Password</h2>
                    <input hidden type="number" name="user_id" value="<?php echo $user_id;?>">
                    <div class="form__input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" id="password"  placeholder="Enter New Password" required />
                    </div>
                    <div class="form__input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="Confirm Password" id="confirm_password" name="confirm_password"  required />
                    </div>
                    <input class="form__submit" type="submit" style="background-color: #FF3859; border: 0px;" 
                    value="Set Password" />
                </form>
            </div>
        </div>
        <div class="container__panels">
            <div class="panel panel__left">
                <div class="panel__content">
                    <h3 class="panel__title" style="color: white;">Reset Your Password</h3>
                    <p class="panel__paragraph" style="color: white;">
                        Here you can create a new password. Just enter a new unique password then confirm it and hit the button.
                    </p>
                </div>
                
            </div>
        </div>
    </div>

    <script>
        function confirm(){
            if (document.getElementById('password').value==document.getElementById('confirm_password').value) {
                return true;
            } else {
                alert("Fail!! Passwords are not matching.");
                return false;
            }
        }
    </script>
</body>
</html>       


