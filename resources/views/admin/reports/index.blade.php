@extends('admin.layouts.master')

@section('title', 'التقارير والإحصائيات')
@section('page_title', 'التقارير')
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">التقارير</li>
@endsection

@section('content')
    <!-- General Stats -->
    <div class="row g-3 mb-4">
         <div class="col-md-3">
            <x-admin-stat-card
                title="إجمالي الزوار (اليوم)"
                value="{{ $stats['today_visitors'] }}"
                icon="fas fa-eye"
                color="primary"
            />
        </div>
        <div class="col-md-3">
            <x-admin-stat-card
                title="إجمالي الخدمات"
                value="{{ $stats['services'] }}"
                icon="fas fa-concierge-bell"
                color="info"
            />
        </div>
        <div class="col-md-3">
            <x-admin-stat-card
                title="إجمالي الأنشطة"
                value="{{ $stats['activities'] }}"
                icon="fas fa-clipboard-list"
                color="success"
            />
        </div>
        <div class="col-md-3">
            <x-admin-stat-card
                title="رسائل الزوار"
                value="{{ $stats['messages'] }}"
                icon="fas fa-envelope"
                color="warning"
            />
        </div>
    </div>

    <div class="row g-3">
        <!-- Visitors Chart -->
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-header bg-transparent border-0 pt-3">
                    <h5 class="card-title fw-bold text-secondary mb-0"><i class="fas fa-chart-bar me-2"></i> إحصائيات الزوار (آخر 7 أيام)</h5>
                </div>
                <div class="card-body">
                    <canvas id="visitorsChart" style="max-height: 300px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Top Pages -->
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header bg-transparent border-0 pt-3">
                    <h5 class="card-title fw-bold text-secondary mb-0"><i class="fas fa-list-ol me-2"></i> الصفحات الأكثر زيارة</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-3">الصفحة</th>
                                    <th class="text-end pe-3">الزيارات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topPages as $page)
                                    <tr>
                                        <td class="ps-3 text-sm fw-medium text-dark">{{ Str::limit($page->page_url, 30) }}</td>
                                        <td class="text-end pe-3"><span class="badge bg-primary rounded-pill">{{ $page->count }}</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center py-3 text-muted">لا توجد بيانات</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var canvasEl = document.getElementById('visitorsChart');
        if (!canvasEl) return;

        var visitorDates  = {!! json_encode($visitorDates  ?? []) !!};
        var visitorCounts = {!! json_encode($visitorCounts ?? []) !!};

        new Chart(canvasEl.getContext('2d'), {
            type: 'bar',
            data: {
                labels: visitorDates,
                datasets: [{
                    label: 'عدد الزوار',
                    data: visitorCounts,
                    backgroundColor: 'rgba(79, 70, 229, 0.6)',
                    borderColor: 'rgba(79, 70, 229, 1)',
                    borderWidth: 1,
                    borderRadius: 4,
                    barThickness: 30
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0,0,0,0.05)' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    });
</script>
@endpush

