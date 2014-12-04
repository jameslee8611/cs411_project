<nav class="navbar navbar-fixed-top" id="header" role="navigation">
    <ul class="nav navbar-nav navbar-left">
        <li><a href="<?php echo URL.'board/jobboard'; ?>">JobBoard</a></li>
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
        <form method="post" id="profileForm" action="setting/updateProfile" enctype="multipart/form-data">
            <label>First Name: <input type="text" name="firstname" class="form-control" id="firstname" /></label>
            <label>Last Name: <input type="text" name="lastname" class="form-control" id="lastname" /></label></br>

            <label>Address: <input type="text" name="address" class="form-control" id="address" /></label>
            <label>Phone Number: <input type="text" name="phonenum" class="form-control" id="phonenum" /></label><br>

            <label>Personal Link: <input type="text" name="personallink" class="form-control" id="personallink" /></label>
            <label>School: <input type="text" name="school" class="form-control" id="school" /></label></br>

            <label for="visa_type">Visa Type:</label></br>
            <div class="btn-group" name="profile_visa_type">
                <label><select class="form-control" name="profile-visa" id="profile-visa"/>
                    <option value="0" selected>Visa</option>
                    <option value="1">F1</option>
                </select></label>
            </div></br>

            <label id="current-resume"></label>
            <label><input type="button" class="form-control" id="upload-resume" value="Upload Resume"/></label>
            <input type="file" name="resume" class="form-control" id="resume"  accept=".pdf"/></br>
            
            <label><button type="submit" class="form-control">Submit</button></label><label><p id="profileFeedBack"></p></label>
        </form>
    </div>

    <div class="col-lg-6" id="searchPref">
        <h2>Search Preferences</h2>
        <form method="post" action="setting/updatePreference">
            <label>Minimum Salary: <input type="number" name="min-salary" class="form-control" id="min-salary"/></label><br>
            <label>Skill: <input type="text" name="skill-primary" class="form-control" id="skill-primary" /></label><br>
            <label>Area: <input type="text" name="area" class="form-control" id="area" /></label><br>
            
            <label for="level">Level:</label>
            <label><select class="form-control" name="level" id="level"/>
                <option value="" selected>Level</option>
                <option value="Entry">Entry</option>
                <option value="Junior">Junior</option>
                <option value="Senior">Senior</option>
            </select></label><br>
            
            <label for="position">Position:</label>
            <label><select class="form-control" name="position" id="position"/>
                <option id="first_position" value="" selected>Position</option>
                <option value="Full Time">Full Time</option>
                <option value="Contract">Contract</option>
                <option value="Internship">Internship</option>
            </select></label><br>

            <label for="search-visa">Visa Type:</label>
            <label><select class="form-control" name="search-visa" id="search-visa"/>
                <option value="0" selected>Visa</option>
                <option value="1">F1</option>
            </select></label><br>
            
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