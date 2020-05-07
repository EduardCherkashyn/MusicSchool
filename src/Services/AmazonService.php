<?php
namespace App\Services;

use Aws\S3\S3Client;

class AmazonService
{
    private $s3;

    public function __construct($access_key, $private_key)
    {

        $this->s3 = new S3Client([
            'region'  => 'eu-north-1',
            'version' => 'latest',
            'credentials' => [
                'key'    => $access_key,
                'secret' => $private_key,
            ]
        ]);

    }

    public function upload(string $type, $image, $name , string $contentType)
    {
        $result = $this->s3->putObject([
            'Bucket' => 'eduardcherkashyn',
            'Key'    => 'music_school/'.$type.'/'.$name,
            'Body'   => $image,
            'ContentType' => $contentType,
            'ACL'    => 'public-read',

        ]);

        return $result;
    }

    public function delete($keyname)
    {
         $key = str_replace('https://eduardcherkashyn.s3.eu-north-1.amazonaws.com/','',$keyname);
         $this->s3->deleteObject([
            'Bucket' => 'eduardcherkashyn',
            'Key'    => $key

         ]);
    }
}
