<?/*
if (isset($_POST['rezervace'])) {
 $prijemce = rtrim("growlbox123g@gmail.com");
  $prijemce = $nastaveni['email'];
  $predmet = "Arusolar.cz";
  $obsah = "<table>
      <tr><th style='background-color: #eeeeee;text-align: left;padding: 5px;'>Jméno a příjmení: </th><td style='padding: 5px;'>" . $_POST['jmeno'] . "</td></tr>
      <tr><th style='background-color: #eeeeee;text-align: left;padding: 5px;'>Ulice: </th><td style='padding: 5px;'>" . $_POST['ulice'] . "</td></tr>
      <tr><th style='background-color: #eeeeee;text-align: left;padding: 5px;'>E-mail: </th><td style='padding: 5px;'>" . $_POST['email'] . "</td></tr>
      <tr><th style='background-color: #eeeeee;text-align: left;padding: 5px;'>Telefon: </th><td style='padding: 5px;'>" . $_POST['telefon'] . "</td></tr>
      <tr><th style='background-color: #eeeeee;text-align: left;padding: 5px;'>Poznámka: </th><td style='padding: 5px;'>" . nl2br($_POST['poznamka']) . "</td></tr>
      <tr><th style='background-color: #eeeeee;text-align: left;padding: 5px;'>Soubor: </th><td style='padding: 5px;'><img src='" . $_POST['file'] . "'/></td></tr>
    </table>";
  $odesilatel = rtrim($_POST['email']);

  if (Mail($prijemce, $predmet, $obsah, "From: " . $odesilatel . "\nX-Mailer: PHP\nContent-Type: text/html; charset=utf-8\n")) {
    Mail($_POST['email'], $predmet, $obsah, "From: " . $odesilatel . "\nX-Mailer: PHP\nContent-Type: text/html; charset=utf-8\n");

    $_SESSION['msg'] = "Velmi nás těší Váš zájem o naše ubytování. Vaše rezervace bude vyřízena nejpozději do 24 hodin. Dovolujeme si upozornit a poprosíme Vás, náš e-mail, hledejte i v nevyžádané poště, spamu apod. Prosím, pokud nenajdete ve svém e-mailu naši odpověď do 24 hodin, kontaktujte nás telefonicky na čísle 774 440 242. Děkujeme.";
    header('Location:' . $domena . 'success.html');
    exit;
  } else {
    $_SESSION['err'] = "E-mail se nepodařilo odeslat";
    header('Location:' . $domena . 'error.html');
    exit;
  }
}*/
$message = '';

function clean_text($string)
{
 $string = trim($string);
 $string = stripslashes($string);
 $string = htmlspecialchars($string);
 return $string;
}

if(isset($_POST["submit"]))
{

 /*$path = array('upload/' . $_FILES["file"]["name"]);
 move_uploaded_file($_FILES["file"]["tmp_name"], $path);

 print_r($_FILES);*/
 function imgarray(array $arr){

    $result = array();
    foreach($arr as $key => $value){
      for($i =0; $i < count($value); $i++){
        $result[$i][$key] = $value[$i];
      }
    }
    return $result;
 }

 $files = [];
 if(!empty($_FILES['file'])){
  $files = imgarray($_FILES['file']);
 }

 $message = '
  <h3 align="center">Formulář</h3>
  <table border="1" width="100%" cellpadding="5" cellspacing="5">
   <tr>
    <td width="30%">Jméno a příjmení:</td>
    <td width="70%">'.$_POST["jmeno"].'</td>
   </tr>
   <tr>
    <td width="30%">Adresa:</td>
    <td width="70%">'.$_POST["ulice"].'</td>
   </tr>
   <tr>
    <td width="30%">E-mail:</td>
    <td width="70%">'.$_POST["email"].'</td>
   </tr>
 
   
   <tr>
    <td width="30%">Telefon:</td>
    <td width="70%">'.$_POST["telefon"].'</td>
   </tr>
   <tr>
    <td width="30%">Poznámka:</td>
    <td width="70%">'.$_POST["poznamka"].'</td>
   </tr>
  </table>
 ';
 
 require 'phpmailer/class.phpmailer.php';
 $mail = new PHPMailer;
 $mail->IsMail();        //Sets Mailer to send message using SMTP
 /*$mail->Host = 'smtpout.secureserver.net';  //Sets the SMTP hosts of your Email hosting, this for Godaddy
 $mail->Port = '80';        //Sets the default SMTP server port
 $mail->SMTPAuth = true;       //Sets SMTP authentication. Utilizes the Username and Password variables
 $mail->Username = 'xxxxxxx';     //Sets SMTP username
 $mail->Password = 'xxxxxxx';     //Sets SMTP password
 $mail->SMTPSecure = '';  */     //Sets connection prefix. Options are "", "ssl" or "tls"
 $mail->From = $_POST["email"];     //Sets the From email address for the message
 $mail->FromName = $_POST["jmeno"];    //Sets the From name of the message
 $mail->AddAddress('Rudolf.altrichter@arutech.cz', 'Rudolf');
 $mail->AddAddress('petr.dufka@arutech.cz', 'Petr');  //Adds a "To" address
 $mail->WordWrap = 50;       //Sets word wrapping on the body of the message to a given number of characters
 $mail->IsHTML(true);       //Sets message type to HTML

if(!empty($files)){
  foreach($files as $key => $file){
    $mail->addAttachment(
      $file['tmp_name'],
      $file['name']
    ); 
  }
}
 //$mail->AddAttachment($path);     //Adds an attachment from a path on the filesystem

 $mail->Subject = 'Arusolar.cz';    //Sets the Subject of the message
 $mail->Body = $message;       //An HTML or plain text message body
 if($mail->Send())        //Send an Email. Return true on success or false on error
 {
  $message = '<div class="alert alert-success">Application Successfully Submitted</div>';
 unlink($path);
 header('Location:' . $domena . 'success.html');
 }
 else
 {
  $message = '<div class="alert alert-danger">There is an Error</div>';
  header('Location:' . $domena . 'error.html');
 }
}
?>
 

