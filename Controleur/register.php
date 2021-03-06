<?php

if(isset($_POST['confirm-button']))
{
    $lastname = uninjection_sql(htmlspecialchars($_POST['last-name']));
    $firstname = uninjection_sql(htmlspecialchars($_POST['first-name']));
    $mail = uninjection_sql(htmlspecialchars($_POST['mail']));
    $password = sha1($_POST['password']);
    $confirmpassword = sha1($_POST['confirm-password']);

    if(!empty($_POST['last-name']) AND !empty($_POST['first-name']) AND !empty($_POST['mail']) AND !empty($_POST['password']) AND !empty($_POST['confirm-password']) AND !empty($_POST['serialnumber']))
    {
        if(filter_var($mail, FILTER_VALIDATE_EMAIL))
        {
            $reqmail = $bdd->prepare("SELECT * FROM client WHERE mail = ?");
            $reqmail->execute(array($mail));
            $mailexist = $reqmail->rowCount(); //change --> if serial exist

            if($mailexist == 0)
            {
                if($password == $confirmpassword)
                {
                    /*$insertmbr = $bdd->prepare("INSERT INTO client(lastname, firstname, mail, password, type) VALUES(?,?,?,?,?)");
                    $insertmbr->execute(array($lastname, $firstname, $mail, $password, $typeclient));
                    $error = "Merci de vous être inscrit ! Veuillez vous connecter  pour continuer !"; 
                    sleep(2);
                    */
                    $insertmbr = $bdd->prepare("INSERT INTO client(mail, password) VALUES(?,?)");
                    $insertmbr->execute(array($mail, $password));
                    header("Location: ../Vue/login.php");
                }
                else
                {
                    $error = "Mots de passes non correspondant !";
                }
            }
            else
            {
                $error = "Adresse mail existante !";
            }
        }
        else
        {
            $error = " Votre adresse email n'est pas valide !";
        }
    }
    else
    {
        $error = "Champ(s) non complété(s)";
    }
}
?>