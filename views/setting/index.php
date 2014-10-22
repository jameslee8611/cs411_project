<div class="row">    
    <div class="large-9 push-3 columns">
        <h2>Setting page</h2>
        <p>You can change your privacy or change your password</p>
    </div>
    
    <div>
        <section id="changePasswordBox">
            <h2>Change Password</h2>
            <form method="post" class="minimal" action="setting/changePassword">
                <label for="current_password">
                    Current Password:
                    <input type="password" name="current_password" id="current_password" required="required" />
                </label>
                <label for="new_password">
                    New Password:
                    <input type="password" name="new_password" id="new_password" required="required" />
                </label>
                <label for="confirm_password">
                    Confirm Password:
                    <input type="password" name="confirm_password" id="confirm_password" required="required" />
                </label>
                <button type="submit" class="btn-submit">Change</button>
            </form>
        </section>
        
        <section id="withdrawAccountBox">
            <h2>Withdraw Account</h2>
            <form method="post" class="minimal" action="setting/withdrawAccount">
                <label for="username">
                    Password:
                    <input type="password" name="current_password" id="current_password" required="required" />
                </label>
                <button type="submit" class="btn-submit">Withdraw</button>
            </form>
        </section>
    </div>
</div>