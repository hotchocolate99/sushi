<?php

//against CSRF
session_start();

require 'validation.php';


//against click junction
header('X-FRAME-OPTION:DENY');

//against XSS
function h($str){
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

//var_dump($_SESSION);

//to switch pages---------------------
  $pageFlag = 0;

  $error = validation_reservation($_POST);

  //btn_confirmとしてconfirmという文字列が入っているので空ではない。
 if(!empty($_POST['btn_confirm']) && empty($error)){
   $pageFlag = 1;
 }

 if(!empty($_POST['btn_submit'])){
   $pageFlag = 2;
 }
//--------------------------------------


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sushi Nisinokaze/Reservations</title>
    <link rel="stylesheet" type="text/css" href="../css/contact&reservation.css">
    <link rel="stylesheet" type="text/css" href="../css/common.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
</head>

<body>


<!--common part-->
<header>
   <div class="container">

      <div class="header-left">
        <img class="logo" src="../image/sushi-logo.png" alt="logo">
      </div>

      <div class="header-right">
        <a href="reservation.php" class="reservation">reservations</a>
      </div>

      <div class="clearlist">
      </div>

  <!--Navigation-->
      <div class="navi">
          <div class="container">
              <ul class="navi_menu">
                  <li><a href="../html/index.html">HOME</a>
                      <ul>
                        <li><a href="../html/index.html#menu">MENU</a></li>
                        <li><a href="../html/index.html#access">ACCESS</a></li>
                      </ul>
                  </li>
                  <li><a href="../html/about_us.html">ABOUT US</a>
                      <ul>
                        <li><a href="../html/about_us.html#sd">SEASONAL DINNING</a></li>
                        <li><a href="../html/about_us.html#chef">THE CHEF</a></li>
                      </ul>
                  </li>
                  <li><a href="../html/gallery.html">GALLERY</a>
                  <li><a href="contact.php">CONTACT</a>
                      <ul>
                        <li><a href="contact.php#inquiry">INQUIRIES</a></li>
                        <li><a href="contact.php#policy">RESERVATION POLICY</a></li>
                      </ul>
                   </li>
               </ul>

          <div class="clearlist">
          </div>

      </div><!--navi-->

   </div><!--container-->
</header>
<!--common part end-->




  <div class="main-wrapper">
    <div class="container">

<!--confirm page-->
    　   <?php if($pageFlag === 1): ?>
         <?php if($_POST['csrf']===$_SESSION['csrfToken']) :?>
            <div class="section-title">
                <h2 class=>CONFIRMATION</h2><br>
                  <form method="POST" action="reservation.php">
                    <p>Name:&nbsp;&nbsp;&nbsp;<?php echo h($_POST['your_name']);?></p><br>
                    <p>E-mail:&nbsp;&nbsp;&nbsp;<?php echo h($_POST['email']);?></p><br>
                    <p>Date:&nbsp;&nbsp;&nbsp;<?php echo h($_POST['book_at']);?></p><br>
                    <p>Time:&nbsp;&nbsp;&nbsp;<?php if($_POST['time']==='6:00PM'){echo '6:00 PM';}
                                                    elseif($_POST['time']==='8:30PM'){echo '8:30 PM';}?></p><br>
                    <p>Number of guests:&nbsp;&nbsp;&nbsp;<?php echo h($_POST['people']);?></p><br>

                      <input type="submit" name="back" value="go back">
                      <input type="submit" name="btn_submit" value="send">
                      <input type="hidden" name="your_name" value="<?php echo h($_POST['your_name']);?>"> <!--valueにコンファームのデータ（＄inquiry）を入れることで、次の完了画面に送っている-->
                      <input type="hidden" name="email" value="<?php echo h($_POST['email']);?>">
                      <input type="hidden" name="book_at" value="<?php echo h($_POST['book_at']);?>">
                      <input type="hidden" name="time" value="<?php echo h($_POST['time']);?>">
                      <input type="hidden" name="people" value="<?php echo h($_POST['people']);?>">
                      <input type="hidden" name="csrf" value="<?php echo nl2br(h($_POST['csrf']));?>">

                  </form>
            </div>
         <?php endif; ?>
         <?php endif; ?>

<!--confirm page end-->

<!--complete page-->
         <?php if($pageFlag === 2): ?>
         <?php if($_POST['csrf']===$_SESSION['csrfToken']) :?>
              <div class="section-title">
                  <h2 class="anime message">Your request has been sent successfully.
                  <br>Thank you very much for your reservation!</h2>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
              </div>

              <?php unset($_SESSION['csrfToken']); ?>

         <?php endif; ?>
         <?php endif; ?>
<!--complete page end-->


<!--input page-->
         <?php if($pageFlag === 0): ?>

          <!--defining csrf token-->
           <?php
                if(!isset($_SESSION['csrfToken'])){
                  $csrfToken = bin2hex(random_bytes(32));
                  $_SESSION['csrfToken'] = $csrfToken;
                }
                  $token = $_SESSION['csrfToken'];
            ?>
           <!--defining csrf token end-->

              <div class="section-title reserve">
                <h1>RESERVE SEATS</h1>
                <p>Please read the reservation policy below befor you reserve.</p><br>

        <!--error messege-->
                  <?php if(!empty($_POST['btn_confirm']) && !empty($error)) :?>
                      <ul>
                        <?php foreach($error as $value):?>
                          <li class="notice"><?php echo $value ;?></li>
                        <?php endforeach;?>
                      </ul>
                  <?php endif; ?>
        <!--error messege end-->

                    <form method="POST" action="reservation.php" >

                        <div class="form-item">Name&nbsp;(required)</div>
                        <input type="text" name="your_name" value="<?php echo h($_POST['your_name']);?>">

                        <div class="form-item">Email&nbsp;(required)</div>
                        <input type="text" name="email"  value="<?php echo h($_POST['email']);?>">

                        <div class="form-item">Date</div>
                        <input type="date" name="book_at" value="<?php echo h($_POST['book_at']);?>">

                        <div class="form-item">Time</div>
                        <p>There are only two seatings per night : </p>
                        <input type="radio" name="time" value='0' checked>6:00 PM Start
                        <input type="radio" name="time" value='1' >8:30 PM Start

                        <div class="form-item">Number of gueats</div>
                        <select name="people">
                            <?php for($i=1; $i<=12; $i++):?>
                                  <?php if($_POST['people'] = $i): ?>
                                      <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                  <?php endif; ?>
                            <?php endfor; ?>
                        </select><br>

                        <input type="submit" name="btn_confirm" value="confirm">
                        <input type="hidden" name="csrf" value="<?php echo $token ?>">

                    </form>
              </div><!--section-title-->
         <?php endif;?>
 <!--input page end-->


          <div class="section-title policy">
              <h1 class="anime">RESERVATION POLICIES</h1>
              <ul class="anime">
                <li>Cancellation Policy. There will be a cancellation charge which is the full price of the course plus tax per person if the reservation is cancelled less than 48 hours ( 72 hours for groups of 4 to 7 guests ) from the reservation date. This policy also applies to any reduction of party size and to guests who "no show".</li>
                <li>A valid credit card is required to secure reservations.</li>
                <li>Please be on time. If you will be late please contact us and let us know. We cannot guarantee you will be offered the full course if more than 15 minutes late and if this is the case then you will still be charged the full price of the course plus tax.</li>
                <li>We are sorry but children under 12 years of age are not permitted with the exception of private bookings.</li>
                <li>Due to the nature of the course, please plan your night accordingly. The length of the course will be an estimated 2 hours.</li>
                <li>For all guests to have a pleasant dining experience please refrain from using strong perfumes/cologne and loud cellphones. Please set phones to silent mode.</li>
                <li>We apologize but unfortunately we cannot accommodate guests who have dietary lifestyles ( gluten-free, vegan, vegetarian, ex. ). <br>
                  We serve primarily raw seafood. Please inform us of any allergies ahead of time and we will do our best to accommodate.</li>
                <li>We reserve the right to cancel any reservations due to weather, emergency or restaurant related issues. In those circumstances, all guests will be notified and there will be no cancellation charges.</li>
                <li>Please be aware that consuming raw or undercooked seafood, shellfish, or eggs may increase your risk of food borne illness.</li>
              </ul>
          </div>

    </div><!--container-->
  </div><!--main-wrapper-->



<!--common part-->
<footer>
  <div class="container">
    <h3>SOCIAL</h3>
    <a href="reservation.php" class="back_top back_home">Back to top</a>

    <div class="clearlist">
    </div>

    <a  href="#" class="btn facebook"><span><i class="fab fa-facebook-square"></i>Facebook</span></a>
    <a  href="http://instagram.com/sushi_nishinokaze?igshid=1lxn5k8wzq1px" class="btn instagram" ><span><i class="fab fa-instagram"></i>Instagram</span></a>
  </div>
</footer>
<!--common part end-->

  </body>
  </html>