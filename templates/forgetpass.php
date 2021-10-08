<?php  
/* 
Template Name: Register 
*/  
   
get_header();   

  
?>  

<!-- Prestashop Dboyz Forget Pass -->
<div class="ps-dboyz-page-wrapper">
    <!-- Start header Area -->
    <header class="header-area">
        <div class="container-auto-fluid">
            <div class="header-content">
                <div class="header-logo">
                    <a href="#">
                        <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . '/assets/images/dboyz-site-logo.png'; ?>"> 
                    </a>
                </div>
                <div class="elem-close-button">
                    <!-- <a href="#">X</a> -->
                </div>
            </div>
        </div>
    </header>
    <!-- End Header Area -->
    <!-- Start Dboyz Ps Login -->
    <section class="dboyz-ps-my-account">
        <div class="container-auto">
            <div class="ps-my-account-content">
                <div class="ps-my-account-box">
                    <div class="ps-my-account-form">
                        <h2>Reset Your Password</h2>
                        <p>Please enter your email and we’ll send you a link that will reset your password.</p>

                        <form name="lostpasswordform" id="lostpasswordform" class="ps-dboyz-form" action="<?php echo esc_url( network_site_url( 'wp-login.php?action=lostpassword', 'login_post' ) ); ?>" method="post">
    						<?php wp_nonce_field('ps_user_login'); ?>
                            <input id="email" type="hidden" name="username">
    						<input id="password" class="cp-password_stub" type="hidden"name="password" >
                            <div class="dboyz-ps-form-fields-wrapper">
                                <div class="dboyz-ps-field-group">
                                    <label class="dboyz-ps-field-label" for="email">Email</label>
								    <input class="dboyz-ps-input-field" type="text" name="email" placeholder="Email" id="email" autocomplete="off">  
                                </div>
                                <div class="dboyz-ps-field-group">
                                    <input type="submit" id="submitbtn" name="submit" value="Reset Password"/> 
                                </div>
                            </div>
                        </form>
                        <p class="ps-dboyz-note-redirect">
                             <a href="<?php echo esc_url(get_page_link(get_option("login_page")) ); ?>">Back to Log In</a>
                        </p>
                    </div> 
                </div>
            </div>
        </div>
    </section>
    <!-- End Dboyz Ps Login -->
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


  
<?php get_footer(); 