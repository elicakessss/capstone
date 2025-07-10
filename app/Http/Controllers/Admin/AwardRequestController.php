<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AwardRequest;

class AwardRequestController extends Controller
{
    public function index()
    {
        $awardRequests = AwardRequest::with(['user', 'org', 'awardType'])->latest()->get();
        $awardTypes = [];
        return view('admin.awards.index', compact('awardRequests', 'awardTypes'));
    }
    public function show($id)
    {
        $request = AwardRequest::with(['user', 'org', 'awardType'])->findOrFail($id);
        return view('admin.awards.show', compact('request'));
    }
    public function approve($id)
    {
        $request = AwardRequest::findOrFail($id);
        $request->status = 'approved';
        $request->save();
        return back()->with('success', 'Award request approved.');
    }
    public function reject($id)
    {
        $request = AwardRequest::findOrFail($id);
        $request->status = 'rejected';
        $request->save();
        return back()->with('success', 'Award request rejected.');
    }
}
