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
 * Default Finder
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class DefaultFinder implements Finder
{
    /**
     * @var array
     */
    protected $paths = [];

    /**
     * @var array
     */
    protected $pathCache = [];

    /**
     * @param array $paths
     */
    public function __construct(array $paths = [])
    {
        $this->addPaths($paths);
    }

    /**
     * {@inheritdoc}
     */
    public function find($resource)
    {
        // Check the cache first
        if (isset($this->pathCache[$resource])) {
            return $this->pathCache[$resource];
        }

        // Search through available paths, until we find the resource we're after
        foreach ($this->paths as $path) {
            $fullPath = $path.DIRECTORY_SEPARATOR.$resource;

            if (is_file($fullPath)) {
                return $this->pathCache[$resource] = $fullPath;
            }
        }

        // If we got this far, nothing was found
        throw new \RuntimeException(sprintf('Could not find resource "%s" in any paths.', $resource));
    }

    /**
     * Returns the current paths
     *
     * @return array
     */
    public function getPaths()
    {
        return $this->paths;
    }

    /**
     * Adds a path to the current paths
     *
     * @param string $path
     */
    public function addPath($path)
    {
        if (!is_dir($path)) {
            throw new \InvalidArgumentException(sprintf('"%s" is not a valid directory', $path));
        }

        $path = rtrim($path, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;

        array_unshift($this->paths, $path);
    }

    /**
     * Adds multiple paths to the current paths
     *
     * @param array $paths
     */
    public function addPaths(array $paths)
    {
        array_map([$this, 'addPath'], $paths);
    }
}
