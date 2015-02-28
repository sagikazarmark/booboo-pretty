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
 * Generic interface for dumping assets in templates
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
interface AssetHelper
{
    /**
     * Dumps an asset
     *
     * @param string $asset
     *
     * @return string
     */
    public function dump($asset);
}
