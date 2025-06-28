<x-table>
    <table id="table_id" class="table" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>@lang('lecturerEvaluation.staff_id')</th>
                <th>@lang('lecturerEvaluation.teacher_name')</th>
                <th>@lang('lecturerEvaluation.submitted_by')</th>
                <th>@lang('lecturerEvaluation.class')(@lang('lecturerEvaluation.section'))</th>
                <th>@lang('lecturerEvaluation.rating')</th>
                <th>@lang('lecturerEvaluation.comment')</th>
                <th>@lang('lecturerEvaluation.status')</th>
                <th>@lang('lecturerEvaluation.actions')</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lecturerEvaluations as $lecturerEvaluation)
                @if ($lecturerEvaluation->status == 1 && $approved_evaluation_button_enable == false)
                    <tr>
                        <td>{{ $lecturerEvaluation->staff->id }}</td>
                        <td>{{ $lecturerEvaluation->staff->full_name }}</td>
                        <td>
                            @if ($lecturerEvaluation->role_id == 2)
                                {{ $lecturerEvaluation->studentRecord->studentDetail->full_name }}(@lang('teacherEvaluation.student'))
                            @else
                                {{ $lecturerEvaluation->studentRecord->studentDetail->parents->fathers_name }}(@lang('teacherEvaluation.parent'))
                            @endif
                        </td>
                        <td>{{ $lecturerEvaluation->studentRecord->class->class_name }}({{ $lecturerEvaluation->studentRecord->section->section_name }})
                        </td>
                        <td>
                            <div class="star-rating">
                                <input type="radio"
                                    id="5-stars{{ $lecturerEvaluation->id }}"
                                    name="rating{{ $lecturerEvaluation->id }}" value="5"
                                    {{ $lecturerEvaluation->rating == 5 ? 'checked' : '' }}
                                    disabled />
                                <label for="5-stars{{ $lecturerEvaluation->id }}"
                                    class="star">&#9733;</label>
                                    
                                <input type="radio"
                                    id="4-stars{{ $lecturerEvaluation->id }}"
                                    name="rating{{ $lecturerEvaluation->id }}" value="4"
                                    {{ $lecturerEvaluation->rating == 4 ? 'checked' : '' }}
                                    disabled />
                                <label for="4-stars{{ $lecturerEvaluation->id }}"
                                    class="star">&#9733;</label>
                                    
                                <input type="radio"
                                    id="3-stars{{ $lecturerEvaluation->id }}"
                                    name="rating{{ $lecturerEvaluation->id }}" value="3"
                                    {{ $lecturerEvaluation->rating == 3 ? 'checked' : '' }}
                                    disabled />
                                <label for="3-stars{{ $lecturerEvaluation->id }}"
                                    class="star">&#9733;</label>
                                    
                                <input type="radio"
                                    id="2-stars{{ $lecturerEvaluation->id }}"
                                    name="rating{{ $lecturerEvaluation->id }}" value="2"
                                    {{ $lecturerEvaluation->rating == 2 ? 'checked' : '' }}
                                    disabled />
                                <label for="2-stars{{ $lecturerEvaluation->id }}"
                                    class="star">&#9733;</label>
                                    
                                <input type="radio"
                                    id="1-star{{ $lecturerEvaluation->id }}"
                                    name="rating{{ $lecturerEvaluation->id }}" value="1"
                                    {{ $lecturerEvaluation->rating == 1 ? 'checked' : '' }}
                                    disabled />
                                <label for="1-star{{ $lecturerEvaluation->id }}"
                                    class="star">&#9733;</label>
                            </div>
                        </td>
                        <td data-bs-toggle="tooltip" title="{{ $lecturerEvaluation->comment }}">
                            {{ $lecturerEvaluation->comment }}</td>
                        <td>
                            @if ($lecturerEvaluation->status == 0)
                                <button
                                    class="primary-btn small bg-danger text-white border-0">@lang('teacherEvaluation.pending')</button>
                            @else
                                <button
                                    class="primary-btn small bg-success text-white border-0">@lang('teacherEvaluation.approved')</button>
                            @endif
                        </td>
                        <td>
                            <a class="primary-btn small fix-gr-bg"
                                href="{{ route('teacher-evaluation-approve-delete', $lecturerEvaluation->id) }}"
                                style="padding: 0px 10px;!important"
                                data-bs-toggle="tooltip" title="Delete">&#x292C;</a>
                        </td>
                    </tr>
                @endif
                @if ($lecturerEvaluation->status == 0 && $approved_evaluation_button_enable == true)
                    <tr>
                        <td>{{ $lecturerEvaluation->staff->id }}</td>
                        <td>{{ $lecturerEvaluation->staff->full_name }}</td>
                        <td>
                            @if ($lecturerEvaluation->role_id == 2)
                                {{ $lecturerEvaluation->studentRecord->studentDetail->full_name }}(@lang('teacherEvaluation.student'))
                            @else
                                {{ $lecturerEvaluation->studentRecord->studentDetail->parents->fathers_name }}(@lang('teacherEvaluation.parent'))
                            @endif
                        </td>
                        <td>{{ $lecturerEvaluation->studentRecord->class->class_name }}({{ $lecturerEvaluation->studentRecord->section->section_name }})
                        </td>
                        <td>
                            <div class="star-rating">
                                <input type="radio"
                                    id="5-stars{{ $lecturerEvaluation->id }}"
                                    name="rating{{ $lecturerEvaluation->id }}" value="5"
                                    {{ $lecturerEvaluation->rating == 5 ? 'checked' : '' }}
                                    disabled />
                                <label for="5-stars{{ $lecturerEvaluation->id }}"
                                    class="star">&#9733;</label>
                                <input type="radio"
                                    id="4-stars{{ $lecturerEvaluation->id }}"
                                    name="rating{{ $lecturerEvaluation->id }}" value="4"
                                    {{ $lecturerEvaluation->rating == 4 ? 'checked' : '' }}
                                    disabled />
                                <label for="4-stars{{ $lecturerEvaluation->id }}"
                                    class="star">&#9733;</label>
                                <input type="radio"
                                    id="3-stars{{ $lecturerEvaluation->id }}"
                                    name="rating{{ $lecturerEvaluation->id }}" value="3"
                                    {{ $lecturerEvaluation->rating == 3 ? 'checked' : '' }}
                                    disabled />
                                <label for="3-stars{{ $lecturerEvaluation->id }}"
                                    class="star">&#9733;</label>
                                <input type="radio"
                                    id="2-stars{{ $lecturerEvaluation->id }}"
                                    name="rating{{ $lecturerEvaluation->id }}" value="2"
                                    {{ $lecturerEvaluation->rating == 2 ? 'checked' : '' }}
                                    disabled />
                                <label for="2-stars{{ $lecturerEvaluation->id }}"
                                    class="star">&#9733;</label>
                                <input type="radio"
                                    id="1-star{{ $lecturerEvaluation->id }}"
                                    name="rating{{ $lecturerEvaluation->id }}" value="1"
                                    {{ $lecturerEvaluation->rating == 1 ? 'checked' : '' }}
                                    disabled />
                                <label for="1-star{{ $lecturerEvaluation->id }}"
                                    class="star">&#9733;</label>
                            </div>
                        </td>
                        <td data-bs-toggle="tooltip" title="{{ $lecturerEvaluation->comment }}">
                            {{ $lecturerEvaluation->comment }}</td>
                        <td>
                            <button
                                class="primary-btn small bg-danger text-white border-0">@lang('teacherEvaluation.pending')</button>
                        </td>
                        <td>
                            <a class="primary-btn small fix-gr-bg"
                                href="{{ route('teacher-evaluation-approve-submit', $lecturerEvaluation->id) }}"
                                style="padding: 0px 10px;!important"
                                data-bs-toggle="tooltip" title="Approve">&#10003;</a>
                            <a class="primary-btn small fix-gr-bg"
                                href="{{ route('teacher-evaluation-approve-delete', $lecturerEvaluation->id) }}"
                                style="padding: 0px 10px;!important"
                                data-bs-toggle="tooltip" title="Delete">&#x292C;</a>
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</x-table>
