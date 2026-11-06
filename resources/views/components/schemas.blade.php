@php
    $schemaSiteUrl = rtrim(url('/'), '/');
    $schemaIsHomepage = trim(request()->path(), '/') === '';
    $schemaPageUrl = $canonicalUrl ?? (
        $schemaIsHomepage
            ? $schemaSiteUrl . '/'
            : rtrim(url('/' . trim(request()->path(), '/')), '/') . '/'
    );
    $schemaLogo = asset('uploads/header-logo.svg');
    $schemaSettings = $siteSettings ?? [];

    $schemaImageUrl = function ($path) {
        if (empty($path)) {
            return null;
        }
        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }
        $path = ltrim($path, '/');
        if (\Illuminate\Support\Str::startsWith($path, ['storage/', 'images/', 'uploads/'])) {
            return asset($path);
        }
        return asset('uploads/' . $path);
    };

    $schemaProduct = isset($product) ? (array) $product : [];
    $schemaCategory = isset($category) ? (array) $category : [];
    $schemaBlog = isset($blog) ? (array) $blog : [];
    $schemaAuthor = isset($author) ? (array) $author : [];

    $schemaPageName = $title
        ?? ($schemaProduct['meta_title'] ?? $schemaProduct['title'] ?? null)
        ?? ($schemaCategory['meta_title'] ?? $schemaCategory['title'] ?? null)
        ?? ($schemaBlog['meta_title'] ?? $schemaBlog['title'] ?? null)
        ?? ($schemaAuthor['title'] ?? null)
        ?? (($settings ?? [])['meta_title'] ?? null)
        ?? ($schemaIsHomepage
            ? 'Go Custom Boxes'
            : ucwords(str_replace(['-', '/'], [' ', ' - '], trim(request()->path(), '/'))));

    $schemaPageDescription = $metaDescription
        ?? ($schemaProduct['meta_description'] ?? $schemaProduct['description'] ?? null)
        ?? ($schemaCategory['meta_description'] ?? $schemaCategory['description'] ?? null)
        ?? ($schemaBlog['meta_description'] ?? $schemaBlog['excerpt'] ?? null)
        ?? (($settings ?? [])['meta_description'] ?? null)
        ?? 'Custom printed boxes and premium packaging solutions designed for brands and products.';
    $schemaPageDescription = trim(strip_tags((string) $schemaPageDescription));

    // Shared business info
    $sameAsSocials = [
        'https://www.facebook.com/GoCustomBoxesUSA',
        'https://www.instagram.com/gocustomboxesusa/',
        'https://www.linkedin.com/company/go-custom-boxes-usa/',
        'https://www.youtube.com/@gocustomboxes7838',
        'https://www.pinterest.com/gocustomboxesusa/',
    ];

    $sharedAddress = [
        '@type' => 'PostalAddress',
        'streetAddress' => '1941 Waverly way',
        'addressLocality' => 'Montgomery',
        'addressRegion' => 'IL',
        'postalCode' => '60538',
        'addressCountry' => 'US',
    ];

    $customerSupportDept = [
        '@type' => 'Organization',
        'name' => 'Customer Support',
        'contactPoint' => [
            '@type' => 'ContactPoint',
            'telephone' => '+1-800-315-8441',
            'email' => 'support@gocustomboxes.com',
            'contactType' => 'Customer Service',
            'areaServed' => 'US',
            'availableLanguage' => 'English',
        ],
    ];

    // FAQs collection
    $schemaFaqs = [];
    if (!empty($faqs) && is_iterable($faqs)) {
        $schemaFaqs = $faqs;
    } elseif (!empty(($settings ?? [])['faqs'])) {
        $schemaFaqs = $settings['faqs'];
    }

    $schemaFaqEntities = collect($schemaFaqs)
        ->map(fn ($faq) => (array) $faq)
        ->filter(fn ($faq) => !empty(trim((string)($faq['question'] ?? ''))) && !empty(trim((string)($faq['answer'] ?? ''))))
        ->map(fn ($faq) => [
            '@type' => 'Question',
            'name' => trim(strip_tags((string)$faq['question'])),
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => trim(strip_tags((string)$faq['answer'])),
            ],
        ])
        ->values()
        ->all();

    // Check if Custom Schema is provided in Admin (or view variable)
    $schemaCustomRaw = $schemaProduct['schema']
        ?? $schemaCategory['schema']
        ?? $schemaBlog['schema']
        ?? (($settings ?? [])['schema'] ?? null)
        ?? ($schema ?? null);

    // Ignore legacy dummy auto-generated seeder schema (ProductGroup) so new rich default schema loads
    if (is_string($schemaCustomRaw) && str_contains($schemaCustomRaw, '"@type":"ProductGroup"')) {
        $schemaCustomRaw = null;
    }

    $hasCustomSchema = false;
    $customSchemaHtml = '';

    if (!empty($schemaCustomRaw)) {
        if (is_array($schemaCustomRaw) && !empty($schemaCustomRaw)) {
            $customSchemaHtml = '<script type="application/ld+json">' . "\n" . json_encode(
                $schemaCustomRaw,
                JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
            ) . "\n</script>";
            $hasCustomSchema = true;
        } elseif (is_string($schemaCustomRaw) && trim($schemaCustomRaw) !== '') {
            $rawTrimmed = trim($schemaCustomRaw);
            if (stripos($rawTrimmed, '<script') !== false) {
                $customSchemaHtml = $rawTrimmed;
            } else {
                $decoded = json_decode($rawTrimmed, true);
                if (json_last_error() === JSON_ERROR_NONE && (is_array($decoded) || is_object($decoded))) {
                    $customSchemaHtml = '<script type="application/ld+json">' . "\n" . json_encode(
                        $decoded,
                        JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
                    ) . "\n</script>";
                } else {
                    $customSchemaHtml = '<script type="application/ld+json">' . "\n" . $rawTrimmed . "\n</script>";
                }
            }
            $hasCustomSchema = true;
        }
    }

    // If NO custom schema, build the rich DEFAULT schema
    $finalDefaultPayload = null;

    if (!$hasCustomSchema) {
        if (!empty($schemaProduct)) {
            // ==========================================
            // DEFAULT SCHEMA FOR PRODUCTS
            // ==========================================
            $prodTitle = $schemaProduct['title'] ?? $schemaPageName;
            $prodImages = [];
            if ($mainImg = $schemaImageUrl($schemaProduct['image'] ?? null)) {
                $prodImages[] = $mainImg;
            }
            $gallery = is_string($schemaProduct['images'] ?? null)
                ? (json_decode($schemaProduct['images'], true) ?: [])
                : (array) ($schemaProduct['images'] ?? []);
            foreach ($gallery as $gImg) {
                if ($rImg = $schemaImageUrl($gImg)) {
                    $prodImages[] = $rImg;
                }
            }
            $prodImages = array_values(array_unique($prodImages));
            if (empty($prodImages)) {
                $prodImages = [asset('uploads/Home-Banner.webp')];
            }

            $productGraph = [
                // 1. Product Entity
                [
                    '@type' => 'Product',
                    '@id' => $schemaPageUrl . '#product',
                    'name' => $prodTitle,
                    'image' => $prodImages,
                    'description' => $schemaPageDescription,
                    'url' => $schemaPageUrl,
                    'brand' => [
                        '@type' => 'Brand',
                        'name' => 'Go Custom Boxes',
                    ],
                    'aggregateRating' => [
                        '@type' => 'AggregateRating',
                        'ratingValue' => (string) (!empty($schemaProduct['rating_value']) ? $schemaProduct['rating_value'] : '4.9'),
                        'reviewCount' => (string) (!empty($schemaProduct['review_count']) ? $schemaProduct['review_count'] : '54'),
                    ],
                    'offers' => [
                        '@type' => 'Offer',
                        'url' => $schemaPageUrl,
                        'priceCurrency' => 'USD',
                        'price' => (string) (!empty($schemaProduct['price']) ? ltrim($schemaProduct['price'], '$ ') : '0.10'),
                        'availability' => 'https://schema.org/InStock',
                        'seller' => [
                            '@type' => 'Organization',
                            'name' => 'Go Custom Boxes',
                        ],
                    ],
                ],
                // 2. LocalBusiness Entity
                [
                    '@context' => 'https://schema.org',
                    '@type' => 'LocalBusiness',
                    '@id' => $schemaPageUrl . '#business',
                    'name' => $prodTitle . ': Food-Safe & Wholesale Packaging - Go Custom Boxes',
                    'description' => $schemaPageDescription,
                    'url' => $schemaPageUrl,
                    'logo' => $schemaLogo,
                    'image' => $prodImages[0] ?? asset('uploads/Home-Banner.webp'),
                    'telephone' => '+1-800-315-8441',
                    'email' => 'support@gocustomboxes.com',
                    'address' => $sharedAddress,
                    'sameAs' => $sameAsSocials,
                    'openingHours' => ['Mo-Su 00:00-23:59'],
                    'paymentAccepted' => 'Credit Card, Visa, MasterCard, PayPal, Wire Transfer, Check',
                    'priceRange' => !empty($schemaProduct['price']) ? (str_starts_with($schemaProduct['price'], '$') ? $schemaProduct['price'] : '$' . $schemaProduct['price']) : '$$',
                    'serviceArea' => [
                        '@type' => 'AdministrativeArea',
                        'name' => 'United States',
                    ],
                    'department' => $customerSupportDept,
                ],
            ];

            // 3. FAQPage (if FAQs exist)
            if (!empty($schemaFaqEntities)) {
                $productGraph[] = [
                    '@context' => 'https://schema.org',
                    '@type' => 'FAQPage',
                    '@id' => $schemaPageUrl . '#faq',
                    'mainEntity' => collect($schemaFaqEntities)->map(function ($faq, $index) use ($schemaPageUrl) {
                        $faq['@id'] = $schemaPageUrl . '#q' . ($index + 1);
                        return $faq;
                    })->all(),
                ];
            }

            // 4. BreadcrumbList
            $productGraph[] = [
                '@context' => 'https://schema.org',
                '@type' => 'BreadcrumbList',
                '@id' => $schemaPageUrl . '#breadcrumb',
                'itemListElement' => [
                    [
                        '@type' => 'ListItem',
                        'position' => 1,
                        'name' => 'Home',
                        'item' => $schemaSiteUrl . '/',
                    ],
                    [
                        '@type' => 'ListItem',
                        'position' => 2,
                        'name' => $prodTitle,
                        'item' => $schemaPageUrl,
                    ],
                ],
            ];

            $finalDefaultPayload = [
                '@context' => 'https://schema.org',
                '@graph' => $productGraph,
            ];

        } elseif (!empty($schemaCategory)) {
            // ==========================================
            // DEFAULT SCHEMA FOR CATEGORIES
            // ==========================================
            $catTitle = $schemaCategory['title'] ?? $schemaPageName;
            $catImage = $schemaImageUrl(!empty($schemaCategory['hero_image']) ? $schemaCategory['hero_image'] : (!empty($schemaCategory['image']) ? $schemaCategory['image'] : null))
                ?: asset('uploads/Home-Banner.webp');

            // Category Items
            $categoryItemListElements = collect($products ?? [])
                ->take(20)
                ->map(function ($prod, $index) use ($schemaSiteUrl) {
                    $prod = (array) $prod;
                    $pSlug = trim($prod['slug'] ?? '', '/');
                    if ($pSlug === '') {
                        return null;
                    }
                    return [
                        '@type' => 'ListItem',
                        'position' => $index + 1,
                        'url' => $schemaSiteUrl . '/' . $pSlug . '/',
                        'name' => trim(strip_tags((string)($prod['title'] ?? ''))),
                    ];
                })
                ->filter(fn ($item) => !empty($item['name']) && !empty($item['url']))
                ->values()
                ->all();

            $categoryDefaultList = [];

            // 1. ItemList
            if (!empty($categoryItemListElements)) {
                $categoryDefaultList[] = [
                    '@context' => 'https://schema.org',
                    '@type' => 'ItemList',
                    '@id' => $schemaPageUrl . '#itemlist',
                    'name' => $catTitle,
                    'description' => $schemaPageDescription,
                    'url' => $schemaPageUrl,
                    'itemListOrder' => 'https://schema.org/ItemListOrderAscending',
                    'numberOfItems' => count($categoryItemListElements),
                    'itemListElement' => $categoryItemListElements,
                ];
            }

            // 2. LocalBusiness
            $categoryDefaultList[] = [
                '@context' => 'https://schema.org',
                '@type' => 'LocalBusiness',
                '@id' => $schemaPageUrl . '#business',
                'name' => 'Go Custom Boxes - ' . $catTitle,
                'description' => $schemaPageDescription,
                'url' => $schemaPageUrl,
                'logo' => $schemaLogo,
                'image' => $catImage,
                'telephone' => '+1-847-200-0971',
                'email' => 'support@gocustomboxes.com',
                'address' => $sharedAddress,
                'sameAs' => $sameAsSocials,
                'openingHours' => ['Mo-Su 00:00-23:59'],
                'paymentAccepted' => 'Credit Card, Visa, MasterCard, PayPal, Wire Transfer, Check',
                'priceRange' => !empty($schemaCategory['price']) ? (str_starts_with($schemaCategory['price'], '$') ? $schemaCategory['price'] : '$' . $schemaCategory['price']) : '$$',
                'serviceArea' => [
                    '@type' => 'AdministrativeArea',
                    'name' => 'United States',
                ],
                'department' => $customerSupportDept,
                'aggregateRating' => [
                    '@type' => 'AggregateRating',
                    'ratingValue' => is_numeric($schemaCategory['rating_value'] ?? null) ? (float) $schemaCategory['rating_value'] : (!empty($schemaCategory['rating_value']) ? $schemaCategory['rating_value'] : 4.9),
                    'reviewCount' => is_numeric($schemaCategory['review_count'] ?? null) ? (int) $schemaCategory['review_count'] : (!empty($schemaCategory['review_count']) ? $schemaCategory['review_count'] : 1540),
                ],
            ];

            // 3. FAQPage (if FAQs exist)
            if (!empty($schemaFaqEntities)) {
                $categoryDefaultList[] = [
                    '@context' => 'https://schema.org',
                    '@type' => 'FAQPage',
                    '@id' => $schemaPageUrl . '#faq',
                    'mainEntity' => $schemaFaqEntities,
                ];
            }

            // 4. BreadcrumbList
            $categoryDefaultList[] = [
                '@context' => 'https://schema.org',
                '@type' => 'BreadcrumbList',
                '@id' => $schemaPageUrl . '#breadcrumb',
                'itemListElement' => [
                    [
                        '@type' => 'ListItem',
                        'position' => 1,
                        'name' => 'Home',
                        'item' => $schemaSiteUrl . '/',
                    ],
                    [
                        '@type' => 'ListItem',
                        'position' => 2,
                        'name' => $catTitle,
                        'item' => $schemaPageUrl,
                    ],
                ],
            ];

            $finalDefaultPayload = $categoryDefaultList;

        } else {
            // ==========================================
            // DEFAULT SCHEMA FOR OTHER PAGES (Home, Blog, Author, etc.)
            // ==========================================
            $schemaOrganizationId = $schemaSiteUrl . '#organization';
            $schemaBusinessId = $schemaSiteUrl . '#localbusiness';
            $schemaWebsiteId = $schemaSiteUrl . '#website';
            $schemaWebPageId = $schemaPageUrl . '#webpage';

            $generalGraph = [
                [
                    '@type' => 'Organization',
                    '@id' => $schemaOrganizationId,
                    'name' => 'Go Custom Boxes',
                    'url' => $schemaSiteUrl,
                    'logo' => [
                        '@type' => 'ImageObject',
                        'url' => $schemaLogo,
                    ],
                    'description' => 'Custom printed packaging and boxes manufacturer.',
                    'contactPoint' => [
                        '@type' => 'ContactPoint',
                        'telephone' => '+1-800-315-8441',
                        'email' => 'support@gocustomboxes.com',
                        'contactType' => 'customer service',
                        'availableLanguage' => 'English',
                    ],
                ],
                [
                    '@type' => 'LocalBusiness',
                    '@id' => $schemaBusinessId,
                    'name' => 'Go Custom Boxes',
                    'url' => $schemaSiteUrl,
                    'logo' => $schemaLogo,
                    'image' => asset('uploads/Home-Banner.webp'),
                    'description' => 'Custom printed boxes and premium packaging solutions for businesses.',
                    'telephone' => '+1-800-315-8441',
                    'email' => 'support@gocustomboxes.com',
                    'priceRange' => '$$',
                    'address' => $sharedAddress,
                    'parentOrganization' => ['@id' => $schemaOrganizationId],
                    'sameAs' => $sameAsSocials,
                ],
                [
                    '@type' => 'WebSite',
                    '@id' => $schemaWebsiteId,
                    'url' => $schemaSiteUrl,
                    'name' => 'Go Custom Boxes',
                    'publisher' => ['@id' => $schemaOrganizationId],
                    'potentialAction' => [
                        '@type' => 'SearchAction',
                        'target' => [
                            '@type' => 'EntryPoint',
                            'urlTemplate' => $schemaSiteUrl . '/search?q={search_term_string}',
                        ],
                        'query-input' => 'required name=search_term_string',
                    ],
                ],
            ];

            $schemaWebPageType = 'WebPage';
            if (request()->is('contact-us')) {
                $schemaWebPageType = 'ContactPage';
            } elseif (request()->is('about-us')) {
                $schemaWebPageType = 'AboutPage';
            } elseif (request()->is('search')) {
                $schemaWebPageType = 'SearchResultsPage';
            } elseif (request()->is('blog') || request()->is('blog/*')) {
                $schemaWebPageType = 'CollectionPage';
            } elseif (!empty($schemaAuthor)) {
                $schemaWebPageType = 'ProfilePage';
            }

            $schemaWebPageIndex = count($generalGraph);
            $generalGraph[] = [
                '@type' => $schemaWebPageType,
                '@id' => $schemaWebPageId,
                'url' => $schemaPageUrl,
                'name' => trim(strip_tags((string) $schemaPageName)),
                'description' => $schemaPageDescription,
                'isPartOf' => ['@id' => $schemaWebsiteId],
                'about' => ['@id' => $schemaBusinessId],
            ];

            $generalBreadcrumbs = [[
                '@type' => 'ListItem',
                'position' => 1,
                'name' => 'Home',
                'item' => $schemaSiteUrl . '/',
            ]];
            if (!$schemaIsHomepage) {
                $generalBreadcrumbs[] = [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => trim(strip_tags((string) $schemaPageName)),
                    'item' => $schemaPageUrl,
                ];
            }
            $generalGraph[] = [
                '@type' => 'BreadcrumbList',
                '@id' => $schemaPageUrl . '#breadcrumb',
                'itemListElement' => $generalBreadcrumbs,
            ];

            if (!empty($schemaFaqEntities)) {
                $generalGraph[] = [
                    '@type' => 'FAQPage',
                    '@id' => $schemaPageUrl . '#faq',
                    'mainEntity' => $schemaFaqEntities,
                ];
            }

            if (!empty($schemaBlog)) {
                $schemaBlogAuthor = $schemaBlog['joined_author_name']
                    ?? $schemaBlog['author_name']
                    ?? 'Go Custom Boxes';
                $generalGraph[] = array_filter([
                    '@type' => 'BlogPosting',
                    '@id' => $schemaPageUrl . '#article',
                    'headline' => $schemaBlog['title'] ?? $schemaPageName,
                    'description' => trim(strip_tags((string) (
                        $schemaBlog['meta_description']
                        ?? $schemaBlog['excerpt']
                        ?? $schemaBlog['content']
                        ?? ''
                    ))),
                    'image' => $schemaImageUrl($schemaBlog['image'] ?? null),
                    'datePublished' => $schemaBlog['publish_date'] ?? $schemaBlog['created_at'] ?? null,
                    'dateModified' => $schemaBlog['updated_at'] ?? $schemaBlog['publish_date'] ?? null,
                    'author' => [
                        '@type' => !empty($schemaBlog['joined_author_name']) ? 'Person' : 'Organization',
                        'name' => $schemaBlogAuthor,
                    ],
                    'publisher' => ['@id' => $schemaOrganizationId],
                    'mainEntityOfPage' => ['@id' => $schemaWebPageId],
                ], fn ($value) => $value !== null && $value !== '');
            }

            if (!empty($schemaAuthor)) {
                $schemaPersonId = $schemaPageUrl . '#person';
                $generalGraph[] = array_filter([
                    '@type' => 'Person',
                    '@id' => $schemaPersonId,
                    'name' => $schemaAuthor['title'] ?? $schemaPageName,
                    'url' => $schemaPageUrl,
                    'image' => $schemaImageUrl($schemaAuthor['image'] ?? null),
                    'description' => trim(strip_tags((string) (!empty($schemaAuthor['bio']) ? $schemaAuthor['bio'] : ($schemaAuthor['description'] ?? '')))),
                    'worksFor' => ['@id' => $schemaOrganizationId],
                ], fn ($value) => $value !== null && $value !== '');
                $generalGraph[$schemaWebPageIndex]['mainEntity'] = ['@id' => $schemaPersonId];
            }

            $finalDefaultPayload = [
                '@context' => 'https://schema.org',
                '@graph' => $generalGraph,
            ];
        }
    }
@endphp
@if($hasCustomSchema)
{!! $customSchemaHtml !!}
@elseif($finalDefaultPayload !== null)
<script type="application/ld+json">
{!! json_encode(
    $finalDefaultPayload,
    JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
) !!}
</script>
@endif
