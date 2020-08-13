@switch($questionUser->question->type)
    @case('select')
    @foreach($questionUser->question->answers as $answer)
        <div class="form-row align-items-center answer">
            <div class="col-auto">
                <div class="form-check mb-2">
                    <input style="pointer-events: none" @if($answer->id === $questionUser->answer_id) checked
                           @endif class="form-check-input answer_right"
                           type="radio"
                           name="card_radio_{{$questionUser->question_id}}">
                    <label class="form-check-label"></label>
                </div>
            </div>
            <div class="col">
                <input disabled type="text" class="form-control mb-2 answer_text
                    @if($answer->id === $questionUser->answer_id and !$answer->is_right) is-invalid @endif
                    @if($answer->is_right) is-valid @endif"
                       value="{{$answer->text}}">
            </div>
        </div>
    @endforeach
    @break

    @case('text')
        <div class="answer">{{$questionUser->text}}</div>
        @break
@endswitch

    <div class="files">
        @foreach($questionUser->studentFiles as $file)
            <a href="{{route('file.show', $file)}}">{{$file->name}}</a><br>
        @endforeach
    </div>
