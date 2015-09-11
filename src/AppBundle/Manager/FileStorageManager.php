<?php

namespace AppBundle\Manager;

use Aws\S3\MultipartUploader;
use Aws\S3\S3Client;

/**
 * Class FileStorageManager
 */
class FileStorageManager
{
    /**
     * @var \AmazonS3
     */
    protected $client;

    /**
     * @var string
     */
    protected $bucketName;

    /**
     * @var string
     */
    protected $bucketUrl;

    /**
     * @param S3Client $client
     * @param string $bucketName
     * @param string $bucketUrl
     */
    public function __construct(S3Client $client, $bucketName, $bucketUrl)
    {
        $this->client = $client;
        $this->bucketName = $bucketName;
        $this->bucketUrl = $bucketUrl;
    }

    /**
     * @param $filePath
     *
     * @return string
     */
    public function upload($filePath)
    {
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $fileName = sprintf('%d-%s.%s', time(), uniqid(), $extension);

        $uploader = new MultipartUploader($this->client, $filePath, [
            'bucket' => $this->bucketName,
            'key'    => $fileName,
        ]);

        $result = $uploader->upload();
        return $result['ObjectURL'];
    }
}
