<div class="donor-form">
    <form name="add_donation_form" id="add_donation_form" onsubmit="return false">
        <div id="add_donation_response_div"></div>
        <div class="input-box">
            <label for="donor_id">Donor ID: </label>
            <input type="text" class="input-field" id="donor_id" name="donor_id" maxlength="45" required>
        </div>
        <div class="input-box">
            <label for="amount_ml">Amount (mL): </label>
            <input type="text" class="input-field" id="amount_ml" name="amount_ml" placeholder="200 ml" maxlength="45" required>
        </div>
        <div class="input-box">
            <label for="time">Time: </label>
            <input type="datetime-local" class="input-field" id="time" name="time" required>
        </div>
        <div class="input-box">
            <label for="status">Blood Group: </label>
            <select id="status" style="width: auto; display: inline;"
                    name="status" class="input-field" required>
                <option value="" selected disabled>Select</option>
                <option value="Completed">Completed</option>
                <option value="In progress">In progress</option>
                <option value="Planned">Planned</option>
            </select>
        </div>
        <input type="submit" name="donation_submit" id="donation_submit" value="Submit" onclick="submit_add_donation_form()">
    </form>
</div>