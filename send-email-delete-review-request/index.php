<?php
    header("Access-Control-Allow-Origin: https://shopping-cart-java.herokuapp.com");
    header("Content-type: application/x-www-form-urlencoded");
    
    $domain = filter_input(INPUT_POST, 'domain');
    $row_id = filter_input(INPUT_POST, 'row_id');
    $item_id = filter_input(INPUT_POST, 'item_id');
    $rating = filter_input(INPUT_POST, 'rating');
    $subject = filter_input(INPUT_POST, 'subject');
    $description = filter_input(INPUT_POST, 'description');
    $name = filter_input(INPUT_POST, 'name');
    $email = filter_input(INPUT_POST, 'email');
    $security_code = filter_input(INPUT_POST, 'security_code');
    $forward_slash_or_html = '/';
    $message = '';
    
    if ($domain != '' && !(ctype_space($domain))
            && $row_id != '' && !(ctype_space($row_id))
            && $item_id != '' && !(ctype_space($item_id))
            && $rating != '' && !(ctype_space($rating))
            && $subject != '' && !(ctype_space($subject))
            && $description != '' && !(ctype_space($description))
            && $name != '' && !(ctype_space($name))
            && $email != '' && !(ctype_space($email)) && filter_var($email, FILTER_VALIDATE_EMAIL)
            && $security_code != '' && !(ctype_space($security_code))) {
        
        //Take the rating number, and use a word to describe the rating.
        switch ($rating) {
            
            case '5':
                
                $rating = 'Excellent';
                break;
            
            case '4':
                
                $rating = 'Good';
                break;
            
            case '3':
                
                $rating = 'Average';
                break;
                
            case '2':
                
               $rating = 'Fair';
               break;
           
           default:
               
               $rating = 'Poor';
               break;
        }
        
        //Multiple recipients can receive this message, by using the comma in the $email variable.
        $message .= "<!DOCTYPE html>\r\n";
        $message = "<html xmlns=\"http://www.w3.org/1999/xhtml\">\r\n";
        $message .= "<head>\r\n";
        $message .= "<title>" . $name . ", you are trying to edit your review.</title>\r\n";
        $message .= "</head>\r\n";
        $message .= "<body>\r\n";
        $message .= "<style>\r\n";
        $message .= "a { text-decoration: none; font-family: normal normal normal 'Open Sans', sans-serif; font-size: 12pt; color: #e20000; cursor: pointer; }\r\n";
        $message .= "a:hover, a:focus, a:visited { text-decoration: underline; font-family: normal normal normal 'Open Sans', sans-serif; font-size: 12pt; color: #e20000; cursor: pointer; }\r\n";
        $message .= "</style>\r\n";
	$message .= "<div style=\"text-align: left\">\r\n";
        $message .= "<p>\r\n";
        $message .= $name . ", \r\n";
        $message .= "you are trying to delete the following review.<br />\r\n";
        $message .= "</p>\r\n";
        $message .= "</div>\r\n";
	$message .= "<div style=\"text-align: left\">\r\n";
        $message .= "<p>\r\n";
        $message .= "<b>Rating:</b>\r\n";
        $message .= $rating . "<br />\r\n";
        $message .= "</p>\r\n";
        $message .= "</div>\r\n";
	$message .= "<div style=\"text-align: left\">\r\n";
        $message .= "<p>\r\n";
        $message .= "<b>Subject:</b>\r\n";
        $message .= $subject . "<br />\r\n";
        $message .= "</p>\r\n";
        $message .= "</div>\r\n";
	$message .= "<div style=\"text-align: left\">\r\n";
        $message .= "<p>\r\n";
        $message .= "<b>Description:</b>\r\n";
        $message .= $description . "<br />\r\n";
        $message .= "</p>\r\n";
        $message .= "</div>\r\n";
        $message .= "<div style=\"text-align: left\">\r\n";
        $message .= "<p><a href='" . $domain . "/product-reviews" . $forward_slash_or_html .
                "?code=" . $security_code . "&review=" . $row_id . "&product=" . $item_id . "&sort=Low%20to%20high&perpage=10&pagenum=1&enablereviewdeletion=Enable&search=Search'>Delete review</a></p>\r\n";
        $message .= "</div>\r\n";
        $message .= "<div style=\"text-align: left\">\r\n";
        $message .= "<p>If you did not intend to delete this review disregard this email.</p>\r\n";
        $message .= "</div>\r\n";
        $message .= "<div style=\"text-align: left\"><p>Do not reply to this message.</p></div>\r\n";
        $message .= "</body>\r\n";
        $message .= "</html>\r\n";

        // To send HTML mail, the Content-type header must be set
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';

        // Additional headers
        $headers[] = 'From: Timothy\'s Digital Solutions <timvdg45@gmail.com>';
        $headers[] = 'Reply-To: timvdg45@gmail.com';
        $headers[] = 'X-Mailer: PHP/' . phpversion();

        // Mail it
        mail($email, ($name . ', you are trying to delete your review.'), $message, implode("\r\n", $headers));
        
        echo 'success';
    }
