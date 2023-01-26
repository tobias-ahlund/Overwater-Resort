<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Magnus V. - Added a "/" to make filepaths relative -->
    <link href="/styles.css" rel="stylesheet">
    <link href="/header.css" rel="stylesheet">
    <link href="/hero.css" rel="stylesheet">
    <link href="/nav.css" rel="stylesheet">
    <link href="/main.css" rel="stylesheet">
    <link href="/forms.css" rel="stylesheet">
    <link href="/footer.css" rel="stylesheet">
    <link href="/calendar.css" rel="stylesheet">
    <link href="/bookings.css" rel="stylesheet">
    <link href="/receipt.css" rel="stylesheet">
    <link href="/messages.css" rel="stylesheet">
    <link href="/admin.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overwater Resort</title>
</head>

<body>
    <!-- Header -->
    <header>

        <!-- Magnus V. - Added a new <div>-element to wrap the old header content -->
        <div class="landing-wrapper">
            <h1>Overwater Resort</h1>
            <div class="hr-container">
                <hr class="header-hr">
                <!-- Magnus V. - Added a "/" to make filepaths relative -->
                <img src="/images/star.svg" alt="">
                <img src="/images/star.svg" alt="">
                <hr class="header-hr">
            </div>
            <h4 class="header-est">Established 1986</h4>
        </div>

        <!-- Magnus V. - Added a new element to contain the new "Log in"-text and elements on the header's right side. -->
        <div class="login-wrapper">
            <div class="login-content">

                <?php
                if (!$authenticated) :
                ?> <span>Log in</span>
                    <!-- The login-form -->
                    <div class="drop-down-field">
                        <form class="login-form" action="/app/users/login.php" method="post">

                            <!-- User name-field -->
                            <div class="label-container">
                                <label for="user-name">User name</label>
                            </div>
                            <input id="user-name" type="text" name="user-name" placeholder="(Your first name)" required>

                            <!-- Field for API-key-input -->
                            <div class="label-container">
                                <label for="password">Password</label>
                            </div>
                            <input id="password" type="password" name="password" placeholder="(api-key)" required>

                            <div class="break"></div>

                            <div class="button-container">
                                <button type="submit">Login</button>
                            </div>
                        </form>
                    </div>

                <?php
                else :
                ?>
                    <a href="/index.php">Home</a>
                    <a href="/app/users/hotel-manager.php">Admin</a>
                    <span>Log out</span>
                    <!-- The confirm logout-message -->
                    <div class="drop-down-field">
                        <form class="logout-form" action="/app/users/logout.php">

                            <p>Log out?</p>

                            <div class="break"></div>

                            <div class="button-container">
                                <button>Log out</button>
                            </div>

                        </form>
                    </div>

                <?php
                endif;
                ?>

            </div>
        </div>
    </header>
