<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Mail\ApplicantConfirmation;
use App\Mail\InternalApplicationNotification;
use App\Models\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ApplicationFormController extends Controller
{
    public function step1(Request $request): View
    {
        return view('form.step1', ['brand' => $request->query('brand', '')]);
    }

    public function processStep1(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'trademark_description' => ['required', 'string', 'min:5', 'max:2000'],
            'logo'                  => ['nullable', 'image', 'mimes:jpeg,png,gif,svg,webp', 'max:5120'],
        ]);

        $existingPath = session('application.step1.logo_file_path');

        if ($request->hasFile('logo')) {
            if ($existingPath && Storage::disk('local')->exists($existingPath)) {
                Storage::disk('local')->delete($existingPath);
            }
            $logoPath = $request->file('logo')->store('private/logos', 'local');
        } else {
            $logoPath = $existingPath;
        }

        session(['application.step1' => [
            'trademark_description' => $data['trademark_description'],
            'logo_file_path'        => $logoPath,
        ]]);

        return redirect()->route('apply.step2');
    }

    public function step2(): RedirectResponse|View
    {
        if (!session('application.step1')) {
            return redirect()->route('apply.step1');
        }
        return view('form.step2');
    }

    public function processStep2(Request $request): RedirectResponse
    {
        if (!session('application.step1')) {
            return redirect()->route('apply.step1');
        }

        $data = $request->validate([
            'business_description' => ['required', 'string', 'min:5', 'max:2000'],
        ]);

        session(['application.step2' => $data]);
        return redirect()->route('apply.step3');
    }

    public function step3(): RedirectResponse|View
    {
        if (!session('application.step2')) {
            return redirect()->route('apply.step1');
        }
        return view('form.step3');
    }

    public function processStep3(Request $request): RedirectResponse
    {
        if (!session('application.step2')) {
            return redirect()->route('apply.step1');
        }

        $data = $request->validate([
            'legal_owner_name' => ['required', 'string', 'max:255'],
            'legal_owner_type' => ['required', 'in:individual,company'],
            'abn'              => ['nullable', 'string', 'regex:/^[\d\s]+$/', 'max:20'],
        ]);

        session(['application.step3' => $data]);
        return redirect()->route('apply.step4');
    }

    public function step4(): RedirectResponse|View
    {
        if (!session('application.step3')) {
            return redirect()->route('apply.step1');
        }
        return view('form.step4');
    }

    public function processStep4(Request $request): RedirectResponse
    {
        if (!session('application.step3')) {
            return redirect()->route('apply.step1');
        }

        $data = $request->validate([
            'contact_name'  => ['required', 'string', 'max:255'],
            'contact_email' => ['required', 'email:rfc', 'max:255'],
            'contact_phone' => ['required', 'string', 'max:30'],
        ]);

        session(['application.step4' => $data]);
        return redirect()->route('apply.step5');
    }

    public function step5(): RedirectResponse|View
    {
        if (!session('application.step4')) {
            return redirect()->route('apply.step1');
        }
        return view('form.step5');
    }

    public function submit(Request $request): RedirectResponse
    {
        if (!session('application.step4')) {
            return redirect()->route('apply.step1');
        }

        $validated = $request->validate([
            'additional_notes' => ['nullable', 'string', 'max:3000'],
        ]);

        $step1 = session('application.step1');
        $step2 = session('application.step2');
        $step3 = session('application.step3');
        $step4 = session('application.step4');

        $application = Application::create([
            'trademark_description' => $step1['trademark_description'],
            'logo_file_path'        => $step1['logo_file_path'] ?? null,
            'business_description'  => $step2['business_description'],
            'legal_owner_name'      => $step3['legal_owner_name'],
            'legal_owner_type'      => $step3['legal_owner_type'],
            'abn'                   => $step3['abn'] ?? null,
            'contact_name'          => $step4['contact_name'],
            'contact_email'         => $step4['contact_email'],
            'contact_phone'         => $step4['contact_phone'],
            'additional_notes'      => $validated['additional_notes'] ?? null,
            'status'                => 'Received',
            'submitted_at'          => now(),
        ]);

        try {
            Mail::to(config('services.mills_ip_nz.notification_email'))
                ->send(new InternalApplicationNotification($application));

            Mail::to($application->contact_email)
                ->send(new ApplicantConfirmation($application));
        } catch (\Exception $e) {
            Log::error('Failed to send application emails', [
                'application_id' => $application->id,
                'error'          => $e->getMessage(),
            ]);
        }

        session()->forget(['application.step1', 'application.step2', 'application.step3', 'application.step4']);
        session([
            'application.confirmed'          => true,
            'application.confirmed_id'       => $application->id,
            'application.confirmed_trademark' => $application->trademark_description,
            'application.confirmed_name'     => $application->contact_name,
        ]);

        return redirect()->route('apply.confirm');
    }

    public function confirm(): RedirectResponse|View
    {
        if (!session('application.confirmed')) {
            return redirect()->route('search');
        }

        $applicationId = session('application.confirmed_id');
        $trademark     = session('application.confirmed_trademark');
        $contactName   = session('application.confirmed_name');

        session()->forget([
            'application.confirmed',
            'application.confirmed_id',
            'application.confirmed_trademark',
            'application.confirmed_name',
        ]);

        return view('public.confirm', compact('applicationId', 'trademark', 'contactName'));
    }
}
