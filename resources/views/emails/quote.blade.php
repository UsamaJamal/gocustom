<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="{{ asset('uploads/go-custom-boxes-favicon.png') }}" type="image/png">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
            max-width: 50rem;
            margin: 0 auto;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 0.75rem;
            text-align: left;
            font-size: 0.875rem;
        }
        th {
            background-color: #3498DB;
            color: #ffffff;
            width: 30%;
            font-weight: bold;
        }
        td {
            color: #333333;
            background-color: #ffffff;
        }
        body {
            background-color: #f9f9f9;
            padding: 1.25rem;
        }
    </style>
</head>
<body style="background-color: #f9f9f9; padding: 1.25rem;">
    <h2 style="text-align: center; color: #3498DB; font-family: Arial, sans-serif; margin-bottom: 1.25rem; font-size: 1.5rem;">Request a Quote</h2>
    <table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; max-width: 50rem; margin: 0 auto;">
        @php
            $productName = $data['product_name'] ?? $data['box_style'] ?? null;
        @endphp
        @if(!empty($productName) && $productName !== 'N/A')
        <tr>
            <th style="border: 1px solid #ddd; padding: 0.75rem; text-align: left; font-size: 0.875rem; background-color: #3498DB; color: #ffffff; width: 30%; font-weight: bold;">Product Name:</th>
            <td style="border: 1px solid #ddd; padding: 0.75rem; text-align: left; font-size: 0.875rem; color: #333333; background-color: #ffffff;">{{ $productName }}</td>
        </tr>
        @endif

        @if(!empty($data['name']) && $data['name'] !== 'N/A')
        <tr>
            <th style="border: 1px solid #ddd; padding: 0.75rem; text-align: left; font-size: 0.875rem; background-color: #3498DB; color: #ffffff; width: 30%; font-weight: bold;">Client Name:</th>
            <td style="border: 1px solid #ddd; padding: 0.75rem; text-align: left; font-size: 0.875rem; color: #333333; background-color: #ffffff;">{{ $data['name'] }}</td>
        </tr>
        @endif
        
        @if(!empty($data['email']) && $data['email'] !== 'N/A')
        <tr>
            <th style="border: 1px solid #ddd; padding: 0.75rem; text-align: left; font-size: 0.875rem; background-color: #3498DB; color: #ffffff; width: 30%; font-weight: bold;">Client Email:</th>
            <td style="border: 1px solid #ddd; padding: 0.75rem; text-align: left; font-size: 0.875rem; color: #333333; background-color: #ffffff;">{{ $data['email'] }}</td>
        </tr>
        @endif
        
        @if(!empty($data['phone']) && $data['phone'] !== 'N/A')
        <tr>
            <th style="border: 1px solid #ddd; padding: 0.75rem; text-align: left; font-size: 0.875rem; background-color: #3498DB; color: #ffffff; width: 30%; font-weight: bold;">Client Phone:</th>
            <td style="border: 1px solid #ddd; padding: 0.75rem; text-align: left; font-size: 0.875rem; color: #333333; background-color: #ffffff;">{{ $data['phone'] }}</td>
        </tr>
        @endif
        
        @if(!empty($data['company_name']) && $data['company_name'] !== 'N/A')
        <tr>
            <th style="border: 1px solid #ddd; padding: 0.75rem; text-align: left; font-size: 0.875rem; background-color: #3498DB; color: #ffffff; width: 30%; font-weight: bold;">Company:</th>
            <td style="border: 1px solid #ddd; padding: 0.75rem; text-align: left; font-size: 0.875rem; color: #333333; background-color: #ffffff;">{{ $data['company_name'] }}</td>
        </tr>
        @endif
        
        @if(!empty($data['website']) && $data['website'] !== 'N/A')
        <tr>
            <th style="border: 1px solid #ddd; padding: 0.75rem; text-align: left; font-size: 0.875rem; background-color: #3498DB; color: #ffffff; width: 30%; font-weight: bold;">Website:</th>
            <td style="border: 1px solid #ddd; padding: 0.75rem; text-align: left; font-size: 0.875rem; color: #333333; background-color: #ffffff;">{{ $data['website'] }}</td>
        </tr>
        @endif
        
        @if(!empty($data['physical_address']) && $data['physical_address'] !== 'N/A')
        <tr>
            <th style="border: 1px solid #ddd; padding: 0.75rem; text-align: left; font-size: 0.875rem; background-color: #3498DB; color: #ffffff; width: 30%; font-weight: bold;">Physical Address:</th>
            <td style="border: 1px solid #ddd; padding: 0.75rem; text-align: left; font-size: 0.875rem; color: #333333; background-color: #ffffff;">{{ $data['physical_address'] }}</td>
        </tr>
        @endif

        @if(!empty($data['length']) && $data['length'] !== 'N/A')
        <tr>
            <th style="border: 1px solid #ddd; padding: 0.75rem; text-align: left; font-size: 0.875rem; background-color: #3498DB; color: #ffffff; width: 30%; font-weight: bold;">Length:</th>
            <td style="border: 1px solid #ddd; padding: 0.75rem; text-align: left; font-size: 0.875rem; color: #333333; background-color: #ffffff;">{{ $data['length'] }}</td>
        </tr>
        @endif
        
        @if(!empty($data['width']) && $data['width'] !== 'N/A')
        <tr>
            <th style="border: 1px solid #ddd; padding: 0.75rem; text-align: left; font-size: 0.875rem; background-color: #3498DB; color: #ffffff; width: 30%; font-weight: bold;">Width:</th>
            <td style="border: 1px solid #ddd; padding: 0.75rem; text-align: left; font-size: 0.875rem; color: #333333; background-color: #ffffff;">{{ $data['width'] }}</td>
        </tr>
        @endif
        
        @if(!empty($data['depth']) && $data['depth'] !== 'N/A')
        <tr>
            <th style="border: 1px solid #ddd; padding: 0.75rem; text-align: left; font-size: 0.875rem; background-color: #3498DB; color: #ffffff; width: 30%; font-weight: bold;">Height:</th>
            <td style="border: 1px solid #ddd; padding: 0.75rem; text-align: left; font-size: 0.875rem; color: #333333; background-color: #ffffff;">{{ $data['depth'] }}</td>
        </tr>
        @endif
        
        @if(!empty($data['units']) && $data['units'] !== 'N/A')
        <tr>
            <th style="border: 1px solid #ddd; padding: 0.75rem; text-align: left; font-size: 0.875rem; background-color: #3498DB; color: #ffffff; width: 30%; font-weight: bold;">Unit:</th>
            <td style="border: 1px solid #ddd; padding: 0.75rem; text-align: left; font-size: 0.875rem; color: #333333; background-color: #ffffff;">{{ $data['units'] }}</td>
        </tr>
        @endif

        @if(!empty($data['material']) && $data['material'] !== 'N/A')
        <tr>
            <th style="border: 1px solid #ddd; padding: 0.75rem; text-align: left; font-size: 0.875rem; background-color: #3498DB; color: #ffffff; width: 30%; font-weight: bold;">Material:</th>
            <td style="border: 1px solid #ddd; padding: 0.75rem; text-align: left; font-size: 0.875rem; color: #333333; background-color: #ffffff;">{{ $data['material'] }}</td>
        </tr>
        @endif

        @if(!empty($data['paper_stock']) && $data['paper_stock'] !== 'N/A')
        <tr>
            <th style="border: 1px solid #ddd; padding: 0.75rem; text-align: left; font-size: 0.875rem; background-color: #3498DB; color: #ffffff; width: 30%; font-weight: bold;">Stock:</th>
            <td style="border: 1px solid #ddd; padding: 0.75rem; text-align: left; font-size: 0.875rem; color: #333333; background-color: #ffffff;">{{ $data['paper_stock'] }}</td>
        </tr>
        @endif
        
        @if(!empty($data['color']) && $data['color'] !== 'N/A')
        <tr>
            <th style="border: 1px solid #ddd; padding: 0.75rem; text-align: left; font-size: 0.875rem; background-color: #3498DB; color: #ffffff; width: 30%; font-weight: bold;">Color:</th>
            <td style="border: 1px solid #ddd; padding: 0.75rem; text-align: left; font-size: 0.875rem; color: #333333; background-color: #ffffff;">{{ $data['color'] }}</td>
        </tr>
        @endif
        
        @if(!empty($data['paper_coating']) && $data['paper_coating'] !== 'N/A')
        <tr>
            <th style="border: 1px solid #ddd; padding: 0.75rem; text-align: left; font-size: 0.875rem; background-color: #3498DB; color: #ffffff; width: 30%; font-weight: bold;">Coating:</th>
            <td style="border: 1px solid #ddd; padding: 0.75rem; text-align: left; font-size: 0.875rem; color: #333333; background-color: #ffffff;">{{ $data['paper_coating'] }}</td>
        </tr>
        @endif
        
        @if(isset($data['cad_sample']) && $data['cad_sample'] !== '' && $data['cad_sample'] !== 'N/A')
        <tr>
            <th style="border: 1px solid #ddd; padding: 0.75rem; text-align: left; font-size: 0.875rem; background-color: #3498DB; color: #ffffff; width: 30%; font-weight: bold;">CAD Sample:</th>
            <td style="border: 1px solid #ddd; padding: 0.75rem; text-align: left; font-size: 0.875rem; color: #333333; background-color: #ffffff;">{{ $data['cad_sample'] }}</td>
        </tr>
        @endif
        
        @if(!empty($data['turn_around_time']) && $data['turn_around_time'] !== 'N/A')
        <tr>
            <th style="border: 1px solid #ddd; padding: 0.75rem; text-align: left; font-size: 0.875rem; background-color: #3498DB; color: #ffffff; width: 30%; font-weight: bold;">Turn Around Time:</th>
            <td style="border: 1px solid #ddd; padding: 0.75rem; text-align: left; font-size: 0.875rem; color: #333333; background-color: #ffffff;">{{ $data['turn_around_time'] }}</td>
        </tr>
        @endif
        
        @if(!empty($data['quantity']) && $data['quantity'] !== 'N/A')
        <tr>
            <th style="border: 1px solid #ddd; padding: 0.75rem; text-align: left; font-size: 0.875rem; background-color: #3498DB; color: #ffffff; width: 30%; font-weight: bold;">Qty:</th>
            <td style="border: 1px solid #ddd; padding: 0.75rem; text-align: left; font-size: 0.875rem; color: #333333; background-color: #ffffff;">{{ $data['quantity'] }}</td>
        </tr>
        @endif

        {{-- The product page sample-kit form has no file upload. --}}
        @if(($data['source_form'] ?? '') !== 'Product Page - Bottom Form')
        <tr>
            <th style="border: 1px solid #ddd; padding: 0.75rem; text-align: left; font-size: 0.875rem; background-color: #3498DB; color: #ffffff; width: 30%; font-weight: bold;">File:</th>
            <td style="border: 1px solid #ddd; padding: 0.75rem; text-align: left; font-size: 0.875rem; color: #333333; background-color: #ffffff;">
                @if(!empty($data['quote_file_path']) && $data['quote_file_path'] !== 'N/A')
                    Attached{{ !empty($data['quote_file_name']) ? ': ' . $data['quote_file_name'] : '' }}
                @else
                    No file uploaded
                @endif
            </td>
        </tr>
        @endif
        
        @if(!empty($data['message']) && $data['message'] !== 'N/A')
        <tr>
            <th style="border: 1px solid #ddd; padding: 0.75rem; text-align: left; font-size: 0.875rem; background-color: #3498DB; color: #ffffff; width: 30%; font-weight: bold;">Message:</th>
            <td style="border: 1px solid #ddd; padding: 0.75rem; text-align: left; font-size: 0.875rem; color: #333333; background-color: #ffffff;">{{ $data['message'] }}</td>
        </tr>
        @endif

        @if(!empty($data['source_form']) || !empty($data['source_page']))
        <tr>
            <th style="border: 1px solid #ddd; padding: 0.75rem; text-align: left; font-size: 0.875rem; background-color: #3498DB; color: #ffffff; width: 30%; font-weight: bold;">Source:</th>
            <td style="border: 1px solid #ddd; padding: 0.75rem; text-align: left; font-size: 0.875rem; color: #333333; background-color: #ffffff;">
                @if(!empty($data['source_form']))
                    <strong>{{ $data['source_form'] }}</strong><br>
                @endif
                @if(!empty($data['source_page']))
                    {{ $data['source_page'] }}
                @endif
            </td>
        </tr>
        @endif
    </table>
</body>
</html>
