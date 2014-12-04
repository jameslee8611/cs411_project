<nav class="navbar navbar-fixed-top" id="header" role="navigation">
	<ul class="nav navbar-nav navbar-left">
        <li><a href="<?php echo URL.'board/jobboard'; ?>">JobBoard</a></li>
        <li><a href="<?php echo URL.'company/company'; ?>">Companies</a></li>
    </ul>             
    <ul class="nav navbar-nav navbar-right">
        <li><a href="<?php echo URL.'setting'; ?>"><?php echo Session::get("username");?></a></li>
		<li><a href="<?php echo URL.'index/logout'; ?>">Logout</a></li>
    </ul>
</nav>

<div class="row" id="content">
	<div class="col-lg-3">
		<h2>Company Board</h2>
	</div>
	<div class="col-lg-6">

		<h3>Liked Companies</h3>
		<?php
			echo '<table id="liked-company-container"><tbody id="liked-company-body">';
		 	if (isset($this->like) || !empty($this->like)) {	
		        foreach ($this->like as $info) {
		        	$content = '<tr><td>'.'<a class="company-name" data-toggle="modal" data-target="#dislikeModal"><h4>'. $info['name'] . 
		        	'</h4></a>' . '<div class="company-description">';
		        	if(strlen($info['description']) > 160){
		        		$content = $content . substr($info['description'], 0, 217) . " ... " . '</div>' . '<div class="companyID">'
		        		 . $info['companyId'] . '</div>' .'</td></tr>';
		        		
		        	}else{
		        		$content = $content . $info['description'] . '</div>' . '<div class="companyId">' 
		        		. $info['companyId'] . '</div>' .'</td></tr>';
		        	}
		        	echo $content;
		        }
		    }
		    echo '</tbody></table>';
	    ?>

		<h3>General Companies</h3>
		<?php
			echo '<table id="company-container"><tbody id="company-body">';
		    if (isset($this->data) || !empty($this->data)) {
		        foreach ($this->data as $info) {
		        	$content = '<tr><td>'.'<a class="company-name" data-toggle="modal" data-target="#likeModal"><h4>'. $info['name'] . 
		        	'</h4></a>' . '<div class="company-description">';
		        	if(strlen($info['description']) > 160){
		        		$content = $content . substr($info['description'], 0, 217) . " ... " . '</div>' . '<div class="companyID">'
		        		 . $info['companyId'] . '</div>' .'</td></tr>';
		        		
		        	}else{
		        		$content = $content . $info['description'] . '</div>' . '<div class="companyId">' 
		        		. $info['companyId'] . '</div>' .'</td></tr>';
		        	}
		        	echo $content;
		        }
		    }
		    echo '</tbody></table>';
		?>
	</div>
</div>

<div class="modal fade" id="likeModal" tabindex="-1" role="dialog" aria-labelledby="likeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Like Company</h4>
      </div>
      <div class="modal-body" id="likeModalBody"></div>
      <div class="modal-footer">
		<button type="button" class="btn" id="likeButton" data-dismiss="modal">Like</button>
		<button type="button" class="btn" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="dislikeModal" tabindex="-1" role="dialog" aria-labelledby="dislikeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Dislike Company</h4>
      </div>
      <div class="modal-body" id="dislikeModalBody"></div>
      <div class="modal-footer">
		<button type="button" class="btn" id="dislikeButton" data-dismiss="modal">Dislike</button>
		<button type="button" class="btn" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>