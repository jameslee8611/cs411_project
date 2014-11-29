<nav class="navbar navbar-fixed-top" id="header" role="navigation">
    <ul class="nav navbar-nav navbar-left">
        <li><a href="<?php 
                        if(Session::get('isStudent')) {
                            echo URL.'board/jobBoard';
                        }
                        else {
                            echo URL.'board/recruiterBoard';
                        }
                     ?>">
            <?php 
            if(Session::get('isStudent')) {
                echo 'Student Board';
            }
            else {
                echo 'Recruiter Board';
            }
            ?>
            </a>
        </li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
        <li><a href="<?php echo URL.'setting'; ?>"><?php echo Session::get("username");?></a></li>
        <li><a href="<?php echo URL.'index/logout'; ?>">Logout</a></li>
    </ul>
</nav>

<div class="row" id="content"> 
    <h2>Invalid Access</h2>
    <div>
        You are reaching a different type of board now.
    </div>
</div>