<?php

declare(strict_types=1);

// Magnus V. - This connection is for fetching the user information from user.db to be compared with login-input.
function getUsersFromUsersDb(): array
{
    // Magnus V. - connection try against user.db
    try {
        $userDbh = new PDO('sqlite:../database/user.db');
        $userDbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $userDbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'Connection failed:';
        throw $e;
    }

    $userStmt = $userDbh->prepare(('SELECT * from admins'));

    $userStmt->execute();

    // Magnus V. - all users (or admins if you like) are fetched from the user-database:
    $users = $userStmt->fetchAll(PDO::FETCH_ASSOC);

    return $users;
}

function checkUserName($userNameToCheck, $users): array
{
    foreach ($users as $userKey => $user) {
        // Magnus V. - if we were to have more than one admin, it would probably be a good idea to fill an array here, and loop through with a nested loop instead:
        $userCheck = $user['user_name'];

        $userResult = [];

        if ($userNameToCheck === $userCheck) : {

                $userResult = [$userKey, true];
                return $userResult;
                // Magnus V. - A bit unsure about this part. Maybe a different kind of loop should be used if number of users are more than one? |--->
            }
        else : {
                $userResult = [null, false];
                return $userResult;
            }
        endif;
        // <--- --- ---|
    }
}

function checkPassword($passwordToCheck, $users): array
{
    foreach ($users as $passwordKey => $user) {
        $passwordCheck = $user['pass_word'];

        $passwordResult = [];

        // Magnus V. - password_verify would probably be a better method here:
        if ($passwordToCheck === $passwordCheck) : {

                $passwordResult = [$passwordKey, true];
                return $passwordResult;
            }
        else : {
                $passwordResult = [null, false];
                return $passwordResult;
            }
        endif;
    }
}

// Magnus V. - this function checks fetched username- and password-index, so that any correct username can't be combined with any correct password:
function validateLogin($userResult, $passwordResult): bool
{
    if (!is_null($userResult[0]) && !is_null($passwordResult[0] && $userResult[0] === $passwordResult[0])) : {
            return true;
        }
    else : {
            return false;
        }
    endif;
}
