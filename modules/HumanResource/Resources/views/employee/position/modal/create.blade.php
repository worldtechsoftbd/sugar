<!-- Modal -->
<div class="modal fade" id="create-position" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">
                    {{ localize('new_position') }}
                </h5>
            </div>
            <form class="validateForm" action="{{ route('positions.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">

                        <div class="form-group mb-2 mx-0 row">
                            <label for="position_name" class="col-lg-3 col-form-label ps-0 label_position_name">
                                {{ localize('position_name') }}
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-9">
                                <input type="text" required name="position_name" id="position_name"
                                    placeholder="{{ localize('position_name') }}" class="form-control"
                                    autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group mb-2 mx-0 row">
                            <label for="position_short" class="col-lg-3 col-form-label ps-0 label_position_short">
                                {{ localize('position_short') }}
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-9">
                                <input type="text" required name="position_short" id="position_short"
                                       placeholder="{{ localize('position_short') }}" class="form-control"
                                       autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group mb-2 mx-0 row">
                            <label for="OverTimeYN" class="col-lg-3 col-form-label ps-0 label_OverTimeYN">
                                {{ localize('overtimeyn') }}
                                <span class="text-danger">*</span>
                            </label>

                            <div class="col-sm-9 d-flex align-items-center">
                                @foreach(['true' => 'Yes', 'false' => 'No'] as $value => $label)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="OverTimeYN"
                                               id="OverTimeYN{{ $value }}" value="{{ $value }}">
                                        <label class="form-check-label" for="OverTimeYN{{ $value }}">
                                            {{ $label }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group mb-2 mx-0 row">
                            <label for="seniority_order" class="col-lg-3 col-form-label ps-0 label_seniority_order">
                                {{ localize('seniority_order') }}
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-9">
                                <input type="number" required name="seniority_order" id="seniority_order"
                                       placeholder="{{ localize('seniority_order') }}" class="form-control"
                                       autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group mb-2 mx-0 row">
                            <label for="position_details" class="col-lg-3 col-form-label ps-0 label_position_details">
                                {{ localize('position_details') }}
                                <span class="text-danger">*</span>
                            </label>

                            <div class="col-lg-9">
                                <input type="text" required name="position_details" id="position_details"
                                    value="" placeholder="{{ localize('position_details') }}"
                                    class="form-control  " aria-describedby="emailHelp" autocomplete="off">
                            </div>
                        </div>
                        @radio(['input_name' => 'is_active', 'data_set' => [1 => 'Active', 0 => 'Inactive'], 'value' => 1, 'required' => 'true'])
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger"
                        data-bs-dismiss="modal">{{ localize('close') }}</button>
                    <button class="btn btn-primary submit_button" id="create_submit">{{ localize('save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
