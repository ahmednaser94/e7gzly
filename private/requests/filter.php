<?php 

class filters {
  
    // filters a string 
    public function filterString($data) {
      $data = filter_var($data, FILTER_SANITIZE_STRING);
      return $data;
    }

    // filter and validate email
    public function filterEmail($email) {
      
      $email = filter_var($email, FILTER_SANITIZE_EMAIL);
      
      if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "$email"; 
    } else {
      die("$email is Invalid email");
    }

    }

    // filter and validate URL
    public function filterURL($url) {
        $url = filter_var($url, FILTER_SANITIZE_URL);
        if (filter_var($url, FILTER_VALIDATE_URL)) {
          return "$url";
        } else {
            die("$url is NOT a valid URL");
        }
    }

    // filter and validate INT 
    public function filterInt($num) {
      $num = filter_var($num, FILTER_SANITIZE_NUMBER_INT);

      if (!filter_var($num, FILTER_VALIDATE_INT)) {
        die("$num is NOT a valid number");
      } else {
        return "$num";
      }
    }



}


  
?>