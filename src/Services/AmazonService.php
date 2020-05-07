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

    public function uploadAvatar($image, $name , $extension)
    {
        $result = $this->s3->putObject([
            'Bucket' => 'eduardcherkashyn',
            'Key'    => 'music_school/avatars/'.$name,
            'Body'   => $image,
            'ContentType' => 'image/'.$extension,
            'ACL'    => 'public-read',

        ]);

        return $result;
    }

    public function deleteAvatar($keyname)
    {
         $key = str_replace('https://eduardcherkashyn.s3.eu-north-1.amazonaws.com/','',$keyname);
         $this->s3->deleteObject([
            'Bucket' => 'eduardcherkashyn',
            'Key'    => $key

         ]);
    }
}
