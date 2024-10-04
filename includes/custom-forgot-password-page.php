<form id="custom-login-form" method="post" action="<?php echo esc_url(network_site_url('wp-login.php?action=lostpassword', 'login_post')); ?>">
                <!-- Your custom form fields go here -->
                <p>
                    <label for="user_login"><?php _e('Username or Email'); ?></label>
                    <input type="text" name="user_login" id="user_login" class="input" value="" size="20" autocapitalize="off" />
                </p>
                <?php do_action('lostpassword_form'); ?>
                <p class="submit">
                    <input type="submit" name="wp-submit" id="wp-submit" class="button button-primary" value="<?php esc_attr_e('Reset Password'); ?>" />
                </p>
            </form>