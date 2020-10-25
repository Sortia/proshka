<div class="answer-cover">
    <hr>
    <div class="row justify-content-center">
        <div class="answers col-xl-5 col-lg-6 col-md-8">
            @foreach($question->answers->sortBy('order_number') as $answer)
                <div class="form-row align-items-center answer">
                    <div class="col-auto">
                        <div class="form-check mb-2">
                            <input class="form-check-input answer_right large-checkbox"
                                   @if($question->user && $question->user->answer_id === $answer->id) checked @endif
                                   type="checkbox" data-answer_id="{{$answer->id}}">
                            <label class="form-check-label"></label>
                        </div>
                    </div>
                    <div class="col">
                        <input type="text" readonly class="form-control mb-2 answer_text" value="{{$answer->text}}">
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>
<hr>
