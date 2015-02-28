<?php

/*
 * This file is part of the BooBoo Pretty package.
 *
 * (c) Márk Sági-Kazár <mark.sagikazar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace League\BooBoo\Formatter\Pretty;

/**
 * Default Template helper
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class DefaultTemplateHelper extends AbstractTemplateHelper
{
    /**
     * @var Finder
     */
    protected $templateFinder;

    /**
     * @var Finder
     */
    protected $assetFinder;

    /**
     * Store the data to make it available in all templates
     *
     * @var array
     */
    protected $data = [];

    /**
     * @param Finder $templateFinder
     * @param Finder $assetFinder
     */
    public function __construct(Finder $templateFinder, Finder $assetFinder)
    {
        $this->templateFinder = $templateFinder;
        $this->assetFinder = $assetFinder;
    }

    /**
     * {@inheritdoc}
     */
    public function render($template, array $data = [])
    {
        $template = $this->templateFinder->find($template);

        $this->data = array_merge($this->data, $data);

        $loadTemplate = function ($__template, $__data)
        {
            extract($__data, EXTR_REFS);
            ob_start();

            try
            {
                // Load the view within the current scope
                include $__template;
            }
            catch (\Exception $e)
            {
                // Delete the output buffer
                ob_end_clean();

                // Re-throw the exception
                throw $e;
            }

            // Get the captured output and close the buffer
            return ob_get_clean();
        };

        return $loadTemplate($template, $this->data);
    }

    /**
     * {@inheritdoc}
     */
    public function asset($asset)
    {
        $asset = $this->assetFinder->find($asset);

        return file_get_contents($asset);
    }
}
