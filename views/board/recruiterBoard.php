<nav class="navbar navbar-fixed-top" id="header" role="navigation">
	<ul class="nav navbar-nav navbar-left">
        <li><a href="<?php echo URL.'board/recruiterBoard'; ?>">Recruiter Board</a></li>
    </ul>             
    <ul class="nav navbar-nav navbar-right">
        <li><a href="<?php echo URL.'setting'; ?>"><?php echo Session::get("username");?></a></li>
		<li><a href="<?php echo URL.'index/logout'; ?>">Logout</a></li>
    </ul>

</nav>
<?php $user = $this->userInfo; ?>

<div class="row" id="content">    
    <div class="col-lg-3">
        <h3>Hello, <?php echo $user['firstname']; ?></h3>
        <ul>
            <li>email: <?php echo $user['email']?></li>
            <li>first name: <?php echo $user['firstname']?></li>
            <li>last name: <?php echo $user['lastname']?></li>
            <li>personal link: <a href="<?php echo $user['personalLink']?>"><?php echo $user['personalLink']?></a></li>
        </ul>
    </div>
    
    <div class="col-lg-6" id="accountSettings">
        <?php
	    if (isset($this->data) || !empty($this->data)) {
                echo '<table id="job-container"><tbody id="job-body">';
                foreach ($this->data as $info) {
                    echo '<tr>'
                        . '<td>'
                            . '<a class="job-title" id="'. $info['jobID'] .'" data-toggle="modal" data-target="#jobModal" onclick="updateJob(\''.$info['jobID'].'\',  \''.$info['title'].'\')"><h4>'. $info['title'] . '</h4></a>' 
                            . '<div>' . $info['companyName'] . ' - ' . $info['location'] . '</div>'
                            . '<div class="job-description">'. $info['description'] . '</div>' 
                            . '<div>'. $info['postedDate'] . '</div>' 
                            . '<div class="jobID">JobID: '. $info['jobID'] . '</div>'
                        . '</td>'
                        .'</tr>';
                }
                echo '</tbody></table>';
            }
        ?>
    </div>
    
    <!-- Job-Student Modal -->
    <div class="modal fade" id="jobModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalJobTitleLabel">Job Title</h4>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>