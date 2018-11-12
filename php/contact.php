<?php 
    $array = array("firstname" => "", "name" => "", "email" => "", "phone" => "", "message" => "", "firstnameError" => "", "nameError" => "", "emailError" => "", "phoneError" => "", "messageError" => "", "isSuccess" => false);
    
    $emailTo = "EMAIL@DOMAINE.COM";
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $array["firstname"]  = verifyInput($_POST["firstname"]);
        $array["name"]       = verifyInput($_POST["name"]);
        $array["email"]      = verifyInput($_POST["email"]);
        $array["phone"]      = verifyInput($_POST["phone"]);
        $array["message"]    = verifyInput($_POST["message"]);
        $array["isSuccess"]  = true;
        $emailText = "";

        if(empty($array["firstname"]))
        {
            $array["firstnameError"] = "Sachez qu'il faut indiquez votre prénom !";
            $array["isSuccess"]  = false;
        }
        else{
            $emailText .= "Firstname: {$array['firstname']}\n";
        }    
        if(empty($array["name"]))
        {
            $array["nameError"] = "Votre nom est une information requise !";
            $array["isSuccess"]  = false;
        }
        else{
            $emailText .= "Name: {$array['name']}\n";
        }
        if(!isEmail($array["email"]))
        {
            $array["emailError"] = "Veuillez saisir une adresse email.";
            $array["isSuccess"]  = false;
        }
        else{
            $emailText .= "Email: {$array['email']}\n";
        } 
        if(!isPhone($array["phone"]))
        {
            $array["phoneError"] = "Utilisé des caractères entre 0 et 9";
            $array["isSuccess"]  = false;
        }
        else{
            $emailText .= "Phone: {$array['phone']}\n";
        } 
        if(empty($array["message"]))
        {
            $array["messageError"] = "Je vous invite à écrire un message.";
            $array["isSuccess"]  = false;
        }
        else{
            $emailText .= "Message: {$array['message']}\n";
        } 
        if($array["isSuccess"])
        {
            $headers = "From: {$array['firstname']} {$array['name']} <{$array['email']}>\r\nReply-To: {$array['email']}";
            mail($emailTo, "Un message de votre site", $emailText, $headers);
        }

        echo json_encode($array);
    }

    function isPhone($phone)
    {   # Regular Expression / preg_match Phone-Numbers "/^[0-9 ]*$/"
        return preg_match("/^[\+0-9\-\/\(\)\.\s]*$/", $phone);
    }

    function isEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    function verifyInput($data)
    {
        $var = trim($data);
        $var = stripslashes($data);
        $var = htmlspecialchars($data);
        return $data;
    }

?>