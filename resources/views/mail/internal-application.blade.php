<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>New Trademark Application</title>
</head>
<body style="margin:0;padding:0;background:#f6f8fb;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#172033;">

<table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background:#f6f8fb;">
    <tr>
        <td align="center" style="padding:40px 20px;">

            <table width="600" cellpadding="0" cellspacing="0" role="presentation" style="max-width:600px;width:100%;">

                {{-- Header --}}
                <tr>
                    <td style="background:#172033;border-radius:8px 8px 0 0;padding:28px 36px;">
                        <p style="margin:0;font-size:20px;font-weight:800;color:#ffffff;letter-spacing:0;">Mills IP NZ</p>
                        <p style="margin:6px 0 0;font-size:12px;color:rgba(255,255,255,0.55);font-weight:600;letter-spacing:0.08em;text-transform:uppercase;">Internal Application Notification</p>
                    </td>
                </tr>

                {{-- Alert banner --}}
                <tr>
                    <td style="background:#0a7c6e;padding:14px 36px;">
                        <p style="margin:0;font-size:14px;font-weight:700;color:#ffffff;">
                            New trademark application received — {{ $application->submitted_at->format('j F Y, g:i A') }}
                        </p>
                    </td>
                </tr>

                {{-- Body --}}
                <tr>
                    <td style="background:#ffffff;padding:36px;">

                        <h1 style="margin:0 0 6px;font-size:22px;font-weight:800;color:#172033;">{{ $application->contact_name }}</h1>
                        <p style="margin:0 0 28px;font-size:14px;color:#5f6b7a;">Application #{{ $application->id }} &middot; Status: <strong style="color:#0f8f6a;">{{ $application->status }}</strong></p>

                        {{-- Step 1 --}}
                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-bottom:24px;">
                            <tr>
                                <td style="border-left:3px solid #0a7c6e;padding:0 0 0 14px;">
                                    <p style="margin:0 0 6px;font-size:11px;font-weight:800;color:#8a95a5;letter-spacing:0.08em;text-transform:uppercase;">Step 1 — Trademark Description</p>
                                    <p style="margin:0;font-size:15px;color:#172033;line-height:1.6;">{{ $application->trademark_description }}</p>
                                </td>
                            </tr>
                        </table>

                        @if($application->logo_file_path)
                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-bottom:24px;">
                            <tr>
                                <td style="background:#eef4f6;border-radius:6px;padding:12px 16px;">
                                    <p style="margin:0;font-size:13px;color:#5f6b7a;font-weight:600;">
                                        &#128206; Logo attached to this email
                                    </p>
                                </td>
                            </tr>
                        </table>
                        @endif

                        {{-- Step 2 --}}
                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-bottom:24px;">
                            <tr>
                                <td style="border-left:3px solid #0a7c6e;padding:0 0 0 14px;">
                                    <p style="margin:0 0 6px;font-size:11px;font-weight:800;color:#8a95a5;letter-spacing:0.08em;text-transform:uppercase;">Step 2 — Business Description</p>
                                    <p style="margin:0;font-size:15px;color:#172033;line-height:1.6;">{{ $application->business_description }}</p>
                                </td>
                            </tr>
                        </table>

                        {{-- Step 3 --}}
                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-bottom:24px;">
                            <tr>
                                <td style="border-left:3px solid #0a7c6e;padding:0 0 0 14px;">
                                    <p style="margin:0 0 8px;font-size:11px;font-weight:800;color:#8a95a5;letter-spacing:0.08em;text-transform:uppercase;">Step 3 — Legal Owner</p>
                                    <p style="margin:0 0 4px;font-size:15px;font-weight:700;color:#172033;">{{ $application->legal_owner_name }}</p>
                                    <p style="margin:0 0 4px;font-size:13px;color:#5f6b7a;">Type: {{ ucfirst($application->legal_owner_type) }}</p>
                                    @if($application->abn)
                                        <p style="margin:0;font-size:13px;color:#5f6b7a;">NZBN: {{ $application->abn }}</p>
                                    @endif
                                </td>
                            </tr>
                        </table>

                        {{-- Step 4 --}}
                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-bottom:24px;">
                            <tr>
                                <td style="border-left:3px solid #0a7c6e;padding:0 0 0 14px;">
                                    <p style="margin:0 0 8px;font-size:11px;font-weight:800;color:#8a95a5;letter-spacing:0.08em;text-transform:uppercase;">Step 4 — Contact Details</p>
                                    <p style="margin:0 0 4px;font-size:15px;font-weight:700;color:#172033;">{{ $application->contact_name }}</p>
                                    <p style="margin:0 0 4px;font-size:13px;color:#5f6b7a;">
                                        <a href="mailto:{{ $application->contact_email }}" style="color:#0a7c6e;text-decoration:none;">{{ $application->contact_email }}</a>
                                    </p>
                                    <p style="margin:0;font-size:13px;color:#5f6b7a;">{{ $application->contact_phone }}</p>
                                </td>
                            </tr>
                        </table>

                        @if($application->additional_notes)
                        {{-- Step 5 --}}
                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-bottom:24px;">
                            <tr>
                                <td style="border-left:3px solid #0a7c6e;padding:0 0 0 14px;">
                                    <p style="margin:0 0 6px;font-size:11px;font-weight:800;color:#8a95a5;letter-spacing:0.08em;text-transform:uppercase;">Step 5 — Additional Notes</p>
                                    <p style="margin:0;font-size:15px;color:#172033;line-height:1.6;">{{ $application->additional_notes }}</p>
                                </td>
                            </tr>
                        </table>
                        @endif

                        {{-- Action reminder --}}
                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                            <tr>
                                <td style="background:#eef4f6;border-radius:6px;padding:16px 20px;">
                                    <p style="margin:0;font-size:14px;font-weight:700;color:#172033;">Respond with a fixed fee quote within one business day.</p>
                                    <p style="margin:4px 0 0;font-size:13px;color:#5f6b7a;">Reply directly to {{ $application->contact_email }}</p>
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>

                {{-- Footer --}}
                <tr>
                    <td style="background:#f6f8fb;border-top:1px solid #dde5ee;border-radius:0 0 8px 8px;padding:20px 36px;">
                        <p style="margin:0;font-size:12px;color:#8a95a5;">
                            Mills IP NZ Ltd &middot; New Zealand Trademark Attorneys &middot; This is an internal notification only.
                        </p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>
