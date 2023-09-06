<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

if (! function_exists('responseSuccessData')) {
    function responseSuccessData($data, string $message = 'Success', int $status = 200)
    {
        return response()->json([
            'statusType' => true,
            'status'     => $status,
            'message'    => $message,
            'data'       => $data,
        ], $status);
    }
}

if (! function_exists('responseSuccessMessage')) {
    function responseSuccessMessage(string $message = 'Success', int $status = 200)
    {
        return response()->json([
            'statusType' => true,
            'status'     => $status,
            'message'    => $message,
        ], $status);
    }
}

if (! function_exists('responseErrorMessage')) {
    function responseErrorMessage($error, int $status = 400)
    {
        return response()->json([
            'statusType' => false,
            'status'     => $status,
            'error'      => $error,
        ], $status);
    }
}

if (! function_exists('uploadImage ')) {
    function uploadImage($image, $path)
    {
        $image_name = date('Y-m-d') . '_' . Str::random(10) . '.' . $image->extension();
        $image_name  = Storage::putFileAs($path, $image, $image_name);

        return $image_name;
    }
}

if (! function_exists('deleteImage ')) {
    function deleteImage($path)
    {
        if (File::exists($path)) {
            File::delete($path);
        }
    }
}

// if (! function_exists('getIamgesMediaUrl')) {
//     function getIamgesMediaUrl($images, $conversions = '')
//     {
//         $gallery = [];
//         foreach ($images as $image) {
//             $gallery[] = [
//                 'id'  => $image->id,
//                 'url' => $image->getUrl($conversions),
//             ];
//         }

//         return $gallery;
//     }
// }