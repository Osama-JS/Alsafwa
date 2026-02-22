<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use App\Models\GalleryCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class GalleryImageController extends Controller
{
    public function index(Request $request)
    {
        // Stats
        $stats = [
            'total'     => GalleryImage::count(),
            'published' => GalleryImage::where('status', 'published')->count(),
            'draft'     => GalleryImage::where('status', 'draft')->count(),
        ];

        // Filtering
        $query = GalleryImage::with('category');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category_id')) {
            $query->where('gallery_category_id', $request->category_id);
        }

        $images     = $query->orderBy('order')->paginate(12);
        $categories = GalleryCategory::where('status', 1)->get();

        return view('admin.gallery.index', compact('images', 'stats', 'categories'));
    }

    public function create()
    {
        $categories = GalleryCategory::where('status', 1)->get();
        return view('admin.gallery.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'               => 'nullable|string|max:255',
            'gallery_category_id' => 'nullable|exists:gallery_categories,id',
            'image'               => 'required|image|max:5120',
            'status'              => 'required|in:published,draft',
            'order'               => 'nullable|integer',
        ]);

        $validated['image']      = $request->file('image')->store('gallery', 'public');
        $validated['created_by'] = Auth::id();

        GalleryImage::create($validated);

        return redirect()->route('admin.gallery.index')
            ->with('success', 'تم إضافة الصورة بنجاح');
    }

    /**
     * Show the Dropzone bulk-upload page.
     */
    public function bulkUpload()
    {
        $categories = GalleryCategory::where('status', 1)->get();
        return view('admin.gallery.bulk-upload', compact('categories'));
    }

    /**
     * Handle Dropzone AJAX file upload (one file per request).
     */
    public function uploadMultiple(Request $request)
    {
        $request->validate([
            'file'                => 'required|image|max:5120',
            'gallery_category_id' => 'nullable|exists:gallery_categories,id',
            'status'              => 'nullable|in:published,draft',
        ]);

        try {
            $path = $request->file('file')->store('gallery', 'public');

            $image = GalleryImage::create([
                'image'               => $path,
                'gallery_category_id' => $request->gallery_category_id,
                'status'              => $request->status ?? 'published',
                'created_by'          => Auth::id(),
                'order'               => 0,
            ]);

            return response()->json([
                'success' => true,
                'id'      => $image->id,
                'url'     => asset('storage/' . $path),
                'message' => 'تم رفع الصورة بنجاح',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء رفع الصورة: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function edit($id)
    {
        $image      = GalleryImage::findOrFail($id);
        $categories = GalleryCategory::where('status', 1)->get();
        return view('admin.gallery.edit', compact('image', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $image = GalleryImage::findOrFail($id);

        $validated = $request->validate([
            'title'               => 'nullable|string|max:255',
            'gallery_category_id' => 'nullable|exists:gallery_categories,id',
            'image'               => 'nullable|image|max:5120',
            'status'              => 'required|in:published,draft',
            'order'               => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            if ($image->image) {
                Storage::disk('public')->delete($image->image);
            }
            $validated['image'] = $request->file('image')->store('gallery', 'public');
        }

        $image->update($validated);

        return redirect()->route('admin.gallery.index')
            ->with('success', 'تم تحديث الصورة بنجاح');
    }

    public function destroy($id)
    {
        $image = GalleryImage::findOrFail($id);

        if ($image->image) {
            Storage::disk('public')->delete($image->image);
        }

        $image->delete();
        return redirect()->route('admin.gallery.index')
            ->with('success', 'تم حذف الصورة بنجاح');
    }
}

