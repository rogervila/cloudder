<?php

namespace JD\Cloudder;

use Cloudinary;
use Illuminate\Config\Repository;

class CloudinaryWrapper
{
    use PresetApi;
    use MappingApi;
    use FoldersApi;
    use TransformationApi;
    use TagApi;

    /**
     * Cloudinary lib.
     *
     * @var \Cloudinary
     */
    protected $cloudinary;

    /**
     * Cloudinary uploader.
     *
     * @var \Cloudinary\Uploader
     */
    protected $uploader;

    /**
     * Repository config.
     *
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    /**
     * Uploaded result.
     *
     * @var array
     */
    protected $uploadedResult;

    /**
     * @var Cloudinary\Api
     */
    protected $api;

    /**
     * Create a new cloudinary instance.
     *
     * @param  \Illuminate\Config\Repository $config
     *
     * @param Cloudinary $cloudinary
     * @param Cloudinary\Uploader $uploader
     * @param Cloudinary\Api $api
     */
    public function __construct(
        Repository $config,
        Cloudinary $cloudinary,
        Cloudinary\Uploader $uploader,
        Cloudinary\Api $api
    ) {
        $this->cloudinary = $cloudinary;

        $this->uploader = $uploader;

        $this->api = $api;

        $this->config = $config;

        $this->cloudinary->config(array(
            'cloud_name' => $this->config->get('cloudder.cloudName'),
            'api_key'    => $this->config->get('cloudder.apiKey'),
            'api_secret' => $this->config->get('cloudder.apiSecret')
        ));
    }

    /**
     * Get cloudinary class.
     *
     * @return \Cloudinary
     */
    public function getCloudinary()
    {
        return $this->cloudinary;
    }

    /**
     * Get cloudinary uploader.
     *
     * @return \Cloudinary\Uploader
     */
    public function getUploader()
    {
        return $this->uploader;
    }

    /**
     * Get cloudinary api
     *
     * @return \Cloudinary\Api
     */
    public function getApi()
    {
        return $this->api;
    }


    /**
     * Upload image to cloud.
     *
     * @param  mixed $source
     * @param  string $publicId
     * @param  array $uploadOptions
     * @param  array $tags
     *
     * @return CloudinaryWrapper
     */
    public function upload($source, $publicId = null, $uploadOptions = array(), $tags = array())
    {
        $defaults = array(
            'public_id' => null,
            'tags'      => array()
        );

        $options = array_merge($defaults, array(
            'public_id' => $publicId,
            'tags'      => $tags
        ));

        $options = array_merge($options, $uploadOptions);

        $this->uploadedResult = $this->getUploader()->upload($source, $options);

        return $this;
    }

    /**
     * Upload video to cloud.
     *
     * @param  mixed $source
     * @param  string $publicId
     * @param  array $uploadOptions
     * @param  array $tags
     *
     * @return CloudinaryWrapper
     */
    public function uploadVideo($source, $publicId = null, $uploadOptions = array(), $tags = array())
    {
        $options = array_merge($uploadOptions, ['resource_type' => 'video']);

        return $this->upload($source, $publicId, $options, $tags);
    }

    /**
     * Uploaded result.
     *
     * @return array
     */
    public function getResult()
    {
        return $this->uploadedResult;
    }

    /**
     * Uploaded public ID.
     *
     * @return string
     */
    public function getPublicId()
    {
        return $this->uploadedResult['public_id'];
    }

    /**
     * Display resource through https.
     *
     * @param  string $publicId
     * @param  array $options
     *
     * @return string
     */
    public function show($publicId, $options = array())
    {
        $defaults = $this->config->get('cloudder.scaling');

        $options = array_merge($defaults, $options);

        return $this->getCloudinary()->cloudinary_url($publicId, $options);
    }

    /**
     * Display resource through https.
     *
     * @param  string $publicId
     * @param  array $options
     *
     * @return string
     */
    public function secureShow($publicId, $options = array())
    {
        $defaults = $this->config->get('cloudder.scaling');

        $options = array_merge($defaults, $options);

        $options = array_merge(['secure' => true], $options);

        return $this->getCloudinary()->cloudinary_url($publicId, $options);
    }


    /**
     * Alias for privateDownloadUrl
     *
     * @param string $publicId
     * @param string $format
     * @param array $options
     *
     * @return string
     */
    public function showPrivateUrl($publicId, $format, $options = array())
    {
        return $this->privateDownloadUrl($publicId, $format, $options);
    }

    /**
     * Display private image
     *
     * @param string $publicId
     * @param string $format
     * @param array $options
     *
     * @return string
     */
    public function privateDownloadUrl($publicId, $format, $options = array())
    {
        return $this->getCloudinary()->private_download_url($publicId, $format, $options);
    }

    /**
     * Rename public ID.
     *
     * @param  string $publicId
     * @param  string $toPublicId
     * @param  array $options
     *
     * @return array|bool
     */
    public function rename($publicId, $toPublicId, $options = array())
    {
        try {
            return $this->getUploader()->rename($publicId, $toPublicId, $options);
        } catch (\Exception $e) {
        }

        return false;
    }