<!DOCTYPE html>
<html>
  <head>
    <!-- Google tag (gtag.js) --> <script async src="https://www.googletagmanager.com/gtag/js?id=G-1NEV7L5BYZ"></script> <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'G-1NEV7L5BYZ'); </script>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="./css/global.css">
      <link rel="stylesheet" href="./css/form/formfooter.css">
    <link rel="stylesheet" href="./css/navbar.css">
   
    <link rel="stylesheet" href="./css/copyright.css">
     <link rel="stylesheet" href="./css/success/success.css">
      <link rel="stylesheet" href="./css/form/form.css">
      <link rel="stylesheet" href="./css/menu.css">
      <!-- <link rel="stylesheet" href="./css/footer.css"> -->
  </head>
  <body style="max-width: 1920px; margin: auto;">
    <img src="./img/background.png" class="img_bg" alt="backgroundimg" style="position: absolute; object-fit: cover; width:100%;  z-index: -1;">
<nav class="element_border nav_">
   <a href="./index.html"><img src="./img/logonav.svg" alt="logonav"></a>
</nav>

<!-- <div class="solarimg_success">
    <img src="./img/solar.png" alt="">
  </div> -->

    <section class="element_border form_">
       <div><h1>VYPLŇTE</h1></div>
        <div><h2>NEZÁVAZNÝ FORMULÁŘ</h2></div>
        <form method="post" enctype="multipart/form-data">
          <div class="form_item">
            <p>jméno a příjmení*</p>
            <input type="text" name="jmeno">
          </div>
          <div class="form_item">
            <p>adresa realizace/servisu*</p>
            <input type="text" name="ulice">
          </div>
        <div class="form_items_row">
          <div class="form_items">
            <p>telefon*</p>
            <input type="text" name="telefon">
          </div>
           <div class="form_items input2_padding item1">
            <p>e-mail*</p>
            <input type="text" name="email">
          </div>
        </div> 
         <div  class="form_item">
            <p>popis požadavku*</p>
            <textarea type="text" name="poznamka"></textarea>
          </div>
          <div> <p style="font: normal normal 800 22px/25px Open Sans; color:white; text-align:center;">NAHRAJTE FOTOGRAFIE NEBO DOKUMENTACI</p></div>
          <div class="form_item_upload">
            <div style="    margin-inline: auto;
     margin-top:2rem" class="filebutton">
    
            <label for="file" style="text-transform:uppercase;">
              vyberte soubory
            
            </label>
          <input id="file" type="file" name="file[]" multiple></div>
          </div>
           <div class="form_item_button">
           
            <button type="submit" name="submit">odeslat nezávaznou poptávku</button>
          </div>
          <div class="form_item_checkbox"><input type="checkbox" required>
          <label for="">Souhlasím se <a href=""> zpracováním osobních údajů v rámci GDPR.</a></label></div>
        </form>
    </section>


<section class="element_border footer_ footer_text">
  <div style="z-index: 3;">
    <a href="./index.html"> <img src="./img/logofooter.svg" alt="arusolar logo" style=" z-index: 3;"> </a>
  </div>
  <div>
    <h1>ARU services s.r.o.</h1>
    <p>Střimelická 452</p>
    <p>251 65, Ondřejov</p>
    <p>IČ: 171 26 401</p>
  </div>
<div>
  <p>E-MAIL:</p>
  <h1>aru_kancelar@arutech.cz</h1>
</div>

</section>
<div class="copyright_bg">
<footer class="element_border copyright_">
  <div class="copyright_text_left">
    <p>2022 © ARU technologies s.r.o.</p>
  </div>
  <div class="copyright_text_center">
    <a href="./gdpr.html"><p>gdpr</p></a>
    <a href="./cookies.html"><p>cookies</p></a>
  </div>
  <div class="copyright_text_right">
    <p>webdesign by
    <a href="https://www.synapse5.com/" style="color: white; font-weight: 800;">SYNAPSE/5</a></p>
  </div>

</footer>
</div>
  </body>
</html>