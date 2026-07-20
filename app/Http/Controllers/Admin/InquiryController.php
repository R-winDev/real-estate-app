<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PropertyInquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index(Request $request)
    {
        $query = PropertyInquiry::with(['property', 'customer']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $inquiries = $query->latest()->paginate(15);

        return view('admin.inquiries.index', compact('inquiries'));
    }

    public function show(PropertyInquiry $inquiry)
    {
        $inquiry->load(['property', 'customer']);
        return view('admin.inquiries.show', compact('inquiry'));
    }

    public function updateStatus(Request $request, PropertyInquiry $inquiry)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,contacted,closed',
        ]);

        $inquiry->update($validated);

        return back()->with('success', 'وضعیت درخواست بروزرسانی شد');
    }

    public function destroy(PropertyInquiry $inquiry)
    {
        $inquiry->delete();

        return redirect()->route('admin.inquiries.index')->with('success', 'درخواست با موفقیت حذف شد');
    }
}
