<?php
require_once 'sms.php';
require_once 'db.php';
require_once 'util.php';

class Menu {
    protected $text;
    protected $sessionId;
    protected $phoneNumber;
    protected $conn;
    protected $session = [];
    protected $userInput;

    function __construct($text, $sessionId, $phoneNumber, $conn) {
        $this->text = $text;
        $this->sessionId = $sessionId;
        $this->phoneNumber = $phoneNumber;
        $this->conn = $conn;
        $this->userInput = $text;
    }

    public function mainMenuUnregistered() {
        echo "CON Welcome to F&I MOMO  LTD\n1. Register User\n2. Register Agent";
    }

    public function menuRegister($textArray) {
        $level = count($textArray);
    
        if ($level == 1) {
            echo "CON Enter your full User name";
        } elseif ($level == 2) {
            echo "CON Enter your PIN";
        } elseif ($level == 3) {
            echo "CON Re-enter your PIN";
        } elseif ($level == 4) {
            $name = trim($textArray[1]);
            $pin = trim($textArray[2]);
            $confirmPin = trim($textArray[3]);
     
            // Check if PINs match
            if ($pin !== $confirmPin) {
                echo "END PINs do not match. Please try again.";
                return;
            }
    
            // Check if phone is already registered
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE phone_number = ?");
            $stmt->execute([$this->phoneNumber]);
            if ($stmt->rowCount() > 0) {
                echo "END This phone number is already registered.";
                return;
            }
    
            // Hash PIN and insert into database
            
            $hashedPin = password_hash($pin, PASSWORD_DEFAULT);
            $stmt = $this->conn->prepare("INSERT INTO users (phone_number, full_name, pin, balance) VALUES (?, ?, ?, 500)");
            if ($stmt->execute([$this->phoneNumber, $name, $hashedPin])) {
          
            echo "END Dear $name, you have successfully registered.Initial balance Account is:".Util::$user_balance."Rwf";
            } else {
                echo "END Registration failed. Please try again.";
            }
        } else {
            echo "END Invalid input. Please try again.";
        }
    }

    
    public function RegisterAgent($textArray) {
        $level = count($textArray);
        $name = '';
        $code = '';
        $pin = '';

        if ($level == 1) {
            echo "CON Enter Your Full Agent Name:";
            return;
        } elseif ($level == 2) {
            echo "CON Enter Agent Code (6 digits):";
            return;
        } elseif ($level == 3) {
            echo "CON Enter your PIN (4 digits):";
            return;
        } elseif ($level == 4) {
            echo "CON Re-enter your PIN:";
            return;
        } elseif ($level == 5) {
            $name = trim($textArray[1]);
            $code = trim($textArray[2]);
            $pin = trim($textArray[3]);
            $confirmPin = trim($textArray[4]);

            // Validate inputs
            if (!preg_match('/^\d{6}$/', $code)) {
                echo "END Invalid agent code. Must be 6 digits.";
                return;
            }

            if (!preg_match('/^\d{4}$/', $pin)) {
                echo "END Invalid PIN. Must be 4 digits.";
                return;
            }

            if ($pin !== $confirmPin) {
                echo "END PINs do not match. Please try again.";
                return;
            }

            try {
                // Check if phone is already registered
                $stmt = $this->conn->prepare("SELECT * FROM agents WHERE phone_number = ? OR Agent_Code = ?");
                $stmt->execute([$this->phoneNumber, $code]);

                if ($stmt->rowCount() > 0) {
                    echo "END This phone number or agent code is already registered.";
                    return;
                }

                // Hash PIN and register agent
                $hashedPin = password_hash($pin, PASSWORD_DEFAULT);
                $stmt = $this->conn->prepare("INSERT INTO agents (phone_number, full_name, Agent_Code, pin, balance) VALUES (?, ?, ?, ?, 500)");
                
                if ($stmt->execute([$this->phoneNumber, $name, $code, $hashedPin])) {
                    $welcomeMessage = "Welcome $name! Your F&I MOMO agent account has been created successfully. Your agent code is: $code";
                    try {
                        $sms = new Sms();
                        $sms->sendSMS($welcomeMessage, $this->phoneNumber);
                    } catch (Exception $e) {
                        error_log("SMS sending failed: " . $e->getMessage());
                    }
                    
                    echo "END $welcomeMessage";
                } else {
                    echo "END Registration failed. Please try again.";
                }
            } catch (PDOException $e) {
                error_log("Agent registration error: " . $e->getMessage());
                echo "END Registration failed. Please try again later.";
            }
        }
    }

