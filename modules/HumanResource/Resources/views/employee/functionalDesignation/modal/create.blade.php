<!-- Modal -->
<div class="modal fade" id="create-functional-designation" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">
                    {{ localize('new_functional_designation') }}
                </h5>
            </div>
            <form class="validateForm" action="{{ route('functionalDesignation.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">

                        <div class="form-group mb-2 mx-0 row">
                            <label for="functional_designation"
                                   class="col-lg-3 col-form-label ps-0 label_position_name">
                                {{ localize('functional_designation') }}
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-9">
                                <input type="text" required name="functional_designation" id="functional_designation"
                                       placeholder="{{ localize('functional_designation') }}" class="form-control"
                                       autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group mb-2 mx-0 row">
                            <label for="designation_short" class="col-lg-3 col-form-label ps-0 label_position_short">
                                {{ localize('designation_short') }}
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-9">
                                <input type="text" required name="designation_short" id="designation_short"
                                       placeholder="{{ localize('designation_short') }}" class="form-control"
                                       autocomplete="off">
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
                            <label for="designation_details"
                                   class="col-lg-3 col-form-label ps-0 label_designation_details">
                                {{ localize('designation_details') }}
                                <span class="text-danger">*</span>
                            </label>

                            <div class="col-lg-9">
                                <input type="text" required name="designation_details" id="designation_details"
                                       value="" placeholder="{{ localize('designation_details') }}"
                                       class="form-control  " aria-describedby="emailHelp" autocomplete="off">
                            </div>
                        </div>

                        @radio(['input_name' => 'status', 'data_set' => [1 => 'Active', 0 => 'Inactive'], 'value' => 1,
                        'required' => 'true'])</div>
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
