<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo $pageTitle; ?></title>

        <style type="text/css"><?php echo $assetHelper->dump('css/whoops.base.css'); ?></style>
    </head>
    <body>
        <div class="Whoops container">
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

        <script src="//cdnjs.cloudflare.com/ajax/libs/zeroclipboard/1.3.5/ZeroClipboard.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/prettify/r224/prettify.js"></script>
        <script type="text/javascript"><?php echo $assetHelper->dump('js/zepto.min.js') ?></script>
        <script type="text/javascript"><?php echo $assetHelper->dump('js/whoops.base.js') ?></script>
    </body>
</html>
