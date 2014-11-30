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
		<h2>Job Board</h2>
	</div>
	<div class="col-lg-6">

		<form id="searchbar">
			<input type="text" class="form-control" id="search-input"/>
			<input type="submit" class="form-control" id="search" value="Search"/>
		</form>

		<h3>Jobs</h3>

		<?php
		    if (isset($this->data) || !empty($this->data)) {
		    	echo '<table id="job-container"><tbody id="job-body">';
		        foreach ($this->data as $info) {
		        	echo '<tr><td>'.'<a class="job-title" data-toggle="modal" data-target="#applyModal"><h4>'. $info['title'] . '</h4></a>' . '<div>' . $info['companyName'] . ' ' . $info['location'] . '</div>'
		        	. '<div class="job-description">'. $info['description'] . '</div>' . '<div>'. $info['postedDate'] . '</div>' . '<div class="jobID">'
		        	. $info['jobID'] . '</div>' .'</td></tr>';
		        }
		        echo '</tbody></table>';
		    }
		?>
	</div>
</div>

<div class="modal fade" id="applyModal" tabindex="-1" role="dialog" aria-labelledby="applyModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Modal title</h4>
      </div>
      <div class="modal-body" id="applyModalBody"></div>
      <div class="modal-footer">
		<button type="button" class="btn" id="applyButton" data-dismiss="modal">Apply</button>
		<button type="button" class="btn" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>