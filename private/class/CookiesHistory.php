<?php
require_once 'User.php';
require_once 'Operations.php';


class CookiesHistory extends User implements Operations
{
    private  $key;


    // create the cookie into the user's device
    private function CreateCookie()
    {
        setcookie('data', $this->key, time() + 604800, '/');
    }


    // destroy key if it's expired
    private function DestroyUserCookie()
    {
        setcookie("data", null, time() - 3600, '/');
    }


    // add cookie value into DB
    public function Add()
    {
        return $query = $this->RUNDML("INSERT INTO cookies_history (user_id, name, value, time) VALUES (?, 'data', ?, NOW())", [$this->user_id, $this->key]);
    }

    public function Update()
    { }

    // delete cookie from DB by value
    public function Delete()
    {
        return $query = $this->RUNDML("DELETE FROM cookies_history WHERE value = ?", [$this->key]);
    }

    // delete cookie from DB by user ID
    public function DeleteByUserID()
    {
        return $query = $this->RUNDML("DELETE FROM cookies_history WHERE user_id = ?", [$this->user_id]);
    }

    // get cookie value from DB
    public function Search()
    {

        $query = $this->RUNSearch("SELECT * FROM cookies_history WHERE value = ? AND time >= NOW() - INTERVAL 1 WEEK", [$this->key]);

        return $query->rowCount() > 0 ? $query : false;
    }

    // check if there any cookie for this user before making a new one
    public function CheckUserCookie()
    {

        $query = $this->RUNSearch("SELECT * FROM cookies_history WHERE user_id = ? ", [$this->user_id]);

        return $query->rowCount() > 0 ? true : false;
    }


    // after successful login put the key into the table and set cookie
    public function RememberME($user_id)
    {
        // set the user_id
        $this->user_id = $user_id;

        // if there is cookie with this user in DB delete it
        if ($this->CheckUserCookie())
            $this->DeleteByUserID();

        // generate a unique key
        $this->generate_key();

        // create a cookie
        $this->CreateCookie();

        // insert the key into DB
        $this->Add();
    }


    // generate random and unique key 
    private function generate_key($length = 32)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $query = $this->pdo->prepare("SELECT * FROM cookies_history WHERE value = ? AND time >= NOW() - INTERVAL 1 WEEK");

        while (true) {
            $key = '';

            // generate random key
            for ($i = 0; $i < $length; $i++) {
                $key .= $characters[rand(0, $charactersLength - 1)];
            }

            // query that key from DB
            $query->execute([$key]);

            // if key is not in DB then break and set $this->key = key
            if (!$query->rowCount()) {
                $this->key = $key;
                break;
            }
        }
    }



    // if there is a cookie in the users browser let's check its validty
    public function logged()
    {
        return $this->CheckCookie();

    }

    // check validity of cookie
    private function CheckCookie()
    {
        // if there are no active session
        if (!isset($_SESSION['user_id']) || !$_SESSION['user_id']) {

            // check if there is any cookie 
            if ($this->CheckPermanentCookie()) {

                // get the user data if the cookie is valid 
                $query = $this->RUNSearch("SELECT * FROM `users` WHERE user_id = ?", [$this->user_id]);

                if (!$query->rowCount()) {
                    // if the user id is not valid anymore then exit
                    $this->DestroyUserCookie();
                    return false;
                } else {
                    // in case of a valid user, fill  sessions with the user data
                    $this->FillSession($query->fetch());
                    return true;
                }
            }
        }
    }



    // check if key is valid
    private function CheckPermanentCookie()
    {
        // if there is no cookie exit
        if (!isset($_COOKIE['data'])) {
            return false;
        }

        // get the key from the user's cookie
        $this->key = trim($_COOKIE['data']);

        // if there is no key exit
        if (!$this->key || mb_strlen($this->key) != 32) {
            $this->DestroyUserCookie();
            return false;
        } else {

            // get the key from the table to make validation
            $query = $this->Search();

            // if result is empty then destory the user's cookie
            if (!$query) {
                $this->DestroyUserCookie();
                return false;
            } else {
                // fetch the result
                $row = $query->fetch();

                // calculate time difference to make sure it's valid
                $deff = strtotime((new \DateTime())->format('Y-m-d H:i:s')) - strtotime($row['time']);

                if ($deff > 604800) {
                    // if time less than 1 sec then 
                    $this->DestroyUserCookie();

                    // delete from DB
                    $this->Delete();

                    return false;
                } else {
                    // time is valid then login the user
                    $this->user_id = $row['user_id'];
                    return true;
                }
            }
        }
    }


    // fill user data into sessions
    private function FillSession($data)
    {
        $_SESSION['logged'] = true;
        $_SESSION['user_id'] = $data['user_id'];
        $_SESSION['name'] = $data['name'];
        

        switch ($data['user_type_id']) {
                // customer
            case 1: {
                    $_SESSION['user_type'] = $data['user_type_id'];
                }
                break;

                // employee or manager
            case 2:
            case 3: {
                    $_SESSION['user_type'] = $data['user_type_id'];
                    $_SESSION['org_id'] = $data['org_id'];
                    $_SESSION['branch_id'] = $data['branch_id'];
                }
                break;

                // organization
            case 4: {
                    $_SESSION['user_type'] = $data['user_type_id'];
                    $_SESSION['org_id'] = $data['org_id'];
                }
                break;
                // ADMIN
            case 5: {
                    $_SESSION['user_type'] = $data['user_type_id'];
                }
                break;
        }

        return true;
    }
}
