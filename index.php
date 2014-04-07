<?php
require_once('TwitterAPIExchange.php');

/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
    'oauth_access_token' => "73316915-VXjoSJdYVCAYpXBGkpfvs2KkzF3tSD8ygwzngWlpm",
    'oauth_access_token_secret' => "xSEuRBZj5QjjfmfXLpAK0BV6sD2BDG7YB31UXFS3n5RID",
    'consumer_key' => "6Bs8mJY2MoEmGMoKPqzRf243K",
    'consumer_secret' => "WSd8Jaer2X7liMEfsxuFPd2cGZlqv0mqji5Higaz0ivmP2knuO"
);

if (isset($_GET['user'])) {
  $user = $_GET['user'];
}

if (isset($_GET['count'])) {
  $count = $_GET['count'];
} else {
  $count = 10;
}

$url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
$requestMethod = "GET";
$getfield = "?screen_name=$user&count=$count";


$twitter = new TwitterAPIExchange($settings);
$output = json_decode($twitter->setGetfield($getfield)
            -> buildOauth($url, $requestMethod)
            -> performRequest(), $assoc = TRUE);
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>TwitMe - A Cleaner Way To View Your Tweets</title>

    <!-- Bootstrap core CSS -->
    <link href="css/styles.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">
      <div class="header">
        <!-- <ul class="nav nav-pills pull-right">
          <li class="active"><a href="#">Home</a></li>
          <li><a href="#">About</a></li>
          <li><a href="#">Contact</a></li>
        </ul> -->
        <?php if (isset($user)) {
          ?>

          <a href="index.php" class="btn btn-danger tooltips pull-right" data-placement="left" title="Try A Different Username">&times;</a>

        <?php
        }
        ?>
        <h3 class="text-muted"><?= (isset($user) ? "@".$user : "TwitMe") ?></h3>
      </div>

      <?php

      if (!isset($user)) {

      ?>

      <div class="jumbotron">
        <h1>Clean Tweets</h1>
        <p class="lead">This is a work in progress, built by @_jacurtis wanting to experiment and build his own twitter app. To get started, input your information to view your tweets.</p>
        <!-- <p><a class="btn btn-lg btn-success" href="#" role="button">Sign up today</a></p> -->
      </div>

      <form role="form" action="index.php" method="get">
        <div class="row marketing">
          <div class="col-lg-6">
            <div class="form-group">
              <label for="username-field">Twitter Username</label>
              <div class="input-group">
                <span class="input-group-addon">@</span>
                <input type="text" id="username-field" name="user" class="form-control" placeholder="Username">
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <label>Load How Many Tweets?</label>
            <select id="tweet-num-select" name="count" class="form-control">
              <option>5</option>
              <option>10</option>
              <option>15</option>
              <option>25</option>
              <option>50</option>
            </select>
          </div>


          <div class="row">
            <div class="col-md-12" id="load-tweets-btn">
              <input type="submit" class="btn btn-default btn-block" value="Load Tweets">
            </div>
          </div>

        </div>
      </form>
      
      <?php
        } else {
      
      if($string["errors"][0]["message"] != "") {
        echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>".$string[errors][0]["message"]."</em></p>";
        exit();
      }

      foreach ($output as $tweet) {
        echo "<p>".$tweet['text']."<br />";
        echo $tweet['created_at']."<br /></p><hr>";
      }
    }

      ?>
      <div class="footer">
        <p>&copy; Jacurtis 2014</p>
      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" ></script>
    <script src="js/bootstrap/tooltip.js"></script>
    <script>
      $(document).ready(function(){
        $('.tooltips').tooltip();
      });
    </script>
  </body>
</html>
