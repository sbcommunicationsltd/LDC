<?php
$logout = false;
if (strpos($_SERVER['PHP_SELF'], '/admin') !== false) {
    if (isset($_SESSION['admin_is_logged_in'])) {
        $logout = true;
    }
}?>
<footer>
    <div class="container center">
        <h5 class="little-header uppercase">London Dinner Club</h5>
        <div class="line"></div>
            <div class="footer-icons-wrapper">
                <a href="https://www.facebook.com/pages/London-Dinner-Club/233376956703832" rel="nofollow" target="_blank" title="Follow London Dinner Club on Facebook" class="footer-icon facebook fl"><span class="displace"></span></a>
                <a href="https://twitter.com/#!/LdnDinnerClub" rel="nofollow" target="_blank" title="Follow London Dinner Club on twitter" class="footer-icon twitter fl"><span class="displace"></span></a>
                <a href="http://uk.linkedin.com.pub/salima-manji/4/6a1/3a0" rel="nofollow" target="_blank" title="Follow London Dinner Club on linkedin" class="footer-icon linkedin fl"><span class="displace"></span></a>
            </div>
        <div class="line"></div>
        
         <div class="footer-icons-wrapper">
      	<a href="http://www.londondinnerclub.org/terms.php" target="_self" title="London Dinner Club Terms & Conditions"><div class="button-grey fl">Terms &amp; Conditions</div></a>
        <a href="http://www.londondinnerclub.org/admin/" target="_self" title="London Dinner Club Admin"><div class="button-grey fr">Administrator</div></a>
        </div>
        <?php
        if (true === $logout) {?>
            <p class='terms'><a href="logout.php" target="_self" title="London Dinner Club Admin Logout">Log Out</a><br/><br/></p>
        <?php
        }?>
        
        <p class="terms">&copy; All rights reserved - Copyright London Dinner Club <?php echo date("Y"); ?></p>
        <p class="terms">Design: <a href="http://elevated-artanddesign.com" title="Elevated Art & Design - Leicester" target="_blank">Elevated Art &amp; Design</a></p>
        <p class='terms'>Developed by: <a href="http://www.sbcommunications.co.uk" title='S B Communications Ltd' target='_blank'>S B Communications Ltd.</a></p>
    </div>
</footer>


<!-- Analytics -->
<script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    
      ga('create', 'UA-52364856-1', 'auto');
      ga('send', 'pageview');
</script>
 
<!-- scroll up -->
<script>
    // scrollUp full options
    $(function () {
        $.scrollUp({
            scrollName: 'scrollUp', // Element ID
            scrollDistance: 300, // Distance from top/bottom before showing element (px)
            scrollFrom: 'top', // 'top' or 'bottom'
            scrollSpeed: 300, // Speed back to top (ms)
            easingType: 'linear', // Scroll to top easing (see http://easings.net/)
            animation: 'fade', // Fade, slide, none
            animationInSpeed: 200, // Animation in speed (ms)
            animationOutSpeed: 200, // Animation out speed (ms)
            scrollText: '', // Text for element, can contain HTML
            scrollTitle: false, // Set a custom <a> title if required. Defaults to scrollText
            scrollImg: false, // Set true to use image
            activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
            zIndex: 2147483647 // Z-Index for the overlay
        });
    });

</script>