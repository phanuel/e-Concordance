<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo $title; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" >

        <?php echo isset($canonicalUrl) ? "<link rel='canonical' href='".base_url().$canonicalUrl."'>\n" : ""; ?>
        <link href="<?php echo base_url(); ?>css/lib/bootstrap.min.css" media="screen" rel="stylesheet" type="text/css" >
        <link href="<?php echo base_url(); ?>css/lib/bootstrap-responsive.min.css" media="screen" rel="stylesheet" type="text/css" >
        <link href="<?php echo base_url(); ?>css/base.css" media="screen" rel="stylesheet" type="text/css" >
        <link href="<?php echo base_url(); ?>css/style.css" media="screen" rel="stylesheet" type="text/css" >
        <link href="<?php echo base_url(); ?>favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" >

        <script type="text/javascript" src="<?php echo base_url(); ?>js/stats.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/lib/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/lib/bootstrap.min.js"></script>
        <!--[if lt IE 9]> <script type="text/javascript" src="<?php echo base_url(); ?>js/lib/html5.js"></script><![endif]-->
    </head>
    <body>
        <div id="wrap">
            <?php if (!isset($home)): ?>
                <div class="navbar navbar-fixed-top">
                    <div class="navbar-inner">
                        <div class="container">
                            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </a>
                            <a class="brand" href="<?php echo base_url(); ?>"></a>
                            <div class="nav-collapse">
                                <ul class="nav">
                                    <div class="menu_hack hidden-desktop"></div>
                                    <li class="active"><a href="<?php echo base_url(); ?>">Accueil</a></li>
                                    <li class="active"><a href="<?php echo base_url(); ?>index/news">Nouveautés</a></li>
                                    <li class="active"><a href="<?php echo base_url(); ?>index/contact">Contact</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="container">
                <?php if (!isset($home)): ?>
                    <div class="push visible-desktop"></div>
                <?php endif; ?>
                <?php echo $content; ?>
            </div>
            <div class="push"></div>
        </div>
        <div id="footer">
            <div class="container">
                <div id="main" class="container clear-top">
                    <footer>
                        <hr />
                        <p>e-Concordance v2.1 — <a href="<?php echo base_url(); ?>index/contact">contact</a></p>
                    </footer>
                </div>
            </div>
        </div>
    </body>
</html>
