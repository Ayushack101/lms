@extends('layouts.frontend')

@section('homeContent')

    <div class="container-fluid my-5 px-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header text-center">
                        <h4>Question Paper For {{ $test_assiged->class->class_name }}</h4>
                        <h5>{{ $test->test_name }}</h5>

                        <div class="d-flex justify-content-end">
                            {{-- Count total marks --}}
                            <h6>Max Marks: {{ $questions->sum('marks') }}</h6>
                        </div>
                    </div>
                    {{-- questions for objective --}}
                    <form action="{{ route('student.submit.test') }}" method="POST">
                        @csrf
                        <input type="hidden" name="test_template_id" value="{{ $test->id }}">
                        @if($test->type === 'objective')
                            @foreach ($questions as $question)
                                <div class="card-body">

                                    <div class="quest-section">
                                        <div class="d-flex justify-content-between"
                                            style="letter-spacing: .5px; font-size: 18px; font-weight: 500;">
                                            <p>
                                                <strong>Q{{ $loop->iteration }}:&nbsp;{{ $question->question }}</strong>
                                            </p>
                                            <span>{{ $question->marks }}</span>
                                        </div>
                                        <div class="px-4">
                                            <p>
                                                A. <input type="radio" name="answers[{{ $question->id }}]" value="A"><span
                                                    class="px-2">{{ $question->a }}</span>
                                            </p>
                                            <p>
                                                B. <input type="radio" name="answers[{{ $question->id }}]" value="B"><span
                                                    class="px-2">{{ $question->b }}</span>
                                            </p>
                                            <p>
                                                C. <input type="radio" name="answers[{{ $question->id }}]" value="C"><span
                                                    class="px-2">{{ $question->c }}</span>
                                            </p>
                                            <p>
                                                D. <input type="radio" name="answers[{{ $question->id }}]" value="D"><span
                                                    class="px-2">{{ $question->d }}</span>
                                            </p>
                                        </div>
                                    </div>

                                </div>
                            @endforeach

                        @else
                            {{-- questions for subjective --}}
                            @foreach ($questions as $question)
                                <div class="card-body">
                                    <div class="quest-section">
                                        <div class="d-flex justify-content-between"
                                            style="letter-spacing: .5px; font-size: 18px; font-weight: 500;">
                                            <p>
                                                <strong>Q{{ $loop->iteration }}:&nbsp;{{ $question->question }}</strong>
                                            </p>
                                            <span>{{ $question->marks }}</span>
                                        </div>
                                        <div><textarea name="answers[{{ $question->id }}]" rows="4" class="form-control">
                                                                                            </textarea></div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        <div class="text-center my-4">
                            <button type="submit" class="btn btn-success">
                                Submit Test
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#student-table').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "responsive": true,
            });
        });
    </script>

@endpush