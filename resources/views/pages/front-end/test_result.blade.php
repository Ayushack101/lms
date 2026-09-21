@extends('layouts.frontend')

@section('homeContent')

    <div class="container-fluid my-5 px-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card ">

                    <div class="card-header text-center">
                        <h4>Result:</h4>
                        <h4>{{ $test->test_name }}</h4>

                        @if($test->type === 'objective')
                            <h5>
                                Total: {{ $attempt->obtained_marks }} /
                                {{ $attempt->total_marks }}
                            </h5>
                        @else
                            @if(is_null($attempt->obtained_marks))
                                <h5 class="text-warning">
                                    Awaiting Teacher Evaluation
                                </h5>
                            @else
                                <h5>
                                    Total: {{ $attempt->obtained_marks }} /
                                    {{ $attempt->total_marks }}
                                </h5>
                            @endif
                        @endif
                    </div>


                    @foreach ($studentAnswers as $answer)

                                            @php
                        $question = $answer->question;
                                            @endphp

                                            <div class="card-body">

                                                <div class="d-flex justify-content-between">
                                                    <strong>
                                                        Q{{ $loop->iteration }}:
                                                        {{ $question->question }}
                                                    </strong>

                                                    <span>{{ $question->marks }}</span>
                                                </div>

                                                {{-- MCQ RESULT VIEW --}}
                                                @if($test->type === 'objective')

                                                    @foreach(['A', 'B', 'C', 'D'] as $option)

                                                        @php
                                $optionText = strtolower($option);
                                                        @endphp

                                                        <p>

                                                            {{ $option }}.
                                                            {{ $question->$optionText }}

                                                            {{-- Correct Answer --}}
                                                            @if($question->answer == $option)
                                                                <span class="text-success font-weight-bold"> ✔ </span>
                                                            @endif

                                                            {{-- Student Wrong Selection --}}
                                                            @if($answer->answer == $option && !$answer->is_correct)
                                                                <span class="text-danger font-weight-bold"> ❌ </span>
                                                            @endif

                                                        </p>

                                                    @endforeach

                                                    <div>
                                                        Obtained Marks:
                                                        {{ $answer->marks_obtained }}
                                                    </div>

                                                @else

                                                    {{-- Subjective --}}
                                                    <div class="mt-2">
                                                        <strong>Your Answer:</strong>
                                                        <p>{{ $answer->answer }}</p>

                                                        @if(!is_null($answer->marks_obtained))
                                                            <strong>Marks:</strong>
                                                            {{ $answer->marks_obtained }}
                                                        @else
                                                            <span class="text-warning">
                                                                Waiting for teacher evaluation
                                                            </span>
                                                        @endif
                                                    </div>

                                                @endif

                                            </div>

                    @endforeach
                    <div class="mx-3 my-3"><a href="{{ route('student.panel') }}"><button class="btn btn-primary">Back</button></a> </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>

    </script>

@endpush