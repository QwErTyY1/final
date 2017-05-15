<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>MINI</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
    <link rel="stylesheet" href="<?=URL?>css/normalize.css">
    <link rel="stylesheet" href="<?=URL?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=URL?>css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="<?=URL?>css/my.css">




</head>
<body>

<nav class="navbar navbar-inverse">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Comment Site</a>
        </div>
        <ul class="nav navbar-nav">
            <li class="<?=$see = (($active == "home")?"active": ""); ?>"><a href="<?php echo URL;?>">Home</a></li>
            <li class="<?=$see = (($active == "comment")?"active": ""); ?>"><a href="<?php echo URL;?>comment">Comment Page</a></li>

        </ul>
        <ul class="nav navbar-nav pull-right">
           <li><a href="<?php echo URL;?>home/logOut"><?=$welcome = (isset($_SESSION['user']['name'])? $_SESSION['user']['name']: 'Login');?></a></li>


        </ul>
    </div>
</nav>