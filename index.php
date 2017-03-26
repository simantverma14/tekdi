<?php
// Admin Dashboard

ob_start();
session_start();
require_once 'config/variables.php';

$tbox_obj = new Cl_Tbox();

define('LAYOUT', SITE_URL . 'index.php');
?>

<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]> <!--><html class="no-js" lang="en"><!--<![endif]-->

    <!-- Include Header -->
    <?php require_once TEMPLATES . 'header.php'; ?>
    
    <body class="skin-blue layout-boxed">
        <!-- Site wrapper -->
        <div class="wrapper">
            <header class="main-header">
                <!-- Logo -->
                <a href="<?php echo SITE_URL;  ?>" class="logo">
                    <b>TEKDI Project</b>
                </a>
            </header>
            
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <?php $pages = array('users'); ?>
                <?php
                if (isset($_GET['page']) && !empty($_GET['page']) && in_array($_GET['page'], $pages)) {
                    include(VIEWS . $_GET['page'] . '.php');
                } else if (isset($_GET['page']) && !empty($_GET['page']) && !in_array($_GET['page'], $pages)) { ?>
                    <section class="content">
                        <div class="error-page">
                            <h2 class="headline text-yellow"> 404</h2>
                            <div class="error-content">
                                <h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>
                                <p> We could not find the page you were looking for.</p>
                            </div><!-- /.error-content -->
                        </div><!-- /.error-page -->
                    </section><!-- /.content -->
                <?php } else {
                    include(VIEWS . 'users.php');
                }
                ?>
            </div><!-- /.content-wrapper -->

            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <span>T: 0235412541</span><span>F: 0214521452</span><span>info@abcd.com</span>
                </div>
                <strong>Copyright &COPY; <?php echo date("Y"); ?> Therapy-Box.</strong> All rights reserved.
            </footer>
        </div><!-- ./wrapper -->
        
        <!-- Include Footer -->
        <?php require_once TEMPLATES . 'footer.php'; ?>
    </body>
</html>
<?php ob_end_flush(); ?>
