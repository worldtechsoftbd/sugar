<?php

namespace Modules\Organization\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Organization\App\Models\Organization;

class OrganizationController extends Controller

{
    public function index()
    {
        $organizations = Organization::all();
        return view('organization::organization.index', compact('organizations'));
    }

    public function create(Organization $organization)
    {

        return view('organization::organization.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'org_name' => 'required|string|max:100',
            'description' => 'nullable|string|max:200',
            'address' => 'nullable|string|max:200',
            'phone_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'longitude' => 'nullable|numeric',
            'latitude' => 'nullable|numeric',
            'status' => 'required|integer',
        ]);

        Organization::create($request->all());

        return redirect()->route('organizations.index')
            ->with('success', 'Organization created successfully.');
    }

    public function show(Organization $organization)
    {
        return view('organization::organization.show', compact('organization'));
    }

    public function edit(Organization $organization)
    {
        return view('organization::organization.edit', compact('organization'));
    }

    public function update(Request $request, Organization $organization)
    {
        $request->validate([
            'org_name' => 'required|string|max:100',
            'description' => 'nullable|string|max:200',
            'address' => 'nullable|string|max:200',
            'phone_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'longitude' => 'nullable|numeric',
            'latitude' => 'nullable|numeric',
            'status' => 'required|integer',
        ]);

        $organization->update($request->all());

        return redirect()->route('organizations.index')
            ->with('success', 'Organization updated successfully.');
    }

    public function destroy(Organization $organization)
    {
        $organization->delete();

        return redirect()->route('organizations.index')
            ->with('success', 'Organization deleted successfully.');
    }
}
