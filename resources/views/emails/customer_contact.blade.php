<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form Confirmation</title>
</head>
<body style="margin:0; padding:1.25rem; background:#f4f7fb; font-family:Arial, sans-serif; color:#1f2937;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width:45rem; margin:0 auto; border-collapse:collapse; background:#ffffff; border:1px solid #d7e0ea; border-radius:0.5rem; overflow:hidden;">
        <!-- Header -->
        <tr>
            <td style="padding:1.5rem 1.25rem; background:#0B2240; text-align:center;">
                <h1 style="margin:0; color:#ffffff; font-size:1.4rem; font-weight:700; letter-spacing:0.5px;">Go Custom Boxes</h1>
                <p style="margin:0.35rem 0 0; color:#93c5fd; font-size:0.875rem;">Premium Custom Packaging Solutions</p>
            </td>
        </tr>

        <!-- Greeting -->
        <tr>
            <td style="padding:1.5rem 1.5rem 1rem;">
                <h2 style="margin:0 0 0.75rem; color:#0B2240; font-size:1.2rem;">Thank you for contacting us, {{ $data['name'] ?? 'valued customer' }}!</h2>
                <p style="margin:0; color:#4b5563; font-size:0.925rem; line-height:1.6;">
                    We have received your message and our customer support team is reviewing it. We will get back to you shortly (usually within 1–2 business hours).
                </p>
            </td>
        </tr>

        <!-- Submission Details -->
        <tr>
            <td style="padding:0 1.5rem 1.5rem;">
                <div style="background:#f1f5f9; border-left:4px solid #0B2240; padding:0.6rem 0.85rem; margin-bottom:1rem; border-radius:0 4px 4px 0;">
                    <span style="font-size:0.8rem; color:#64748b; text-transform:uppercase; font-weight:600; letter-spacing:0.5px;">Reference Number:</span>
                    <strong style="font-size:1.05rem; color:#0B2240; margin-left:0.5rem; letter-spacing:0.5px;">{{ $contactRef ?? ($data['contact_ref'] ?? 'N/A') }}</strong>
                </div>

                <h3 style="margin:0 0 0.75rem; color:#1e293b; font-size:0.95rem; text-transform:uppercase; letter-spacing:0.5px; border-bottom:2px solid #e2e8f0; padding-bottom:0.4rem;">
                    A Copy of Your Submitted Message
                </h3>
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse:collapse;">
                    @if(!empty($data['name']))
                    <tr>
                        <th align="left" style="width:30%; padding:0.6rem 0.75rem; background:#f8fafc; color:#475569; border:1px solid #e2e8f0; font-size:0.85rem;">Name:</th>
                        <td style="padding:0.6rem 0.75rem; border:1px solid #e2e8f0; color:#1e293b; font-size:0.875rem;">{{ $data['name'] }}</td>
                    </tr>
                    @endif

                    @if(!empty($data['email']))
                    <tr>
                        <th align="left" style="width:30%; padding:0.6rem 0.75rem; background:#f8fafc; color:#475569; border:1px solid #e2e8f0; font-size:0.85rem;">Email:</th>
                        <td style="padding:0.6rem 0.75rem; border:1px solid #e2e8f0; color:#1e293b; font-size:0.875rem;">{{ $data['email'] }}</td>
                    </tr>
                    @endif

                    @if(!empty($data['phone']))
                    <tr>
                        <th align="left" style="width:30%; padding:0.6rem 0.75rem; background:#f8fafc; color:#475569; border:1px solid #e2e8f0; font-size:0.85rem;">Phone:</th>
                        <td style="padding:0.6rem 0.75rem; border:1px solid #e2e8f0; color:#1e293b; font-size:0.875rem;">{{ $data['phone'] }}</td>
                    </tr>
                    @endif

                    @if(!empty($data['subject']))
                    <tr>
                        <th align="left" style="width:30%; padding:0.6rem 0.75rem; background:#f8fafc; color:#475569; border:1px solid #e2e8f0; font-size:0.85rem;">Subject:</th>
                        <td style="padding:0.6rem 0.75rem; border:1px solid #e2e8f0; color:#1e293b; font-size:0.875rem;">{{ $data['subject'] }}</td>
                    </tr>
                    @endif

                    @if(!empty($data['message']))
                    <tr>
                        <th align="left" style="width:30%; padding:0.6rem 0.75rem; background:#f8fafc; color:#475569; border:1px solid #e2e8f0; font-size:0.85rem; vertical-align:top;">Message:</th>
                        <td style="padding:0.6rem 0.75rem; border:1px solid #e2e8f0; color:#1e293b; font-size:0.875rem; line-height:1.5; white-space:pre-line;">{{ $data['message'] }}</td>
                    </tr>
                    @endif
                </table>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="padding:1.25rem 1.5rem; background:#f8fafc; border-top:1px solid #e2e8f0; font-size:0.825rem; color:#64748b; line-height:1.5;">
                <p style="margin:0 0 0.5rem; font-weight:600; color:#334155;">Need immediate assistance?</p>
                <p style="margin:0 0 0.5rem;">
                    You can reply directly to this email or reach us anytime at:
                    <br>
                    <strong>Email:</strong> <a href="mailto:{{ $supportEmail ?? 'support@gocustomboxes.com' }}" style="color:#2563eb; text-decoration:none;">{{ $supportEmail ?? 'support@gocustomboxes.com' }}</a>
                    &nbsp;|&nbsp;
                    <strong>Phone:</strong> <a href="tel:+18003158441" style="color:#2563eb; text-decoration:none;">+1-800-315-8441</a>
                </p>
                <p style="margin:0; font-size:0.75rem; color:#94a3b8;">
                    Go Custom Boxes &bull; 1941 Waverly way, Montgomery, IL 60538, US
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
