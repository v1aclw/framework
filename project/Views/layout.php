<?php
/**
 * Created by PhpStorm.
 * User: V1acl
 * Date: 02.08.17
 * Time: 21:40
 *
 * @var \App\View $this
 * @var string $title
 * @var string $description
 * @var string $content
 * @var \Models\User $user
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo $description; ?>">
    <meta name="author" content="V1acl">

    <title><?php echo $title; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">V1acl</a>
        </div>
        <div class="navbar-collapse collapse">
            <?php if ($user->id): ?>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $user->login; ?>
                            <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="/logout">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            <?php else: ?>
                <form class="navbar-form navbar-right" id="loginForm" role="form">
                    <div class="form-group">
                        <input type="text" name="login" id="login" placeholder="Login" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" id="password" placeholder="Password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success">Sign in</button>
                </form>
            <?php endif; ?>
        </div><!--/.navbar-collapse -->
    </div>
</div>

<script type="text/javascript">
    $(function () {

        $(document).on('submit', "#loginForm", function () {
            $("#loginForm .form-group").removeClass('has-error');

            $.ajax({
                url      : "/login",
                method   : 'post',
                data     : new FormData(this),
                dataType : 'json',
                mimeType:"multipart/form-data",
                contentType: false,
                cache: false,
                processData:false,
                success  : function (response) {
                    if (response.success) {
                        window.location.reload();
                    } else {
                        $("#loginForm .form-group").addClass('has-error');
                    }
                }
            });
            return false;
        });

    });
</script>

<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
    <div class="container">
        <h1><?php echo $title; ?></h1>
        <p><?php echo $description; ?></p>
    </div>
</div>

<div class="container">
    <?php echo $content; ?>

    <hr>

    <footer>
        <p>&copy; V1acl 2017</p>
    </footer>
</div> <!-- /container -->

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="/js/bootstrap.min.js"></script>
</body>
</html>