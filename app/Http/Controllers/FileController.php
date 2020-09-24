<?php

namespace App\Http\Controllers;

use App\File;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FileController extends Controller
{
    /**
     * Возвращает файл на скачивание
     *
     * @param File $file
     * @return BinaryFileResponse
     */
    public function show(File $file)
    {
        return Response::download(storage_path('app/' . $file->path));
    }

    /**
     * Удаление файла. Только для методиста
     *
     * @param File $file
     * @return \Illuminate\Http\Response|RedirectResponse
     * @throws Exception
     */
    public function destroy(File $file)
    {
        try {
            Storage::delete($file->path);

            $file->delete();

        } catch (Exception $e) {
            return response($e->getMessage());
        }

        return $this->respondSuccess();
    }
}
