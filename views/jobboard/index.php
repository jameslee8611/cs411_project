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
		<h2>Job Board</h2>
		<table>
			<tr>
				<td><input type="radio" name="salary" id="500000"/><label for="500000">50000+</label></td>
				<td><input type="radio" name="salary" id="600000"/><label for="600000">60000+</label></td>
				<td><input type="radio" name="salary" id="700000"/><label for="700000">70000+</label></td>
			</tr>
			<tr>
				<td><input type="radio" name="salary" id="800000"/><label for="800000">80000+</label></td>
				<td><input type="radio" name="salary" id="900000"/><label for="900000">90000+</label></td>
				<td><input type="radio" name="salary" id="1000000"/><label for="1000000">100000+</label></td>
			</tr>
		</table></br>

		<table>
			<tr>
				<td><input type="radio" name="level" id="entry"/><label for="entry">Entry</label></td>
				<td><input type="radio" name="level" id="junior"/><label for="junior">Junior</label></td>
				<td><input type="radio" name="level" id="senior"/><label for="senior">Senior</label></td>
			</tr>
		</table></br>

		<table>
			<tr>
				<td><input type="radio" name="job-type" id="full"/><label for="full">Full Time</label></td>
				<td><input type="radio" name="job-type" id="contract"/><label for="contract">Contract</label></td>
				<td><input type="radio" name="job-type" id="intern"/><label for="intern">Internship</label></td>
				<td><input type="radio" name="job-type" id="other"/><label for="intern">Other</label></td>
			</tr>
		</table>

	</div>
	<div class="col-lg-6">

		<form id="searchbar">
			<input type="text" class="form-control"/>
			<input type="submit" class="form-control" id="search" value="Search"/>
		</form>

		<h3>Jobs</h3>

		<?php
		    if (isset($this->data) || !empty($this->data)) {
		        foreach ($this->data as $info) {
		        	echo '<div>' . "Company: " . $info['companyName'] . '  ' . "Title: " . $info['title'] . '</div>';
		        }
		    }
		?>
	</div>
</div>