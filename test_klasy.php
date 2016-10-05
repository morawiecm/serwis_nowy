


<html>
<body>

<?php
if (isset($_REQUEST['email']))
//jeśli "email" jest wypełnione, Wyślij e-mail
{
    // Wyślij e-mail
    $email = $_REQUEST['email'] ;
    $subject = $_REQUEST['subject'] ;
    $message = $_REQUEST['message'] ;
    mail("serwiskwppolicja@gmail.com", $subject,
        $message, "From:" . $email);
    echo " Dziękujemy za skorzystanie z naszego formularza e-mail ";
}
else
//jeśli "email" nie jest ustawiony, wyświetl formularz
{
    echo "<form method='post' action='test_klasy.php'>
  Email: <input name='email' type='text'><br>
  Subject: <input name='subject' type='text'><br>
  Message:<br>
  <textarea name='message' rows='15' cols='40'>
  </textarea><br>
  <input type='submit'>
  </form>";
}
?>

</body>
</html>