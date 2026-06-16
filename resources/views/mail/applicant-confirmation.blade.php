<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Application Received — Mills IP</title>
</head>
<body style="margin:0;padding:0;background:#f6f8fb;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#172033;">

<table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background:#f6f8fb;">
    <tr>
        <td align="center" style="padding:40px 20px;">

            <table width="600" cellpadding="0" cellspacing="0" role="presentation" style="max-width:600px;width:100%;">

                {{-- Header --}}
                <tr>
                    <td style="background:#172033;border-radius:8px 8px 0 0;padding:28px 36px;">
                        <p style="margin:0;font-size:20px;font-weight:800;color:#ffffff;letter-spacing:0;">Mills IP</p>
                        <p style="margin:6px 0 0;font-size:12px;color:rgba(255,255,255,0.55);font-weight:600;letter-spacing:0.08em;text-transform:uppercase;">Australian Trademark Attorneys</p>
                    </td>
                </tr>

                {{-- Body --}}
                <tr>
                    <td style="background:#ffffff;padding:40px 36px;">

                        {{-- Tick icon --}}
                        <table cellpadding="0" cellspacing="0" role="presentation" style="margin-bottom:24px;">
                            <tr>
                                <td style="background:#e7f6f1;border-radius:50%;width:56px;height:56px;text-align:center;vertical-align:middle;">
                                    <span style="font-size:24px;line-height:56px;">&#10003;</span>
                                </td>
                            </tr>
                        </table>

                        <h1 style="margin:0 0 14px;font-size:26px;font-weight:800;color:#172033;line-height:1.2;">
                            We have received your application, {{ $application->contact_name }}.
                        </h1>

                        <p style="margin:0 0 20px;font-size:16px;color:#5f6b7a;line-height:1.65;">
                            Thank you for submitting your trademark application to Mills IP. Our attorneys will review everything you have provided and get back to you with a fixed fee quote within <strong style="color:#172033;">one business day</strong>.
                        </p>

                        {{-- Promise box --}}
                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-bottom:28px;">
                            <tr>
                                <td style="background:#eef4f6;border-left:3px solid #1f5eff;border-radius:0 6px 6px 0;padding:16px 20px;">
                                    <p style="margin:0;font-size:14px;font-weight:700;color:#172033;">What happens next</p>
                                    <p style="margin:6px 0 0;font-size:14px;color:#5f6b7a;line-height:1.6;">A Mills IP attorney will review your application, assess any potential conflicts in the trademark register, and prepare a clear fixed fee quote. You will hear from us within one business day.</p>
                                </td>
                            </tr>
                        </table>

                        <p style="margin:0 0 8px;font-size:15px;color:#5f6b7a;line-height:1.6;">
                            Your application reference is <strong style="color:#172033;font-family:'Courier New',monospace;">#{{ $application->id }}</strong>.
                        </p>

                        <p style="margin:0 0 28px;font-size:15px;color:#5f6b7a;line-height:1.6;">
                            If you have any questions in the meantime, simply reply to this email and we will be in touch.
                        </p>

                        <p style="margin:0;font-size:15px;color:#172033;font-weight:600;">
                            The Mills IP Team
                        </p>

                    </td>
                </tr>

                {{-- Footer --}}
                <tr>
                    <td style="background:#f6f8fb;border-top:1px solid #dde5ee;border-radius:0 0 8px 8px;padding:20px 36px;">
                        <p style="margin:0;font-size:12px;color:#8a95a5;line-height:1.6;">
                            Mills IP Pty Ltd &middot; Australian Trademark Attorneys<br>
                            You are receiving this email because you submitted a trademark application through the Mills IP platform.
                        </p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>
