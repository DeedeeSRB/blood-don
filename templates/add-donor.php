<div class="donor-form">
    <form name="add_donor_form" id="add_donor_form" onsubmit="return false">
        <div id="response_div"></div>
        <div class="input-box">
            <label for="first_name">First Name: </label>
            <input type="text" class="input-field" id="first_name" name="first_name" placeholder="First Name" maxlength="45" required>
        </div>
        <div class="input-box">
            <label for="last_name">Last Name: </label>
            <input type="text" class="input-field" id="last_name" name="last_name" placeholder="Last Name" maxlength="45" required>
        </div>
        <div class="input-box">
            <label for="blood_group">Blood Group: </label>
            <select id="blood_group" style="width: auto; display: inline;"
                    name="blood_group" class="input-field" required>
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
            <label for="phone_number">Phone Number: </label>
            <input type="tel" class="input-field" id="phone_number" name="phone_number" placeholder="0XXX-XXX-XXXX" maxlength="45" required>
        </div>
        <div class="input-box">
            <label for="email">Email: </label>
            <input type="email" class="input-field" id="email" name="email" placeholder="someone@something.com" maxlength="45">
        </div>
        <div class="input-box">
            <label for="address">Address: </label>
            <textarea class="input-field" id="address" name="address" placeholder="Over there at that street" maxlength="100"></textarea>
        </div>
        <input type="submit" name="donor_submit" id="donor_submit" value="Submit" onclick="submit_contact_form()">
    </form>
</div>