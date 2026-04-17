<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

use App\Models\User;
use App\Models\InventorySoftware;

class InventorySoftwareController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'inventory_id' => 'required',
            'software_id' => 'required',
            'product_key' => 'nullable',
            'remarks' => 'nullable',
            'date_installed' => 'required|date',
            'date_expired' => 'nullable|date',
        ]);

        $validated['installed_by'] = Auth::user()->name ?? 'System';
        if (!empty($validated['product_key'])) {
            $validated['product_key'] = strtoupper($validated['product_key']);
        }

        try {
            InventorySoftware::create($validated);
            return back()->with('success', 'Application added successfully!');
        } catch (Exception $e) {
            return back()->with('error', 'Error Occured When Adding a Software.');
        }
    }

    public function update(Request $request, $id)
    {
        $software = InventorySoftware::findOrFail($id);

        $validated = $request->validate([
            'software_id' => 'required',
            'product_key' => 'nullable',
            'remarks' => 'nullable',
            'date_installed' => 'required|date',
            'date_expired' => 'nullable|date',
        ]);

        $validated = array_map('strtoupper', $validated);

        $software->update($validated);

        return back()->with('success', 'Application Updated Successfully');
    }

    public function destroy($id)
    {
        $software = InventorySoftware::findOrFail($id);
        $software->delete();

        return back()->with('success', 'Application Deleted Successfully');
    }

    public function sendNotification()
    {
        $recipients = User::whereNotNull('email')->where('credential', 'ADMIN')->get();

        $software = InventorySoftware::with(['inventory.latestAccountability', 'software'])
            ->whereNotNull('date_expired')
            ->where(function ($query) {
                $query->where('date_expired', '<', now())->orWhereBetween('date_expired', [now(), now()->addDays(30)]);
            })
            ->orderBy('date_expired', 'asc')
            ->get();

        if ($recipients->isEmpty()) {
            return 'No recipients found.';
        }

        if ($software->isEmpty()) {
            return 'No expiring or expired software.';
        }

        foreach ($recipients as $ref) {
            Mail::send(
                'emails.test',
                [
                    'ref' => $ref,
                    'software' => $software,
                ],
                function ($message) use ($ref) {
                    $message->to($ref->email)->subject('Software Expiry Notification');
                },
            );
        }

        return 'Emails sent successfully!';

        // 👇 RETURN VIEW FOR PREVIEW (NOT EMAIL YET)
        // return view('emails.test', [
        //     'ref' => $recipients->first(), // just sample user
        //     'software' => $software,
        // ]);
    }
}
