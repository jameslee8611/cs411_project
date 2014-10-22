<div class="row">    
    <div class="large-9 push-3 columns">
        <h2>Setting page</h2>
        <p>You can change your privacy or change your password</p>
    </div>
    
    <div>
        <section id="loginBox">
            <h2>Login</h2>
            <form method="post" class="minimal" action="index/login">
                <label for="username">
                    Username:
                    <input type="text" name="username" id="username" required="required" />
                </label>
                <label for="password">
                    Password:
                    <input type="password" name="password" id="password" required="required" />
                </label>
                <button type="submit" class="btn-submit">Sign in</button>
            </form>
        </section>
        <section id = "newUserBox">
            <h3>Are you a new user?
                <form method="post" action="signup">
                    <button type="newUser" class="btn-newUser">New User</button>
                </form>
            </h3>
        </section>
    </div>
</div>