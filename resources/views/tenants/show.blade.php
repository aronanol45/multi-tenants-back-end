@extends('layouts.app')

@section('content')
    <div class="header-actions">
        <h1>Tenant Details: {{ $tenant->name }}</h1>
        <a href="{{ route('tenants.index') }}" style="color: #6b7280; text-decoration: none;">&larr; Back to List</a>
    </div>

    <div style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 2rem; margin-bottom: 2rem;">
        <div style="display: flex; gap: 2rem; align-items: flex-start;">
            @if($tenant->tenant_logo)
                <div style="flex-shrink: 0;">
                    <img src="{{ Str::startsWith($tenant->tenant_logo, 'logos/') ? asset('storage/' . $tenant->tenant_logo) : $tenant->tenant_logo }}" alt="Logo" width="150" style="border-radius: 8px; border: 1px solid #e5e7eb;">
                </div>
            @endif

            <div style="flex-grow: 1;">
                <h2 style="margin-top: 0; margin-bottom: 1rem;">{{ $tenant->name }}</h2>
                <p><strong>ID:</strong> {{ $tenant->id }}</p>
                <p><strong>Subdomain:</strong> {{ $tenant->subdomain }}</p>
                <p><strong>Domain:</strong> <a href="http://{{ $tenant->domain }}" target="_blank" style="color: #2563eb;">{{ $tenant->domain }}</a></p>
                
                @if(App::environment('local'))
                    <p><strong>Dev URL:</strong> <a href="http://{{ $tenant->subdomain }}.companynameapi.local" target="_blank" style="color: #2563eb;">http://{{ $tenant->subdomain }}.companynameapi.local</a></p>
                @endif
                
                <div style="margin-top: 2rem;">
                    <a href="{{ route('tenants.edit', $tenant->id) }}" class="btn-primary">Edit Tenant</a>
                    
                    <form action="{{ route('tenants.destroy', $tenant->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this tenant?');" style="display:inline; margin-left: 1rem;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red" style="font-size: 1rem;">Delete Tenant</button>
                    </form>
                </div>
            </div>
        </div>
        
        <hr>

        <h3>Meta Descriptions</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
            <div style="background: #f9fafb; padding: 1rem; border-radius: 4px;">
                <strong>English</strong>
                <p style="margin-top: 0.5rem; color: #4b5563;">{{ $tenant->meta_description['en'] ?? 'N/A' }}</p>
            </div>
            <div style="background: #f9fafb; padding: 1rem; border-radius: 4px;">
                <strong>German</strong>
                <p style="margin-top: 0.5rem; color: #4b5563;">{{ $tenant->meta_description['de'] ?? 'N/A' }}</p>
            </div>
            <div style="background: #f9fafb; padding: 1rem; border-radius: 4px;">
                <strong>French</strong>
                <p style="margin-top: 0.5rem; color: #4b5563;">{{ $tenant->meta_description['fr'] ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <div style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 2rem; margin-bottom: 2rem;">
        <h2 style="margin-top: 0; margin-bottom: 1.5rem;">Digital Marketing</h2>
        
        <div style="margin-bottom: 2rem;">
            <h3 style="font-size: 1rem; color: #4b5563; margin-bottom: 0.5rem;">Sales (Last 12 Months)</h3>
            <canvas id="salesChart" style="width: 100%; max-height: 300px;"></canvas>
        </div>

        <div style="display: flex; gap: 2rem; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 300px;">
                <h3 style="font-size: 1rem; color: #4b5563; margin-bottom: 0.5rem;">Visits (Last 7 Days)</h3>
                <canvas id="visitsChart" style="width: 100%; max-height: 250px;"></canvas>
            </div>

            <div style="flex: 1; min-width: 300px;">
                <h3 style="font-size: 1rem; color: #4b5563; margin-bottom: 0.5rem;">User Locations (Switzerland)</h3>
                <div id="regions_div" style="width: 100%; height: 250px; border: 1px solid #f3f4f6; border-radius: 4px;"></div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script>
        // Sales Chart
        const ctxSales = document.getElementById('salesChart').getContext('2d');
        new Chart(ctxSales, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Sales ($)',
                    data: [1200, 1900, 3000, 5000, 2000, 3000, 4500, 4000, 5500, 6000, 7000, 8500],
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                }
            }
        });

        // Visits Chart
        const ctxVisits = document.getElementById('visitsChart').getContext('2d');
        new Chart(ctxVisits, {
            type: 'bar',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Visits',
                    data: [150, 230, 180, 320, 290, 450, 400],
                    backgroundColor: '#10b981'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                }
            }
        });

        // Google Map
        google.charts.load('current', {
            'packages':['geochart'],
        });
        google.charts.setOnLoadCallback(drawRegionsMap);

        function drawRegionsMap() {
            var data = google.visualization.arrayToDataTable([
                ['Canton', 'Users'],
                ['Zurich', 500],
                ['Geneva', 350],
                ['Vaud', 200],
                ['Bern', 150],
                ['Ticino', 100],
                ['Lucerne', 80]
            ]);

            var options = {
                region: 'CH', // Switzerland
                displayMode: 'regions',
                resolution: 'provinces',
                colorAxis: {colors: ['#e5e7eb', '#2563eb']},
                backgroundColor: 'transparent',
                datalessRegionColor: '#f9fafb',
            };

            var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));
            chart.draw(data, options);
        }
    </script>
@endsection
