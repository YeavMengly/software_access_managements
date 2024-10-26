<?php

namespace App\Http\Controllers\Certificates;

use App\Http\Controllers\Controller;
use App\Models\Certificates\Certificate;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 25);
    
        // Get sort parameters with default values
        $sortField = $request->input('sort_field', 'name_certificate'); // Default sort field
        $sortDirection = $request->input('sort_direction', 'asc'); // Default sorting direction
    
        $certificates = Certificate::when($search, function ($query, $search) {
                return $query->where('name_certificate', 'like', "%{$search}%");
            })
            ->orderBy($sortField, $sortDirection) // Apply sorting
            ->paginate($perPage);
    
        return view('layouts.admin.forms.certificate.certificate-index', compact('certificates', 'sortField', 'sortDirection'));
    }
    
    
    public function create()
    {
        return view('layouts.admin.forms.certificate.certificate-create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_certificate' => 'required|string|unique:certificates,name_certificate',
        ], [
            'name_certificate.unique' => 'ឈ្មោះសលាកបត្របានប្រើរួចរាល់។', // Custom error message
        ]);
        Certificate::create($validated);
        return redirect()->route('certificate.index')->with('success', 'ឈ្មោះសលាកបត្របានដោយជោគជ័យ');
    }
    public function show($id)
    {
        $certificate = Certificate::findOrFail($id);
        return view('certificate.show', compact('certificate'));
    }

    public function edit($id)
    {
        $certificates = Certificate::findOrFail($id);
        return view('layouts.admin.forms.certificate.certificate-edit', compact('certificates'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate(['name_certificate' => 'required']);
        $certificates = Certificate::findOrFail($id);
        $certificates->update($validated);
        return redirect()->route('certificate.index')->with('success', 'ឈ្មោះសលាកបត្របានកែដោយជោគជ័យ');
    }

    public function destroy($id)
    {
        $certificate = Certificate::findOrFail($id);
        $certificate->delete();
        return redirect()->route('certificate.index')->with('success', 'ឈ្មោះសលាកបត្របានលុបដោយជោគជ័យ');
    }
}
