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
 * Generic interface for table structured data
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
interface Table
{
    /**
     * Returns the label
     *
     * @return string
     */
    public function getLabel();

    /**
     * Returns data as associative array
     *
     * @return array
     */
    public function getData();
}
