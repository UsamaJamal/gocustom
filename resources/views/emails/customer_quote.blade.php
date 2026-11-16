<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quote Request Confirmation</title>
</head>
<body style="margin:0; padding:1.25rem; background:#f4f7fb; font-family:Arial, sans-serif; color:#1f2937;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width:50rem; margin:0 auto; border-collapse:collapse; background:#ffffff; border:1px solid #d7e0ea; border-radius:0.5rem; overflow:hidden;">
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
                @php
                    $productName = $data['product_name'] ?? $data['box_style'] ?? 'Custom Packaging';
                @endphp
                <h2 style="margin:0 0 0.75rem; color:#0B2240; font-size:1.25rem;">
                    Thank you for your quote request, {{ $data['name'] ?? 'valued customer' }}!
                </h2>
                <p style="margin:0 0 0.75rem; color:#4b5563; font-size:0.925rem; line-height:1.6;">
                    We have successfully received your custom quote request for <strong>{{ $productName }}</strong>.
                </p>
                <p style="margin:0; color:#4b5563; font-size:0.925rem; line-height:1.6;">
                    Our packaging specialists are reviewing your specifications and will provide you with our official wholesale pricing and turnaround time shortly (usually within 1–2 business hours).
                </p>
            </td>
        </tr>

        <!-- Submission Summary Table -->
        <tr>
            <td style="padding:0 1.5rem 1.5rem;">
                <div style="background:#f1f5f9; border-left:4px solid #0B2240; padding:0.6rem 0.85rem; margin-bottom:1rem; border-radius:0 4px 4px 0;">
                    <span style="font-size:0.8rem; color:#64748b; text-transform:uppercase; font-weight:600; letter-spacing:0.5px;">Quote Reference Number:</span>
                    <strong style="font-size:1.05rem; color:#0B2240; margin-left:0.5rem; letter-spacing:0.5px;">{{ $quoteRef ?? ($data['quote_ref'] ?? 'N/A') }}</strong>
                </div>

                <h3 style="margin:0 0 0.75rem; color:#1e293b; font-size:0.95rem; text-transform:uppercase; letter-spacing:0.5px; border-bottom:2px solid #e2e8f0; padding-bottom:0.4rem;">
                    Your Requested Specifications
                </h3>
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse:collapse;">
                    @if(!empty($productName) && $productName !== 'N/A')
                    <tr>
                        <th align="left" style="width:30%; padding:0.6rem 0.75rem; background:#f8fafc; color:#475569; border:1px solid #e2e8f0; font-size:0.85rem;">Product / Style:</th>
                        <td style="padding:0.6rem 0.75rem; border:1px solid #e2e8f0; color:#1e293b; font-size:0.875rem; font-weight:600;">{{ $productName }}</td>
                    </tr>
                    @endif

                    @if(!empty($data['quantity']) && $data['quantity'] !== 'N/A')
                    <tr>
                        <th align="left" style="width:30%; padding:0.6rem 0.75rem; background:#f8fafc; color:#475569; border:1px solid #e2e8f0; font-size:0.85rem;">Quantity:</th>
                        <td style="padding:0.6rem 0.75rem; border:1px solid #e2e8f0; color:#1e293b; font-size:0.875rem; font-weight:600;">{{ $data['quantity'] }} units</td>
                    </tr>
                    @endif

                    @php
                        $dim = array_filter([
                            'L' => $data['length'] ?? null,
                            'W' => $data['width'] ?? null,
                            'D' => $data['depth'] ?? null,
                        ]);
                        $unit = $data['units'] ?? '';
                    @endphp
                    @if(!empty($dim))
                    <tr>
                        <th align="left" style="width:30%; padding:0.6rem 0.75rem; background:#f8fafc; color:#475569; border:1px solid #e2e8f0; font-size:0.85rem;">Dimensions (L × W × D):</th>
                        <td style="padding:0.6rem 0.75rem; border:1px solid #e2e8f0; color:#1e293b; font-size:0.875rem;">
                            {{ $data['length'] ?? '-' }} × {{ $data['width'] ?? '-' }} × {{ $data['depth'] ?? '-' }} {{ $unit }}
                        </td>
                    </tr>
                    @endif

                    @if(!empty($data['material']) && $data['material'] !== 'N/A')
                    <tr>
                        <th align="left" style="width:30%; padding:0.6rem 0.75rem; background:#f8fafc; color:#475569; border:1px solid #e2e8f0; font-size:0.85rem;">Material:</th>
                        <td style="padding:0.6rem 0.75rem; border:1px solid #e2e8f0; color:#1e293b; font-size:0.875rem;">{{ $data['material'] }}</td>
                    </tr>
                    @endif

                    @if(!empty($data['paper_stock']) && $data['paper_stock'] !== 'N/A')
                    <tr>
                        <th align="left" style="width:30%; padding:0.6rem 0.75rem; background:#f8fafc; color:#475569; border:1px solid #e2e8f0; font-size:0.85rem;">Stock:</th>
                        <td style="padding:0.6rem 0.75rem; border:1px solid #e2e8f0; color:#1e293b; font-size:0.875rem;">{{ $data['paper_stock'] }}</td>
                    </tr>
                    @endif

                    @if(!empty($data['color']) && $data['color'] !== 'N/A')
                    <tr>
                        <th align="left" style="width:30%; padding:0.6rem 0.75rem; background:#f8fafc; color:#475569; border:1px solid #e2e8f0; font-size:0.85rem;">Color / Printing:</th>
                        <td style="padding:0.6rem 0.75rem; border:1px solid #e2e8f0; color:#1e293b; font-size:0.875rem;">{{ $data['color'] }}</td>
                    </tr>
                    @endif

                    @if(!empty($data['paper_coating']) && $data['paper_coating'] !== 'N/A')
                    <tr>
                        <th align="left" style="width:30%; padding:0.6rem 0.75rem; background:#f8fafc; color:#475569; border:1px solid #e2e8f0; font-size:0.85rem;">Coating / Finish:</th>
                        <td style="padding:0.6rem 0.75rem; border:1px solid #e2e8f0; color:#1e293b; font-size:0.875rem;">{{ $data['paper_coating'] }}</td>
                    </tr>
                    @endif

                    @if(!empty($data['turn_around_time']) && $data['turn_around_time'] !== 'N/A')
                    <tr>
                        <th align="left" style="width:30%; padding:0.6rem 0.75rem; background:#f8fafc; color:#475569; border:1px solid #e2e8f0; font-size:0.85rem;">Turnaround Time:</th>
                        <td style="padding:0.6rem 0.75rem; border:1px solid #e2e8f0; color:#1e293b; font-size:0.875rem;">{{ $data['turn_around_time'] }}</td>
                    </tr>
                    @endif

                    @if(!empty($data['quote_file_name']) && $data['quote_file_name'] !== 'N/A')
                    <tr>
                        <th align="left" style="width:30%; padding:0.6rem 0.75rem; background:#f8fafc; color:#475569; border:1px solid #e2e8f0; font-size:0.85rem;">Artwork / File:</th>
                        <td style="padding:0.6rem 0.75rem; border:1px solid #e2e8f0; color:#1e293b; font-size:0.875rem;">{{ $data['quote_file_name'] }} (Uploaded)</td>
                    </tr>
                    @endif

                    @if(!empty($data['message']) && $data['message'] !== 'N/A')
                    <tr>
                        <th align="left" style="width:30%; padding:0.6rem 0.75rem; background:#f8fafc; color:#475569; border:1px solid #e2e8f0; font-size:0.85rem; vertical-align:top;">Your Instructions:</th>
                        <td style="padding:0.6rem 0.75rem; border:1px solid #e2e8f0; color:#1e293b; font-size:0.875rem; line-height:1.5; white-space:pre-line;">{{ $data['message'] }}</td>
                    </tr>
                    @endif
                </table>
            </td>
        </tr>

        <!-- Next Steps Banner -->
        <tr>
            <td style="padding:0 1.5rem 1.5rem;">
                <div style="background:#eff6ff; border-left:4px solid #3b82f6; padding:0.875rem 1rem; border-radius:0 0.375rem 0.375rem 0;">
                    <strong style="color:#1e40af; font-size:0.9rem; display:block; margin-bottom:0.25rem;">What happens next?</strong>
                    <span style="color:#1e3a8a; font-size:0.85rem; line-height:1.5;">
                        1. Our estimators calculate the best wholesale price based on your specs.<br>
                        2. A dedicated packaging specialist contacts you with a custom digital 2D/3D proof and full quote.<br>
                        3. Free shipping is automatically applied to all custom box orders across the USA!
                    </span>
                </div>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="padding:1.25rem 1.5rem; background:#f8fafc; border-top:1px solid #e2e8f0; font-size:0.825rem; color:#64748b; line-height:1.5;">
                <p style="margin:0 0 0.5rem; font-weight:600; color:#334155;">Have artwork updates or urgent questions?</p>
                <p style="margin:0 0 0.5rem;">
                    You can reply directly to this email or contact us at:
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
