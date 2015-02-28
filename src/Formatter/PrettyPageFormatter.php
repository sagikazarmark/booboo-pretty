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
    protected $tables = [];

    /**
     * @var string
     */
    protected $pageTitle = 'Boo! There was an error.';

    /**
     * @var Pretty\TemplateHelper
     */
    protected $templateHelper;

    public function __construct(Pretty\TemplateHelper $templateHelper = null)
    {
        $this->templateHelper = $templateHelper ?: new Pretty\DefaultTemplateHelper(
            new Pretty\DefaultFinder([__DIR__.'/../../resources/views/']),
            new Pretty\DefaultFinder([__DIR__.'/../../resources/assets/'])
        );
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

        $tables = array_merge($this->getDefaultTables(), $this->tables);

        $data = [
            'pageTitle'      => $this->pageTitle,
            'title'          => $this->pageTitle,
            'name'           => explode('\\', $inspector->getExceptionName()),
            'message'        => $e->getMessage(),
            'code'           => $code,
            'plainException' => $this->formatExceptionPlain($inspector),
            'frames'         => $frames,
            'hasFrames'      => count($frames) > 0,
            'tables'         => $this->processTables($tables),
        ];

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
     * Adds an entry to the list of tables displayed in the template
     *
     * The expected data is a simple associative array. Any nested arrays
     * will be flattened with print_r
     *
     * @param Pretty\Table $table
     */
    public function addTable(Pretty\Table $table)
    {
        $this->tables[] = $table;
    }

    /**
     * Returns the default tables
     *
     * @return Pretty\Table[]
     */
    protected function getDefaultTables()
    {
        return [
            new Pretty\ArrayTable('Server/Request Data', $_SERVER),
            new Pretty\ArrayTable('GET Data', $_GET),
            new Pretty\ArrayTable('POST Data', $_POST),
            new Pretty\ArrayTable('Files', $_FILES),
            new Pretty\ArrayTable('Cookies', $_COOKIE),
            new Pretty\ArrayTable('Session', isset($_SESSION) ? $_SESSION :  []),
            new Pretty\ArrayTable('Environment Variables', $_ENV),
        ];
    }

    /**
     * Processes an array of tables making sure everything is allright
     *
     * @param Pretty\Table[] $tables
     *
     * @return array
     */
    protected function processTables(array $tables)
    {
        $processedTables = [];

        foreach ($tables as $table) {
            // Make it foolproof so nothing bad can happen
            if (!$table instanceof Pretty\Table) {
                continue;
            }

            $label = $table->getLabel();

            try {
                $data = $table->getData();

                if (!(is_array($data) || $data instanceof \Traversable)) {
                    $data = [];
                }
            } catch (\Exception $e) {
                // Don't allow failure to break the rendering of the original exception.
                $data = [];
            }

            $processedTables[$label] = $data;
        }

        return $processedTables;
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
