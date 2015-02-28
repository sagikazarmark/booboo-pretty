<?php

/*
 * This file is part of the BooBoo Pretty package.
 *
 * (c) Márk Sági-Kazár <mark.sagikazar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace League\BooBoo\Formatter;

use League\BooBoo\Util\Inspector;

/**
 * Pretty Page formatter
 *
 * Based on Whoops
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 * @author Filipe Dobreira <http://github.com/filp>
 */
class PrettyPageFormatter extends AbstractFormatter
{
    /**
     * @var array
     */
    protected $extraTables = [];

    /**
     * @var string
     */
    protected $pageTitle = 'Boo! There was an error.';

    /**
     * @var Pretty\TemplateHelper
     */
    protected $templateHelper;

    /**
     * @var Pretty\AssetHelper
     */
    protected $assetHelper;

    public function __construct(Pretty\TemplateHelper $templateHelper = null, Pretty\AssetHelper $assetHelper = null)
    {
        $this->templateHelper = $templateHelper ?: new Pretty\DefaultTemplateHelper(new Pretty\DefaultFinder([__DIR__.'/../../resources/views/']));
        $this->assetHelper = $assetHelper ?: new Pretty\DefaultAssetHelper(new Pretty\DefaultFinder([__DIR__.'/../../resources/assets/']));
    }

    /**
     * {@inheritdoc}
     */
    public function format(\Exception $e)
    {
        $inspector = $this->getInspector($e);
        $frames    = $inspector->getFrames();
        $code      = $e->getCode();

        if ($e instanceof \ErrorException) {
            $code = $this->determineSeverityTextValue($e->getSeverity());
        }

        $data = [
            'assetHelper'    => $this->assetHelper,
            'pageTitle'      => $this->pageTitle,
            'title'          => $this->pageTitle,
            'name'           => explode('\\', $inspector->getExceptionName()),
            'message'        => $e->getMessage(),
            'code'           => $code,
            'plainException' => $this->formatExceptionPlain($inspector),
            'frames'         => $frames,
            'hasFrames'      => count($frames) > 0,
            'tables'         => [
                'Server/Request Data'   => $_SERVER,
                'GET Data'              => $_GET,
                'POST Data'             => $_POST,
                'Files'                 => $_FILES,
                'Cookies'               => $_COOKIE,
                'Session'               => isset($_SESSION) ? $_SESSION :  [],
                'Environment Variables' => $_ENV,
            ],
        ];

        $extraTables = array_map(function ($table) {
            return $table instanceof \Closure ? $table() : $table;
        }, $this->getDataTables());

        $data['tables'] = array_merge($extraTables, $data['tables']);

        return $this->templateHelper->render('layout.html.php', $data);
    }

    /**
     * Creates a new Inspector
     *
     * Since the Inspector is a dependency of this class and instantiated internally
     * this is an extension point.
     *
     * @param \Exception $e
     *
     * @return Inspector
     */
    protected function getInspector(\Exception $e)
    {
        return new Inspector($e);
    }

    /**
     * Returns all the extra data tables registered with this handler.
     * Optionally accepts a 'label' parameter, to only return the data
     * table under that label.
     *
     * @param string|null $label
     *
     * @return array[]|callable
     */
    public function getDataTables($label = null)
    {
        if ($label !== null) {
            return isset($this->extraTables[$label]) ? $this->extraTables[$label] : [];
        }

        return $this->extraTables;
    }

    /**
     * Adds an entry to the list of tables displayed in the template.
     * The expected data is a simple associative array. Any nested arrays
     * will be flattened with print_r
     *
     * @param string $label
     * @param array  $data
     */
    public function addDataTable($label, array $data)
    {
        $this->extraTables[$label] = $data;
    }
    /**
     * Lazily adds an entry to the list of tables displayed in the table.
     * The supplied callback argument will be called when the error is rendered,
     * it should produce a simple associative array. Any nested arrays will
     * be flattened with print_r.
     *
     * @param string   $label
     * @param callable $callback
     */
    public function addDataTableCallback($label, callable $callback)
    {
        $this->extraTables[$label] = function () use ($callback) {
            try {
                $result = call_user_func($callback);
                // Only return the result if it can be iterated over by foreach().
                return is_array($result) || $result instanceof \Traversable ? $result : [];
            } catch (\Exception $e) {
                // Don't allow failure to break the rendering of the original exception.
                return [];
            }
        };
    }

    /**
     * Formats the exception as plain string
     *
     * @param Inspector $inspector
     *
     * @return string
     */
    public function formatExceptionPlain(Inspector $inspector)
    {
        $message = $inspector->getException()->getMessage();
        $frames = $inspector->getFrames();
        $plain = $inspector->getExceptionName();
        $plain .= ' thrown with message "';
        $plain .= $message;
        $plain .= '"'."\n\n";
        $plain .= "Stacktrace:\n";
        foreach ($frames as $i => $frame) {
            $plain .= "#". (count($frames) - $i - 1). " ";
            $plain .= $frame->getClass() ?: '';
            $plain .= $frame->getClass() && $frame->getFunction() ? ":" : "";
            $plain .= $frame->getFunction() ?: '';
            $plain .= ' in ';
            $plain .= ($frame->getFile() ?: '<#unknown>');
            $plain .= ':';
            $plain .= (int) $frame->getLine(). "\n";
        }
        return $plain;
    }
}
