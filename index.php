<?php
    $firstname = $lastname = $email = $phone = $message = "";
    $firstnameErr = $lastnameErr = $emailErr = $phoneErr = $messageErr = "";
    $isSuccess = false;
    $emailTo = "r.pinet@nuevo.fr";

    function checkInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    } 

    function isEmail($data) {
        return filter_var($data, FILTER_VALIDATE_EMAIL);
    }

    function isPhone($data) {
        return preg_match("/^[a-zA-Z-' ]*$/",$data);
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $emailText = "";
        if (empty($_POST['firstname'])) {
            $firstnameErr = "firstname is required";
            $isSuccess = false;
        } else {
            $firstname = checkInput($_POST['firstname']);
            $isSuccess = true;
            if (!preg_match("/^[a-zA-Z-' ]*$/",$firstname)) {
                $firstnameErr = "Only letters and white space allowed";
                $isSuccess = false;
            }
            $emailText .= "firstname: $firstname\n";
        }
               
        if (empty($_POST['lastname'])) {
            $lastnameErr = "lastname is required";
            $isSuccess = false;
        } else {
            $lastname = checkInput($_POST['lastname']);
            $isSuccess = true;
            if (!preg_match("/^[a-zA-Z-' ]*$/",$lastname)) {
                $lastnameErr = "Only letters and white space allowed";
                $isSuccess = false;
            }
            $emailText .= "lastname: $lastname\n";
        }

        if (empty($_POST['email'])) {
            $emailErr = "email is required";
            $isSuccess = false;
        } else {
            $email = checkInput($_POST['email']);
            $isSuccess = true;
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
                $isSuccess = false;
            }
            $emailText .= "email: $email\n";
        }

        if (empty($_POST['phone'])) {
            $phoneErr = "telephone is required";
            $isSuccess = false;
        } else {
            $phone = checkInput($_POST['phone']);
            if (!preg_match("/^[0-9 ]*$/",$phone)) {
                $phoneErr = "Invalid phone format";
                $isSuccess = false;
            }
            $isSuccess = true;
            $emailText .= "phone: $phone\n";
        }

        if (empty($_POST['message'])) {
            $messageErr = "message is required";
            $isSuccess = false;
        } else {
            $message = checkInput($_POST['message']);
            $isSuccess = true;
            $emailText .= "message: $message";
        }

        if ($isSuccess) {
            $headers = "from: $firstname $lastname <$email>\r\nReply-To: $email";
            mail($emailTo, "un message de votre site", $emailText, $headers);
            $firstname = $lastname = $email = $phone = $message = "";
        }

    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/skeleton/2.0.4/skeleton.min.css" integrity="sha512-EZLkOqwILORob+p0BXZc+Vm3RgJBOe1Iq/0fiI7r/wJgzOFZMlsqTa29UEl6v6U6gsV4uIpsNZoV32YZqrCRCQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="styles102.css">
    <title>Formulaire et envoi de mail</title>
</head>
<body>
    <div class="container">
        <h3>FORMULAIRE DE CONTACT</h3>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
            <div class="formulaire">
                <div class="formulaire-block">
                    <label for="name">firstname</label>
                    <input type="text" name="firstname"  value="<?php echo $firstname; ?>"/>
                    <p><?php echo $firstnameErr; ?></p>
                    
                    <label for="lastname">lastname</label>
                    <input type="text" name="lastname"  value="<?php echo $lastname; ?>"/>
                    <p><?php echo $lastnameErr; ?></p>
                </div>

                <div class="formulaire-block">
                    <label for="email">Email</label>
                    <input type="email" name="email"  value="<?php echo $email; ?>"/>
                    <p><?php echo $emailErr; ?></p>

                    <label for="tel">Téléphone</label>
                    <input type="tel" name="phone"  value="<?php echo $phone; ?>"/>
                    <p><?php echo $phoneErr; ?></p>
                </div>

                <div class="formulaire-block">
                    <label for="message">Message</label>
                    <input type="textarea" class="textarea"  name="message" value="<?php echo $message; ?>"></textarea>
                    <p><?php echo $messageErr; ?></p>
                            
                    <input type="submit"/>
                </div>

            </div>
        </form>
        <div style="display:<?php if($isSuccess) echo 'block'; else echo 'none'; ?>">Message envoyé. Merci !!!!</div>'
    </div>

</body>
</html>