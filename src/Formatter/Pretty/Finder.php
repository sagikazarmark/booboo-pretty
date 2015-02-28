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
 * Generic interface for finding resources
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
interface Finder
{
    /**
     * Find a resource
     *
     * @param string $resource
     *
     * @return string
     *
     * @throws \RuntimeException if the resource cannot be found
     */
    public function find($resource);
}
