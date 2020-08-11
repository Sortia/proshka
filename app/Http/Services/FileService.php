<?php

namespace App\Http\Services;

use App\File;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileService
{
    /**
     * Сохранение файла в файловую систему и БД
     *
     * @param Model $model - модель к которой относится файл
     * @param UploadedFile $file
     * @param string $path - папка для сохранения файла todo перенести в поле модели
     * @return mixed
     */
    public static function save($model, $file, $path)
    {
        return $model->files()->create([
            'path' => $file->store($path),
            'name' => $file->getClientOriginalName(),
        ]);
    }

    /**
     * Удаление файла и файловой системы и БД
     *
     * @param File $file
     * @throws Exception
     */
    public function delete(File $file)
    {
        Storage::delete($file->path);

        $file->delete();
    }
}
