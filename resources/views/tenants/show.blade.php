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
                @if($tenant->custom_domain)
                    <p><strong>Custom Domain:</strong> <a href="http://{{ $tenant->custom_domain }}" target="_blank" style="color: #2563eb;">{{ $tenant->custom_domain }}</a></p>
                @endif
                
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
        <details style="margin-bottom: 2rem; border: 1px solid #d1d5db; border-radius: 6px; padding: 0.5rem;">
            <summary style="cursor: pointer; font-weight: 600; padding: 0.5rem;">Meta Descriptions</summary>
            <div style="padding: 1rem; padding-top: 0; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
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
        </details>
    </div>
    <section style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 2rem; margin-bottom: 0.5rem;">
        <details open>
            <summary style="cursor: pointer;"><h2 style="display: inline; margin: 0;">Digital Marketing</h2></summary>
            
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
        </details>
    </section>
    <section style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 2rem; margin-bottom: 0.5rem;">
        <details open>
            <summary style="cursor: pointer; margin-bottom: 0.5rem;"><h2 style="display: inline; font-size: 1rem; color: #4b5563; margin: 0;">Sales done</h2></summary>
            <table border="0" cellpadding="0" cellspacing="0" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 1px solid #e5e7eb;">
                    <th style="padding: 0.75rem; text-align: left; font-size: 0.875rem; color: #6b7280;">ID</th>
                    <th style="padding: 0.75rem; text-align: left; font-size: 0.875rem; color: #6b7280;">Client</th>
                    <th style="padding: 0.75rem; text-align: left; font-size: 0.875rem; color: #6b7280;">Items</th>
                    <th style="padding: 0.75rem; text-align: left; font-size: 0.875rem; color: #6b7280;">Amount</th>
                    <th style="padding: 0.75rem; text-align: left; font-size: 0.875rem; color: #6b7280;">Date</th>
                    <th style="padding: 0.75rem; text-align: left; font-size: 0.875rem; color: #6b7280;">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($purchases as $purchase)
                    <tr style="border-bottom: 1px solid #f3f4f6;">
                        <td style="padding: 0.75rem;">
                            <a href="{{ route('purchases.show', $purchase->id) }}" style="color: #2563eb; text-decoration: none; font-weight: 600;">#{{ $purchase->id }}</a>
                        </td>
                        <td style="padding: 0.75rem;">
                            <div>{{ $purchase->cart->client->name }}</div>
                            <div style="font-size: 0.75rem; color: #6b7280;">{{ $purchase->cart->client->email }}</div>
                        </td>
                        <td style="padding: 0.75rem;">{{ $purchase->cart->products->count() }}</td>
                        <td style="padding: 0.75rem;">{{ number_format($purchase->total_amount, 2) }}</td>
                        <td style="padding: 0.75rem;">{{ $purchase->created_at->format('d/m/Y H:i') }}</td>
                        <td style="padding: 0.75rem;">
                            <span style="display: inline-block; padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; background-color: #d1fae5; color: #065f46;">
                                {{ ucfirst($purchase->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding: 1rem; text-align: center; color: #6b7280;">No sales done yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        <div style="margin-top: 1rem;">
            {{ $purchases->appends(['pending_page' => $pendingSales->currentPage()])->links() }}
        </div>
        </details>
    </section>
    <section style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 2rem; margin-bottom: 0.5rem;">
        <details open>
            <summary style="cursor: pointer; margin-bottom: 0.5rem;"><h2 style="display: inline; font-size: 1rem; color: #4b5563; margin: 0;">Pending sales</h2></summary>
            <table border="0" cellpadding="0" cellspacing="0" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 1px solid #e5e7eb;">
                    <th style="padding: 0.75rem; text-align: left; font-size: 0.875rem; color: #6b7280;">Cart ID</th>
                    <th style="padding: 0.75rem; text-align: left; font-size: 0.875rem; color: #6b7280;">Client</th>
                    <th style="padding: 0.75rem; text-align: left; font-size: 0.875rem; color: #6b7280;">Items</th>
                    <th style="padding: 0.75rem; text-align: left; font-size: 0.875rem; color: #6b7280;">Current Total</th>
                    <th style="padding: 0.75rem; text-align: left; font-size: 0.875rem; color: #6b7280;">Last Updated</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendingSales as $cart)
                    <tr style="border-bottom: 1px solid #f3f4f6;">
                        <td style="padding: 0.75rem;">#{{ $cart->id }}</td>
                        <td style="padding: 0.75rem;">
                            <div>{{ $cart->client->name }}</div>
                            <div style="font-size: 0.75rem; color: #6b7280;">{{ $cart->client->email }}</div>
                        </td>
                        <td style="padding: 0.75rem;">{{ $cart->products->count() }}</td>
                        <td style="padding: 0.75rem;">
                            {{ number_format($cart->products->sum(function($product) {
                                return $product->pivot->price * $product->pivot->quantity;
                            }), 2) }}
                        </td>
                        <td style="padding: 0.75rem;">{{ $cart->updated_at->diffForHumans() }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding: 1rem; text-align: center; color: #6b7280;">No pending sales (active carts).</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
            <div style="margin-top: 1rem;">
            {{ $pendingSales->appends(['sales_page' => $purchases->currentPage()])->links() }}
        </div>
        </details>
    </section>

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
