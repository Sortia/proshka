<?php

namespace App\Http\Services;

use App\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileService
{
    /**
     * @param Model$model
     * @param UploadedFile $file
     * @param string $path
     * @return mixed
     */
    public static function save($model, $file, $path)
    {
        return $model->files()->create([
            'path' => $file->store($path),
            'name' => $file->getClientOriginalName(),
        ]);
    }

    public function delete(File $file)
    {
        Storage::delete($file->path);

        $file->delete();
    }
}
