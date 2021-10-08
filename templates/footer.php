<?php
/* 
Template Name: Register 
*/
?>
<!-- Start Footer Area -->
<footer class="ps-dboyz-footer-area">
    <div class="container-auto">
        <div class="ps-elem-footer-content">
            <p> &copy; 2020 All Rights Reserved. <a href="#" target="_blank">Terms of Service</a>, <a href="#" target="_blank">Privacy Policy</a> </p>
        </div>
    </div>
</footer>
<!-- End Footer Area -->
</div>

<?php
if (is_user_logged_in()) {
    echo "<a href='" . wp_logout_url() . "'>LOGOUT</a>";;
}
get_footer();
