<?php

use Illuminate\Support\Facades\Storage;

function passportUpload($file)
{
    $path = 'passport/';
    $fileName = strtolower(str_ireplace(' ', '', $file->getClientOriginalName()));
    $ext = $file->getClientOriginalExtension();
    $fileName = str_replace(",", "", str_ireplace('.' . $ext, '', $fileName)) . '_' . time() . '.' . $ext;
    Storage::disk('public')->put($path . $fileName, $file->get());
    return $fileName;
}

function passport($filename)
{
    return Storage::url('passport/' . $filename);
}
