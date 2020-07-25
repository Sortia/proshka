<?php

namespace App\Http\Controllers;

use App\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function __construct()
    {
        $this->middleware('methodist');
    }

    public function destroy(File $file)
    {
        Storage::delete($file->path);

        $file->delete();

        return $this->respondSuccess();
    }
}
