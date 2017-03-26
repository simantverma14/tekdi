<!-- Scripts -->
<script src="<?php echo JS_PATH; ?>jquery-ui.min.js"></script>
<script src="<?php echo JS_PATH; ?>moment-with-locales.js"></script> <!-- v2.9.0 -->

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>

<script src="<?php echo JS_PATH; ?>bootstrap.min.js"></script> <!-- v3.3.6 -->
<script src="<?php echo JS_PATH; ?>bootstrap-datetimepicker.js"></script> <!-- v4.15.35 -->
<script src="<?php echo JS_PATH; ?>jquery.dataTables.min.js"></script>
<script src="<?php echo JS_PATH; ?>dataTables.bootstrap.min.js"></script>
<script src="<?php echo JS_PATH; ?>jquery.validate.min.js"></script>
<script src="<?php echo JS_PATH; ?>additional-methods.min.js"></script>
<script src="<?php echo APP_URL; ?>ckeditor/ckeditor.js"></script>

<script src="<?php echo JS_PATH; ?>fastclick.min.js"></script>

<!-- custom script charts -->
<script src="<?php echo JS_PATH; ?>custom_scripts.js"></script>

<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="<?php echo JS_PATH; ?>ie10-viewport-bug-workaround.js"></script>