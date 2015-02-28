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
 * Finder aware logic
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
trait FinderAware
{
    /**
     * @var Finder
     */
    protected $finder;

    /**
     * @param Finder $finder
     */
    public function __construct(Finder $finder)
    {
        $this->finder = $finder;
    }

    /**
     * Returns the finder
     *
     * @return Finder
     */
    public function getFinder()
    {
        return $this->finder;
    }
}
