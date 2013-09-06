<?php
require_once 'class.model.php';

$file = new Files();
$files = $file->getAll();

$request = new Requests();
$requests = array ();

//print_r ($files);
foreach ($files as $value) {
    $requests[] = $request->getRequests($value['file_guid']);
}

$value = null;

print_r ($files);


?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <style>
            body {
                padding-top: 60px;
                padding-bottom: 40px;
            }
        </style>
        <link rel="stylesheet" href="css/bootstrap-responsive.min.css">
        <link rel="stylesheet" href="css/main.css">

        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>

    </head>
    <body style="background-image:url(img/bg.jpg);">
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

        <!-- This code is taken from http://twitter.github.com/bootstrap/examples/hero.html -->

        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <a class="brand" href="#" style="margin-left:5px;">Bulk Emailer</a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <li><a href="index.php">Home</a></li>
                            <li class="active"><a href="list.php">List</a></li>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>

        <div class="container">

            <!-- Main hero unit for a primary marketing message or call to action -->
            <div class="hero-unit">
                <p>Please upload your excel file here, remember that the extension of file must be "xls, xlsx". It will take a few minutes to process your file.</p>
                <p>Development : pluploader doc - 2013.06.13 14:36</p>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>File Name</th>
                        <th>Upload Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($files as $value) : ?>
                    <tr>
                        <td></td>
                        <td><?php echo $value['file_name']; ?></td>
                        <td><?php echo date ("Y-m-d H:i:s", $value['file_created']); ?></td>
                    </tr>
                    <?php
                    endforeach; ?>
                </tbody>
            </table>
            <?php
                    foreach ($requests as $value) : ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Email</th>
                        <th>Company</th>
                        <th>Contact Person</th>
                        <th>Location</th>
                        <th>Price1</th>
                        <th>Price2</th>
                        <th>Price3</th>
                        <th>Price4</th>
                        <th>Created Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($value as $val): ?>
                    <tr>
                        <td></td>
                        <td><?php echo $val['request_email']; ?></td>
                        <td><?php echo $val['request_company']; ?></td>
                        <td><?php echo $val['request_contact_person']; ?></td>
                        <td><?php echo $val['request_location']; ?></td>
                        <td><?php echo $val['request_product1']; ?></td>
                        <td><?php echo $val['request_product2']; ?></td>
                        <td><?php echo $val['request_product3']; ?></td>
                        <td><?php echo $val['request_product4']; ?></td>
                        <td><?php echo date ("Y-m-d H:i:s", $val['request_created']); ?></td>
                    </tr>
                    <?php
                    endforeach; ?>
                </tbody>
            </table>
            <?php endforeach; ?>
            <hr style="border-color: #ccc"/>
            <!-- Example row of columns -->
            <hr />
            <footer>
                <p>@Power By <a href="http://www.initializr.com/" target="_blank">Initializr </a>&nbsp;&nbsp;@Programming By <a href="https://github.com/hellomaya" target="_blank">HelloMaya</a></p>
            </footer>

        </div> <!-- /container -->


        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.9.1.min.js"><\/script>')</script>

        <script src="js/vendor/bootstrap.min.js"></script>

        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>
    </body>
</html>

