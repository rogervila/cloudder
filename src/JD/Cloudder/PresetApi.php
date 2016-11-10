<?php

namespace JD\Cloudder;

trait PresetApi
{
    /**
     * List Upload Presets
     *
     * @param  array $options
     *
     * @return array
     */
    public function uploadPresets($options = array())
    {
        return $this->getApi()->upload_presets($options);
    }

    /**
     * Get upload preset
     *
     * @param  string $name
     * @param  array $options
     *
     * @return array
     */
    public function uploadPreset($name, $options = array())
    {
        return $this->getApi()->upload_preset($name, $options);
    }

    /**
     * Create upload preset
     *
     * @param  string $name
     * @param  array $options
     *
     * @return array
     */
    public function createUploadPreset($name, $options = array())
    {
        return $this->getApi()->create_upload_preset($name, $options);
    }

    /**
     * Delete upload preset
     *
     * @param  string $name
     * @param  array $options
     *
     * @return array
     */
    public function deleteUploadPreset($name, $options = array())
    {
        return $this->getApi()->delete_upload_preset($name, $options);
    }

    /**
     * Update upload preset
     *
     * @param  string $name
     * @param  array $options
     *
     * @return array
     */
    public function updateUploadPreset($name, $options = array())
    {
        return $this->getApi()->update_upload_preset($name, $options);
    }
}