<?php

namespace JD\Cloudder;

trait MappingApi
{
    /**
     * List Upload Mappings
     *
     * @param  array $options
     *
     * @return array
     */
    public function uploadMappings($options = array())
    {
        return $this->getApi()->upload_mappings($options);
    }

    /**
     * Get upload mapping
     *
     * @param  string $name
     * @param  array $options
     *
     * @return array
     */
    public function uploadMapping($name, $options = array())
    {
        return $this->getApi()->upload_mapping($name, $options);
    }

    /**
     * Create upload mapping
     *
     * @param  string $name
     * @param  array $options
     *
     * @return array
     */
    public function createUploadMapping($name, $options = array())
    {
        return $this->getApi()->create_upload_mapping($name, $options);
    }

    /**
     * Delete upload mapping
     *
     * @param  string $name
     * @param  array $options
     *
     * @return array
     */
    public function deleteUploadMapping($name, $options = array())
    {
        return $this->getApi()->delete_upload_mapping($name, $options);
    }

    /**
     * Update upload mapping
     *
     * @param  string $name
     * @param  array $options
     *
     * @return array
     */
    public function updateUploadMapping($name, $options = array())
    {
        return $this->getApi()->update_upload_mapping($name, $options);
    }
}