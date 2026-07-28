<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

use App\Models\AuditTrail;

class AuditTrailController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = AuditTrail::with('user')->when($search, function ($q) use ($search) {
            $q->where(function ($query) use ($search) {
                $query
                    ->where('model', 'like', "%{$search}%")
                    ->orWhere('created_at', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        });

        $history = $query->orderBy('id', 'desc')->paginate(10);

        // ✅ ADD THIS PART (compare old vs new)
        $history->getCollection()->transform(function ($audit) {
            $old = $audit->old_values ?? [];
            $new = $audit->new_values ?? [];

            $changes = [];

            $fields = collect(array_keys($old))->merge(array_keys($new))->unique();

            foreach ($fields as $field) {
                $oldValue = $old[$field] ?? null;
                $newValue = $new[$field] ?? null;

                // ✅ ONLY show real changes
                if ($oldValue != $newValue) {
                    $changes[] = [
                        'label' => ucwords(str_replace('_', ' ', $field)),
                        'old' => $oldValue ?? '-',
                        'new' => $newValue ?? '-',
                    ];
                }
            }

            // attach result
            $audit->changes = $changes;

            return $audit;
        });

        return view('maintenance.audittrail', compact('history', 'search'));
    }
}
