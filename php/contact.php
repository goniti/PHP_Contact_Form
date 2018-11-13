<?php 
    $array = array("firstname" => "", "name" => "", "email" => "", "phone" => "", "message" => "", "firstnameError" => "", "nameError" => "", "emailError" => "", "phoneError" => "", "messageError" => "", "isSuccess" => false);
    $emailTo = "EMAIL@DOMAINE.COM";

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $array["firstname"]  = test_input($_POST["firstname"]);
        $array["name"]       = test_input($_POST["name"]);
        $array["email"]      = test_input($_POST["email"]);
        $array["phone"]      = test_input($_POST["phone"]);
        $array["message"]    = test_input($_POST["message"]);
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

    function isEmail($email) 
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    function isPhone($phone) 
    {
        return preg_match("/^[0-9 ]*$/",$phone);
    }
    function test_input($data) 
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
 
?>