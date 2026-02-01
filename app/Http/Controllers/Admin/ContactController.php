<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Contact status options
     */
    protected $statuses = [
        'new' => 'Baru',
        'read' => 'Dibaca',
        'replied' => 'Dibalas',
        'archived' => 'Diarsipkan',
    ];

    /**
     * Display a listing of contacts.
     */
    public function index(Request $request)
    {
        $query = Contact::with('repliedBy');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter trashed
        if ($request->filled('trashed')) {
            if ($request->trashed === 'only') {
                $query->onlyTrashed();
            } elseif ($request->trashed === 'with') {
                $query->withTrashed();
            }
        }

        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        // Get statistics
        $stats = [
            'total' => Contact::count(),
            'new' => Contact::where('status', 'new')->count(),
            'read' => Contact::where('status', 'read')->count(),
            'replied' => Contact::where('status', 'replied')->count(),
            'archived' => Contact::where('status', 'archived')->count(),
            'trashed' => Contact::onlyTrashed()->count(),
        ];

        $statuses = $this->statuses;
        $contacts = $query->paginate(15)->withQueryString();

        return view('admin.contacts.index', compact('contacts', 'stats', 'statuses'));
    }

    /**
     * Display the specified contact.
     */
    public function show(Contact $contact)
    {
        // Mark as read if new
        if ($contact->status === 'new') {
            $contact->update(['status' => 'read']);
        }

        $contact->load('repliedBy');
        $statuses = $this->statuses;

        return view('admin.contacts.show', compact('contact', 'statuses'));
    }

    /**
     * Show the reply form for the specified contact.
     */
    public function replyForm(Contact $contact)
    {
        return view('admin.contacts.reply', compact('contact'));
    }

    /**
     * Store a reply to the specified contact.
     */
    public function reply(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'reply' => 'required|string|min:10',
            'send_email' => 'boolean',
        ]);

        $contact->update([
            'reply' => $validated['reply'],
            'replied_at' => now(),
            'replied_by' => Auth::id(),
            'status' => 'replied',
        ]);

        // Send email if requested
        if ($request->boolean('send_email')) {
            try {
                Mail::raw($validated['reply'], function ($message) use ($contact) {
                    $message->to($contact->email, $contact->name)
                        ->subject('Re: ' . $contact->subject);
                });
            } catch (\Exception $e) {
                return redirect()->route('admin.contacts.show', $contact)
                    ->with('warning', 'Balasan tersimpan, tetapi email gagal dikirim: ' . $e->getMessage());
            }
        }

        return redirect()->route('admin.contacts.show', $contact)
            ->with('success', 'Balasan berhasil disimpan' . ($request->boolean('send_email') ? ' dan dikirim via email.' : '.'));
    }

    /**
     * Update the status of the specified contact.
     */
    public function updateStatus(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:new,read,replied,archived',
        ]);

        $contact->update(['status' => $validated['status']]);

        return back()->with('success', 'Status berhasil diperbarui.');
    }

    /**
     * Soft delete the specified contact.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('admin.contacts.index')
            ->with('success', 'Pesan kontak berhasil dihapus.');
    }

    /**
     * Restore a soft-deleted contact.
     */
    public function restore($id)
    {
        $contact = Contact::onlyTrashed()->findOrFail($id);
        $contact->restore();

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Pesan kontak berhasil dipulihkan.');
    }

    /**
     * Permanently delete the specified contact.
     */
    public function forceDelete($id)
    {
        $contact = Contact::onlyTrashed()->findOrFail($id);
        $contact->forceDelete();

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Pesan kontak berhasil dihapus permanen.');
    }

    /**
     * Handle bulk actions.
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|string|in:delete,restore,force_delete,mark_read,mark_archived',
            'ids' => 'required|array',
            'ids.*' => 'integer',
        ]);

        $action = $request->action;
        $ids = $request->ids;
        $count = 0;

        switch ($action) {
            case 'delete':
                $count = Contact::whereIn('id', $ids)->delete();
                $message = "{$count} pesan kontak berhasil dihapus.";
                break;

            case 'restore':
                $count = Contact::onlyTrashed()->whereIn('id', $ids)->restore();
                $message = "{$count} pesan kontak berhasil dipulihkan.";
                break;

            case 'force_delete':
                $count = Contact::onlyTrashed()->whereIn('id', $ids)->forceDelete();
                $message = "{$count} pesan kontak berhasil dihapus permanen.";
                break;

            case 'mark_read':
                $count = Contact::whereIn('id', $ids)->update(['status' => 'read']);
                $message = "{$count} pesan kontak ditandai sebagai dibaca.";
                break;

            case 'mark_archived':
                $count = Contact::whereIn('id', $ids)->update(['status' => 'archived']);
                $message = "{$count} pesan kontak berhasil diarsipkan.";
                break;

            default:
                return back()->with('error', 'Aksi tidak valid.');
        }

        return back()->with('success', $message);
    }

    /**
     * Export contacts to CSV.
     */
    public function export(Request $request)
    {
        $query = Contact::query();

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $contacts = $query->orderBy('created_at', 'desc')->get();

        $filename = 'contacts_' . date('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($contacts) {
            $file = fopen('php://output', 'w');
            
            // Header row
            fputcsv($file, ['ID', 'Nama', 'Email', 'Telepon', 'Subjek', 'Pesan', 'Status', 'Tanggal']);
            
            // Data rows
            foreach ($contacts as $contact) {
                fputcsv($file, [
                    $contact->id,
                    $contact->name,
                    $contact->email,
                    $contact->phone,
                    $contact->subject,
                    $contact->message,
                    $contact->status,
                    $contact->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
