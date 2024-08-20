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
        $certificates = Certificate::when($search, function ($query, $search) {
            return $query->where('name_certificate', 'like', "%{$search}%");
        })->paginate(10);

        // Pass the message if no certificates are found
        $message = $certificates->isEmpty() ? 'គ្មានទិន្ន័យសលាកបត្រ.' : null;

        return view('layouts.admin.forms.certificate.certificate-index', compact('certificates', 'message'));
    }

    public function create()
    {
        return view('layouts.admin.forms.certificate.certificate-create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(['name_certificate' => 'required|string']);
        Certificate::create($validated);
        return redirect()->route('certificate.index')->with('success', 'Certificate created successfully.');
    }
    public function show($id)
    {
        $certificate = Certificate::findOrFail($id);
        return view('certificate.show', compact('certificate'));
    }

    public function edit($id)
    {
        $certificate = Certificate::findOrFail($id);
        return view('certificate.edit', compact('certificate'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate(['name_certificate' => 'required']);
        $certificate = Certificate::findOrFail($id);
        $certificate->update($validated);
        return redirect()->route('certificate.index')->with('success', 'Certificate updated successfully.');
    }

    public function destroy($id)
    {
        $certificate = Certificate::findOrFail($id);
        $certificate->delete();
        return redirect()->route('certificate.index')->with('success', 'Certificate deleted successfully.');
    }
}