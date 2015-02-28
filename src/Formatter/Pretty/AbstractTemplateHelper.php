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
 * Abstract Template helper required for the core templates
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
abstract class AbstractTemplateHelper implements TemplateHelper
{
    /**
     * Escapes a string for output in an HTML document
     *
     * @param string $raw
     *
     * @return string
     */
    public function escape($raw)
    {
        $flags = ENT_QUOTES;
        // HHVM has all constants defined, but only ENT_IGNORE
        // works at the moment
        if (defined("ENT_SUBSTITUTE") && !defined("HHVM_VERSION")) {
            $flags |= ENT_SUBSTITUTE;
        } else {
            // This is for 5.3.
            // The documentation warns of a potential security issue,
            // but it seems it does not apply in our case, because
            // we do not blacklist anything anywhere.
            $flags |= ENT_IGNORE;
        }

        return htmlspecialchars($raw, $flags, "UTF-8");
    }

    /**
     * Escapes a string for output in an HTML document, but preserves
     * URIs within it, and converts them to clickable anchor elements.
     *
     * @param string $raw
     *
     * @return string
     */
    public function escapeButPreserveUris($raw)
    {
        $escaped = $this->escape($raw);

        return preg_replace(
            "@([A-z]+?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@",
            "<a href=\"$1\" target=\"_blank\">$1</a>", $escaped
        );
    }

    /**
     * Convert a string to a slug version of itself
     *
     * @param string $original
     *
     * @return string
     */
    public function slug($original)
    {
        $slug = str_replace(" ", "-", $original);
        $slug = preg_replace('/[^\w\d\-\_]/i', '', $slug);

        return strtolower($slug);
    }

    /**
     * Dumps an asset
     *
     * @param string $asset
     *
     * @return string
     */
    abstract public function asset($asset);
}
