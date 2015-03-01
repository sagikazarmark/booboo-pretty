<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo $pageTitle; ?></title>

        <style type="text/css"><?php echo $this->asset('css/booboo.min.css'); ?></style>
    </head>
    <body>
        <div class="container">
            <div class="stack-container">
                <div class="frames-container cf <?php echo $hasFrames ? '' : 'empty'; ?>">
                    <?php echo $this->render('frame_list.html.php'); ?>
                </div>
                <div class="details-container cf">
                    <header><?php echo $this->render('header.html.php'); ?></header>
                    <?php echo $this->render('frame_code.html.php'); ?>
                    <?php echo $this->render('env_details.html.php'); ?>
                </div>
            </div>
        </div>

        <script type="text/javascript"><?php echo $this->asset('js/ZeroClipboard.min.js') ?></script>
        <script type="text/javascript"><?php echo $this->asset('js/prettify.min.js') ?></script>
        <script type="text/javascript"><?php echo $this->asset('js/zepto.min.js') ?></script>
        <script type="text/javascript"><?php echo $this->asset('js/booboo.min.js') ?></script>
    </body>
</html>
