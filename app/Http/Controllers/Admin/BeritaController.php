<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    public function index() {
        $beritas = Berita::all();
        return view('admin.berita.index', compact('beritas'));
    }
    public function create() {
        return view('admin.berita.create');
    }
    public function store(Request $request) {
        $request->validate([
            'judul' => 'required',
            'konten' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $imageName = 'berita_' . time() . '_' . uniqid() . '.' . $file->extension();
            $file->move(public_path('uploads/berita'), $imageName);
            $thumbnailPath = 'berita/' . $imageName;
        }

        Berita::create([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'thumbnail' => $thumbnailPath,
            'konten' => $request->konten,
            'kategori' => $request->kategori,
            'status' => $request->status ?? 'draft',
            'penulis_id' => auth()->id() ?? 1,
            'tanggal_publish' => $request->status === 'published' ? now() : null,
        ]);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan');
    }

    public function edit(Berita $beritum) {
        return view('admin.berita.edit', compact('beritum'));
    }

    public function update(Request $request, Berita $beritum) {
        $request->validate([
            'judul' => 'required',
            'konten' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $thumbnailPath = $beritum->thumbnail;

        if ($request->hasFile('thumbnail')) {
            // Hapus gambar lama jika ada
            if (!empty($beritum->thumbnail)) {
                $oldPath = public_path('uploads/' . $beritum->thumbnail);
                if (\Illuminate\Support\Facades\File::exists($oldPath)) {
                    \Illuminate\Support\Facades\File::delete($oldPath);
                }
            }

            $file = $request->file('thumbnail');
            $imageName = 'berita_' . time() . '_' . uniqid() . '.' . $file->extension();
            $file->move(public_path('uploads/berita'), $imageName);
            $thumbnailPath = 'berita/' . $imageName;
        }

        $beritum->update([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'thumbnail' => $thumbnailPath,
            'konten' => $request->konten,
            'kategori' => $request->kategori,
            'status' => $request->status,
            'tanggal_publish' => $request->status === 'published' ? ($beritum->tanggal_publish ?? now()) : null,
        ]);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui');
    }

    public function destroy(Berita $beritum) {
        if (!empty($beritum->thumbnail)) {
            $oldPath = public_path('uploads/' . $beritum->thumbnail);
            if (\Illuminate\Support\Facades\File::exists($oldPath)) {
                \Illuminate\Support\Facades\File::delete($oldPath);
            }
        }

        $beritum->delete();
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus');
    }
}
