@method('PUT')
<div class="row ps-4 pe-4">

    <div class="col-md-12 mt-3">
        <div class="row">
            <label for="project_name"
                class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ localize('project_name') }}<span
                    class="text-danger">*</span></label>
            <div class="col-sm-9 col-md-12 col-xl-9">
                <input type="text" class="form-control" readonly
                    placeholder="{{ localize('project_name') }}" value="{{ old('project_name') ?? $project_info->project_name }}"
                    required>
            </div>
        </div>
    </div>

    <div class="col-md-12 mt-3">
        <div class="row">
            <label for="summary"
                class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ localize('summary') }}<span
                    class="text-danger">*</span></label>
            <div class="col-sm-9 col-md-12 col-xl-9">
                <textarea  class="form-control" id="summary" name="summary" placeholder="{{ localize('summary') }}" rows ="3" required>{{ $task_data->summary }}</textarea>
            </div>

            @if ($errors->has('summary'))
                <div class="error text-danger m-2">{{ $errors->first('summary') }}</div>
            @endif
        </div>
    </div>

    <div class="col-md-12 mt-3">
        <div class="row">
            <label for="description"
                class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ localize('description') }}<span
                    class="text-danger">*</span></label>
            <div class="col-sm-9 col-md-12 col-xl-9">
                <textarea  class="form-control" id="description" name="description" placeholder="{{ localize('description') }}" rows ="3" required>{{ $task_data->description }}</textarea>
            </div>

            @if ($errors->has('description'))
                <div class="error text-danger m-2">{{ $errors->first('description') }}</div>
            @endif
        </div>
    </div>

    <div class="col-md-12 mt-3">
        <div class="row">
            <label for="attachment"
                class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ localize('attachment') }}</label>
            <div class="col-sm-9 col-md-12 col-xl-9">
                <input type="file" class="form-control" id="attachment" name="attachment"
                    placeholder="{{ localize('attachment') }}"
                    value="{{ old('attachment') }}">
                    @if($task_data->attachment)
                        <a href="{{ asset('storage/' . $task_data->attachment) }}" target="_blank">{{ localize('attachment') }}</a>
                    @endif
                </div>

            @if ($errors->has('attachment'))
                <div class="error text-danger m-2">{{ $errors->first('attachment') }}</div>
            @endif
        </div>
    </div>

    <div class="col-md-12 mt-3">
        <div class="row">
            <label for="reporter"
                class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ localize('reporter') }}</label>
            <div class="col-sm-9 col-md-12 col-xl-9">

                <select name="project_lead" id="reporter" class="form-control select-basic-single" disabled>
                    @foreach ($project_leads as $key => $project_lead)
                        <option value="{{ $key }}" {{ $key == $project_info->project_lead ? 'selected' : '' }} >{{ $project_lead }}
                        </option>
                    @endforeach
                </select>

            </div>

            @if ($errors->has('reporter'))
                <div class="error text-danger m-2">{{ $errors->first('reporter') }}</div>
            @endif
        </div>
    </div>

    <div class="col-md-12 mt-3">
        <div class="row">
            <label for="sprint"
                class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ localize('sprint') }}</label>
            <div class="col-sm-9 col-md-12 col-xl-9">

                <select name="sprint_id" id="sprint" class="form-control select-basic-single" placeholder=">{{ localize('select_sprint') }}" required>
                    @foreach ($available_sprints as $key => $available_sprint)
                        <option value="{{ $key }}" {{ $key == $task_data->sprint_id ? 'selected' : '' }} >{{ $available_sprint }}
                        </option>
                    @endforeach
                </select>

            </div>

            @if ($errors->has('sprint'))
                <div class="error text-danger m-2">{{ $errors->first('sprint') }}</div>
            @endif
        </div>
    </div>

    <div class="col-md-12 mt-3">
        <div class="row">
            <label for="priority"
                class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ localize('priority') }}<span
                    class="text-danger">*</span></label>
            <div class="col-sm-9 col-md-12 col-xl-9">

                <select name="priority" id="priority" class="form-control select-basic-single" placeholder=">{{ localize('select_priority') }}" required>
                    <option value="">{{ localize('priority') }}</option>
                    <option value="2" {{ 2 == $task_data->priority ? 'selected' : '' }} >{{ localize('high') }}</option>
                    <option value="1" {{ 1 == $task_data->priority ? 'selected' : '' }} >{{ localize('low') }}</option>
                    <option value="0" {{ 0 == $task_data->priority ? 'selected' : '' }} >{{ localize('medium') }}</option>
                </select>

            </div>

            @if ($errors->has('priority'))
                <div class="error text-danger m-2">{{ $errors->first('priority') }}</div>
            @endif
        </div>
    </div> 

    <div class="col-md-12 mt-3">
        <div class="row">
            <label for="task_status"
                class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ localize('task_status') }}<span
                    class="text-danger">*</span></label>
            <div class="col-sm-9 col-md-12 col-xl-9">

                <select name="task_status" id="task_status" class="form-control select-basic-single" placeholder=">{{ localize('select_task_status') }}" required>
                    <option value="">{{ localize('task_status') }}</option>
                    <option value="3" {{ 3 == $task_data->task_status ? 'selected' : '' }} >{{ localize('done') }}</option>
                    <option value="2" {{ 2 == $task_data->task_status ? 'selected' : '' }} >{{ localize('in_progress') }}</option>
                    <option value="1" {{ 1 == $task_data->task_status ? 'selected' : '' }} >{{ localize('to_do') }}</option>
                </select>

            </div>

            @if ($errors->has('task_status'))
                <div class="error text-danger m-2">{{ $errors->first('task_status') }}</div>
            @endif
        </div>
    </div> 


</div>
