<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    // Simpan review
    public function store(Request $request)
    {
        // LOGGING untuk debugging
        Log::info('=== REVIEW STORE CALLED ===', [
            'all_data' => $request->all(),
            'is_authenticated' => Auth::guard('customer')->check(),
            'customer_id' => Auth::guard('customer')->id(),
        ]);

        // Cek autentikasi
        if (!Auth::guard('customer')->check()) {
            Log::warning('User not authenticated');
            return back()->with('error', 'Silakan login terlebih dahulu');
        }

        try {
            // Validasi
            $validated = $request->validate([
                'transaksi_id' => 'required|exists:transaksi,id',
                'produk_id' => 'required|exists:produk,id',
                'rating' => 'required|integer|min:1|max:5',
                'review' => 'required|string|min:10|max:1000',
            ]);

            Log::info('Validation passed', $validated);

            $customer = Auth::guard('customer')->user();

            // STEP 1: Ambil transaksi dulu
            $transaksi = Transaksi::find($validated['transaksi_id']);

            // Log detail transaksi
            Log::info('=== TRANSAKSI DETAILS ===', [
                'found' => $transaksi ? true : false,
                'id' => $transaksi ? $transaksi->id : null,
                'customer_id' => $transaksi ? $transaksi->customer_id : null,
                'customer_id_match' => $transaksi ? ($transaksi->customer_id == $customer->id) : false,
                'status_pengiriman' => $transaksi ? $transaksi->status_pengiriman : null,
                'status_pengiriman_length' => $transaksi ? strlen($transaksi->status_pengiriman) : null,
                'status_pengiriman_trim' => $transaksi ? trim($transaksi->status_pengiriman) : null,
                'status_pengiriman_lower' => $transaksi ? strtolower(trim($transaksi->status_pengiriman)) : null,
                'is_selesai_exact' => $transaksi ? ($transaksi->status_pengiriman === 'selesai') : null,
                'is_selesai_lower' => $transaksi ? (strtolower(trim($transaksi->status_pengiriman)) === 'selesai') : null,
            ]);

            if (!$transaksi) {
                Log::error('Transaksi not found in database', ['id' => $validated['transaksi_id']]);
                return back()->with('error', 'Transaksi tidak ditemukan di database');
            }

            // STEP 2: Cek kepemilikan
            if ($transaksi->customer_id != $customer->id) {
                Log::warning('Customer mismatch', [
                    'transaksi_customer_id' => $transaksi->customer_id,
                    'logged_customer_id' => $customer->id
                ]);
                return back()->with('error', 'Transaksi ini bukan milik Anda');
            }

            // STEP 3: Cek status (case-insensitive dan trim whitespace)
            $status = strtolower(trim($transaksi->status_pengiriman));
            if ($status !== 'selesai') {
                Log::warning('Transaksi not completed', [
                    'status_raw' => $transaksi->status_pengiriman,
                    'status_processed' => $status
                ]);
                return back()->with('error', 'Pesanan belum selesai. Status saat ini: ' . $transaksi->status_pengiriman);
            }

            // Cek apakah produk ada di transaksi
            $detailExists = DetailTransaksi::where('transaksi_id', $validated['transaksi_id'])
                ->where('produk_id', $validated['produk_id'])
                ->exists();

            Log::info('Product in transaction check', [
                'exists' => $detailExists,
                'transaksi_id' => $validated['transaksi_id'],
                'produk_id' => $validated['produk_id']
            ]);

            if (!$detailExists) {
                Log::warning('Product not in transaction');
                return back()->with('error', 'Produk tidak ditemukan dalam transaksi ini');
            }

            // Cek apakah sudah pernah review
            $existingReview = Review::where('transaksi_id', $validated['transaksi_id'])
                ->where('produk_id', $validated['produk_id'])
                ->where('customer_id', $customer->id)
                ->first();

            if ($existingReview) {
                Log::warning('Review already exists', ['review_id' => $existingReview->id]);
                return back()->with('error', 'Anda sudah memberikan review untuk produk ini');
            }

            // Simpan review
            $review = Review::create([
                'transaksi_id' => $validated['transaksi_id'],
                'produk_id' => $validated['produk_id'],
                'customer_id' => $customer->id,
                'rating' => $validated['rating'],
                'review' => $validated['review'],
            ]);

            Log::info('Review created successfully', ['review_id' => $review->id]);

            return back()->with('success', 'Review berhasil dikirim. Terima kasih!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error', [
                'errors' => $e->errors(),
                'message' => $e->getMessage()
            ]);
            return back()->withErrors($e->errors())->withInput();

        } catch (\Exception $e) {
            Log::error('Error creating review', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Tampilkan form review untuk produk tertentu dari transaksi
    public function create($transaksiId)
    {
        if (!Auth::guard('customer')->check()) {
            return redirect()->route('customer.login')
                ->with('error', 'Silakan login terlebih dahulu');
        }

        $customer = Auth::guard('customer')->user();

        $transaksi = Transaksi::with('details.produk')
            ->where('id', $transaksiId)
            ->where('customer_id', $customer->id)
            ->whereRaw('LOWER(TRIM(status_pengiriman)) = ?', ['selesai'])
            ->firstOrFail();

        $details = $transaksi->details;
        $reviewedProducts = Review::where('transaksi_id', $transaksiId)
            ->where('customer_id', $customer->id)
            ->pluck('produk_id')
            ->toArray();

        $unreviewedProducts = $details->filter(function($detail) use ($reviewedProducts) {
            return !in_array($detail->produk_id, $reviewedProducts);
        });

        if ($unreviewedProducts->isEmpty()) {
            return redirect()->route('customer.orders')
                ->with('info', 'Semua produk sudah direview');
        }

        return view('frontend.review.create', compact('transaksi', 'unreviewedProducts'));
    }

    // Tampilkan daftar review customer
    public function index()
    {
        if (!Auth::guard('customer')->check()) {
            return redirect()->route('customer.login')
                ->with('error', 'Silakan login terlebih dahulu');
        }

        $customer = Auth::guard('customer')->user();

        $reviews = Review::with('produk', 'transaksi')
            ->where('customer_id', $customer->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('frontend.review.index', compact('reviews'));
    }
}