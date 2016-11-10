<?php

namespace JD\Cloudder;

trait TagApi
{
    /**
     * Display tags list
     *
     * @param  array $options
     *
     * @return array
     */
    public function tags($options = array())
    {
        return $this->getApi()->tags($options);
    }

    /**
     * Add tag to images.
     *
     * @param string $tag
     * @param array $publicIds
     * @param array $options
     *
     * @return mixed
     */
    public function addTag($tag, $publicIds = array(), $options = array())
    {
        return $this->getUploader()->add_tag($tag, $publicIds, $options);
    }

    /**
     * Remove tag from images.
     *
     * @param string $tag
     * @param array $publicIds
     * @param array $options
     *
     * @return mixed
     */
    public function removeTag($tag, $publicIds = array(), $options = array())
    {
        return $this->getUploader()->remove_tag($tag, $publicIds, $options);
    }

    /**
     * Replace image's tag.
     *
     * @param string $tag
     * @param array $publicIds
     * @param array $options
     *
     * @return mixed
     */
    public function replaceTag($tag, $publicIds = array(), $options = array())
    {
        return $this->getUploader()->replace_tag($tag, $publicIds, $options);
    }
}