@extends('layouts.app')

@section('content')
    <div class="header-actions">
        <h1>Dashboard</h1>
        <p style="color: #6b7280; font-size: 0.875rem;">Overview of specific B2B Pet Ecosystem</p>
    </div>

    <!-- KPIs -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <div style="background: white; border: 1px solid #e5e7eb; padding: 1.5rem; border-radius: 8px;">
            <p style="color: #6b7280; font-size: 0.875rem; margin: 0;">Total Annual Revenue</p>
            <h3 style="font-size: 1.5rem; font-weight: 700; margin: 0.5rem 0 0;">$1,240,000</h3>
            <span style="color: #10b981; font-size: 0.75rem;">+12% vs last year</span>
        </div>
        <div style="background: white; border: 1px solid #e5e7eb; padding: 1.5rem; border-radius: 8px;">
            <p style="color: #6b7280; font-size: 0.875rem; margin: 0;">Active Boutiques</p>
            <h3 style="font-size: 1.5rem; font-weight: 700; margin: 0.5rem 0 0;">42</h3>
            <span style="color: #10b981; font-size: 0.75rem;">+3 new this month</span>
        </div>
        <div style="background: white; border: 1px solid #e5e7eb; padding: 1.5rem; border-radius: 8px;">
            <p style="color: #6b7280; font-size: 0.875rem; margin: 0;">Pension Orders</p>
            <h3 style="font-size: 1.5rem; font-weight: 700; margin: 0.5rem 0 0;">156</h3>
            <span style="color: #ef4444; font-size: 0.75rem;">12 urgent</span>
        </div>
        <div style="background: white; border: 1px solid #e5e7eb; padding: 1.5rem; border-radius: 8px;">
            <p style="color: #6b7280; font-size: 0.875rem; margin: 0;">Top Category</p>
            <h3 style="font-size: 1.25rem; font-weight: 700; margin: 0.5rem 0 0;">Prem. Dog Food</h3>
            <span style="color: #6b7280; font-size: 0.75rem;">32% of sales</span>
        </div>
    </div>

    <div style="display: flex; gap: 2rem; flex-wrap: wrap;">
        <!-- Tenants Growth Chart -->
        <div style="flex: 2; min-width: 400px; background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 1.5rem;">
            <h3 style="margin-top: 0; margin-bottom: 1rem; font-size: 1rem; color: #4b5563;">Platform Growth (Boutiques)</h3>
            <canvas id="growthChart" style="width: 100%; max-height: 300px;"></canvas>
        </div>

        <!-- Category Pie Chart -->
        <div style="flex: 1; min-width: 300px; background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 1.5rem;">
            <h3 style="margin-top: 0; margin-bottom: 1rem; font-size: 1rem; color: #4b5563;">Sales by Pet Type</h3>
            <canvas id="categoryChart" style="width: 100%; max-height: 300px;"></canvas>
        </div>
    </div>

    <!-- Recent Activity -->
    <div style="margin-top: 2rem; background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 1.5rem;">
        <h3 style="margin-top: 0; margin-bottom: 1rem; font-size: 1rem; color: #4b5563;">Recent B2B Orders</h3>
        <table style="width: 100%; border-collapse: collapse; font-size: 0.875rem;">
            <thead>
                <tr style="border-bottom: 2px solid #f3f4f6; text-align: left;">
                    <th style="padding: 0.75rem 0;">Boutique</th>
                    <th style="padding: 0.75rem 0;">Order Summary</th>
                    <th style="padding: 0.75rem 0;">Amount</th>
                    <th style="padding: 0.75rem 0;">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr style="border-bottom: 1px solid #f3f4f6;">
                    <td style="padding: 0.75rem 0; font-weight: 500;">Paws & Claws Zurich</td>
                    <td style="padding: 0.75rem 0;">500kg Dry Dog Food (Premium)</td>
                    <td style="padding: 0.75rem 0;">$4,200</td>
                    <td style="padding: 0.75rem 0;"><span style="color: #d97706; background: #fef3c7; padding: 0.25rem 0.5rem; borderRadius: 4px;">Processing</span></td>
                </tr>
                <tr style="border-bottom: 1px solid #f3f4f6;">
                    <td style="padding: 0.75rem 0; font-weight: 500;">Geneva Pet Supplies</td>
                    <td style="padding: 0.75rem 0;">200x Cat Toys Bundle</td>
                    <td style="padding: 0.75rem 0;">$1,850</td>
                    <td style="padding: 0.75rem 0;"><span style="color: #059669; background: #d1fae5; padding: 0.25rem 0.5rem; borderRadius: 4px;">Shipped</span></td>
                </tr>
                <tr style="border-bottom: 1px solid #f3f4f6;">
                    <td style="padding: 0.75rem 0; font-weight: 500;">Alpine Dogs</td>
                    <td style="padding: 0.75rem 0;">50x Heavy Duty Leashes</td>
                    <td style="padding: 0.75rem 0;">$950</td>
                    <td style="padding: 0.75rem 0;"><span style="color: #059669; background: #d1fae5; padding: 0.25rem 0.5rem; borderRadius: 4px;">Shipped</span></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Growth Chart
        new Chart(document.getElementById('growthChart'), {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Active Boutiques',
                    data: [20, 22, 24, 25, 28, 30, 32, 35, 38, 40, 41, 42],
                    borderColor: '#2563eb',
                    tension: 0.4
                }]
            },
            options: { plugins: { legend: { display: false } } }
        });

        // Category Chart
        new Chart(document.getElementById('categoryChart'), {
            type: 'doughnut',
            data: {
                labels: ['Dogs', 'Cats', 'Small Pets', 'Others'],
                datasets: [{
                    data: [55, 30, 10, 5],
                    backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#6b7280']
                }]
            }
        });
    </script>
@endsection
