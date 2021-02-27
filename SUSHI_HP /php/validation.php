<?php

//validation for reservation page
function validation_reservation($data){
    $error = [];

   if(empty($data['your_name']) || 20 < strlen($data['your_name'])){
        $error[] = 'Enter your name in 20 characters or less.';
   }

   //以下のemailアドレスのバリデーションをやると、正しいアドレスを入力しても必ず、エラーとなる。。。

   //if(empty($data['email']) || !filter_var($data['email'],FILTER_VALIDATION_EMAIL)){
   //     $error[] = 'Your Email address is not formatted correctly.';
   //}


   //予約日を指定しないとエラーとなるようにしたいのに出来ない。。。

   //if(!isset($data['book_at']){
   //     $error[] = 'Choose the date for your reservation.';
  // }

    return $error;
}



//validation for contact page
function validation_contact($data){
    $error = [];


   if(empty($data['your_name']) || 20 < strlen($data['your_name'])){
        $error[] = 'Enter your name in 20 characters or less.';
   }

  // if(empty($data['email']) || !filter_var($data['email'],FILTER_VALIDATION_EMAIL)){
  //      $error[] = 'Your Email address is not formatted correctly.';
  // }

   if(empty($data['content']) || 1500 < strlen($data['content'])){
        $error[] = 'The content of the inquiries must be written in 300 words or less.';
   }

    return $error;
}

?>