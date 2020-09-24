<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function respondSuccess($message = 'success')
    {
        return response($message, 200);
    }

    public function respondError($message, $status = 500)
    {
        return response($message, $status);
    }

    /**
     * Заполнение blade-шаблона значениями и возврашение в виде строки
     */
    protected function prepareLayout(string $view, array $data = []): string
    {
        return view($view, $data)->toHtml();
    }
}
