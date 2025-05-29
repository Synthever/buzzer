@extends('layouts.admin')

@section('title', 'Dashboard - BuzzerIn')

@section('styles')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Task Dashboard</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#addTaskModal">
        <i class="fas fa-plus fa-sm text-white-50"></i> Create New Task
    </a>
</div>

<!-- Content Row - Task Statistics -->
<div class="row">
    <!-- Pending Tasks Card -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Pending Tasks</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- In Progress Tasks Card -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            In Progress Tasks</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">12</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-spinner fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Completed Tasks Card -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Completed Tasks</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">42</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row - Charts -->
<div class="row">

    <!-- Tasks Distribution Chart -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Tasks Overview</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                        aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">View Options:</div>
                        <a class="dropdown-item" href="#">Weekly</a>
                        <a class="dropdown-item" href="#">Monthly</a>
                        <a class="dropdown-item" href="#">Yearly</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Export Data</a>
                    </div>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="tasksOverviewChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Task Distribution Pie Chart -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <!-- Card Header -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Task Distribution</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                        aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">View Options:</div>
                        <a class="dropdown-item" href="#">By Status</a>
                        <a class="dropdown-item" href="#">By Priority</a>
                        <a class="dropdown-item" href="#">By Category</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Export Data</a>
                    </div>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-pie pt-4 pb-2">
                    <canvas id="taskDistributionChart"></canvas>
                </div>
                <div class="mt-4 text-center small">
                    <span class="mr-2">
                        <i class="fas fa-circle text-warning"></i> Pending
                    </span>
                    <span class="mr-2">
                        <i class="fas fa-circle text-primary"></i> In Progress
                    </span>
                    <span class="mr-2">
                        <i class="fas fa-circle text-success"></i> Completed
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Tasks Table -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Recent Tasks</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Task Name</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Due Date</th>
                        <th>Progress</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Website Redesign</td>
                        <td><span class="badge bg-danger text-white">High</span></td>
                        <td><span class="badge bg-primary text-white">In Progress</span></td>
                        <td>2023/10/25</td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: 75%"
                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">75%
                                </div>
                            </div>
                        </td>
                        <td>
                            <a href="#" class="btn btn-sm btn-primary"><i
                                    class="fas fa-edit"></i></a>
                            <a href="#" class="btn btn-sm btn-success"><i
                                    class="fas fa-check"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>Database Migration</td>
                        <td><span class="badge bg-warning text-dark">Medium</span></td>
                        <td><span class="badge bg-success text-white">Completed</span></td>
                        <td>2023/10/20</td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar"
                                    style="width: 100%" aria-valuenow="100" aria-valuemin="0"
                                    aria-valuemax="100">100%</div>
                            </div>
                        </td>
                        <td>
                            <a href="#" class="btn btn-sm btn-primary"><i
                                    class="fas fa-edit"></i></a>
                            <a href="#" class="btn btn-sm btn-danger"><i
                                    class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>API Integration</td>
                        <td><span class="badge bg-danger text-white">High</span></td>
                        <td><span class="badge bg-warning text-dark">Pending</span></td>
                        <td>2023/10/30</td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar"
                                    style="width: 0%" aria-valuenow="0" aria-valuemin="0"
                                    aria-valuemax="100">0%</div>
                            </div>
                        </td>
                        <td>
                            <a href="#" class="btn btn-sm btn-primary"><i
                                    class="fas fa-edit"></i></a>
                            <a href="#" class="btn btn-sm btn-info"><i class="fas fa-play"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>Content Creation</td>
                        <td><span class="badge bg-info text-white">Low</span></td>
                        <td><span class="badge bg-warning text-dark">Pending</span></td>
                        <td>2023/11/05</td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar"
                                    style="width: 0%" aria-valuenow="0" aria-valuemin="0"
                                    aria-valuemax="100">0%</div>
                            </div>
                        </td>
                        <td>
                            <a href="#" class="btn btn-sm btn-primary"><i
                                    class="fas fa-edit"></i></a>
                            <a href="#" class="btn btn-sm btn-info"><i class="fas fa-play"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>Mobile App Testing</td>
                        <td><span class="badge bg-warning text-dark">Medium</span></td>
                        <td><span class="badge bg-primary text-white">In Progress</span></td>
                        <td>2023/10/28</td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: 45%"
                                    aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">45%
                                </div>
                            </div>
                        </td>
                        <td>
                            <a href="#" class="btn btn-sm btn-primary"><i
                                    class="fas fa-edit"></i></a>
                            <a href="#" class="btn btn-sm btn-success"><i
                                    class="fas fa-check"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Charts Init -->
<script>
    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.font.family = 'Nunito, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif';
    Chart.defaults.color = '#858796';

    // Task Distribution Pie Chart
    var ctx = document.getElementById("taskDistributionChart").getContext('2d');
    var taskDistributionChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["Pending", "In Progress", "Completed"],
            datasets: [{
                data: [18, 12, 42],
                backgroundColor: ['#f6c23e', '#4e73df', '#1cc88a'],
                hoverBackgroundColor: ['#e0ae37', '#2e59d9', '#17a673'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    displayColors: false,
                    caretPadding: 10,
                }
            },
            cutout: '70%',
        },
    });

    // Tasks Overview Area Chart
    var ctx2 = document.getElementById("tasksOverviewChart").getContext('2d');
    var tasksOverviewChart = new Chart(ctx2, {
        type: 'line',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [
                {
                    label: "Completed",
                    lineTension: 0.3,
                    backgroundColor: "rgba(28, 200, 138, 0.05)",
                    borderColor: "rgba(28, 200, 138, 1)",
                    pointRadius: 3,
                    pointBackgroundColor: "rgba(28, 200, 138, 1)",
                    pointBorderColor: "rgba(28, 200, 138, 1)",
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: "rgba(28, 200, 138, 1)",
                    pointHoverBorderColor: "rgba(28, 200, 138, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: [10, 15, 12, 20, 18, 24, 25, 30, 32, 42, 38, 40],
                },
                {
                    label: "In Progress",
                    lineTension: 0.3,
                    backgroundColor: "rgba(78, 115, 223, 0.05)",
                    borderColor: "rgba(78, 115, 223, 1)",
                    pointRadius: 3,
                    pointBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointBorderColor: "rgba(78, 115, 223, 1)",
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: [5, 8, 10, 8, 12, 10, 8, 15, 12, 12, 10, 12],
                },
                {
                    label: "Pending",
                    lineTension: 0.3,
                    backgroundColor: "rgba(246, 194, 62, 0.05)",
                    borderColor: "rgba(246, 194, 62, 1)",
                    pointRadius: 3,
                    pointBackgroundColor: "rgba(246, 194, 62, 1)",
                    pointBorderColor: "rgba(246, 194, 62, 1)",
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: "rgba(246, 194, 62, 1)",
                    pointHoverBorderColor: "rgba(246, 194, 62, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: [20, 18, 15, 12, 10, 8, 10, 12, 15, 18, 20, 18],
                }
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        maxTicksLimit: 7
                    }
                },
                y: {
                    ticks: {
                        maxTicksLimit: 5
                    },
                    grid: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyColor: "#858796",
                    titleMarginBottom: 10,
                    titleColor: '#6e707e',
                    titleFontSize: 14,
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10
                }
            }
        }
    });
</script>
@endsection