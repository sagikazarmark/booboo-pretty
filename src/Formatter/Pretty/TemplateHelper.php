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
 * Generic interface for template engines/framework display implementations
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
interface TemplateHelper
{
    /**
     * Renders the page
     *
     * @param array $data
     *
     * @return string
     */
    public function render(array $data = []);
}
