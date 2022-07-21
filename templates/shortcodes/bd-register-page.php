<div class="w-50 m-auto">
    <div name="bd_register_alert_box" id="bd_register_alert_box" class="alert alert-danger alert-dismissible collapse role="alert"></div>
    <form name="bd_register_form" id="bd_register_form" onsubmit="return false">
        <div class="row align-items-center">
            <div class="row">
                <div class="col">
                    <label class="fs-5 form-label" for="bd_register_username">Username </label>
                    <input class="shadow-sm form-control" type="text" name="bd_register_username" id="bd_register_username" required>
                </div>
                <div class="col">
                    <label class="fs-5 form-label" for="bd_register_first_name">First Name </label>
                    <input class="shadow-sm form-control" type="text" name="bd_register_first_name" id="bd_register_first_name" required>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label class="fs-5 form-label" for="bd_register_email">Email </label>
                    <input class="shadow-sm form-control" type="email" name="bd_register_email" id="bd_register_email" required>
                </div>
                <div class="col">
                    <label class="fs-5 form-label" for="bd_register_last_name">Last Name </label>
                    <input class="shadow-sm form-control" type="text" name="bd_register_last_name" id="bd_register_last_name" required>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label class="fs-5 form-label" for="bd_register_phone_number">Phone Number </label>
                    <input class="shadow-sm form-control" type="tel" name="bd_register_phone_number" id="bd_register_phone_number">
                </div>
                <div class="col">
                    <label class="fs-5 form-label" for="bd_register_address">Address </label>
                    <textarea class="shadow-sm form-control" rows=1 name="bd_register_address" id="bd_register_address"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label class="fs-5 form-label" for="bd_register_password">Password </label>
                    <input class="shadow-sm form-control" type="password" minlength="5" name="bd_register_password" id="bd_register_password" required>
                </div>
                <div class="col">
                    <label class="fs-5 form-label" for="bd_register_password_confirm">Confirm Password </label>
                    <input class="shadow-sm form-control" type="password" minlength="5" name="bd_register_password_confirm" id="bd_register_password_confirm" required>
                </div>
            </div>
        </div>
        <?php
            $nonce = wp_create_nonce( 'bd_register_form_nonce' );
            echo '<button class="btn btn-primary" type="submit" value="Register" data-nonce="' . $nonce . '" onclick="submit_bd_register_form(this)">Register</button>';
        ?>
        
    </form>
</div>