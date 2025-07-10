<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Award;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AwardController extends Controller
{
    use AuthorizesRequests;

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'certificate' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
        $user = Auth::user();
        $path = $request->file('certificate')->store('awards/' . $user->id, 'public');
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('awards/' . $user->id . '/thumbnails', 'public');
        }
        $award = Award::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'file_path' => $path,
            'thumbnail_path' => $thumbnailPath,
        ]);
        return redirect()->route('portfolio.index')->with('success', 'Award uploaded successfully.');
    }

    public function destroy(Award $award)
    {
        $this->authorize('delete', $award);
        Storage::disk('public')->delete($award->file_path);
        if ($award->thumbnail_path) {
            Storage::disk('public')->delete($award->thumbnail_path);
        }
        $award->delete();
        return response()->json(['success' => true]);
    }
}
