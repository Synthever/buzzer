<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard - Task Collaboration</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/sb-admin-2.min.css') }}">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        .collaborator-badge {
            margin-right: 5px;
            margin-bottom: 5px;
        }
    </style>
</head>
<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/admin') }}">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Admin Panel</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="{{ url('/admin') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Management
            </div>

            <!-- Nav Item - Users -->
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/admin') }}">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Users</span></a>
            </li>

            <!-- Nav Item - Tasks -->
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/admin') }}">
                    <i class="fas fa-fw fa-tasks"></i>
                    <span>Tasks</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                User Interface
            </div>

            <!-- Nav Item - User Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/home') }}">
                    <i class="fas fa-fw fa-home"></i>
                    <span>User Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ auth()->user()->name }}</span>
                                <i class="fas fa-user-circle fa-2x text-gray-300"></i>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ url('/home') }}">
                                    <i class="fas fa-home fa-sm fa-fw mr-2 text-gray-400"></i>
                                    User Dashboard
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Admin Dashboard</h1>
                    </div>

                    <!-- Users Table Card -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Users Management</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="usersTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Username</th>
                                            <th>Tasks Count</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->username }}</td>
                                            <td>{{ $user->tasks_count }}</td>
                                            <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                            <td>
                                                <a href="#" class="btn btn-info btn-sm view-user-tasks" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}">
                                                    <i class="fas fa-tasks"></i> View Tasks
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Tasks Collaboration Card -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Task Collaboration Management</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="tasksTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Task Name</th>
                                            <th>Owner</th>
                                            <th>Status</th>
                                            <th>Priority</th>
                                            <th>Collaborators</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tasks as $task)
                                        <tr>
                                            <td>{{ $task->id }}</td>
                                            <td>{{ $task->name }}</td>
                                            <td>{{ $task->user->name }}</td>
                                            <td>
                                                @if($task->status == 'Completed')
                                                    <span class="badge bg-success text-white">Completed</span>
                                                @elseif($task->status == 'In Progress')
                                                    <span class="badge bg-primary text-white">In Progress</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($task->priority == 'High')
                                                    <span class="badge bg-danger text-white">High</span>
                                                @elseif($task->priority == 'Medium')
                                                    <span class="badge bg-warning text-dark">Medium</span>
                                                @else
                                                    <span class="badge bg-info text-white">Low</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="collaborator-list">
                                                    @foreach($task->collaborators as $collaborator)
                                                    <span class="badge bg-secondary collaborator-badge">{{ $collaborator->name }}</span>
                                                    @endforeach
                                                    @if(count($task->collaborators) == 0)
                                                    <span class="text-muted">No collaborators</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <button class="btn btn-primary btn-sm edit-collaborators" 
                                                        data-task-id="{{ $task->id }}" 
                                                        data-task-name="{{ $task->name }}"
                                                        data-owner-id="{{ $task->user_id }}">
                                                    <i class="fas fa-user-plus"></i> Manage Collaborators
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Task Management System 2023</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Ready to Leave?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-primary">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- User Tasks Modal -->
    <div class="modal fade" id="userTasksModal" tabindex="-1" aria-labelledby="userTasksModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userTasksModalLabel">Tasks for User: <span id="modalUserName"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="userTasksTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Task Name</th>
                                    <th>Status</th>
                                    <th>Priority</th>
                                    <th>Deadline</th>
                                    <th>Progress</th>
                                </tr>
                            </thead>
                            <tbody id="userTasksTableBody">
                                <!-- User tasks will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Manage Collaborators Modal -->
    <div class="modal fade" id="manageCollaboratorsModal" tabindex="-1" aria-labelledby="manageCollaboratorsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="manageCollaboratorsModalLabel">Manage Collaborators</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Task: <strong id="modalTaskName"></strong></p>
                    <p>Owner: <strong id="modalTaskOwner"></strong></p>
                    
                    <form id="collaboratorsForm">
                        @csrf
                        <input type="hidden" id="taskId" name="task_id">
                        
                        <div class="form-group">
                            <label for="collaborators">Select Collaborators:</label>
                            <select class="form-control" id="collaborators" name="collaborators[]" multiple>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->username }})</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Hold Ctrl (or Cmd) to select multiple users</small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveCollaboratorsBtn">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <!-- Custom scripts for sidebar -->
    <script>
        // Initialize the sidebar toggle
        $("#sidebarToggle, #sidebarToggleTop").on('click', function(e) {
            e.preventDefault();
            document.body.classList.toggle("sidebar-toggled");
            document.querySelector(".sidebar").classList.toggle("toggled");
            if ($(".sidebar").hasClass("toggled")) {
                $('.sidebar .collapse').collapse('hide');
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            // Initialize DataTables
            $('#usersTable').DataTable();
            $('#tasksTable').DataTable();
            
            // View User Tasks Button Click
            $('.view-user-tasks').on('click', function(e) {
                e.preventDefault();
                var userId = $(this).data('user-id');
                var userName = $(this).data('user-name');
                
                // Set modal title
                $('#modalUserName').text(userName);
                
                // Clear the table body
                $('#userTasksTableBody').empty();
                
                // Load user tasks via AJAX
                $.ajax({
                    url: '/admin/users/' + userId + '/tasks',
                    type: 'GET',
                    success: function(response) {
                        if (response.tasks.length > 0) {
                            response.tasks.forEach(function(task) {
                                // Calculate progress
                                var progressPercentage = 0;
                                if (task.total_slots > 0) {
                                    progressPercentage = Math.round((task.completed_slots / task.total_slots) * 100);
                                }
                                
                                // Determine progress bar class
                                var progressClass = 'bg-danger';
                                if (progressPercentage >= 100) {
                                    progressClass = 'bg-success';
                                } else if (progressPercentage >= 75) {
                                    progressClass = 'bg-info';
                                } else if (progressPercentage >= 50) {
                                    progressClass = 'bg-primary';
                                } else if (progressPercentage >= 25) {
                                    progressClass = 'bg-warning';
                                }
                                
                                // Create status badge
                                var statusBadge = '';
                                if (task.status === 'Completed') {
                                    statusBadge = '<span class="badge bg-success text-white">Completed</span>';
                                } else if (task.status === 'In Progress') {
                                    statusBadge = '<span class="badge bg-primary text-white">In Progress</span>';
                                } else {
                                    statusBadge = '<span class="badge bg-warning text-dark">Pending</span>';
                                }
                                
                                // Create priority badge
                                var priorityBadge = '';
                                if (task.priority === 'High') {
                                    priorityBadge = '<span class="badge bg-danger text-white">High</span>';
                                } else if (task.priority === 'Medium') {
                                    priorityBadge = '<span class="badge bg-warning text-dark">Medium</span>';
                                } else {
                                    priorityBadge = '<span class="badge bg-info text-white">Low</span>';
                                }
                                
                                // Format date
                                var deadlineDate = new Date(task.deadline);
                                var formattedDate = deadlineDate.toLocaleDateString();
                                
                                // Create progress bar
                                var progressBar = '<div class="progress">' +
                                                   '<div class="progress-bar ' + progressClass + '" role="progressbar" ' +
                                                   'style="width: ' + progressPercentage + '%" ' +
                                                   'aria-valuenow="' + progressPercentage + '" ' +
                                                   'aria-valuemin="0" aria-valuemax="100">' +
                                                   progressPercentage + '%</div></div>';
                                
                                // Add row to table
                                $('#userTasksTableBody').append('<tr>' +
                                    '<td>' + task.name + '</td>' +
                                    '<td>' + statusBadge + '</td>' +
                                    '<td>' + priorityBadge + '</td>' +
                                    '<td>' + formattedDate + '</td>' +
                                    '<td>' + progressBar + '</td>' +
                                    '</tr>');
                            });
                        } else {
                            $('#userTasksTableBody').html('<tr><td colspan="5" class="text-center">No tasks found for this user</td></tr>');
                        }
                        
                        // Show the modal
                        $('#userTasksModal').modal('show');
                    },
                    error: function(xhr) {
                        console.error('Error loading user tasks:', xhr.responseText);
                        alert('Error loading user tasks. Please try again.');
                    }
                });
            });
            
            // Edit Collaborators Button Click
            $('.edit-collaborators').on('click', function() {
                var taskId = $(this).data('task-id');
                var taskName = $(this).data('task-name');
                var ownerId = $(this).data('owner-id');
                
                // Find owner name
                var ownerName = '';
                $('#usersTable tbody tr').each(function() {
                    var userId = $(this).find('td:first').text();
                    if (userId == ownerId) {
                        ownerName = $(this).find('td:nth-child(2)').text();
                        return false;
                    }
                });
                
                // Set modal values
                $('#taskId').val(taskId);
                $('#modalTaskName').text(taskName);
                $('#modalTaskOwner').text(ownerName);
                
                // Clear select options
                $('#collaborators option:selected').prop('selected', false);
                
                // Load current collaborators via AJAX
                $.ajax({
                    url: '/admin/tasks/' + taskId + '/collaborators',
                    type: 'GET',
                    success: function(response) {
                        // Set selected collaborators
                        response.collaborators.forEach(function(collaboratorId) {
                            $('#collaborators option[value="' + collaboratorId + '"]').prop('selected', true);
                        });
                        
                        // Show the modal
                        $('#manageCollaboratorsModal').modal('show');
                    },
                    error: function(xhr) {
                        console.error('Error loading collaborators:', xhr.responseText);
                        alert('Error loading collaborators. Please try again.');
                    }
                });
            });
            
            // Save Collaborators Button Click
            $('#saveCollaboratorsBtn').on('click', function() {
                var taskId = $('#taskId').val();
                var collaborators = $('#collaborators').val();
                
                $.ajax({
                    url: '/admin/tasks/' + taskId + '/collaborators',
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        collaborators: collaborators
                    },
                    success: function(response) {
                        if (response.success) {
                            // Close the modal
                            $('#manageCollaboratorsModal').modal('hide');
                            
                            // Show success message
                            alert('Collaborators updated successfully');
                            
                            // Reload the page to show updated collaborators
                            window.location.reload();
                        } else {
                            alert('Error updating collaborators: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        console.error('Error updating collaborators:', xhr.responseText);
                        alert('Error updating collaborators. Please try again.');
                    }
                });
            });
        });
    </script>
</body>
</html>
