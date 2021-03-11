<?php
/**
* Secure login/registration user class.
*/

class User{
    /** @var object $pdo Copy of PDO connection */
    private $pdo;
    /** @var object of the logged in user */
    private $user;
    /** @var string error msg */
    private $msg;
    /** @var int number of permitted wrong login attemps */
    private $permittedAttempts = 5;

    /**
    * Connection init function
    * @param string $conString DB connection string.
    * @param string $user DB user.
    * @param string $pass DB password.
    *
    * @return bool Returns connection success.
    */
    public function dbConnect($conString, $user, $pass){
        if(session_status() === PHP_SESSION_ACTIVE){
            try {
                $pdo = new PDO($conString, $user, $pass);
                $this->pdo = $pdo;
                return true;
            }catch(PDOException $e) { 
                $this->msg = 'Connection did not work out!';
                return false;
            }
        }else{
            $this->msg = 'Session did not start.';
            return false;
        }
    }

    /**
    * Return the logged in user.
    * @return user array data
    */
    public function getUser(){
        return $this->user;
    }

    /**
    * Login function
    * @param string $email User email.
    * @param string $password User password.
    *
    * @return bool Returns login success.
    */
    public function login($email,$password){
        if(is_null($this->pdo)){
            $this->msg = 'Connection did not work out!';
            return false;
        }else{
            $pdo = $this->pdo;
            $stmt = $pdo->prepare('SELECT id, email, username, wrong_logins, pass, user_role FROM users WHERE email = ? AND confirm_code = 1 LIMIT 1');
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if(password_verify($password,$user['pass'])){
                if($user['wrong_logins'] <= $this->permittedAttempts){
                    $this->user = $user;
                    session_regenerate_id();
                    $_SESSION['user']['id'] = $user['id'];
                    $_SESSION['user']['user_role'] = $user['user_role'];
                    $_SESSION['user']['username'] = $user['username'];
                    $_SESSION['user']['email'] = $user['email'];
                    $stmt = $pdo->prepare('UPDATE users SET wrong_logins = 0 WHERE email = ?');
                    $stmt->execute([$email]);
                    return true;
                }else{
                    $this->msg = 'Ez a fiók blokkolva van';
                    return false;
                }
            }else{
                $this->registerWrongLoginAttempt($email);
                $this->msg = 'Hibás bejelentkezési adatok! <br> Aktiváltad a fiókod?';
                return false;
            } 
        }
    }

    /**
    * Register a new user account function
    * @param string $email User email.
    * @param string $fname User first name.
    * @param string $lname User last name.
    * @param string $pass User password.
    * @return boolean of success.
    */
    public function registration($email,$username,$pass){
        $pdo = $this->pdo;
        if($this->checkEmail($email)){
            $this->msg = 'Ez az email már foglalt.';
            return false;
        }
        if($this->checkUser($username)){
            $this->msg = 'Ez a név már foglalt.';
            return false;
        }
        if(!(isset($email) && isset($username) && isset($pass) && filter_var($email, FILTER_VALIDATE_EMAIL))){
            $this->msg = 'Insert all valid required fields.';
            return false;
        }

        $pass = $this->hashPass($pass);
        $confCode = $this->hashPass(date('Y-m-d H:i:s').$email);
        $stmt = $pdo->prepare('INSERT INTO users (username, email, pass, confirm_code) VALUES (?, ?, ?, ?)');
        if($stmt->execute([$username,$email,$pass,$confCode])){
            if($this->sendConfirmationEmail($email)){
                return true;
            }else{
                $this->msg = 'Confirmation email sending has failed.';
                return false; 
            }

        }else{
            $this->msg = 'Inserting a new user failed.';
            return false;
        }
    }

    /**
    * Email the confirmation code function
    * @param string $email User email.
    * @return boolean of success.
    */
    private function sendConfirmationEmail($email){
        $pdo = $this->pdo;
        $stmt = $pdo->prepare('SELECT confirm_code FROM users WHERE email = ? limit 1');
        $stmt->execute([$email]);
        $code = $stmt->fetch();

        $activation_link = 'localhost/diabloiv/php/activate.php?email=' . $_POST['email'] . '&code=' . $code['confirm_code'];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.pepipost.com/v5/mail/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\"from\":{\"email\":\"rmeszes1@pepisandbox.com\",\"name\":\"rmeszes1\"},\"subject\":\"Fiók aktiválás\",\"content\":[{\"type\":\"html\",\"value\":\"Kérlek kattints <a href='" . $activation_link . "'>ide</a>!\"}],\"personalizations\":[{\"to\":[{\"email\":\"" . $email . "\",\"name\":\"" . $_POST['username'] . "\"}]}]}",
            CURLOPT_HTTPHEADER => array(
            "api_key: 9c38656096a93ba739392088bac4b1e4",
            "content-type: application/json"
        ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            $this->msg = "cURL Error #:" . $err;
            return false;
        } else {
            $this->msg = $response;
            return true;
        }
    }

    /**
    * Activate a login by a confirmation code and login function
    * @param string $email User email.
    * @param string $confCode Confirmation code.
    * @return boolean of success.
    */
    public function emailActivation($email,$confCode){
        $pdo = $this->pdo;
        $stmt = $pdo->prepare('UPDATE users SET confirmed = 1 WHERE email = ? and confirm_code = ?');
        $stmt->execute([$email,$confCode]);
        if($stmt->rowCount()>0){
            //what to do after activation
            return true;           
        }else{
            $this->msg = 'Account activitation failed.';
            return false;
        }
    }

