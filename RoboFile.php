<?php

require __DIR__.'/vendor/autoload.php';

use Robo\Task\ILess\loadTasks as LessTask;

/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
class RoboFile extends \Robo\Tasks
{
    use LessTask;

    public function assets()
    {
        $this->taskFileSystemStack()
            ->copy(__DIR__.'/vendor/components/zepto/zepto.min.js', __DIR__.'/resources/assets/js/zepto.min.js', true)
            ->copy(__DIR__.'/vendor/zeroclipboard/zeroclipboard/ZeroClipboard.min.js', __DIR__.'/resources/assets/js/ZeroClipboard.min.js', true)
            ->copy(__DIR__.'/vendor/zeroclipboard/zeroclipboard/ZeroClipboard.swf', __DIR__.'/resources/assets/js/ZeroClipboard.swf', true)
            ->run();

        $this->taskCompileLess([
                __DIR__.'/resources/assets/css/booboo.css' => __DIR__.'/resources/assets/less/booboo.less',
            ])
            ->run();

        $this->taskMinify(__DIR__.'/resources/assets/css/booboo.css')->run();
        $this->taskMinify(__DIR__.'/resources/assets/js/booboo.js')->run();
    }
}
