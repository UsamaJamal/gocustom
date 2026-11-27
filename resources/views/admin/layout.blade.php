<!doctype html>
<html lang="en">
<head>
    <link rel="icon" href="{{ asset('uploads/go-custom-boxes-favicon.png') }}" type="image/png">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="theme-color" content="#0B2240">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') · Go-Custom-boxes Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Open+Sans:wght@300;400;600;700;800;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <style>
        :root{--primary:#FFB400;--primary-dark:#e6a200;--sidebar:#0B2240;--sidebar-soft:#15365f;--accent:#FFB400;--soft:#FFF3D3;--bg:#f8f6f0;--card:#fff;--text:#0B2240;--muted:#667085;--line:#e7e2d6;--shadow:0 0.5rem 1.875rem rgba(11,34,64,.07)}
        *{box-sizing:border-box}
        body{margin:0;background:var(--bg);color:var(--text);font:0.875rem 'DM Sans',sans-serif}
        .shell{display:grid;grid-template-columns:16.25rem minmax(0,1fr);min-height:100vh}
        .side{display:flex;flex-direction:column;position:sticky;top:0;height:100vh;padding:0 1rem 1.375rem;background:linear-gradient(180deg,var(--sidebar),#07182d);color:#fff;box-shadow:0.5rem 0 1.875rem rgba(11,34,64,.12);z-index:20;overflow-y:auto}
        .brand{height:5.5rem;display:flex;flex-shrink:0;align-items:center;gap:0.75rem;padding:0 0.5rem;border-bottom:1px solid rgba(255,255,255,.09)}
        .brand img{width:3.125rem;height:3.125rem;object-fit:contain}
        .brand strong{font:700 1rem/1.2 'Open Sans'; display:block;}
        .brand small{display:block;margin-top:0.125rem;color:#aebdd0;font-size:0.625rem;font-weight:500;letter-spacing:.08em;text-transform:uppercase}
        .nav-label{padding:1.375rem 0.875rem 0.5rem;color:#8fa4bd;font-size:0.625rem;font-weight:800;letter-spacing:.15em;text-transform:uppercase}
        .nav{display:grid;gap:0.3125rem;flex-shrink:0}
        .nav a{position:relative;display:flex;align-items:center;gap:0.8125rem;min-height:2.75rem;padding:0 0.875rem;border-radius:0.625rem;color:#d8e1eb;text-decoration:none;font-weight:600;transition:.2s}
        .nav a i{width:1.25rem;text-align:center;font-size:0.9375rem;color:#9fb1c5}
        .nav a:hover{background:rgba(255,255,255,.06);color:#fff}
        .nav a:hover i{color:#fff}
        .nav a.active{background:linear-gradient(90deg,var(--primary),#ffc53d);color:#0B2240;box-shadow:0 0.5rem 1.25rem rgba(255,180,0,.25)}
        .nav a.active i{color:#0B2240}
        .nav a.active:before{content:"";position:absolute;left:-1rem;top:0.5625rem;width:0.25rem;height:1.625rem;border-radius:0 0.3125rem 0.3125rem 0;background:#FFB400}
        .side-bottom{margin-top:auto;padding-top:1.25rem;flex-shrink:0}
        .main{min-width:0}
        .top{height:4.875rem;display:flex;align-items:center;justify-content:space-between;padding:0 2.125rem;background:#fff;border-bottom:1px solid var(--line);position:sticky;top:0;z-index:10}
        .top-left{display:flex;align-items:center;gap:0.875rem}
        .top h1{font:700 1.25rem 'Open Sans';margin:0}
        .crumb{font-size:0.75rem;color:var(--muted);margin-top:0.1875rem}
        .user{display:flex;align-items:center;gap:0.6875rem}
        .user-copy{text-align:right}
        .user-copy strong{display:block;font-size:0.8125rem}
        .user-copy span{font-size:0.6875rem;color:var(--muted)}
        .avatar{width:2.5rem;height:2.5rem;border-radius:0.75rem;display:grid;place-items:center;background:var(--soft);color:var(--text);font-weight:800;border:1px solid #f2d78e}
        .content{padding:1.75rem 2rem 3.125rem;max-width:100rem;margin:0 auto;width:100%}
        .grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:1.125rem}
        .card{background:var(--card);border:1px solid var(--line);border-radius:0.9375rem;padding:1.375rem;box-shadow:var(--shadow)}
        .stat{display:flex;justify-content:space-between;align-items:center;min-height:7.375rem}
        .stat b{display:block;font:800 1.875rem 'Open Sans';color:var(--text)}
        .stat span{color:var(--muted);font-weight:500}
        .icon{width:3.125rem;height:3.125rem;border-radius:0.8125rem;background:var(--soft);display:grid;place-items:center;color:var(--primary);font-size:1.1875rem}
        .panel{margin-top:1.375rem;background:#fff;border:1px solid var(--line);border-radius:0.9375rem;overflow:hidden;box-shadow:var(--shadow)}
        .panel-head{display:flex;align-items:center;justify-content:space-between;padding:1.125rem 1.375rem;border-bottom:1px solid var(--line)}
        .panel-head h2{font:700 1.0625rem 'Open Sans';margin:0}
        .btn{display:inline-flex;align-items:center;justify-content:center;gap:0.5rem;border:0;border-radius:0.5625rem;padding:0.625rem 0.9375rem;background:var(--primary);color:#0B2240;text-decoration:none;font-weight:700;cursor:pointer;box-shadow:0 0.3125rem 0.875rem rgba(255,180,0,.22)}
        .btn:hover{background:var(--primary-dark)}
        .btn.light{background:var(--soft);color:var(--primary);box-shadow:none}
        .btn.danger{background:#fff0f0;color:#a52b2b;box-shadow:none}
        .table-wrap{overflow:auto}
        table{width:100%;border-collapse:collapse}
        th,td{padding:0.875rem 1.25rem;border-bottom:1px solid var(--line);text-align:left;white-space:nowrap}
        th{font-size:0.6875rem;text-transform:uppercase;letter-spacing:.08em;color:var(--muted);background:#fbfafb}
        .status{display:inline-flex;align-items:center;gap:0.375rem;padding:0.3125rem 0.5625rem;border-radius:6.1875rem;background:#eaf8ef;color:#287a45;font-size:0.6875rem;font-weight:700}
        .status:before{content:"";width:0.375rem;height:0.375rem;border-radius:50%;background:currentColor}
        .empty{text-align:center;padding:3.5rem;color:var(--muted)}
        .alert{padding:0.75rem 1rem;border-radius:0.5625rem;background:#e9f8ef;color:#267643;margin-bottom:1.125rem}
        .form-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:1.125rem}
        .field{display:grid;gap:0.4375rem}
        .field.full{grid-column:1/-1}
        .field label{font-weight:700}
        .field small{color:var(--muted)}
        input,select,textarea{width:100%;border:1px solid #ddd8df;border-radius:0.5625rem;padding:0.75rem 0.8125rem;background:#fff;font:inherit;outline:none}
        input:focus,select:focus,textarea:focus{border-color:var(--primary);box-shadow:0 0 0 0.1875rem rgba(255,180,0,.18)}
        textarea{min-height:7.5rem;resize:vertical}
        .section{padding:1.375rem;border-bottom:1px solid var(--line)}
        .section h3{margin:0 0 1.0625rem;font:700 0.9375rem 'Open Sans';color:var(--primary)}
        .checks{display:flex;flex-wrap:wrap;gap:1rem}
        .check{display:flex;align-items:center;gap:0.4375rem}
        .check input{width:auto}
        .actions{display:flex;justify-content:flex-end;gap:0.625rem;padding:1.25rem 1.375rem}
        .help{margin-top:1.375rem;padding:1.125rem;border-radius:0.75rem;background:var(--soft);color:#0B2240}
        .module-link{transition:transform .2s,box-shadow .2s}
        .module-link:hover{transform:translateY(-0.1875rem);box-shadow:0 0.875rem 2.125rem rgba(42,25,31,.1)}

        @media(max-width:68.75rem){
            .grid{grid-template-columns:repeat(2,1fr);}
        }

        @media(max-width:48rem){
            .shell{grid-template-columns:4.5rem minmax(0,1fr);}
            .side{padding-inline:0.5rem;}
            .brand{padding:0;justify-content:center;}
            .brand img{width:2.75rem;}
            .brand div,.nav-label,.nav a span,.side-bottom span{display:none;}
            .nav a{justify-content:center;padding:0;}
            .nav a i{font-size:1.125rem;}
            .grid{grid-template-columns:1fr;}
            .top{padding:0 1rem;}
            .content{padding:1.25rem 0.875rem;}
        }
    </style>
    <script>
        window.tinyMceUploadConfig = {
            // TinyMCE drops <style> blocks by default, so CSS pasted into the source view was lost on every save.
            valid_children: '+body[style],+div[style],+section[style]',
            extended_valid_elements: 'style[type|media]',
            relative_urls: false,
            remove_script_host: false,
            convert_urls: false,
            document_base_url: '{{ url('/') }}/',
            automatic_uploads: true,
            paste_data_images: true,
            setup: function (editor) {
                editor.on('change keyup blur SetContent', function () {
                    editor.save();
                });
            },
            file_picker_types: 'image media',
            images_upload_handler: function (blobInfo) {
                const data = new FormData();
                data.append('file', blobInfo.blob(), blobInfo.filename());

                return window.uploadTinyMceFile(data);
            },
            file_picker_callback: function (callback, value, meta) {
                const input = document.createElement('input');
                input.type = 'file';
                input.accept = meta.filetype === 'media'
                    ? 'video/mp4,video/webm,video/ogg'
                    : 'image/jpeg,image/png,image/gif,image/webp';

                input.addEventListener('change', async function () {
                    const file = input.files && input.files[0];
                    if (!file) return;

                    const data = new FormData();
                    data.append('file', file, file.name);

                    try {
                        const location = await window.uploadTinyMceFile(data);
                        callback(location, { title: file.name });
                    } catch (error) {
                        window.alert(error.message || 'Upload failed.');
                    }
                });

                input.click();
            }
        };

        window.uploadTinyMceFile = async function (data) {
            const response = await fetch(@json(route('admin.tinymce.upload')), {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: data
            });
            const result = await response.json().catch(function () { return {}; });

            if (!response.ok || !result.location) {
                const validationMessage = result.errors && result.errors.file
                    ? result.errors.file[0]
                    : result.message;
                throw new Error(validationMessage || 'Upload failed.');
            }

            return result.location;
        };

        // Ensure all TinyMCE instances (including Source Code <> edits) sync to their textareas before submit
        document.addEventListener('submit', function () {
            if (typeof tinymce !== 'undefined') {
                tinymce.triggerSave();
            }
        }, true);
    </script>
</head>
<body>
<div class="shell">
    <aside class="side">
        <div class="brand">
            <img src="{{ asset('uploads/header-logo.svg') }}" alt="Go-Custom-boxes">
            <div>
                <strong>Go-Custom-boxes</strong>
                <small>Administration</small>
            </div>
        </div>
        <div class="nav-label">Workspace</div>
        <nav class="nav">
            <a class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="fa-solid fa-gauge-high"></i>
                <span>Dashboard</span>
            </a>
            <a class="{{ request()->routeIs('admin.homepage.edit') ? 'active' : '' }}" href="{{ route('admin.homepage.edit') }}">
                <i class="fa-solid fa-house"></i>
                <span>Home Page Settings</span>
            </a>
            <a class="{{ request()->routeIs('admin.popularproducts.edit') ? 'active' : '' }}" href="{{ route('admin.popularproducts.edit') }}">
                <i class="fa-solid fa-star"></i>
                <span>Popular Products Page</span>
            </a>
            <a class="{{ request()->routeIs('admin.footer.edit') ? 'active' : '' }}" href="{{ route('admin.footer.edit') }}">
                <i class="fa-solid fa-gear"></i>
                <span>Footer & Company</span>
            </a>
            <a class="{{ request()->routeIs('admin.faqpage.edit') ? 'active' : '' }}" href="{{ route('admin.faqpage.edit') }}">
                <i class="fa-solid fa-circle-question"></i>
                <span>FAQ Page</span>
            </a>
            <a class="{{ request()->route('module') === 'products' ? 'active' : '' }}" href="{{ route('admin.module.index', 'products') }}">
                <i class="fa-solid fa-box-open"></i>
                <span>Products</span>
            </a>
            <a class="{{ request()->route('module') === 'categories' ? 'active' : '' }}" href="{{ route('admin.module.index', 'categories') }}">
                <i class="fa-solid fa-layer-group"></i>
                <span>Categories</span>
            </a>
            <a class="{{ request()->route('module') === 'blogs' ? 'active' : '' }}" href="{{ route('admin.module.index', 'blogs') }}">
                <i class="fa-solid fa-newspaper"></i>
                <span>Blog Posts</span>
            </a>
            <a class="{{ request()->route('module') === 'authors' ? 'active' : '' }}" href="{{ route('admin.module.index', 'authors') }}">
                <i class="fa-solid fa-users"></i>
                <span>Authors</span>
            </a>
            <a class="{{ request()->route('module') === 'pages' ? 'active' : '' }}" href="{{ route('admin.module.index', 'pages') }}">
                <i class="fa-regular fa-file-lines"></i>
                <span>Dynamic Pages</span>
            </a>
        </nav>
        <div class="side-bottom">
            <nav class="nav">
                <a href="/" target="_blank" rel="noopener noreferrer">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    <span>View Website</span>
                </a>
            </nav>
        </div>
    </aside>
    <main class="main">
        <header class="top">
            <div class="top-left">
                <div>
                    <h1>@yield('heading', 'Dashboard')</h1>
                    <div class="crumb">Go-Custom-boxes <i class="fa-solid fa-chevron-right" style="font-size:8px;margin:0 6px"></i> Admin</div>
                </div>
            </div>
            <div class="user">
                <div class="user-copy">
                    <strong>{{ session('admin_name', 'Administrator') }}</strong>
                    <span>{{ auth()->user()->email ?? session('admin_email', 'admin@gocustomboxes.com') }}</span>
                </div>
                <span class="avatar">GC</span>
                <form action="{{ route('admin.logout') }}" method="POST" style="margin-left:0.5rem;">
                    @csrf
                    <button type="submit" class="btn light" style="padding:0.4375rem 0.75rem;font-size:0.75rem;cursor:pointer;" title="Logout from Admin">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </button>
                </form>
            </div>
        </header>
        <div class="content">
            @if(session('success'))
                <div class="alert">
                    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                </div>
            @endif 
            @yield('content')
        </div>
    </main>
</div>
</body>
</html>