    /**
    * Password change function
    * @param int $id User id.
    * @param string $pass New password.
    * @return boolean of success.
    */
    public function passwordChange($id,$pass){
        $pdo = $this->pdo;
        if(isset($id) && isset($pass)){
            $stmt = $pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
            if($stmt->execute([$id,$this->hashPass($pass)])){
                return true;
            }else{
                $this->msg = 'Password change failed.';
                return false;
            }
        }else{
            $this->msg = 'Provide an ID and a password.';
            return false;
        }
    }


    /**
    * Assign a role function
    * @param int $id User id.
    * @param int $role User role.
    * @return boolean of success.
    */
    public function assignRole($id,$role){
        $pdo = $this->pdo;
        if(isset($id) && isset($role)){
            $stmt = $pdo->prepare('UPDATE users SET role = ? WHERE id = ?');
            if($stmt->execute([$id,$role])){
                return true;
            }else{
                $this->msg = 'Role assign failed.';
                return false;
            }
        }else{
            $this->msg = 'Provide a role for this user.';
            return false;
        }
    }



    /**
    * User information change function
    * @param string $email email
    * @param string $username username
    * @param string $oldpass
    * @param string $newpass
    * @return boolean of success.
    */
    public function update($email, $username, $oldpass, $newpass){
        $pdo = $this->pdo;
        if(isset($email) && isset($username) && isset($oldpass)){
            
            if($this->checkUser($username)){
                $this->msg = 'Ez a név már foglalt.';
                return false;
            }
            $stmt = $pdo->prepare('SELECT pass, wrong_logins FROM users WHERE email = ? AND confirm_code = 1 LIMIT 1');
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if($user['wrong_logins'] >= $this->permittedAttempts) {
                logout();
                
            }

            if(password_verify($oldpass,$user['pass'])){
                if($newpass != "") {
                    $stmt = $pdo->prepare('UPDATE users SET username = ?, pass = ? WHERE email = ?');
                    
                    $newhash = $this->hashPass($newpass);

                    if($stmt->execute([$username,$newhash,$email])){
                        $_SESSION['user']['username'] = $username;
                        
                        return true;
                    } else {
                        $this->msg = 'Felhasználónév foglalt';
                        return false;
                    }
                } else {
                    $stmt = $pdo->prepare('UPDATE users SET username = ? WHERE email = ?');
                    if($stmt->execute([$username,$email])){
                        $_SESSION['user']['username'] = $username;
                        
                        return true;
                    } else {
                        $this->msg = 'Felhasználónév foglalt';
                        return false;
                    }
                }
            } else {
                $this->msg = 'Helytelen jelszó';
                registerWrongLoginAttempt($email);
                return false;
            }
        }else{
            $this->msg = 'Helytelen adatok';
            return false;
        }
    }

    /**
    * Check if email is already used function
    * @param string $email User email.
    * @return boolean of success.
    */
    private function checkEmail($email){
        $pdo = $this->pdo;
        $stmt = $pdo->prepare('SELECT email FROM users WHERE email = ? limit 1');
        $stmt->execute([$email]);
        if($stmt->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }

    private function checkUser($username){
        $pdo = $this->pdo;
        $stmt = $pdo->prepare('SELECT username FROM users WHERE username = ? limit 1');
        $stmt->execute([$username]);
        if($stmt->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }


    /**
    * Register a wrong login attemp function
    * @param string $email User email.
    * @return void.
    */
    private function registerWrongLoginAttempt($email){
        $pdo = $this->pdo;
        $stmt = $pdo->prepare('UPDATE users SET wrong_logins = wrong_logins + 1 WHERE email = ?');
        $stmt->execute([$email]);
    }

    /**
    * Password hash function
    * @param string $password User password.
    * @return string $password Hashed password.
    */
    private function hashPass($pass){
        return password_hash($pass, PASSWORD_DEFAULT);
    }

    /**
    * Print error msg function
    * @return void.
    */
    public function printMsg(){
        print $this->msg;
    }

    /**
    * Logout the user and remove it from the session.
    *
    * @return true
    */
    public function logout() {
        $_SESSION['user'] = null;
        session_regenerate_id();
        return true;
    }



    /**
    * List users function
    *
    * @return array Returns list of users.
    */
    public function listUsers(){
        if(is_null($this->pdo)){
            $this->msg = 'Connection did not work out!';
            return [];
        }else{
            $pdo = $this->pdo;
            $stmt = $pdo->prepare('SELECT id, fname, lname, email FROM users WHERE confirmed = 1');
            $stmt->execute();
            $result = $stmt->fetchAll(); 
            return $result; 
        }
    }

    /**
    * Simple template rendering function
    * @param string $path path of the template file.
    * @return void.
    */
    public function render($path,$vars = '') {
        ob_start();
        include($path);
        return ob_get_clean();
    }

    /**
    * Template for index head function
    * @return void.
    */
    public function indexHead() {
        print $this->render(indexHead);
    }

    /**
    * Template for index top function
    * @return void.
    */
    public function indexTop() {
        print $this->render(indexTop);
    }

    /**
    * Template for login form function
    * @return void.
    */
    public function loginForm() {
        print $this->render(loginForm);
    }

    /**
    * Template for activation form function
    * @return void.
    */
    public function activationForm() {
        print $this->render(activationForm);
    }

    /**
    * Template for index middle function
    * @return void.
    */
    public function indexMiddle() {
        print $this->render(indexMiddle);
    }

    /**
    * Template for register form function
    * @return void.
    */
    public function registerForm() {
        print $this->render(registerForm);
    }

    /**
    * Template for index footer function
    * @return void.
    */
    public function indexFooter() {
        print $this->render(indexFooter);
    }

    /**
    * Template for user page function
    * @return void.
    */
    public function userPage() {
	$users = [];
	if($_SESSION['user']['user_role'] == 2){
		$users = $this->listUsers();
	}
        print $this->render(userPage,$users);
    }
}
?>