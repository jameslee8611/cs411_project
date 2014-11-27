<div class="row" id="header">
    <div class="col-lg-6"></div>
    <form class="navbar-form navbar-right col-lg-6" method="post" action="index/login">
        <input type="text" name="username" class="form-control" id="username" placeholder="Username" required="required" />
        <input type="password" name="password" class="form-control" id="password" placeholder="Password" required="required" autocomplete="off" />
        <input type="submit" class="form-control" value="Login"/>
    </form>
</div>

<div class="row" id="index-body">
    <div class="col-lg-6">
        <h2 class="no-margin">Let us find you a COMJOB</h2>
    </div>
    <div class="col-lg-2"></div>
    <div class="col-lg-4" id="signup">
        <form method="post" action="index/signup">
            <input type="radio" name="position" value="student" id="student" checked/><label for="student">Student</label>
            <input type="radio" name="position" value="recruiter" id="recruiter"/><label for="recruiter">Recruiter</label>
            <input type="email" name="username" class="form-control" id="username" placeholder="Email" required="required" autocomplete="off" />
            <input type="password" name="password" class="form-control" id="password" placeholder="Password" required="required" autocomplete="off" />
            <input type="password" name="confirmpwd" class="form-control" id="confirmpwd" placeholder="Confirm Password" required="required" autocomplete="off" />
            <input type="submit" class="form-control" value="Submit"/>
        </form>
    </div>
</div>