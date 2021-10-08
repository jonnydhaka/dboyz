<?php  
   
get_header(); 

?>
    <!-- Start Dboyz Ps Login -->
    <section class="dboyz-ps-my-account">
        <div class="container-auto">
            <div class="ps-my-account-content">
                <div class="ps-my-account-box">
                    <div class="ps-my-account-form">
                        <h2>My Account</h2>
                        <p class="successfully-login">You have logged in successfully.</p>
                        
                        <div class="dboyz-ps-field-group ps-elem-log-out-btn">
                             <?php 
                             	if(is_user_logged_in()){ 
    								echo "<a href='".wp_logout_url()."'>LOGOUT</a>";;
								}
                              ?> 
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </section>
    <!-- End Dboyz Ps Login -->
<?php  
get_footer(); 