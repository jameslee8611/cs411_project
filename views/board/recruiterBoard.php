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
<?php $company = $this->companyInfo; ?>

<div class="row" id="content">    
    <div class="col-lg-3">
        <h3>Hello, <?php echo $user['firstname']; ?></h3>
        <ul>
            <li>email: <?php echo $user['email']?></li>
            <li>first name: <?php echo $user['firstname']?></li>
            <li>last name: <?php echo $user['lastname']?></li>
            <li>personal link: <a href="<?php echo $user['personalLink']?>"><?php echo $user['personalLink']?></a></li>
        </ul>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add Job Posting</button>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Job Posting</h4>
                </div>
                <div class="modal-body">
                        <div class="container">
                            <h2>Post a Job Here</h2>
                            <p>Try to fill in all information. It will help you to find most suitable applicant</p>
                                <form role="form">
                                    <div class="form-group">
                                        <div class="col-lg-8" id="jobcompany">
                                            <label for="jobcompany">Company: </label>
                                            <p><?php echo $company?></p>
                                        </div>
                                        <div class="col-lg-8" id="jobtitle">
                                            <label for="jobtitle">Job Title: </label>
                                            <input type="text" class="form-control">
                                        </div>
                                        <div class="col-lg-8" id="jobtype">
                                            <label for="jobtype">Job Type:</label>
                                            <input type="text" class="form-control">
                                        </div>
                                        <div class="col-lg-8" id="jobarea">
                                            <label for="jobarea">Job Area/Field:</label>
                                            <input type="text" class="form-control">
                                        </div>
                                        <div class="col-lg-8" id="joblevel">
                                            <label for="joblevel">Experience Level:</label>
                                            <input type="text" class="form-control">
                                        </div>
                                        <div class="col-lg-8" id="joblocation">
                                            <label for="joblocation">Office Location:</label>
                                            <input type="text" class="form-control">
                                        </div>
                                        <div class="col-lg-8" id="jobsalary">
                                            <label for="joblocation">Avg Salary:</label>
                                            <input type="text" class="form-control">
                                        </div>
                                        <div class="col-lg-8" id="jobvisa">
                                            <label for="jobvisa">Visa Sponsorship:</label>
                                            <input type="text" class="form-control">
                                        </div>
                                        <div class="col-lg-8" id="jobdescription">
                                            <label for="jobdescription">Job Description:</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </form>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Add Posting</button>
                </div>
            </div>
        </div>
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

