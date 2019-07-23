<?php
date_default_timezone_set('Europe/Paris');
session_start();
require_once('Classes/Basket.php');
require_once('Classes/Country.php');
require_once('Classes/Cookie.php');
require_once('Classes/Category.php');
require_once('Classes/Image.php');
require_once('Classes/Menu.php');
require_once('Classes/OrderProduct.php');
require_once('Classes/Order.php');
require_once('Classes/SQL.php');
require_once('Classes/Product.php');
require_once('Classes/ProductInBasket.php');
require_once('Classes/Session.php');
require_once('Classes/User.php');
require_once('Classes/Paging.php');

define('BASE', 'shopPOO');
define('IMAGES', 'images1');