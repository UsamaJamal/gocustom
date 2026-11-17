{{-- Admin (Hostinger inbox) notification for every quote form: plain table, blue labels on the left.
     The customer gets the branded emails/customer_quote.blade.php instead. --}}
@php
    $value = function ($key) use ($data) {
        $v = $data[$key] ?? null;
        return ($v === null || trim((string) $v) === '') ? 'N/A' : $v;
    };

    if (!empty($data['quote_file_path'])) {
        $fileText = 'Attached' . (!empty($data['quote_file_name']) ? ': ' . $data['quote_file_name'] : '');
    } else {
        $fileText = 'No file uploaded';
    }

    $pageUrl = $data['source_page'] ?? '';
    $pageUrlIsLink = (bool) preg_match('#^https?://#i', (string) $pageUrl);

    // [label, value, always shown?] in the order of the original admin email.
    // Rows marked false only appear when the form actually sent that field.
    $rows = [
        ['Product Name', $data['product_name'] ?? $value('box_style'), true],
        ['Client Name', $value('name'), true],
        ['Client Email', $value('email'), true],
        ['Client Phone', $value('phone'), true],
        ['Company', $value('company_name'), false],
        ['Website', $value('website'), false],
        ['Address', $value('physical_address'), true],
        ['Length', $value('length'), true],
        ['Width', $value('width'), true],
        ['Height', $value('depth'), true],
        ['Unit', $value('units'), true],
        ['Material', $value('material'), false],
        ['Stock', $value('paper_stock'), true],
        ['Color', $value('color'), true],
        ['Coating', $value('paper_coating'), true],
        ['CAD Sample', $value('cad_sample'), true],
        ['Turn Around Time', $value('turn_around_time'), false],
        ['Qty', $value('quantity'), true],
        ['File', $fileText, true],
        ['Message', $value('message'), true],
        ['Source', $value('source_form'), true],
    ];

    // The product page sample-kit form has no file upload, so it gets no File row.
    if (($data['source_form'] ?? '') === 'Product Page - Bottom Form') {
        $rows = array_values(array_filter($rows, function ($row) {
            return $row[0] !== 'File';
        }));
    }

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
                    @foreach($rows as [$label, $text, $show])
                        @if($show || $text !== 'N/A')
                        <tr>
                            <th align="left" style="{{ $th }}">{{ $label }}:</th>
                            <td style="{{ $td }}{{ $label === 'Message' ? ' white-space:pre-line;' : '' }}">{{ $text }}</td>
                        </tr>
                        @endif
                    @endforeach
                    <tr>
                        <th align="left" style="{{ $th }}">Page URL:</th>
                        <td style="{{ $td }}">
                            @if($pageUrlIsLink)
                                <a href="{{ $pageUrl }}" style="color:#1a73e8; text-decoration:underline; word-break:break-all;">{{ $pageUrl }}</a>
                            @else
                                {{ $pageUrl !== '' ? $pageUrl : 'N/A' }}
                            @endif
                        </td>
                    </tr>
                    @if(!empty($data['quote_ref']))
                    <tr>
                        <th align="left" style="{{ $th }}">Quote Ref:</th>
                        <td style="{{ $td }}">{{ $data['quote_ref'] }}</td>
                    </tr>
                    @endif
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
