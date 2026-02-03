<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Services\CacheService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    protected $cacheService;

    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    /**
     * Display contact page
     */
    public function index()
    {
        $settings = $this->cacheService->getHomepageSettings();
        
        return view('contact', compact('settings'));
    }

    /**
     * Store contact submission
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'subject.required' => 'Subjek harus diisi',
            'message.required' => 'Pesan harus diisi',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'subject' => $request->subject,
                'message' => $request->message,
                'status' => 'new',
                'ip_address' => $request->ip(),
            ]);

            return back()->with('success', 'Pesan Anda berhasil dikirim. Kami akan segera menghubungi Anda.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Terjadi kesalahan saat mengirim pesan. Silakan coba lagi.')
                ->withInput();
        }
    }
}
