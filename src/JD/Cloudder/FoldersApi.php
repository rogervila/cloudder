<?php

namespace JD\Cloudder;

trait FoldersApi
{
    /**
     * List Root folders
     *
     * @param  array $options
     *
     * @return array
     */
    public function rootFolders($options = array())
    {
        return $this->getApi()->root_folders($options);
    }

    /**
     * List subfolders
     *
     * @param  string $name
     * @param  array $options
     *
     * @return array
     */
    public function subfolders($name, $options = array())
    {
        return $this->getApi()->subfolders($name, $options);
    }
}