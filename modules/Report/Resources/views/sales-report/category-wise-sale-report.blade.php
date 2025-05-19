@extends('backend.layouts.app')
@section('title', localize('category_wise_sales_report'))
@push('css')
    <link href="{{ module_asset('Report/css/report-pdf.css') }}" rel="stylesheet">
@endpush
@section('content')
    @include('backend.layouts.common.validation')
    @include('backend.layouts.common.message')
    @include('report::sales-report.sales-report-header')
    <div class="card mb-4 fixed-tab-body">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('category_wise_sales_report') }}</h6>
                </div>
                <div class="text-end">
                    <div class="actions">
                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne"> <i
                                class="fas fa-filter"></i> {{ localize('filter') }}</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <div id="flush-collapseOne" class="accordion-collapse collapse bg-white mb-4"
                                aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">

                                <div class="row">
                                    <div class="col-md-2 mb-4">
                                        <select id="product_id" class="select-basic-single" data-url="{{ $product_url }}">

                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-4">
                                        <select id="product_model" class="select-basic-single"
                                            data-url="{{ $product_url }}">

                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-4">
                                        <select id="brand_id" class="select-basic-single" data-url="{{ $brand_url }}">

                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-4">
                                        <select id="category_id" class="select-basic-single" data-url="{{ $category_url }}">

                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-4">
                                        <input type="text" class="form-control date-range" id="sale_date"
                                            autocomplete="off" placeholder="{{ localize('sale_date') }}">
                                    </div>
                                    <div class="col-md-2 mb-4 align-self-end">
                                        <button type="button" id="filter"
                                            class="btn btn-success">{{ localize('find') }}</button>
                                        <button type="button" id="search-reset"
                                            class="btn btn-danger">{{ localize('reset') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table_customize">
                {{ $dataTable->table([], true) }}
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="purchaseDetailsViewModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ localize('purchase_details') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-0" id="viewData">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger-soft me-2"
                        data-bs-dismiss="modal">{{ localize('close') }}</button>
                    <button class="btn btn-success me-2" onclick="printDetails()"><i
                            class="typcn typcn-printer me-1"></i>{{ localize('print') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script src="{{ module_asset('Report/js/category-wise-sale-report.js') }}"></script>
@endpush
