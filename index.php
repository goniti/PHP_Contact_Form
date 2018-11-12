<?php 
    $firstname = $name = $email = $phone = $message = "";
    $firstnameError = $nameError = $emailError = $phoneError = $messageError = "";
    $isSuccess = false;
    $emailTo = "EMAIL@DOMAINE.COM";
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $firstname = verifyInput($_POST["firstname"]);
        $name = verifyInput($_POST["name"]);
        $email = verifyInput($_POST["email"]);
        $phone = verifyInput($_POST["phone"]);
        $message = verifyInput($_POST["message"]);
        $isSuccess = true;
        $emailText = "";

        if(empty($firstname))
        {
            $firstnameError = "Sachez qu'il faut indiquez votre prénom !";
            $isSuccess = false;
        }
        else{
            $emailText .= "Firstname: $firstname\n";
        }    
        if(empty($name))
        {
            $nameError = "Votre nom est une information requise !";
            $isSuccess = false;
        }
        else{
            $emailText .= "Name: $name\n";
        }
        if(!isEmail($email))
        {
            $emailError = "Veuillez saisir une adresse email.";
            $isSuccess = false;
        }
        else{
            $emailText .= "Email: $email\n";
        } 
        if(!isPhone($phone))
        {
            $phoneError = "Utilisé des caractères entre 0 et 9";
            $isSuccess = false;
        }
        else{
            $emailText .= "Phone: $phone\n";
        } 
        if(empty($message))
        {
            $messageError = "Je vous invite à écrire un message.";
            $isSuccess = false;
        }
        else{
            $emailText .= "Message: $message\n";
        } 
        if($isSuccess)
        {
            $headers = "From: $firstname $name <$email>\r\nReply-To: $email";
            mail($emailTo, "Un message de votre site", $emailText, $headers);
            $firstname = $name = $email = $phone = $message = "";
        }
    }

    function isPhone($var)
    {   # Regular Expression / preg_match Phone-Numbers "/^[0-9 ]*$/"
        return preg_match("/^[\+0-9\-\/\(\)\.\s]*$/", $var);
    }

    function isEmail($var)
    {
        return filter_var($var, FILTER_VALIDATE_EMAIL);
    }

    function verifyInput($var)
    {
        $var = trim($var);
        $var = stripslashes($var);
        $var = htmlspecialchars($var);
        return $var;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contactez-moi !</title>
    <!-- JQUERY 3-->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <!-- BOOTSTRAP 4 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
    <!-- POPPER -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
    <!-- LOCAL -->
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
</head>
<body>
    <div class="container">
        <div class="divider"></div>
        <div class="heading">
            <h2>Contactez-moi!</h2>
        </div>
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 mx-auto">
                <form id="contact-form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" role="form">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="font-weight-bold" for="firstname">Prénom<span class="blue"> *</span></label>
                            <input type="text" id="firstname" name="firstname" class="form-control" placeholder="Votre prénom" value="<?php echo $firstname; ?>">
                            <p class="comments"><?php echo  $firstnameError; ?></p>
                        </div>
                        <div class="col-md-6">
                            <label class="font-weight-bold" for="name">Nom<span class="blue"> *</span></label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Votre nom" value="<?php echo $name; ?>">
                            <p class="comments"><?php echo  $nameError; ?></p>
                        </div>
                        <div class="col-md-6">
                            <label class="font-weight-bold" for="email">Email<span class="blue"> *</span></label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Votre email" value="<?php echo $email; ?>">
                            <p class="comments"><?php echo  $emailError; ?></p>
                        </div>
                        <div class="col-md-6">
                            <label class="font-weight-bold" for="phone">Téléphone</label>
                            <input type="tel" id="phone" name="phone" class="form-control" placeholder="Votre téléphone" value="<?php echo $phone; ?>">
                            <p class="comments"><?php echo  $phoneError; ?></p>
                        </div>
                        <div class="col-md-12">
                            <label class="font-weight-bold" for="message">Message<span class="blue"> *</span></label>
                            <textarea name="message" id="message" class="form-control" placeholder="Votre message" rows="4"><?php echo $message; ?></textarea>
                            <p class="comments"><?php echo  $messageError; ?></p>
                        </div>
                        <div class="col-md-12">
                           <p class="blue"><strong>* Ces informations sont requises</strong></p>
                        </div>
                        <div class="col-md-12">
                            <input type="submit" value="Envoyer" class="button1">
                        </div>
                    </div>

                    <p class="thank-you" style="display:<?php if($isSuccess) echo 'block'; else echo 'none';?>">Votre message a bien été envoyé. Merci de m'avoir contacté !</p>

                </form>
            </div>
        </div>
    </div>
</body>
</html>