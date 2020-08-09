<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function respondSuccess()
    {
        return response('success', 200);
    }

    public function respondError($message)
    {
        return response($message, 500);
    }

    /**
     * Заполнение blade-шаблона значениями и возврашение в виде строки
     */
    protected function prepareLayout(string $view, array $data = []): string
    {
        return view($view, $data)->toHtml();
    }
}
