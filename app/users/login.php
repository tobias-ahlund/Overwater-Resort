<?php

session_start();

$authenticated = $_SESSION['authenticated'] ?? false;

?>
<div class="page-wrapper">
    <?php

    // Magnus V. - Require in the checkLogin.php. The file contains the connection to user.db, and also fetches the "Admins"-table so that login input can be checked.
    require "./checkLogin.php";
    require "../../header.php";

    ?>

    <!-- To be added to proper css-file: -->
    <div class="actions-space">

        <?php

        if (isset($_POST['user-name'], $_POST['password'])) :

            (string) $userName = htmlspecialchars($_POST['user-name']);
            (string) $password = htmlspecialchars($_POST['password']);

            // Magnus V. - Error messages if username or password fields are empty. On "OK"-click the user will be redirected to index.php.
            if (empty($userName)) : ?>
                <div class="user-name-password-fail">
                    <p>It looks like the Username field was empty. Please try again.</p>
                    <button class="OK-button">Okay</button>
                </div>
            <?php elseif (empty($password)) : ?>
                <div class="user-name-password-fail">
                    <p>It looks like the Password field was empty. Please try again.</p>
                    <button class="OK-button">Okay</button>
                </div>
                <?php endif;

            if (!empty($userName) && !empty($password)) {
                // Magnus - V. - Fetching users from database:
                $users = getUsersFromUsersDb();

                // Magnus V. - checking input username and password:
                $userNameCheck = checkUserName($userName, $users);
                $passwordCheck = checkPassword($password, $users);

                // Magnus - V. - Final validation for login:
                $validateLogin = validateLogin($userNameCheck, $passwordCheck);

                if ($validateLogin) : {
                        $_SESSION['authenticated'] = true;
                        header("location: ../../index.php");
                    }
                else : ?>
                    <div class="user-name-password-fail">
                        <p>Either the Username or password was wrong. Please try again.</p>
                        <button class="OK-button">Okay</button>
                    </div>
        <?php endif;
            }

        endif;

        ?>

    </div>

    <script src="../../loginScript.js"></script>

    <?php
    require "../../footer.php";
    ?>

</div>
