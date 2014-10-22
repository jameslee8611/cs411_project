<?php
require 'libs/Router.php';
require 'libs/Controller.php';
require 'libs/View.php';
require 'libs/Model.php';

//Library
require 'libs/Database.php';
require 'libs/Data.php';
require 'libs/Session.php';
require 'libs/Cookie.php';

require 'config/private/key.php';
require 'config/constant.php';
require 'config/database.php';

$app = new Router();