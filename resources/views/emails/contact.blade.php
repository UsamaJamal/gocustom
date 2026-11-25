<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body style="margin:0; padding:1.25rem; background:#f4f7fb; font-family:Arial, sans-serif; color:#1f2937;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width:50rem; margin:0 auto; border-collapse:collapse;">
        <tr>
            <td style="padding:0 0 1.25rem; text-align:center; color:#3498DB; font-size:1.5rem; font-weight:700;">New Contact Form Submission</td>
        </tr>
        <tr>
            <td style="padding:0; background:#ffffff; border:1px solid #d7e0ea; border-radius:0.5rem; overflow:hidden;">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse:collapse;">
                    <tr>
                        <th align="left" style="width:30%; padding:0.75rem; background:#3498DB; color:#ffffff; border:1px solid #d7e0ea; font-size:0.875rem;">Client Name:</th>
                        <td style="padding:0.75rem; border:1px solid #d7e0ea; color:#333333; font-size:0.875rem;">{{ $data['name'] ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th align="left" style="width:30%; padding:0.75rem; background:#3498DB; color:#ffffff; border:1px solid #d7e0ea; font-size:0.875rem;">Client Email:</th>
                        <td style="padding:0.75rem; border:1px solid #d7e0ea; color:#333333; font-size:0.875rem;">{{ $data['email'] ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th align="left" style="width:30%; padding:0.75rem; background:#3498DB; color:#ffffff; border:1px solid #d7e0ea; font-size:0.875rem;">Client Phone:</th>
                        <td style="padding:0.75rem; border:1px solid #d7e0ea; color:#333333; font-size:0.875rem;">{{ $data['phone'] ?? 'N/A' }}</td>
                    </tr>
                    {{-- Subject is optional on the contact form; leave the row out when it's empty. --}}
                    @if(filled($data['subject'] ?? null))
                    <tr>
                        <th align="left" style="width:30%; padding:0.75rem; background:#3498DB; color:#ffffff; border:1px solid #d7e0ea; font-size:0.875rem;">Subject:</th>
                        <td style="padding:0.75rem; border:1px solid #d7e0ea; color:#333333; font-size:0.875rem;">{{ $data['subject'] }}</td>
                    </tr>
                    @endif
                    <tr>
                        <th align="left" style="width:30%; padding:0.75rem; background:#3498DB; color:#ffffff; border:1px solid #d7e0ea; font-size:0.875rem; vertical-align:top;">Message:</th>
                        <td style="padding:0.75rem; border:1px solid #d7e0ea; color:#333333; font-size:0.875rem; line-height:1.5; white-space:pre-line;">{{ $data['message'] ?? 'N/A' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
