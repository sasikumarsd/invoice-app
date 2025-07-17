<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Invoice System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <a href="{{ route('invoices.index') }}" class="navbar-brand">Invoice App</a>
        </div>
    </nav>
    @yield('content')
    @yield('scripts')
</body>
</html>
