<?php
// user.php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;


class User
{
    protected $db;
    protected $user_name;
    protected $user_email;
    protected $user_phone;
    protected $user_pass;
    protected $hash_pass;
    // Mail Account
    protected $senderMail  = 'yourmail@gmail.com';
    protected $senderPass  = 'yourpassword';
    protected $mailHeader  = 'Account Header';
    protected $mailSubject = 'Email Verification';

    public function __construct($pdo)
    {
        $this->db = $pdo;
        
    }

    // SING UP USER
    public function singUpUser($username, $email, $phone, $password, $token,$time, $date, $CSRF, $formCSRF)
    {
        try {
            $this->user_name = trim($username);
            $this->user_email = trim($email);
            $this->user_phone = trim($phone);
            $this->user_pass = trim($password);

            if (!empty($this->user_name) && !empty($this->user_email) && !empty($this->user_pass)) {

                if (filter_var($this->user_email, FILTER_VALIDATE_EMAIL)) {
                    $check_email = $this->db->prepare("SELECT * FROM users WHERE email = ?");
                    $check_email->execute([$this->user_email]);

                    if ($check_email->rowCount() > 0) {
                        return ['errorMessage' => '<p class="text-danger mb-0">Your Email is already registered.Please Try another.<p>'];
                    } else {

                        if (!hash_equals($CSRF,$formCSRF)) {
                            return ['errorMessage' => '<p class="text-danger mb-0">Invalid CSRF </p><small class="text-muted"> The CSRF token is invalid or missing.Please try to resubmit the form.</small>'];
                        } else {
                          
                            $this->hash_pass = password_hash($this->user_pass, PASSWORD_DEFAULT);             
                            $sql = "INSERT INTO users (username, email, password, phone, pic,cv,birth,gender,country,city,dark_mode,profile,friends,readme,user_row,get_start,last_login,block,state, token,createdTime,createdDate) VALUES(:username, :email, :pass, :phone, 'sample-photo1.png','cp.jpg','','','','',0,'','',0,0,0,'',0,0,'$token','$time','$date')";
                            $register_stmt = $this->db->prepare($sql);
                            //BIND VALUES
                            $register_stmt->bindValue(':username', htmlspecialchars($this->user_name), PDO::PARAM_STR);
                            $register_stmt->bindValue(':email', strtolower($this->user_email), PDO::PARAM_STR);
                            $register_stmt->bindValue(':pass', $this->hash_pass, PDO::PARAM_STR);
                            $register_stmt->bindValue(':phone', htmlspecialchars($this->user_phone), PDO::PARAM_STR);
                            $register_stmt->execute();

                            if ($register_stmt) {
                                
                                unset($_SESSION['CSRF']);
                                header("location:state/sendmail.html");

                                $ipaddress = $_SERVER['REMOTE_ADDR'];
                                if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
                                    foreach ($matches[0] AS $xip) {
                                        if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
                                            $ipaddress = $xip;
                                            break;
                                        }
                                    }
                                } elseif (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
                                    $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
                                } elseif (isset($_SERVER['HTTP_CF_CONNECTING_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CF_CONNECTING_IP'])) {
                                    $ipaddress = $_SERVER['HTTP_CF_CONNECTING_IP'];
                                } elseif (isset($_SERVER['HTTP_X_REAL_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_X_REAL_IP'])) {
                                    $ipaddress = $_SERVER['HTTP_X_REAL_IP'];
                                }

                                require 'PHPMailer/PHPMailer.php';
                                require 'PHPMailer/SMTP.php';

                                $mailBody = " <body style='padding: 0;margin: 0;'>
                                <div style='text-align: center;letter-spacing: 0.5px;'>
                                    <div style='width: 100%;display:inline-block;height: 50vh;'>
                                         <div  style='text-align: center;color:rgb(253, 253, 255);font-weight: bold;background-color:#222;padding: 5px 0;'>
                                           <h2>$this->mailHeader</h2>
                                       </div>
                                        <div style='margin: 30px 10px;text-align: left;'>
                                            <p style='font-weight: bold;font-size: 16px;'>Hey $username!</p>
                                            <p style='color: rgb(34, 33, 33);font-size: 14px;'>You registered the $this->mailHeader on $date, but did not verify your account yet,Click here to verify your mail account.</p>
                                        </div>
                                       <div style='text-align: center;display: block;margin: 15px 0;'>
                                           <a href='http://media.zakerxa.com/verify/confirm.php?email=$email&token=$token'><button style='padding:11px 17px;font-weight: bold;background: rgb(29, 77, 180);color:rgb(247, 233, 233);border: none;border-radius: 5px;outline: none;'>Verify email address</button></a>
                                       </div>
                                       <div style='margin: 33px 10px;text-align:left;font-size: 14px;'>
                                           <p style='margin-top:10px;color: rgb(34, 33, 33);'>If button doesn't work,Copy the link below into your web browser.</p>
                                           <a style='text-decoration: none;color:rgb(12, 60, 192)' href='http://media.zakerxa.com/verify/confirm.php?email=$email&token=$token'>http://media.zakerxa.com/verify/confirm.php?email=$email&token=$token</a>
                                       </div>
                                       <hr>
                                       <div class='font-size: 14px;'>
                                          Your Ip Address : $ipaddress
                                       </div>
                                        <hr>
                                       <div style='color: rgb(89, 92, 89) ;margin-top: 10px;padding-left: 5px;text-align: left;'>
                                           <p style='font-size: 13px;'>Thank you for visiting our website.Don't ask to verify this address,you can ignore this email.</p>
                                       </div>
                                     </div>
                                  
                                   <div>
                            </body>";

                                //Create a new PHPMailer instance

                                $mail = new PHPMailer(true);

                                try {
                                    $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output
                                    // $mail->isSMTP(); // Send using SMTP localhost
                                    $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
                                    $mail->SMTPAuth = true; // Enable SMTP authentication
                                    $mail->Username = $this->senderMail;
                                    $mail->Password = $this->senderPass; 
                                    $mail->SMTPSecure = 'Enable TLS encryption'; //PHPMailer::ENCRYPTION_STARTTLS // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
                                    $mail->Port = 587; //465 SSL

                                    //Email Setting
                                 
                                    $mail->setFrom('mail@zakerxa.com', $this->mailHeader); // Zakexa Website
                                    $mail->addAddress($email);

                                    // //Set an alternative reply-to address
                                    // $mail->addReplyTo($email, $this->mailHeader);
                                   
                                    $mail->Subject = $this->mailSubject; //'Zekerxa Website Email Verification';
                                    $mail->Body = $mailBody;
                                    $mail->isHTML(true);
                                   
                                    //send the message, check for errors
                                    if ($mail->send()) {
                                        
                                    //    return ['errorMessage' => 'Mail Sent'];
                                    } else {
                                       return ['errorMessage' => "Something is wrong : <br> $mail->ErrorInfo"];
                                    }
                                   

                                } catch (Exception $e) {
                                //    return ['errorMessage' => "<p class='text-danger mb-0'>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</p>"];

                                }

                            }

                        }
                    }
                } else {
                    return ['errorMessage' => '<p class="text-danger mb-0">Invalid email address!</p>'];
                }
            } else {
                return ['errorMessage' => '<p class="text-danger mb-0">Please fill in all the required fields.</p>'];
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    // LOGIN USER
    public function loginUser($email, $password, $CSRF,$formCSRF)
    {
        try {
            $this->user_email = trim($email);
            $this->user_pass = trim($password);
            // SELECT EMAIL FROM DATABASE AND CHECK WITH USER EMAIL
            $find_email = $this->db->prepare("SELECT * FROM `users` WHERE email = ?");
            $find_email->execute([$this->user_email]);
            // IF USER EMAIL IS EXIST IN DATABASE
            if ($find_email->rowCount() === 1) {
                // GET ROW DATA BY EMAIL FETCH ASSOC
                $row = $find_email->fetch(PDO::FETCH_ASSOC);
                // Check Password is ture or not
                $match_pass = password_verify($this->user_pass, $row['password']);
                // CHECK USER IS VALID CSRF OR NOT
                if (!hash_equals($CSRF,$formCSRF)) {
                    return ['errorMessage' => "<p class='text-danger mb-0'>Invalid CSRF </p><small class='text-muted'> The CSRF token is invalid or missing.Please try to resubmit the form.</small>"];
                } else {
                       // VALID CSRF TOKEN ,NOW USER CAN LOGIN
                    if ($match_pass) {
                        // CHECK VERIFY USER
                        $CHECK_VERIFY = $this->db->prepare("SELECT * FROM `users` WHERE email='$email' AND state=1");
                        $CHECK_VERIFY->execute();
                        $VERIFY = $CHECK_VERIFY->fetch(PDO::FETCH_ASSOC);
                        if(!$VERIFY){
                            return ['errorMessage' => "<p class='text-primary mb-0'>Please Verify Email<p> <small class='text-muted'>Your account didn't verify yet!</small>"];
                            
                        }
                       // IF PASSWORD IS CORRECT ,WE WILL TRY TO GET USER IP TO SAVE IN DATABASE
                        $ipaddress = $_SERVER['REMOTE_ADDR'];
                        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
                            foreach ($matches[0] AS $xip) {
                                if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
                                    $ipaddress = $xip;
                                    break;
                                }
                            }
                        } elseif (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
                            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
                        } elseif (isset($_SERVER['HTTP_CF_CONNECTING_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CF_CONNECTING_IP'])) {
                            $ipaddress = $_SERVER['HTTP_CF_CONNECTING_IP'];
                        } elseif (isset($_SERVER['HTTP_X_REAL_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_X_REAL_IP'])) {
                            $ipaddress = $_SERVER['HTTP_X_REAL_IP'];
                        }
                        // UPDATE USER TOKEN TO IP ADDRESS
                        $addIP = $this->db->prepare("UPDATE users SET token='$ipaddress' WHERE email = ?");
                        $addIP->execute([$this->user_email]);
                        // SET COOKIE IN BROWSER 
                        if (empty($row['pic'])) {$pic = 'sample-photo1.png';} else {
                            $pic = $row['pic'];
                        }
                        setcookie("name", $row['username'], time() + 60 * 60 * 24 * 7);
                        setcookie("id", $row['id'], time() + 60 * 60 * 24 * 7);
                        setcookie("pic", $pic, time() + 60 * 60 * 24 * 7);
                        setcookie("gs", $row['get_start'], time() + 60 * 60 * 24 * 7);
                        unset($_SESSION['CSRF']);
                        header("location:index.php");
                    } 
                    else {
                        // IF FORM INPUT PASSWORD IS NOT SAME DATABASE PASSWORD SHOW USER ALERT
                        setcookie("name", "", time() - 1);
                        setcookie("id", "", time() - 1);
                        setcookie("pic", "", time() - 1);
                        return ['errorMessage' => '<p class="text-danger mb-0">Incorrect password !</p>'];
                    }
                }

            } else {
                // FORM INPUT MAIL DOES'T EXIST IN DATABASE SHOW USER ALERT
                return ['errorMessage' => '<p class="text-danger mb-0">Your mail doesn’t register yet!'];
            }

        } catch (PDOException $e) {
            die($e->getMessage());
        }

    }


    // FIND USER BY ID
    public function find_user_by_id($id)
    {
        try {
            $find_user = $this->db->prepare("SELECT * FROM `users` WHERE id = ?");
            $find_user->execute([$id]);
            if ($find_user->rowCount() === 1) {
                return $find_user->fetch(PDO::FETCH_OBJ);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

}
