<div class="w-50 m-auto">
    <div name="bd-login-alert-box" id="bd-login-alert-box" class="alert alert-danger alert-dismissible collapse role="alert"></div>
    <form name="bd-login-form" id="bd-login-form" onsubmit="return false">
        <div class="row mb-3 align-items-center">
            <label class="col-auto col-form-label fs-5" for="bd-login-username">Username: </label>
            <input class="shadow-sm col form-control ms-3" type="text" name="bd-login-username" id="bd-login-username" required>
        </div>
        <div class="row mb-3 align-items-center">
            <label class="col-auto col-form-label fs-5" for="bd-login-password">Password: </label>
            <input class="shadow-sm col form-control ms-3" type="password" name="bd-login-password" id="bd-login-password" required>
        </div>
        <button class="btn btn-primary" type="submit" value="Login" onclick="submit_bd_login_form(this)">Login</button>
    </form>
</div>