    /**
     * Alias for destroy
     *
     * @param  string $publicId
     * @param  array $options
     *
     * @return array
     */
    public function destroyImage($publicId, $options = array())
    {
        return $this->destroy($publicId, $options);
    }

    /**
     * Destroy resource from Cloudinary
     *
     * @param  string $publicId
     * @param  array $options
     *
     * @return array
     */
    public function destroy($publicId, $options = array())
    {
        return $this->getUploader()->destroy($publicId, $options);
    }

    /**
     * Restore a resource
     *
     * @param  array $publicIds
     * @param  array $options
     *
     * @return null
     */
    public function restore($publicIds = array(), $options = array())
    {
        return $this->getApi()->restore($publicIds, $options);
    }

    /**
     * Alias of destroy.
     *
     * @param $publicId
     * @param array $options
     *
     * @return bool
     */
    public function delete($publicId, $options = array())
    {
        $response = $this->destroy($publicId, $options);

        return (boolean)($response['result'] == 'ok');
    }

    /**
     * Show Resources
     *
     * @param  array $options
     *
     * @return array
     */
    public function resources($options = array())
    {
        return $this->getApi()->resources($options);
    }

    /**
     * Show Resources by id
     *
     * @param  array $options
     *
     * @return array
     */
    public function resourcesByIds($options = array())
    {
        return $this->getApi()->resources_by_ids($options);
    }

    /**
     * Show Resources by tag name
     *
     * @param $tag
     * @param array $options
     *
     * @return \Cloudinary\Api\Response
     */
    public function resourcesByTag($tag, $options = array())
    {
        return $this->getApi()->resources_by_tag($tag, $options);
    }

    /**
     * Show Resources by moderation status
     *
     * @param $kind
     * @param $status
     * @param array $options
     *
     * @return \Cloudinary\Api\Response
     */
    public function resourcesByModeration($kind, $status, $options = array())
    {
        return $this->getApi()->resources_by_moderation($kind, $status, $options);
    }

    /**
     * Display a resource
     *
     * @param  string $publicId
     * @param  array $options
     *
     * @return array
     */
    public function resource($publicId, $options = array())
    {
        return $this->getApi()->resource($publicId, $options);
    }

    /**
     * Updates a resource
     *
     * @param  string $publicId
     * @param  array $options
     *
     * @return array
     */
    public function update($publicId, $options = array())
    {
        return $this->getApi()->update($publicId, $options);
    }

    /**
     * Alias for deleteResources
     *
     * @param  array $publicIds
     * @param  array $options
     *
     * @return null
     */
    public function destroyImages($publicIds, $options = array())
    {
        return $this->deleteResources($publicIds, $options);
    }

    /**
     * Destroy images from Cloudinary
     *
     * @param  array $publicIds
     * @param  array $options
     *
     * @return null
     */
    public function deleteResources($publicIds, $options = array())
    {
        return $this->getApi()->delete_resources($publicIds, $options);
    }

    /**
     * Destroy a resource by its prefix
     *
     * @param  string $prefix
     * @param  array $options
     *
     * @return null
     */
    public function deleteResourcesByPrefix($prefix, $options = array())
    {
        return $this->getApi()->delete_resources_by_prefix($prefix, $options);
    }

    /**
     * Destroy all resources from Cloudinary
     *
     * @param  array $options
     *
     * @return null
     */
    public function deleteAllResources($options = array())
    {
        return $this->getApi()->delete_all_resources($options);
    }

    /**
     * Delete all resources from one tag
     *
     * @param  string $tag
     * @param  array $options
     *
     * @return null
     */
    public function deleteResourcesByTag($tag, $options = array())
    {
        return $this->getApi()->delete_resources_by_tag($tag, $options);
    }

    /**
     * Delete transformed images by IDs
     *
     * @param  array $publicIds
     * @param  array $options
     *
     * @return null
     */
    public function deleteDerivedResources($publicIds = array(), $options = array())
    {
        return $this->getApi()->delete_derived_resources($publicIds, $options);
    }

    /**
     * Create a zip file containing images matching options.
     *
     * @param array $options
     * @param string $nameArchive
     * @param string $mode
     *
     * @return mixed
     */
    public function createArchive($options = array(), $nameArchive = null, $mode = 'create')
    {
        $options = array_merge($options, ['target_public_id' => $nameArchive, 'mode' => $mode]);

        return $this->getUploader()->create_archive($options);
    }

    /**
     * Download a zip file containing images matching options.
     *
     * @param array $options
     * @param string $nameArchive
     *
     * @return string
     */
    public function downloadArchiveUrl($options = array(), $nameArchive = null)
    {
        $options = array_merge($options, ['target_public_id' => $nameArchive]);

        return $this->getCloudinary()->download_archive_url($options);
    }

    /**
     * Get usage details
     *
     * @param  array $options
     *
     * @return array
     */
    public function usage($options = array())
    {
        return $this->getApi()->usage($options);
    }

    /**
     * Ping cloudinary servers
     *
     * @param  array $options
     *
     * @return array
     */
    public function ping($options = array())
    {
        return $this->getApi()->ping($options);
    }
}