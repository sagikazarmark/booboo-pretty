<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Boo! There was an error.</title>

        <style type="text/css"><?php echo $this->asset('css/booboo.min.css'); ?></style>
    </head>
    <body>
        <div class="container">
            <div class="stack-container">
                <div class="frames-container cf <?php echo $inspector->hasFrames() ? '' : 'empty'; ?>">
                    <?php foreach ($inspector->getFrames() as $i => $frame): ?>
                        <div class="frame <?php echo ($i == 0 ? 'active' : '') ?>" id="frame-line-<?php echo $i ?>">
                                <div class="frame-method-info">
                                    <span class="frame-index"><?php echo (count($frames) - $i - 1) ?>.</span>
                                    <span class="frame-class"><?php echo $this->escape($frame->getClass() ?: '') ?></span>
                                    <span class="frame-function"><?php echo $this->escape($frame->getFunction() ?: '') ?></span>
                                </div>

                            <span class="frame-file">
                                <?php echo ($frame->getFile(true) ?: '<#unknown>') ?>
                                <span class="frame-line"><?php echo (int) $frame->getLine() ?></span>
                            </span>
                        </div>
                    <?php endforeach ?>
                </div>
                <div class="details-container cf">
                    <header>
                        <div class="exception">
                            <h3 class="exc-title">
                                <?php foreach (explode('\\', $inspector->getExceptionName()) as $i => $nameSection): ?>
                                    <?php if ($i == count($name) - 1): ?>
                                        <span class="exc-title-primary"><?php echo $this->escape($nameSection) ?></span>
                                    <?php else: ?>
                                        <?php echo $this->escape($nameSection) . ' \\' ?>
                                    <?php endif ?>
                                <?php endforeach ?>
                                <?php if ($code): ?>
                                    <span title="Exception Code">(<?php echo $this->escape($code) ?>)</span>
                                <?php endif ?>
                                <button id="copy-button" class="clipboard" data-clipboard-target="plain-exception" title="copy exception into clipboard"></button>
                                <span id="plain-exception"><?php echo $this->escape($plainException) ?></span>
                            </h3>
                            <p class="exc-message">
                                <?php echo $this->escape($message) ?>
                            </p>
                        </div>
                    </header>
                    <div class="frame-code-container <?php echo $inspector->hasFrames() ? '' : 'empty'; ?>">
                        <?php foreach ($inspector->getFrames() as $i => $frame): ?>
                            <?php $line = $frame->getLine(); ?>
                                <div class="frame-code <?php echo ($i == 0 ) ? 'active' : '' ?>" id="frame-code-<?php echo $i ?>">
                                    <div class="frame-file">
                                        <?php $filePath = $frame->getFile(); ?>
                                        <?php if (false): ?>
                                        <?php //if ($filePath && $editorHref = $handler->getEditorHref($filePath, (int) $line)): ?>
                                            Open:
                                            <a href="<?php echo $editorHref ?>" class="editor-link">
                                                <strong><?php echo $this->escape($filePath ?: '<#unknown>') ?></strong>
                                            </a>
                                        <?php else: ?>
                                            <strong><?php echo $this->escape($filePath ?: '<#unknown>') ?></strong>
                                        <?php endif ?>
                                    </div>
                                    <?php
                                        // Do nothing if there's no line to work off
                                        if ($line !== null):

                                        // the $line is 1-indexed, we nab -1 where needed to account for this
                                        $range = $frame->getFileLines($line - 8, 10);

                                        // getFileLines can return null if there is no source code
                                        if ($range):
                                            $range = array_map(function ($line) { return empty($line) ? ' ' : $line;}, $range);
                                            $start = key($range) + 1;
                                            $code  = join("\n", $range);
                                    ?>
                                            <pre class="code-block prettyprint linenums:<?php echo $start ?>"><?php echo $this->escape($code) ?></pre>
                                        <?php endif ?>
                                    <?php endif ?>

                                    <?php
                                        // Append comments for this frame
                                        $comments = $frame->getComments();
                                    ?>
                                    <div class="frame-comments <?php echo empty($comments) ? 'empty' : '' ?>">
                                        <?php foreach ($comments as $commentNo => $comment): ?>
                                            <?php extract($comment) ?>
                                            <div class="frame-comment" id="comment-<?php echo $i . '-' . $commentNo ?>">
                                                <span class="frame-comment-context"><?php echo $this->escape($context) ?></span>
                                                <?php echo $this->escapeButPreserveUris($comment) ?>
                                            </div>
                                        <?php endforeach ?>
                                    </div>

                                </div>
                        <?php endforeach ?>
                    </div>
                    <div class="details">
                        <div class="data-table-container" id="data-tables">
                            <?php foreach ($tables as $label => $data): ?>
                                <div class="data-table" id="sg-<?php echo $this->escape($this->slug($label)) ?>">
                                    <label><?php echo $this->escape($label) ?></label>
                                    <?php if (!empty($data)): ?>
                                            <table class="data-table">
                                                <thead>
                                                    <tr>
                                                        <td class="data-table-k">Key</td>
                                                        <td class="data-table-v">Value</td>
                                                    </tr>
                                                </thead>
                                            <?php foreach ($data as $k => $value): ?>
                                                <tr>
                                                    <td><?php echo $this->escape($k) ?></td>
                                                    <td><?php echo $this->escape(print_r($value, true)) ?></td>
                                                </tr>
                                            <?php endforeach ?>
                                            </table>
                                    <?php else: ?>
                                        <span class="empty">empty</span>
                                    <?php endif ?>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript"><?php echo $this->asset('js/ZeroClipboard.min.js') ?></script>
        <script type="text/javascript"><?php echo $this->asset('js/prettify.min.js') ?></script>
        <script type="text/javascript"><?php echo $this->asset('js/zepto.min.js') ?></script>
        <script type="text/javascript"><?php echo $this->asset('js/booboo.min.js') ?></script>
    </body>
</html>
