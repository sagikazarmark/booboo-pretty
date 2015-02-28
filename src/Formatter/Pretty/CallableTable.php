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
 * Data table with a callable source
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class CallableTable implements Table
{
    use TableLabel;

    /**
     * @var callable
     */
    protected $data;

    /**
     * @param string    $label
     * @param callable  $data
     */
    public function __construct($label, callable $data)
    {
        $this->label = $label;
        $this->data = $data;
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->data();
    }
}
