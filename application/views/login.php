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

        <title>УГД еУчење - Најава</title>

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
        <style>
            .login_form input:not([type=submit]){
                width: 140px;
                margin-left: 20px;
            }


        </style>
    </head>
    <body style="background-color: #EEE; color: white">

        <!-- container -->
        <div class="container">
            <div class="row">
                <div class="ten columns centered"style="margin-top: 30px;" >
                    <h2 style="font-style: italic; color: #117537;">Систем за еУчење</h2>
                </div>
            </div>
            <div class="row">
                <div class="ten columns centered"style="margin-top: 30px;" >
                    <div style="width:898px;height:372px;background:url('<?= base_url() ?>images/background_login.jpg') no-repeat 0 0;border:1px solid #059706;">
                        <?= form_open(base_url() . 'login') ?>

                        <div style="margin:0 auto; background: #EEE;  width: 450px; min-height:60px; text-align: center; " class="login_form">
                            <div style="font-size: 9px; float: left; margin-top: 20px">

                                <?= form_input(array('name' => 'userName', 'placeholder' => 'Корисничко име'), set_value('userName')) ?>

                            </div>
                            <div style="font-size: 9px; float: left; margin-top: 20px">

                                <?= form_password(array('name' => 'userPassword', 'placeholder' => 'Лозинка')) ?>

                                <?= form_submit(array('value' => 'Login', 'class' => 'button small green', 'style' => "margin-left:20px; opacity:1;")) ?>
                            </div>

                            <div class="clear" style="clear:both"></div>

                            <div style="color:red; text-align: left; margin-left: 20px; margin-top:10px; padding-bottom: 5px;">
                                <? if ($this->session->flashdata('flashError')): ?>
                                    <?= $this->session->flashdata('flashError') ?>
                                <? endif ?>
                                <?= form_error('userName') ?>
                                <?= form_error('userPassword') ?>
                            </div>
                        </div>

                        <?= form_close() ?>
                    </div>
                    <div class="row">
                        <div class="twelve columns"style="margin-top: 5px; background-color: #117537; width: 880px; padding-left: 20px;" >
                            <a style="color: white" href="#" id="buttonZaboravenaLozinka">Заборавена лозинка?</a>
                        </div>
                    </div>



                    <div id="zaboravenaLozinka" class="reveal-modal" style="color: black">
                        <h4>Си ја заборавивте лозинката?</h4><br/>
                        <p>Единствен начин за ресетирање на вашата лозинка е преку контактирање до ИТ службата на УГД.</p>
                        <a class="close-reveal-modal">&#215;</a>
                    </div>

                    <script type="text/javascript">
                        $(document).ready(function() {
                            $('#buttonZaboravenaLozinka').click(function() {
                                $('#zaboravenaLozinka').reveal();
                            });
                        });
                    </script>

                </div>
                <!-- container -->

                <!-- Included JS Files -->

                <script src="<?= base_url() ?>javascripts/foundation.js"></script>
                <script src="<?= base_url() ?>javascripts/app.js"></script>

                </body>
                </html>