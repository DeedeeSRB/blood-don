<div class="donor-form">
    <form name="update_donor_form" id="update_donor_form" onsubmit="return false">
        <div id="update_donor_response_div"></div>
        <div class="input-box">
            <label for="ud_id">ID: </label>
            <input type="text" class="input-field" id="ud_id" name="ud_id" maxlength="45" required>
        </div>
        <div class="input-box">
            <label for="ud_first_name">First Name: </label>
            <input type="text" class="input-field" id="ud_first_name" name="ud_first_name" placeholder="First Name" maxlength="45" required>
        </div>
        <div class="input-box">
            <label for="ud_last_name">Last Name: </label>
            <input type="text" class="input-field" id="ud_last_name" name="ud_last_name" placeholder="Last Name" maxlength="45" required>
        </div>
        <div class="input-box">
            <label for="ud_blood_group">Blood Group: </label>
            <select id="ud_blood_group" style="width: auto; display: inline;"
                    name="ud_blood_group" class="input-field" required>
                <option value="" selected disabled>Select</option>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
            </select>
        </div>
        <div class="input-box">
            <label for="ud_phone_number">Phone Number: </label>
            <input type="tel" class="input-field" id="ud_phone_number" name="ud_phone_number" placeholder="0XXX-XXX-XXXX" maxlength="45" required>
        </div>
        <div class="input-box">
            <label for="ud_email">Email: </label>
            <input type="email" class="input-field" id="ud_email" name="ud_email" placeholder="someone@something.com" maxlength="45">
        </div>
        <div class="input-box">
            <label for="ud_address">Address: </label>
            <textarea class="input-field" id="ud_address" name="ud_address" placeholder="Over there at that street" maxlength="100"></textarea>
        </div>
        <input type="submit" name="update_donor_submit" id="update_donor_submit" value="Update" onclick="submit_update_donor_form()">
    </form>
</div>