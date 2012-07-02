<!DOCTYPE html>

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8" />

        <!-- Set the viewport width to device width for mobile -->
        <meta name="viewport" content="width=device-width" />

        <title>еУГД - Администратор</title>

        <!-- Included CSS Files -->
        <link rel="stylesheet" href="<?= base_url() ?>stylesheets/foundation.css">
        <link rel="stylesheet" href="<?= base_url() ?>stylesheets/app.css">
        
        <link rel="stylesheet" href="<?= base_url() ?>stylesheets/jquery.dataTables.css">
       
        <!--[if lt IE 9]>
                <link rel="stylesheet" href="<?= base_url() ?>stylesheets/ie.css">
        <![endif]-->
        <script src="<?= base_url() ?>javascripts/jquery.min.js"></script>
        <script type="text/javascript" language="javascript" src="<?= base_url() ?>javascripts/jquery.dataTables.js"></script>
        


        <script src="<?= base_url() ?>javascripts/modernizr.foundation.js"></script>

        <!-- IE Fix for HTML5 Tags -->
        <!--[if lt IE 9]>
                <script src="<?= base_url() ?>http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

    </head>
    <body>

        <!-- container -->
        <div class="container">

            <div class="row">
                <div class="nine columns"style="margin-top: 30px" >
                    <h2 style="font-style: italic; color: #117537;">еУчење</h2>
                </div>
                <div class="three columns last" style="margin: 40px 20px 0 0;">
                    <p>Добредојде, <?= $this->session->userdata['userFirstName'] . ' ' . $this->session->userdata['userLastName'] ?></p>
                    <img src="<?=base_url()?>images/icons/user.png" width="16px"/>
                    <a href="<?= base_url() ?>admin/settings">Профил</a> | <a href="<?= base_url() ?>logout">Одјава</a>
                </div>
            </div>
