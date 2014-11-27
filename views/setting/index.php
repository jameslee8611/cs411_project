<nav class="navbar navbar-fixed-top" id="header" role="navigation">
    <ul class="nav navbar-nav navbar-left">
        <li><a href="<?php echo URL.'jobboard'; ?>">JobBoard</a></li>
    </ul>               
    <ul class="nav navbar-nav navbar-right">
        <li><a href="<?php echo URL.'setting'; ?>"><?php echo Session::get("username");?></a></li>
        <li><a href="<?php echo URL.'index/logout'; ?>">Logout</a></li>
    </ul>
</nav>

<div class="row" id="content">    
    <div class="col-lg-3">
        <h2>Setting Menu</h2>
        <ul id="menu">
            <li><a id="profile">Profile/Resume</a></li>
            <li><a id="account">Account Settings</a></li>
            <li><a id="preference">Search Preferences</a></li>
            <li><a id="progress">Application Progress</a></li>
        </ul>
    </div>
    
    <div class="col-lg-6" id="accountSettings">
        <section id="changePasswordBox">
            <h2>Change Password</h2>
            <form method="post" action="setting/changePassword">
                <label for="current_password">
                    Current Password:
                    <input type="password" name="current_password" class="form-control" id="current_password" required="required" />
                </label></br>
                <label for="new_password">
                    New Password:
                    <input type="password" name="new_password" class="form-control" id="new_password" required="required" />
                </label></br>
                <label for="confirm_password">
                    Confirm Password:
                    <input type="password" name="confirm_password" class="form-control" id="confirm_password" required="required" />
                </label></br>
                <label><button type="submit" class="form-control">Change Password</button></label>
            </form>
        </section>
        
        <section id="withdrawAccountBox">
            <h2>Withdraw Account</h2>
            <form method="post" action="setting/withdrawAccount">
                <label for="username">
                    Password:
                    <input type="password" name="current_password" class="form-control" id="current_password" required="required" />
                </label></br>
                <label><button type="submit" class="form-control">Withdraw</button></label>
            </form>
        </section>
    </div>

    <div class="col-lg-6" id="profileResume">
        <h2>Profile/Resume</h2>
        <form method="post">
            <label>First Name: <input type="text" name="firstname" class="form-control" id="firstname" /></label>
            <label>Last Name: <input type="text" name="lastname" class="form-control" id="lastname" /></label></br>

            <label>Phone Number: <input type="number" name="phonenum" class="form-control" id="phonenum" /></label>
            <label>Email: <input type="text" name="email" class="form-control" id="email" /></label></br>

            <label>Websites: <input type="text" name="website" class="form-control" id="website" /></label>
            <label>Repository: <input type="text" name="repo" class="form-control" id="repo" /></label></br>

            <label>Resume: <input type="file" name="resume" class="form-control" id="resume"  accept=".pdf"/></label></br>

            <label><button type="submit" class="form-control">Submit</button></label>
        </form>
    </div>

    <div class="col-lg-6" id="searchPref">
        <h2>Search Preferences</h2>
        <form method="post">
            <label>Minimum Salary: <input type="number" name="min-salary" class="form-control" id="min-salary"/></label></br>
            
            <div name="skill-box">
                <label>Primary Skill: <input type="text" name="skill-primary" class="form-control" id="skill-primary" /></label>
                <label>Secondary Skill: <input type="text" name="skill-secondary" class="form-control" id="skill-secondary" /></label>
            </div>
            
            <label for="location-box">Location:</label></br>
            <div class="btn-group" name="location-box">
                <label><select class="form-control" name="state" id="state"/>
                    <option id="first_cagetory" value="" selected>State</option>
                    <option value="AK">AK</option>
                    <option value="AL">AL</option>
                    <option value="AR">AR</option>
                    <option value="AZ">AZ</option>
                </select></label>
                <label><input type="text" name="city" class="form-control" id="city" placeholder="City"/></label>
            </div></br>
            
            <label for="visa_type">Visa Type:</label></br>
            <div class="btn-group" name="visa_type">
                <label><select class="form-control" name="visa" id="visa"/>
                    <option id="first_cagetory" value="" selected>Visa</option>
                    <option value="F1">F1</option>
                </select></label>
            </div></br>
            
            <label><button type="submit" class="form-control">Submit</button></label>
        </form>
    </div>

    <div class="col-lg-6" id="appProgress">
        <h2>Application Progress</h2>
        <table>
            <tr>
                <th>Application</th>
                <th>Progress</th>
            </tr>
            <tr>
                <td>Test Application</td>
                <td>Test Progress</td>
                <td><button type="button" class="del-button btn btn-sm">Delete</button></td>
            </tr>
        </table>
    </div>

</div>