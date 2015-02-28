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
 * Default Asset helper
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class DefaultAssetHelper implements AssetHelper
{
    use FinderAware;

    /**
     * {@inheritdoc}
     */
    public function dump($asset)
    {
        $asset = $this->finder->find($asset);

        return file_get_contents($asset);
    }
}
