@extends('backend.layouts.app')

@section('title', localize('Employees Salary'))
@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('payroll.name') !!}</p>
@endsection
