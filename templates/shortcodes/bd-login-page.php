<div class="w-50 m-auto">
    <div name="bd_login_alert_box" id="bd_login_alert_box" class="alert alert-danger alert-dismissible collapse role="alert"></div>
    <form name="bd_login_form" id="bd_login_form" onsubmit="return false">
        <div class="row align-items-center">
            <div class="row">
                <div class="col">
                    <label class="fs-5 form-label" for="bd_login_username">Username: </label>
                    <input class="shadow-sm form-control" type="text" name="bd_login_username" id="bd_login_username" required>
                </div>
                <div class="col">
                    <label class="fs-5 form-label" for="bd_login_password">Password: </label>
                    <input class="shadow-sm form-control" type="password" name="bd_login_password" id="bd_login_password" required>
                </div>
            </div>
        </div>
        
        <?php
            $nonce = wp_create_nonce( 'bd_login_form_nonce' );
            echo '<button class="btn btn-primary" type="submit" value="Login" data-nonce="' . $nonce . '" onclick="submit_bd_login_form(this)">Login</button>';
        ?>
    </form>
</div>