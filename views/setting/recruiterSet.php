<nav class="navbar navbar-fixed-top" id="header" role="navigation">
    <ul class="nav navbar-nav navbar-left">
        <li><a href="<?php echo URL.'board/recruiterBoard'; ?>">Recruiter Board</a></li>
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
            <li><a id="profile">Profile</a></li>
            <li><a id="account">Account Settings</a></li>
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
        <h2>Profile</h2>
        <form method="post">
            <label>First Name: <input type="text" name="firstname" class="form-control" id="firstname" /></label>
            <label>Last Name: <input type="text" name="lastname" class="form-control" id="lastname" /></label></br>
            <label>Email: <input type="text" name="email" class="form-control" id="email" /></label>
            <label>Website: <input type="text" name="website" class="form-control" id="website" /></label></br>
            <label>Company
                <select class="form-control" id="company-list">
                    <?php 
                        foreach ($this->companyList as $company) {
                            echo '<option>'. $company .'</option>\n';
                        }
                    ?>
                </select>
            </label>
            <span id="menu"><a id="addCompany">you cannot find your company?</a></span></br>
            </br>
            <label><button type="submit" class="form-control">Submit</button></label>
        </form>
        <section id="addCompanyBox">
            <h2>Adding Company</h2>
            <form method="post" id="company-data">
                <label for="name">
                    name:
                    <input type="text" name="company_name" class="form-control" id="company_name" required="required" />
                </label>
                <label for="url">
                    url:
                    <input type="text" name="company_url" class="form-control" id="company_url" required="required" />
                </label></br>
                <label for="description">
                    description:
                    <input type="text" name="company_description" class="form-control" id="company_description" required="required" />
                </label></br>
                <label><input class="btn btn-default" id="post-submit" type="submit" value="Add"/></label>
            </form>
        </section>
    </div>

</div>