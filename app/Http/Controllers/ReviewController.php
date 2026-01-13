<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use Carbon\Carbon;

class ReviewController extends Controller
{
    // Tampilkan semua review (dengan produk dan customer terkait)
    public function index()
    {
        $reviews = Review::with(['produk', 'customer', 'transaksi'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('backend.v_reviews.index', compact('reviews'));
    }

    // Tampilkan detail review
    public function show($id)
    {
        $review = Review::with(['produk.kategori', 'customer', 'transaksi'])
            ->findOrFail($id);

        return view('backend.v_reviews.show', compact('review'));
    }

    // Balas review oleh admin
    public function reply(Request $request, $id)
    {
        $request->validate([
            'admin_reply' => 'required|string|max:1000',
        ]);

        $review = Review::findOrFail($id);

        // Update kolom balasan admin dan waktu balas
        $review->admin_reply = $request->admin_reply;
        $review->replied_at = Carbon::now();
        $review->save();

        return redirect()->route('backend.reviews.index')
            ->with('success', 'Balasan berhasil disimpan.');
    }

    // Hapus review
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->route('backend.reviews.index')
            ->with('success', 'Review berhasil dihapus.');
    }
}