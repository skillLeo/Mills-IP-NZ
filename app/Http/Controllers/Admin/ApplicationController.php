<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\ApplicationHistory;
use App\Models\ApplicationNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    private array $validStatuses = ['Received', 'Reviewing', 'Quoted', 'Filed', 'Completed', 'On Hold', 'Rejected'];

    public function index(Request $request)
    {
        $query = Application::query()->orderBy('submitted_at', 'desc');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('contact_name', 'like', "%{$search}%")
                  ->orWhere('contact_email', 'like', "%{$search}%")
                  ->orWhere('trademark_description', 'like', "%{$search}%")
                  ->orWhere('legal_owner_name', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $applications = $query->paginate(20)->withQueryString();

        if ($request->ajax()) {
            return view('admin._applications-table', ['applications' => $applications]);
        }

        return view('admin.applications', [
            'applications' => $applications,
            'statuses'     => $this->validStatuses,
        ]);
    }

    public function destroy(int $id)
    {
        $application = Application::findOrFail($id);

        // Remove related records before deleting the application
        $application->notes()->delete();
        DB::table('application_history')->where('application_id', $id)->delete();
        $application->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.application.index')->with('success', 'Application #' . $id . ' deleted.');
    }

    public function show(int $id)
    {
        $application = Application::with(['notes.adminUser', 'history.adminUser'])->findOrFail($id);
        return view('admin.application-detail', [
            'application' => $application,
            'statuses'    => $this->validStatuses,
        ]);
    }

    public function serveLogo(int $id)
    {
        $application = Application::findOrFail($id);
        abort_if(!$application->logo_file_path, 404);
        abort_if(!Storage::disk('local')->exists($application->logo_file_path), 404);
        return Storage::disk('local')->response($application->logo_file_path);
    }

    public function updateStatus(Request $request, int $id)
    {
        $request->validate(['status' => 'required|in:' . implode(',', $this->validStatuses)]);

        $application = Application::findOrFail($id);
        $oldStatus   = $application->status;
        $newStatus   = $request->input('status');

        if ($oldStatus === $newStatus) {
            return back()->with('info', 'Status unchanged.');
        }

        $application->status = $newStatus;
        $application->save();

        ApplicationHistory::create([
            'application_id' => $application->id,
            'admin_user_id'  => Auth::guard('admin')->id(),
            'action'         => 'Status changed',
            'old_value'      => $oldStatus,
            'new_value'      => $newStatus,
        ]);

        return back()->with('success', "Status updated to {$newStatus}.");
    }

    public function addNote(Request $request, int $id)
    {
        $request->validate(['note_text' => 'required|string|max:5000']);

        $application = Application::findOrFail($id);

        ApplicationNote::create([
            'application_id' => $application->id,
            'admin_user_id'  => Auth::guard('admin')->id(),
            'note_text'      => $request->input('note_text'),
        ]);

        ApplicationHistory::create([
            'application_id' => $application->id,
            'admin_user_id'  => Auth::guard('admin')->id(),
            'action'         => 'Note added',
            'old_value'      => null,
            'new_value'      => null,
        ]);

        return back()->with('success', 'Note saved.');
    }
}
