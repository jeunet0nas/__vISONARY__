@extends('admin.layouts.app')

@section('title')
    Dashboard
@endsection

@section('content')
    @include('admin.layouts.sidebar')

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2"><i class="fas fa-chart-line"></i> Dashboard</h1>
            <div class="text-muted">
                <i class="far fa-calendar"></i> {{ now()->format('d/m/Y') }}
            </div>
        </div>

        {{-- ORDERS STATISTICS SECTION --}}
        <div class="mb-4">
            <h4 class="mb-3"><i class="fas fa-shopping-cart text-primary"></i> Thống kê Đơn hàng</h4>

            {{-- Metric Cards Row 1 --}}
            <div class="row g-3 mb-4">
                {{-- Today Orders --}}
                <div class="col-xl-3 col-md-6">
                    <div class="card stat-card border-0 bg-primary bg-gradient text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-subtitle mb-2 text-white-50">Đơn hàng hôm nay</h6>
                                    <h2 class="card-title mb-0">{{ $todayOrders->count() }}</h2>
                                    <small class="text-white-50">
                                        @if($yesterdayOrders->count() > 0)
                                            @php
                                                $change = (($todayOrders->count() - $yesterdayOrders->count()) / $yesterdayOrders->count()) * 100;
                                            @endphp
                                            <i class="fas fa-{{ $change >= 0 ? 'arrow-up' : 'arrow-down' }}"></i>
                                            {{ number_format(abs($change), 1) }}% so với hôm qua
                                        @else
                                            Không có dữ liệu hôm qua
                                        @endif
                                    </small>
                                </div>
                                <div class="fs-1 opacity-50">
                                    <i class="fas fa-shopping-bag"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Today Revenue --}}
                <div class="col-xl-3 col-md-6">
                    <div class="card stat-card border-0 bg-success bg-gradient text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-subtitle mb-2 text-white-50">Doanh thu hôm nay</h6>
                                    <h2 class="card-title mb-0">{{ number_format($todayRevenue, 0, ',', '.') }}đ</h2>
                                    <small class="text-white-50">
                                        @if($yesterdayRevenue > 0)
                                            @php
                                                $revenueChange = (($todayRevenue - $yesterdayRevenue) / $yesterdayRevenue) * 100;
                                            @endphp
                                            <i class="fas fa-{{ $revenueChange >= 0 ? 'arrow-up' : 'arrow-down' }}"></i>
                                            {{ number_format(abs($revenueChange), 1) }}% so với hôm qua
                                        @else
                                            Không có dữ liệu hôm qua
                                        @endif
                                    </small>
                                </div>
                                <div class="fs-1 opacity-50">
                                    <i class="fas fa-dollar-sign"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Month Revenue --}}
                <div class="col-xl-3 col-md-6">
                    <div class="card stat-card border-0 bg-info bg-gradient text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-subtitle mb-2 text-white-50">Doanh thu tháng này</h6>
                                    <h2 class="card-title mb-0">{{ number_format($monthRevenue, 0, ',', '.') }}đ</h2>
                                    <small class="text-white-50">
                                        {{ $monthOrders->count() }} đơn hàng
                                    </small>
                                </div>
                                <div class="fs-1 opacity-50">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Year Revenue --}}
                <div class="col-xl-3 col-md-6">
                    <div class="card stat-card border-0 bg-warning bg-gradient text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-subtitle mb-2 text-white-50">Doanh thu năm nay</h6>
                                    <h2 class="card-title mb-0">{{ number_format($yearRevenue, 0, ',', '.') }}đ</h2>
                                    <small class="text-white-50">
                                        {{ $yearOrders->count() }} đơn hàng
                                    </small>
                                </div>
                                <div class="fs-1 opacity-50">
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Charts Row --}}
            <div class="row g-3">
                {{-- Revenue Chart --}}
                <div class="col-xl-8 col-lg-7">
                    <div class="chart-container">
                        <h5 class="mb-3"><i class="fas fa-chart-area text-primary"></i> Doanh thu 7 ngày qua</h5>
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>

                {{-- Orders Status Chart --}}
                <div class="col-xl-4 col-lg-5">
                    <div class="chart-container">
                        <h5 class="mb-3"><i class="fas fa-chart-pie text-success"></i> Trạng thái đơn hàng</h5>
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- USERS STATISTICS SECTION --}}
        <div class="mb-4 mt-5">
            <h4 class="mb-3"><i class="fas fa-users text-info"></i> Thống kê Người dùng</h4>

            <div class="row g-3">
                {{-- Total Users --}}
                <div class="col-xl-3 col-md-6">
                    <div class="card stat-card border-0 bg-secondary bg-gradient text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-subtitle mb-2 text-white-50">Tổng người dùng</h6>
                                    <h2 class="card-title mb-0">{{ $totalUsers }}</h2>
                                    <small class="text-white-50">Đã đăng ký</small>
                                </div>
                                <div class="fs-1 opacity-50">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Today Users --}}
                <div class="col-xl-3 col-md-6">
                    <div class="card stat-card border-0 bg-primary bg-gradient text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-subtitle mb-2 text-white-50">Đăng ký hôm nay</h6>
                                    <h2 class="card-title mb-0">{{ $todayUsers }}</h2>
                                    <small class="text-white-50">
                                        @if($yesterdayUsers > 0)
                                            @php
                                                $userChange = (($todayUsers - $yesterdayUsers) / $yesterdayUsers) * 100;
                                            @endphp
                                            <i class="fas fa-{{ $userChange >= 0 ? 'arrow-up' : 'arrow-down' }}"></i>
                                            {{ number_format(abs($userChange), 1) }}% so với hôm qua
                                        @else
                                            Không có dữ liệu hôm qua
                                        @endif
                                    </small>
                                </div>
                                <div class="fs-1 opacity-50">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Users with Orders --}}
                <div class="col-xl-3 col-md-6">
                    <div class="card stat-card border-0 bg-success bg-gradient text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-subtitle mb-2 text-white-50">Đã mua hàng</h6>
                                    <h2 class="card-title mb-0">{{ $usersWithOrders }}</h2>
                                    <small class="text-white-50">
                                        {{ $totalUsers > 0 ? number_format(($usersWithOrders/$totalUsers)*100, 1) : 0 }}% tổng users
                                    </small>
                                </div>
                                <div class="fs-1 opacity-50">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Completed Profiles --}}
                <div class="col-xl-3 col-md-6">
                    <div class="card stat-card border-0 bg-info bg-gradient text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-subtitle mb-2 text-white-50">Hoàn thiện hồ sơ</h6>
                                    <h2 class="card-title mb-0">{{ $completedProfiles }}</h2>
                                    <small class="text-white-50">
                                        {{ $totalUsers > 0 ? number_format(($completedProfiles/$totalUsers)*100, 1) : 0 }}% tổng users
                                    </small>
                                </div>
                                <div class="fs-1 opacity-50">
                                    <i class="fas fa-user-check"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>

    <script>
        // Revenue Chart (Line Chart)
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        const last7DaysRevenue = {!! $last7DaysRevenue !!};
        const last7DaysLabels = {!! $last7DaysLabels !!};

        if (last7DaysRevenue && last7DaysLabels && last7DaysLabels.length > 0) {
            const revenueChart = new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: last7DaysLabels,
                    datasets: [{
                        label: 'Doanh thu (VNĐ)',
                        data: last7DaysRevenue,
                        borderColor: 'rgb(75, 192, 192)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        tension: 0.4,
                        fill: true,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        pointBackgroundColor: 'rgb(75, 192, 192)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    label += new Intl.NumberFormat('vi-VN').format(context.parsed.y) + 'đ';
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return new Intl.NumberFormat('vi-VN', {
                                        notation: 'compact',
                                        compactDisplay: 'short'
                                    }).format(value) + 'đ';
                                }
                            }
                        }
                    }
                }
            });
        }

        // Orders Status Chart (Pie Chart)
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        const ordersByStatus = {!! $ordersByStatus !!};

        if (ordersByStatus && Object.keys(ordersByStatus).length > 0) {
            const statusLabels = Object.keys(ordersByStatus);
            const statusData = Object.values(ordersByStatus);

            // Color mapping for payment statuses
            const statusColors = {
                'pending': '#ffc107',
                'paid': '#28a745',
                'unpaid': '#dc3545',
                'processing': '#17a2b8',
                'cancelled': '#6c757d'
            };

            const backgroundColors = statusLabels.map(status => statusColors[status] || '#6c757d');

            const statusChart = new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: statusLabels.map(s => s.charAt(0).toUpperCase() + s.slice(1)),
                    datasets: [{
                        data: statusData,
                        backgroundColor: backgroundColors,
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    let value = context.parsed || 0;
                                    let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    let percentage = ((value / total) * 100).toFixed(1);
                                    return label + ': ' + value + ' đơn (' + percentage + '%)';
                                }
                            }
                        }
                    }
                }
            });
        }
    </script>
@endsection


