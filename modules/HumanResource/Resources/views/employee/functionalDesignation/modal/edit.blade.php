<!-- Modal -->
<div class="modal fade" id="update-functional-designation-{{ $functionalDesignation->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">
                    {{ localize('edit_functional_designation') }}
                </h5>
            </div>
            <form id="leadForm" action="{{ route('functionalDesignation.update', $functionalDesignation->uuid) }}" method="POST"
                enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <div class="modal-body">
                    <div class="row">
                        @input(['input_name' => 'functional_designation', 'value' =>
                        $functionalDesignation->functional_designation, 'required' => 'true'])
                        @input(['input_name' => 'designation_short', 'value' => $functionalDesignation->designation_short, 'required'
                        => 'true'])
                        @input(['input_name' => 'seniority_order', 'value' => $functionalDesignation->seniority_order, 'required' =>
                        'true', 'type' => 'number', 'step' => "0.01"])
                        @input(['input_name' => 'designation_details', 'value' => $functionalDesignation->designation_details,
                        'required' => 'true'])
                        @radio(['input_name' => 'status', 'data_set' => [1 => 'Active', 0 => 'Inactive'], 'value' =>
                        $functionalDesignation->status, 'required' => 'true'])</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger"
                        data-bs-dismiss="modal">{{ localize('close') }}</button>
                    <button class="btn btn-primary" id="update_submit">{{ localize('save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
