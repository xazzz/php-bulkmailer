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
        <link rel="stylesheet" href="js/datepicker/css/datepicker.css">
    
        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>

        <script type="text/javascript" src="http://bp.yahooapis.com/2.4.21/browserplus-min.js"></script>

        <script type="text/javascript" src="js/pluploader/plupload.js"></script>
        <script type="text/javascript" src="js/pluploader/plupload.gears.js"></script>
        <script type="text/javascript" src="js/pluploader/plupload.silverlight.js"></script>
        <script type="text/javascript" src="js/pluploader/plupload.flash.js"></script>
        <script type="text/javascript" src="js/pluploader/plupload.browserplus.js"></script>
        <script type="text/javascript" src="js/pluploader/plupload.html4.js"></script>
        <script type="text/javascript" src="js/pluploader/plupload.html5.js"></script>
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
                            <li class="active"><a href="index.php">Home</a></li>
<!--                            <li><a href="list.php">List</a></li>-->
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>

        <div class="container">

            <!-- Main hero unit for a primary marketing message or call to action -->
            <div class="hero-unit" style="padding:10px;">
                <p>Please upload your excel file here, remember that the extension of file must be "xls, xlsx". It will take a few minutes to process your file.</p>
            </div>

            <div class="row" style="margin-left:10px;margin-right:10px">
                <div class="span9">
                    <span class="label label-info" id="ajax-indicator" style='display:none'>Now it's processing your file, please wait...</span>
                </div>
                <div class="span9" id="uploader">
                    <h4>Uploading Your File Now</h4>
                    <div id="filelist"></div>
                    <br />
                    <a id="pickfiles" class="btn" href="javascript:;">Select</a> 
                    <a id="uploadfiles" class="btn" href="javascript:;">Start</a>
                </div>
            </div>
            <hr style="border-color: #ccc"/>
            <!-- Example row of columns -->
            <div class="row-fluid">
                <form id='user-form' action='sendemail.php' method='post'>
                <div class="inline">
                    <input type="text" id="datepicker" name='date' value="<?php //echo date('Y-m-d'); ?>"  class="input-medium search-query" />&nbsp;<a href="javascript:jQuery('#user-form').submit();" class="btn">Send All</a>
                </div>
                <div id="validate-result">
                    
                </div>
                </form>
            </div>
            <hr />
            <footer>
                <p>@Power By <a href="http://www.initializr.com/" target="_blank">Initializr </a>&nbsp;&nbsp;@Programming By <a href="https://github.com/hellomaya" target="_blank">HelloMaya</a></p>
            </footer>

        </div> <!-- /container -->


        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.9.1.min.js"><\/script>')</script>
        
        <script type="text/javascript" src="js/datepicker/js/bootstrap-datepicker.js"></script>
        <script>
        jQuery(document).ready (function () {
            window.prettyPrint && prettyPrint();
            jQuery( "#datepicker" ).datepicker({format: 'yyyy-mm-dd'});
        });
        </script>
        <script type="text/javascript">
            // Custom example logic
            function $(id) {
                return document.getElementById(id);
            }

            var uploader = new plupload.Uploader({
                runtimes: 'gears,html5,flash,browserplus',
                browse_button: 'pickfiles',
                container: 'uploader',
                max_file_size: '100mb',
                url: 'upload.php',
                multi_selection: false,
                resize: {width: 320, height: 240, quality: 90},
                flash_swf_url: 'js/uploader/plupload.flash.swf',
                //silverlight_xap_url : 'js/uploader/plupload.silverlight.xap',
                filters: [
                    {title: "Excel files", extensions: "xls,xlsx"}
                ]
            });

            uploader.bind('Init', function(up, params) {
                //$('filelist').innerHTML = "<div>Current runtime: " + params.runtime + "</div>";
            });

            uploader.init();

            uploader.bind('FilesAdded', function(up, files) {

                if (uploader.files.length == 2) {
                    uploader.removeFile(uploader.files[0]);
                }
                
                for (var i in files) {
                    $('filelist').innerHTML = '<div id="' + files[i].id + '">' + files[i].name + ' (' + plupload.formatSize(files[i].size) + ') <b></b></div><div class="progress"><div class="bar" id="progress-bar" style="width: 0%;"></div></div>';
                }
            });

            uploader.bind('UploadProgress', function(up, file) {
                if (jQuery('#ajax-indicator').is(":visible")) {
                    
                } else {
                    jQuery('#ajax-indicator').show();
                }
                $(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
                jQuery('#progress-bar').css('width', file.percent + "%");
            });

            uploader.bind('FileUploaded', function(up, file, response) {
                plupload.each(response, function(value, key) {

                    if (key == 'response') {
                        if (value == "0") {
                        } else {
                            ajax_process ("process.php", value);
                        }
                    }
                });

                //alert($.parseJSON(response.response).result);
            });

            $('uploadfiles').onclick = function() {
                uploader.start();
                return false;
            };
            
            function ajax_process (url, guid)
            {
                var guid = guid;
                
                jQuery.ajax({
                    url: url,
                    data:{'guid' : guid},
                    type: "GET",
                    beforeSend: function(xhr) {
                        jQuery("#ajax-indicator").show();
                    }
                }).done(function(data) {
                    jQuery("#ajax-indicator").hide();
                    
                    var err = jQuery.parseJSON(data);
                    
                    if (err.error == 'yes') {
                        jQuery("#validate-result").html ('<h3>' + err.message + '</h3>');
                    } else {
                        ajax_validate ("validate.php", guid);
                    }
                    
                    
                }).fail(function () {

                });
            }
            
            function ajax_validate (url, guid)
            {
                jQuery.ajax({
                    url: url,
                    data:{'guid' : guid},
                    type: "GET",
                    beforeSend: function(xhr) {
                        jQuery("#ajax-indicator").show();
                    }
                }).done(function(data) {
                    jQuery("#ajax-indicator").hide();
                    jQuery("#validate-result").html(data);
                    
                }).fail(function () {

                });
            }

        </script>

        <script src="js/vendor/bootstrap.min.js"></script>

        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>
    </body>
</html>