    public function mainMenuRegistered() {
        echo "CON Welcome back to F&I MOMO LTD\n1. Send Money\n2. Withdraw Money\n3. Check Balance\n4. Deposit Money";
    }

    public function menuSendMoney($textArray) {
        $level = count($textArray);

        if ($level == 1) {
            echo "CON Enter recipient phone number";
        } elseif ($level == 2) {
            echo "CON Enter amount";
        } elseif ($level == 3) {
            echo "CON Enter PIN";
        } elseif ($level == 4) {

            $response="CON Do you want to send Amount of $textArray[2]RWF to $textArray[1]?\n";
            $response .="1.Confirm\n";
            $response .="2.Cancel\n";
            $response .="98.Back\n";
            $response .="99.Main menu\n";
            echo $response;

            list(, $recipient, $amount, $pin) = $textArray;

            $stmt = $this->conn->prepare("SELECT * FROM users WHERE phone_number = ?");
            $stmt->execute([$this->phoneNumber]);
            $sender = $stmt->fetch();

            if (!$sender || !password_verify($pin, $sender['pin'])) {
                echo "END Incorrect PIN.";
                return;
            }

            $stmt = $this->conn->prepare("SELECT * FROM users WHERE phone_number = ?");
            $stmt->execute([$recipient]);
            $receiver = $stmt->fetch();

            if (!$receiver) {
                echo "END Recipient does not exist.";
                return;
            }

            if ($sender['balance'] < $amount) {
                echo "END Insufficient balance.";
                return;
            }

            $this->conn->beginTransaction();

            $this->conn->prepare("UPDATE users SET balance = balance - ? WHERE phone_number = ?")
                ->execute([$amount, $this->phoneNumber]);

            $this->conn->prepare("UPDATE users SET balance = balance + ? WHERE phone_number = ?")
                ->execute([$amount, $recipient]);

            $this->conn->prepare("INSERT INTO transactions (sender_phone, recipient_phone, amount, transaction_type) VALUES (?, ?, ?, 'SEND')")
                ->execute([$this->phoneNumber, $recipient, $amount]);

            $this->conn->commit();

          // echo "END You have sent $amount Rwf to $recipient successfully.";
         }
      
   elseif ($level == 5 && $textArray[4] == "1") {

    $recipientPhone = trim($textArray[1]);
    $amount = trim($textArray[2]);

    $stmt = $this->conn->prepare("SELECT full_name FROM users WHERE phone_number = ?");
    $stmt->execute([$recipientPhone]);

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $recipientName = $row['full_name'];
        echo "END You have sent $amount Rwf to $recipientName ($recipientPhone) successfully.";
    } 
}

elseif($level== 5 && $textArray[4]==2){
        echo"Thank you for using Service";
        }
        elseif($level== 5 && $textArray[4]=="98. Back"){
            echo"END Your are requesting to go back one step";
        }
        elseif($level== 5 && $textArray[4]=="99. Main menu"){
            echo"End your are requestin to go menu";
        }
        else{
            echo"Invalid Option";
        }
    }



    public function menuCheckBalance($textArray) {
        $level = count($textArray);

        if ($level == 1) {
            echo "CON Enter your PIN";
        } 
        elseif ($level == 2) {
            try {
                $pin = $textArray[1];

                // Validate PIN format
                if (!preg_match('/^\d{4}$/', $pin)) {
                    echo "END Invalid PIN format. Must be 4 digits.";
                    return;
                }

                // Check database connection
                if (!$this->conn) {
                    echo "END Database connection error. Please try again later.";
                    return;
                }

                $stmt = $this->conn->prepare("SELECT * FROM users WHERE phone_number = ?");
                if (!$stmt) {
                    echo "END Database error. Please try again later.";
                    return;
                }

                $stmt->execute([$this->phoneNumber]);
                $user = $stmt->fetch();

                if (!$user) {
                    echo "END User account not found.";
                    return;
                }

                if (!password_verify($pin, $user['pin'])) {
                    echo "END Incorrect PIN.";
                    return;
                }

                $balance = number_format($user['balance'], 2);
                $message = "F&I MOMO Balance Alert\nYour current balance is: $balance Rwf\nDate: " . date('Y-m-d H:i:s');

                // Send SMS with error handling
                try {
                    $sms = new Sms();
                    $smsSent = $sms->sendSMS($message, $this->phoneNumber);
                    
                    if ($smsSent) {
                        echo "END Your balance is: $balance Rwf\nConfirmation sent via SMS";
                    } else {
                        // If SMS fails, try sending a simpler message
                        $simpleMessage = "Your F&I MOMO balance is $balance Rwf";
                        $smsSent = $sms->sendSMS($simpleMessage, $this->phoneNumber);
                        echo "END Your balance is: $balance Rwf" . ($smsSent ? "\nConfirmation sent via SMS" : "");
                    }
                } catch (Exception $e) {
                    error_log("SMS sending failed: " . $e->getMessage());
                    echo "END Your balance is: $balance Rwf";
                }
            } catch (PDOException $e) {
                error_log("Database error in menuCheckBalance: " . $e->getMessage());
                echo "END System error. Please try again later.";
            } catch (Exception $e) {
                error_log("General error in menuCheckBalance: " . $e->getMessage());
                echo "END System error. Please try again later.";
            }
        }
    }



    public function menuDepositMoney($textArray) {
        $level = count($textArray);

        if ($level == 1) {
            echo "CON Enter amount to deposit:";
        } elseif ($level == 2) {
            echo "CON Enter agent phone number:";
        } elseif ($level == 3) {
            $amount = trim($textArray[1]);
            $agentPhone = trim($textArray[2]);

            // Validate agent
            $stmt = $this->conn->prepare("SELECT full_name FROM agents WHERE phone_number = ?");
            $stmt->execute([$agentPhone]);
            $agent = $stmt->fetch();

            if (!$agent) {
                echo "END Invalid agent phone number.";
                return;
            }

            echo "CON Confirm deposit of $amount Rwf via agent {$agent['full_name']} ($agentPhone)\n";
            echo "1. Confirm\n2. Cancel\n3. Back\n4. Main Menu";
        } elseif ($level == 4) {
            list(, $amount, $agentPhone, $option) = $textArray;
            
            if ($option == "1") {
                // Process deposit
                $this->conn->beginTransaction();
                
                try {
                    // Update user balance
                    $stmt = $this->conn->prepare("UPDATE users SET balance = balance + ? WHERE phone_number = ?");
                    $stmt->execute([$amount, $this->phoneNumber]);
                    
                    // Record transaction
                    $stmt = $this->conn->prepare("INSERT INTO transactions (sender_phone, recipient_phone, amount, transaction_type) VALUES (?, ?, ?, 'DEPOSIT')");
                    $stmt->execute([$agentPhone, $this->phoneNumber, $amount]);
                    
                    $this->conn->commit();
                    
                    // Get updated balance
                    $stmt = $this->conn->prepare("SELECT balance FROM users WHERE phone_number = ?");
                    $stmt->execute([$this->phoneNumber]);
                    $user = $stmt->fetch();
                    
                    // Send confirmation SMS
                    $sms = new Sms();
                    $message = "Your deposit of $amount Rwf was successful. New balance: {$user['balance']} Rwf. Thank you for using F&I MOMO!";
                    $sms->sendSMS($message, $this->phoneNumber);
                    
                    echo "END Deposit successful! Confirmation sent via SMS.";
                } catch (Exception $e) {
                    $this->conn->rollBack();
                    echo "END Transaction failed. Please try again.";
                }
            } elseif ($option == "2") {
                echo "END Deposit cancelled.";
            } elseif ($option == "3") {
                echo "END Going back to previous step.";
            } elseif ($option == "4") {
                echo "END Returning to main menu.";
            } else {
                echo "END Invalid option selected.";
            }
        }
    }

    public function menuWithdrawMoney($textArray) {
        $level = count($textArray);

        if ($level == 1) {
            echo "CON Enter amount to withdraw:";
        } elseif ($level == 2) {
            echo "CON Enter agent phone number:";
        } elseif ($level == 3) {
            echo "CON Enter your PIN:";
        } elseif ($level == 4) {
            list(, $amount, $agentPhone, $pin) = $textArray;

            // Validate PIN and balance
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE phone_number = ?");
            $stmt->execute([$this->phoneNumber]);
            $user = $stmt->fetch();

            if (!$user || !password_verify($pin, $user['pin'])) {
                echo "END Incorrect PIN.";
                return;
            }

            if ($user['balance'] < $amount) {
                echo "END Insufficient balance.";
                return;
            }

            // Validate agent
            $stmt = $this->conn->prepare("SELECT full_name FROM agents WHERE phone_number = ?");
            $stmt->execute([$agentPhone]);
            $agent = $stmt->fetch();

            if (!$agent) {
                echo "END Invalid agent phone number.";
                return;
            }

            echo "CON Confirm withdrawal of $amount Rwf via agent {$agent['full_name']} ($agentPhone)\n";
            echo "1. Confirm\n2. Cancel\n3. Back\n4. Main Menu";
        } elseif ($level == 5) {
            list(, $amount, $agentPhone, $pin, $option) = $textArray;
            
            if ($option == "1") {
                $this->conn->beginTransaction();
                
                try {
                    // Update user balance
                    $stmt = $this->conn->prepare("UPDATE users SET balance = balance - ? WHERE phone_number = ?");
                    $stmt->execute([$amount, $this->phoneNumber]);
                    
                    // Record transaction
                    $stmt = $this->conn->prepare("INSERT INTO transactions (sender_phone, recipient_phone, amount, transaction_type) VALUES (?, ?, ?, 'WITHDRAW')");
                    $stmt->execute([$this->phoneNumber, $agentPhone, $amount]);
                    
                    $this->conn->commit();
                    
                    // Get updated balance
                    $stmt = $this->conn->prepare("SELECT balance FROM users WHERE phone_number = ?");
                    $stmt->execute([$this->phoneNumber]);
                    $user = $stmt->fetch();
                    
                    // Send confirmation SMS
                    $sms = new Sms();
                    $message = "Your withdrawal of $amount Rwf was successful. New balance: {$user['balance']} Rwf. Thank you for using F&I MOMO!";
                    $sms->sendSMS($message, $this->phoneNumber);
                    
                    echo "END Withdrawal successful! Confirmation sent via SMS.";
                } catch (Exception $e) {
                    $this->conn->rollBack();
                    echo "END Transaction failed. Please try again.";
                }
            } elseif ($option == "2") {
                echo "END Withdrawal cancelled.";
            } elseif ($option == "3") {
                echo "END Going back to previous step.";
            } elseif ($option == "4") {
                echo "END Returning to main menu.";
            } else {
                echo "END Invalid option selected.";
            }
        }
    }

public function middleware($text){
    return $this->goBack($this->goBackMenu($text));

    }
    
public function goBack($text){
    $explodedText=explode("*",$text);
    while(array_search('98',$explodedText)!=false){
        $firstIndex=array_search('98',$explodedText);
        array_splice($explodedText,$firstIndex-1,2);
    }
  return join("*",$explodedText);
}


public function goBackMenu($text){
    $explodedText=explode("*",$text);
    while(array_search('99',$explodedText)!=false){
        $firstIndex=array_search('99',$explodedText);
        $explodedText = array_slice($explodedText,$firstIndex+1);
        
    }
  return join("*",$explodedText);
}
}
?>