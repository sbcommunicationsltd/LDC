<?php
define("EMAIL", "info@londondinnerclub.org");
 
$nameErr ="";
$emailErr ="";
$messageErr ="";
$emailMessage = "";

 
if(isset($_POST['submit'])) {
   
  //include('validate.class.php');
   
  //assign post data to variables 
  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $phone = trim($_POST['phone']);
  $messagesubject = trim($_POST['subject']);
  $message = trim($_POST['message']);
  
  // Validate Name
  if(strlen($name) < intval(3) 
	|| strlen($name) > intval(75)){
	$nameErr = "Must be between 3 and 75 characters";
  }
  
  // Validate Message
  if(strlen($message) < intval(5) 
	|| strlen($message) > intval(1000)){
	$messageErr = "Must be between 5 and 1000 characters";
  }  
  
  // Validte Email
  if(!$email 
	|| !preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $email)){
	$emailErr = "A valid email address is required";
  }
  
  
  //start validating our form
  //$v = new validate();
  //$v->validateStr($name, "name", 3, 75);
  //$v->validateEmail($email, "email");
  //$v->validateStr($message, "message", 5, 1000);  
 
  if(!$nameErr && !$emailErr && !$messageErr) {
        $header = "From: $email\n" . "Reply-To: $email\n";
        $subject = "Contact Form Query - London Dinner Club: ";
		
		/////////////////////////////////////////////
		///////// CHANGE THIS EMAIL ADDRESS /////////
		/////////////////////////////////////////////
        $email_to = "info@londondinnerclub.org";
		/////////////////////////////////////////////
		/////////////////////////////////////////////

		$emailMessage .= "Name: " . $name . $lastname . "\n\n";
		$emailMessage .= "Email: " . $email . "\n\n";
		$emailMessage .= "Phone: " . $phone . "\n\n";
		$emailMessage .= "Enquiry: " . $subject . "\n\n";
        $emailMessage .= "Message: " . $message;
         
    //use php's mail function to send the email
        @mail($email_to, $subject,$emailMessage ,$header );  
         
    //grab the current url, append ?sent=yes to it and then redirect to that url
        $url = "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
        header('Location: '.$url."?sent=yes#contact");
 
    } else {
    //set the number of errors message
    //$message_text = $v->errorNumMessage();       
 
    //store the errors list in a variable
    //$errors = $v->displayErrors();
     
    //get the individual error messages
    //$nameErr = $v->getError("name");
    //$emailErr = $v->getError("email");
    //$messageErr = $v->getError("message");
  }//end error check
}// end isset
?>

<!DOCTYPE html>
<!--[if lt IE 7]> <html class="ie6" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="ie7" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="ie8" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>

    <title>Contact | London Dinner Club | Connecting People | London</title>
    
    <!-- Meta -->
	<meta charset="UTF-8">
	<meta name="keywords" content="Dinner parties London, London Dinner Club, london events, events, london, salima manji, supperclub, vogue, luxury events, luxe events, networking, socialising, professional networking, city networking, city events" />
	<meta name="description" content="Contact London Dinner Club for for more information" />
	<meta name="robots" content="index, follow" />
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        
    <!-- StyleSheet -->
    <link rel="stylesheet" media="screen" href="css/mainstyle.css" type="text/css"/>
    <link rel="stylesheet" media="screen" href="css/fontstyle.css" type="text/css"/>
    <link rel="stylesheet" media="screen" href="css/forms.css" type="text/css"/>
    <link rel="stylesheet" media="screen" href="css/dropdown.css" type="text/css"/>
    
    <!--[if lt IE 9]>  <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

    <!-- Icons -->
    <link rel="icon" href="images/favicon.ico" />
    <link rel="apple-touch-icon-precomposed" href="images/apple-touch-icon.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/apple-touch-icon-114x114.png" type="text/css"/>
    
     <!--JS -->
     <script type="text/javascript" src="js/retina.js"></script>
     <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
     
     <script type="text/javascript" src="js/jquery.scrollUp.min.js"></script>
     <script type="text/javascript" src="js/jquery.easing.min.js"></script>

</head>

