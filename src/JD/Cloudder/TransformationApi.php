<?php

namespace JD\Cloudder;

trait TransformationApi
{
    /**
     * List transformations
     *
     * @param  array $options
     *
     * @return array
     */
    public function transformations($options = array())
    {
        return $this->getApi()->transformations($options);
    }

    /**
     * List single transformation
     *
     * @param  string $transformation
     * @param  array $options
     *
     * @return array
     */
    public function transformation($transformation, $options = array())
    {
        return $this->getApi()->transformation($transformation, $options);
    }

    /**
     * Delete single transformation
     *
     * @param  string $transformation
     * @param  array $options
     *
     * @return array
     */
    public function deleteTransformation($transformation, $options = array())
    {
        return $this->getApi()->delete_transformation($transformation, $options);
    }

    /**
     * Update single transformation
     *
     * @param  string $transformation
     * @param  array $updates
     * @param  array $options
     *
     * @return array
     */
    public function updateTransformation($transformation, $updates = array(), $options = array())
    {
        return $this->getApi()->update_transformation($transformation, $updates, $options);
    }

    /**
     * Create transformation
     *
     * @param  string $name
     * @param  string $definition
     * @param  array $options
     *
     * @return array
     */
    public function createTransformation($name, $definition, $options = array())
    {
        return $this->getApi()->create_transformation($name, $definition, $options);
    }
}