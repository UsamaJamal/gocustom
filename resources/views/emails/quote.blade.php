{{-- Admin (Hostinger inbox) notification for every quote form: plain table, blue labels on the left.
     The customer gets the branded emails/customer_quote.blade.php instead. --}}
@php
    $field = fn ($key) => $data[$key] ?? null;

    $file = null;
    if (!empty($data['quote_file_path'])) {
        $file = 'Attached' . (!empty($data['quote_file_name']) ? ': ' . $data['quote_file_name'] : '');
    }

    $pageUrl = (string) ($data['source_page'] ?? '');
    $pageUrlIsLink = (bool) preg_match('#^https?://#i', $pageUrl);

    // [label, value] in the order of the original admin email. A row without a value is left out,
    // so a field the form doesn't have, or one the customer left empty, never shows up as "N/A".
    $rows = array_filter([
        ['Product Name', $data['product_name'] ?? $field('box_style')],
        ['Client Name', $field('name')],
        ['Client Email', $field('email')],
        ['Client Phone', $field('phone')],
        ['Company', $field('company_name')],
        ['Website', $field('website')],
        ['Address', $field('physical_address')],
        ['Length', $field('length')],
        ['Width', $field('width')],
        ['Height', $field('depth')],
        ['Unit', $field('units')],
        ['Material', $field('material')],
        ['Stock', $field('paper_stock')],
        ['Color', $field('color')],
        ['Coating', $field('paper_coating')],
        ['CAD Sample', $field('cad_sample')],
        ['Turn Around Time', $field('turn_around_time')],
        ['Qty', $field('quantity')],
        ['File', $file],
        ['Message', $field('message')],
        ['Source', $field('source_form')],
    ], fn ($row) => filled($row[1]));

    $th = 'width:35%; padding:10px 12px; background-color:#3498DB; color:#ffffff; border:1px solid #dddddd; font-family:Arial, sans-serif; font-size:13px; font-weight:bold; text-align:left; vertical-align:top;';
    $td = 'padding:10px 12px; background-color:#ffffff; color:#333333; border:1px solid #dddddd; font-family:Arial, sans-serif; font-size:13px; text-align:left; vertical-align:top;';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request a Quote</title>
</head>
<body style="margin:0; padding:20px; background-color:#f4f4f4; font-family:Arial, sans-serif;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width:600px; margin:0 auto; border-collapse:collapse; background-color:#ffffff;">
        <tr>
            <td style="padding:20px;">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse:collapse;">
                    @foreach($rows as [$label, $text])
                        <tr>
                            <th align="left" style="{{ $th }}">{{ $label }}:</th>
                            <td style="{{ $td }}{{ $label === 'Message' ? ' white-space:pre-line;' : '' }}">{{ $text }}</td>
                        </tr>
                    @endforeach
                    @if(filled($pageUrl))
                    <tr>
                        <th align="left" style="{{ $th }}">Page URL:</th>
                        <td style="{{ $td }}">
                            @if($pageUrlIsLink)
                                <a href="{{ $pageUrl }}" style="color:#1a73e8; text-decoration:underline; word-break:break-all;">{{ $pageUrl }}</a>
                            @else
                                {{ $pageUrl }}
                            @endif
                        </td>
                    </tr>
                    @endif
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