<body id="subpages">
	<div class="white-border">
    </div>
    
    <div class="container relative">
    	<!-- Main header and Nav -->
    	<header>
        	<?php $menu="contact";?>
   			<?php include('navigation.php');?>
    
       </header>
    	
       
       <!-- Content-->
       <div class="spacebreak"></div>
       
       <h1 class="medium-header uppercase">Contact</h1>
       <div class="line2"></div>
       		<div class="fl box-326 contact">
               <p>If you have any enquiries please feel free to contact us via the contact form, and a member of the team will contact you back as soon as possible.</p>
               <p>Alternatively you can contact us directly by the details below:</p>
               <p><span class="bold">Email: </span><a href="mailto:info@londondinnerclub.org" target="_blank">info@londondinnerclub.org</a></p>
               
                    <a href="https://www.facebook.com/pages/London-Dinner-Club/233376956703832" rel="nofollow" target="_blank" title="Follow London Dinner Club on Facebook" class="footer-icon facebook fl"><span class="displace"></span></a>
                    <a href="https://twitter.com/#!/LdnDinnerClub" rel="nofollow" target="_blank" title="Follow London Dinner Club on twitter" class="footer-icon twitter fl"><span class="displace"></span></a>
                    <a href="http://uk.linkedin.com.pub/salima-manji/4/6a1/3a0" rel="nofollow" target="_blank" title="Follow London Dinner Club on linkedin" class="footer-icon linkedin fl"><span class="displace"></span></a>
                    <div class="clear"></div>
           		
      		</div>
            
            <form class="form-container fr" action="contact.php#contact" method="post">
			<a name="contact" id="contact"></a>
			<fieldset>
            	<?php if(!isset($_GET['sent'])): ?>
            	<div class="box-260-form fl">
            		<label for="firstname">Name: <span class="asterisk">*</span></label>
            		<input class="form-field" type="text" name="name" id="name" />
                 </div>
                 <div class="box-260-form fr">
            		<label for="surname">Email: <span class="asterisk">*</span></label>
            		<input class="form-field" type="text" name="email" id="email"  />
                 </div>
                 
                 <div class="box-260-form fl">
            		<label for="firstname">Enquiry: <span class="asterisk">*</span></label>
            		<input class="form-field" type="text" name="subject" id="subject" />
                 </div>
                 <div class="box-260-form fr">
            		<label for="surname">Telephone: <span class="asterisk">*</span></label>
            		<input class="form-field" type="text" name="phone" id="phone" />
                 </div>
                 
                 <div class="clear"></div>
                 <div class="text"><label for="message">Message: <span class="asterisk">*</span></label></div>
					<textarea class="form-box" data-label="Type your message here.." rows="4" cols="10" name="message" id="message"></textarea>
                 <div class="line"></div>
                 <input class="button-submit fr" type="submit" name="submit" id="submit" value="Submit" />
                
                 <div class="clear"></div>
                 
                 <?php if ((!$nameErr == "") || (!$emailErr == "") || (!$messageErr == "")): ?>
					<div class="errorbox">
						Sorry - there was an error. Please fill out all fields
					</div>
                     <div class="clear"></div>
					<?php endif; ?>
					
				<?php endif; ?>
                
                <?php if(isset($_GET['sent'])): ?>
                	<div class="box-260-form fl">
            		<label for="firstname">Name: <span class="asterisk">*</span></label>
            		<input class="form-field" type="text" name="name" id="name" />
                 </div>
                 <div class="box-260-form fr">
            		<label for="surname">Email: <span class="asterisk">*</span></label>
            		<input class="form-field" type="text" name="email" id="email"  />
                 </div>
                 
                 <div class="box-260-form fl">
            		<label for="firstname">Enquiry: <span class="asterisk">*</span></label>
            		<input class="form-field" type="text" name="subject" id="subject" />
                 </div>
                 <div class="box-260-form fr">
            		<label for="surname">Telephone: <span class="asterisk">*</span></label>
            		<input class="form-field" type="text" name="phone" id="phone" />
                 </div>
                 
                 <div class="clear"></div>
                 <div class="text"><label for="message">Message: <span class="asterisk">*</span></label></div>
					<textarea class="form-box" data-label="Type your message here.." rows="4" cols="10" name="message" id="message"></textarea>
                 <div class="line"></div>
                 <input class="button-submit fr" type="submit" name="submit" id="submit" value="Submit" />
                
                 <div class="clear"></div>
                 
                
					<div class="errorbox">
						Thank you for your enquiry - your message has been sent successfully.
					</div>
                    
                    <div class="clear"></div>
					
                <?php endif; ?>
            </fieldset>
       		</form>
            
       <div class="clear"></div> 
       <div class="line"></div>
        <div class="spacebreak"></div>   
       <h3 class="medium-header center">Sign up to London Dinner Club for free to stay up to date on all the latest networking events in the Knightsbridge, Chelsea and Mayfair area!</h3>
       <p class="center"><a href="register.php" target="_blank" title="Email London Dinner Club" class="button-signup"><span class="displace"></span></a></p>
       
       <div class="spacebreak"></div>   

    </div>
 
   
    <?php include('footer.php');?>
   
</body>
</html>