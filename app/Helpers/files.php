<?php

use Illuminate\Support\Facades\Storage;

if (! function_exists('deleteFile')) {
    function deleteFile($path)
    {
        Storage::disk('public')->delete($path);
    }
}

if (! function_exists('uploadFile')) {
    function uploadFile($path, $file)
    {
        $url = Storage::disk('public')->put($path, $file);
        return url('/') . '/storage/' . $url;
    }
}
