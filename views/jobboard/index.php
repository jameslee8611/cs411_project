<h2>Job Board</h2>

<div>
    <a href="<?php echo URL.'index/logout'; ?>">log out</a>
    <a href="<?php echo URL.'setting'; ?>">Edit Page</a>
</div>

<div>
    <h3>Jobs</h3>
    <ul>
        <?php 
        foreach ($this->data as $info) {
            echo '<li>'.$info['title']. ' by '. $info['companyName'] .'</li>';
        }
        ?>
    </ul>
</div>