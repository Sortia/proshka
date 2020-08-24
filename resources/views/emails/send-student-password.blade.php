{{-- You can change this template using File > Settings > Editor > File and Code Templates > Code > Laravel Ideal Markdown Mail --}}
@component('mail::message')
# @lang('Hello!')

Ваш пароль для входа: {{$password}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
