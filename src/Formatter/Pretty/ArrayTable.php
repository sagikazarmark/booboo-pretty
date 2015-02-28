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
 * Data table with an array source
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class ArrayTable implements Table
{
    use TableLabel;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @param string $label
     * @param array  $data
     */
    public function __construct($label, array $data)
    {
        $this->label = $label;
        $this->data = $data;
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->data;
    }
}
