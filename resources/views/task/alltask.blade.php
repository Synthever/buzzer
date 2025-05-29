@extends('layouts.admin')

@section('title', 'All Tasks - BuzzerIn')

@section('styles')
<!-- DataTables CSS -->
<link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endsection

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Task Management</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#addTaskModal">
        <i class="fas fa-plus fa-sm text-white-50"></i> Add New Task
    </a>
</div>

<!-- Task Table -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">All Tasks</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="taskTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Task Name</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Deadline</th>
                        <th>Slots</th>
                        <th>Progress</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $task)
                    <tr>
                        <td>{{ $task->name }}</td>
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
                        <td>{{ date('Y-m-d', strtotime($task->deadline)) }}</td>
                        <td><span class="font-weight-bold">{{ $task->completed_slots }}/{{ $task->total_slots }}</span></td>
                        <td>
                            @php
                                $progressPercentage = $task->total_slots > 0 ? round(($task->completed_slots / $task->total_slots) * 100) : 0;
                                $progressClass = 'bg-danger';
                                
                                if($progressPercentage >= 100) {
                                    $progressClass = 'bg-success';
                                } elseif($progressPercentage >= 75) {
                                    $progressClass = 'bg-info';
                                } elseif($progressPercentage >= 50) {
                                    $progressClass = 'bg-primary';
                                } elseif($progressPercentage >= 25) {
                                    $progressClass = 'bg-warning';
                                }
                            @endphp
                            <div class="progress">
                                <div class="progress-bar {{ $progressClass }}" role="progressbar" 
                                    style="width: {{ $progressPercentage }}%" 
                                    aria-valuenow="{{ $progressPercentage }}" 
                                    aria-valuemin="0" 
                                    aria-valuemax="100">{{ $progressPercentage }}%</div>
                            </div>
                        </td>
                        <td>
                            <button class="btn btn-info btn-sm detail-btn" data-task-id="{{ $task->id }}">
                                <i class="fas fa-info-circle"></i> Detail
                            </button>
                            <button class="btn btn-primary btn-sm edit-btn" data-task-id="{{ $task->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm delete-btn" data-task-id="{{ $task->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Task Detail Modal -->
<div class="modal fade" id="taskDetailModal" tabindex="-1" aria-labelledby="taskDetailModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="taskDetailModalLabel">Task Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Task Name:</strong> <span id="detailTaskName"></span></p>
                        <p><strong>Status:</strong> <span id="detailStatus"></span></p>
                        <p><strong>Priority:</strong> <span id="detailPriority"></span></p>
                        <p><strong>Deadline:</strong> <span id="detailDeadline"></span></p>
                        <p><strong>Slots:</strong> <span id="detailCompletedSlots"></span>/<span id="detailTotalSlots"></span> completed</p>
                        <p><strong>Progress:</strong> <span id="detailProgress"></span>%</p>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="m-0 font-weight-bold text-primary">Task Resources</h6>
                            </div>
                            <div class="card-body">
                                <p><i class="fas fa-file-alt mr-2"></i> <a id="detailFormLink" href="#" target="_blank">Open Task Form</a></p>
                                <p><i class="fab fa-google-drive mr-2"></i> <a id="detailDriveLink" href="#" target="_blank">Upload Screenshots to Google Drive</a></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="progress mb-4">
                    <div id="detailProgressBar" class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="button" id="editTaskBtn">Edit Task</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Task Modal -->
<div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTaskModalLabel">Add New Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addTaskForm">
                    <div class="form-group">
                        <label for="taskName">Task Name</label>
                        <input type="text" class="form-control" id="taskName" required>
                    </div>
                    <div class="form-group">
                        <label for="taskStatus">Status</label>
                        <select class="form-control" id="taskStatus" required>
                            <option value="Pending">Pending</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="taskPriority">Priority</label>
                        <select class="form-control" id="taskPriority" required>
                            <option value="Low">Low</option>
                            <option value="Medium">Medium</option>
                            <option value="High">High</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="taskDeadline">Deadline</label>
                        <input type="date" class="form-control" id="taskDeadline" required>
                    </div>
                    <div class="form-group">
                        <label for="taskTotalSlots">Total Slots</label>
                        <input type="number" class="form-control" id="taskTotalSlots" min="1" value="10" required>
                        <small class="form-text text-muted">Total number of work units for this task</small>
                    </div>
                    <div class="form-group">
                        <label for="taskCompletedSlots">Completed Slots</label>
                        <input type="number" class="form-control" id="taskCompletedSlots" min="0" value="0" required>
                        <small class="form-text text-muted">Number of work units already completed</small>
                    </div>
                    <div class="form-group">
                        <label for="taskFormLink">Form Link</label>
                        <input type="url" class="form-control" id="taskFormLink" placeholder="https://forms.google.com/...">
                    </div>
                    <div class="form-group">
                        <label for="taskDriveLink">Google Drive Link</label>
                        <input type="url" class="form-control" id="taskDriveLink" placeholder="https://drive.google.com/...">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" type="button" id="saveTaskBtn">Save Task</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Task Modal -->
<div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTaskModalLabel">Edit Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editTaskForm">
                    <input type="hidden" id="editTaskId">
                    <div class="form-group">
                        <label for="editTaskName">Task Name</label>
                        <input type="text" class="form-control" id="editTaskName" required>
                    </div>
                    <div class="form-group">
                        <label for="editTaskStatus">Status</label>
                        <select class="form-control" id="editTaskStatus" required>
                            <option value="Pending">Pending</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editTaskPriority">Priority</label>
                        <select class="form-control" id="editTaskPriority" required>
                            <option value="Low">Low</option>
                            <option value="Medium">Medium</option>
                            <option value="High">High</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editTaskDeadline">Deadline</label>
                        <input type="date" class="form-control" id="editTaskDeadline" required>
                    </div>
                    <div class="form-group">
                        <label for="editTaskTotalSlots">Total Slots</label>
                        <input type="number" class="form-control" id="editTaskTotalSlots" min="1" required>
                        <small class="form-text text-muted">Total number of work units for this task</small>
                    </div>
                    <div class="form-group">
                        <label for="editTaskCompletedSlots">Completed Slots</label>
                        <input type="number" class="form-control" id="editTaskCompletedSlots" min="0" required>
                        <small class="form-text text-muted">Number of work units already completed</small>
                    </div>
                    <div class="form-group">
                        <label for="editTaskFormLink">Form Link</label>
                        <input type="url" class="form-control" id="editTaskFormLink" placeholder="https://forms.google.com/...">
                    </div>
                    <div class="form-group">
                        <label for="editTaskDriveLink">Google Drive Link</label>
                        <input type="url" class="form-control" id="editTaskDriveLink" placeholder="https://drive.google.com/...">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" type="button" id="updateTaskBtn">Update Task</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Task Confirmation Modal -->
<div class="modal fade" id="deleteTaskModal" tabindex="-1" aria-labelledby="deleteTaskModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteTaskModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this task? This action cannot be undone.</p>
                <p><strong>Task: </strong><span id="deleteTaskName"></span></p>
                <input type="hidden" id="deleteTaskId">
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-danger" type="button" id="confirmDeleteBtn">Delete</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- DataTables JavaScript -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        // Set up CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        // Initialize DataTable
        var taskTable = $('#taskTable').DataTable({
            "ordering": true,
            "searching": true,
            "paging": true,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
        });
        
        // Event delegation for task detail button
        $('#taskTable').on('click', '.detail-btn', function() {
            var taskId = $(this).data('task-id');
            showTaskDetails(taskId);
        });
        
        // Event delegation for task edit button
        $('#taskTable').on('click', '.edit-btn', function() {
            var taskId = $(this).data('task-id');
            loadTaskToEditForm(taskId);
            $('#editTaskModal').modal('show');
        });
        
        // Event delegation for task delete button
        $('#taskTable').on('click', '.delete-btn', function() {
            var taskId = $(this).data('task-id');
            confirmDeleteTask(taskId);
        });
        
        // Add Task Button Click Event
        $('#saveTaskBtn').on('click', function() {
            if($('#addTaskForm')[0].checkValidity()) {
                var totalSlots = parseInt($('#taskTotalSlots').val());
                var completedSlots = parseInt($('#taskCompletedSlots').val());
                
                if (completedSlots > totalSlots) {
                    alert("Completed slots cannot exceed total slots");
                    return;
                }
                
                addNewTask();
            } else {
                $('#addTaskForm')[0].reportValidity();
            }
        });
        
        // Update Task Button Click Event
        $('#updateTaskBtn').on('click', function() {
            if($('#editTaskForm')[0].checkValidity()) {
                var totalSlots = parseInt($('#editTaskTotalSlots').val());
                var completedSlots = parseInt($('#editTaskCompletedSlots').val());
                
                if (completedSlots > totalSlots) {
                    alert("Completed slots cannot exceed total slots");
                    return;
                }
                
                updateTask();
            } else {
                $('#editTaskForm')[0].reportValidity();
            }
        });
        
        // Confirm Delete Button Click Event
        $('#confirmDeleteBtn').on('click', function() {
            deleteTask();
        });
        
        // Functions for AJAX operations
        function showTaskDetails(taskId) {
            $.ajax({
                url: '/tasks/' + taskId,
                type: 'GET',
                success: function(response) {
                    if (response.status === 'success') {
                        var task = response.task;
                        var progressPercentage = task.total_slots > 0 ? Math.round((task.completed_slots / task.total_slots) * 100) : 0;
                        
                        // Populate modal with task details
                        $('#detailTaskName').text(task.name).data('taskid', task.id);
                        $('#detailStatus').text(task.status);
                        $('#detailPriority').text(task.priority);
                        $('#detailDeadline').text(new Date(task.deadline).toLocaleDateString());
                        $('#detailTotalSlots').text(task.total_slots);
                        $('#detailCompletedSlots').text(task.completed_slots);
                        $('#detailProgress').text(progressPercentage);
                        $('#detailFormLink').attr('href', task.form_link);
                        $('#detailDriveLink').attr('href', task.drive_link);
                        
                        // Update progress bar
                        $('#detailProgressBar').css('width', progressPercentage + '%').attr('aria-valuenow', progressPercentage);
                        
                        // Change progress bar color based on progress
                        $('#detailProgressBar').removeClass('bg-danger bg-warning bg-info bg-success bg-primary');
                        if (progressPercentage >= 100) {
                            $('#detailProgressBar').addClass('bg-success');
                        } else if (progressPercentage >= 75) {
                            $('#detailProgressBar').addClass('bg-info');
                        } else if (progressPercentage >= 50) {
                            $('#detailProgressBar').addClass('bg-primary');
                        } else if (progressPercentage >= 25) {
                            $('#detailProgressBar').addClass('bg-warning');
                        } else {
                            $('#detailProgressBar').addClass('bg-danger');
                        }
                        
                        // Show the modal
                        $('#taskDetailModal').modal('show');
                    } else {
                        alert("Error loading task details: " + response.message);
                    }
                },
                error: function(xhr) {
                    console.error("Error loading task details:", xhr.responseText);
                    alert("Error loading task details. Check console for details.");
                }
            });
        }
        
        function loadTaskToEditForm(taskId) {
            $.ajax({
                url: '/tasks/' + taskId,
                type: 'GET',
                success: function(response) {
                    if (response.status === 'success') {
                        var task = response.task;
                        
                        // Populate edit form with task data
                        $('#editTaskId').val(task.id);
                        $('#editTaskName').val(task.name);
                        $('#editTaskStatus').val(task.status);
                        $('#editTaskPriority').val(task.priority);
                        $('#editTaskDeadline').val(task.deadline);
                        $('#editTaskTotalSlots').val(task.total_slots);
                        $('#editTaskCompletedSlots').val(task.completed_slots);
                        $('#editTaskFormLink').val(task.form_link);
                        $('#editTaskDriveLink').val(task.drive_link);
                        
                        // Set max value for completed slots
                        $('#editTaskCompletedSlots').attr('max', task.total_slots);
                    } else {
                        alert("Error loading task for editing: " + response.message);
                    }
                },
                error: function(xhr) {
                    console.error("Error loading task for editing:", xhr.responseText);
                    alert("Error loading task for editing. Check console for details.");
                }
            });
        }
        
        function confirmDeleteTask(taskId) {
            $.ajax({
                url: '/tasks/' + taskId,
                type: 'GET',
                success: function(response) {
                    if (response.status === 'success') {
                        var task = response.task;
                        
                        // Set task name and ID in the delete confirmation modal
                        $('#deleteTaskName').text(task.name);
                        $('#deleteTaskId').val(task.id);
                        
                        // Show the modal
                        $('#deleteTaskModal').modal('show');
                    } else {
                        alert("Error loading task for deletion: " + response.message);
                    }
                },
                error: function(xhr) {
                    console.error("Error loading task for deletion:", xhr.responseText);
                    alert("Error loading task for deletion. Check console for details.");
                }
            });
        }
        
        function addNewTask() {
            // Get form values
            var formData = {
                name: $('#taskName').val(),
                status: $('#taskStatus').val(),
                priority: $('#taskPriority').val(),
                deadline: $('#taskDeadline').val(),
                total_slots: parseInt($('#taskTotalSlots').val()),
                completed_slots: parseInt($('#taskCompletedSlots').val()),
                form_link: $('#taskFormLink').val() || null,
                drive_link: $('#taskDriveLink').val() || null
            };
            
            $.ajax({
                url: '/tasks',
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.status === 'success') {
                        // Refresh page to show new task
                        window.location.reload();
                    } else {
                        alert("Error creating task: " + response.message);
                    }
                },
                error: function(xhr) {
                    console.error("Error creating task:", xhr.responseText);
                    var errors = xhr.responseJSON.errors;
                    var errorMsg = "Error creating task:";
                    $.each(errors, function(key, value) {
                        errorMsg += "\n- " + value;
                    });
                    alert(errorMsg);
                }
            });
        }
        
        function updateTask() {
            var taskId = $('#editTaskId').val();
            
            // Get form values
            var formData = {
                name: $('#editTaskName').val(),
                status: $('#editTaskStatus').val(),
                priority: $('#editTaskPriority').val(),
                deadline: $('#editTaskDeadline').val(),
                total_slots: parseInt($('#editTaskTotalSlots').val()),
                completed_slots: parseInt($('#editTaskCompletedSlots').val()),
                form_link: $('#editTaskFormLink').val() || null,
                drive_link: $('#editTaskDriveLink').val() || null
            };
            
            $.ajax({
                url: '/tasks/' + taskId,
                type: 'PUT',
                data: formData,
                success: function(response) {
                    if (response.status === 'success') {
                        // Refresh page to show updated task
                        window.location.reload();
                    } else {
                        alert("Error updating task: " + response.message);
                    }
                },
                error: function(xhr) {
                    console.error("Error updating task:", xhr.responseText);
                    var errors = xhr.responseJSON.errors;
                    var errorMsg = "Error updating task:";
                    $.each(errors, function(key, value) {
                        errorMsg += "\n- " + value;
                    });
                    alert(errorMsg);
                }
            });
        }
        
        function deleteTask() {
            var taskId = $('#deleteTaskId').val();
            
            $.ajax({
                url: '/tasks/' + taskId,
                type: 'DELETE',
                success: function(response) {
                    if (response.status === 'success') {
                        // Refresh page to show task was removed
                        window.location.reload();
                    } else {
                        alert("Error deleting task: " + response.message);
                    }
                },
                error: function(xhr) {
                    console.error("Error deleting task:", xhr.responseText);
                    alert("Error deleting task. Check console for details.");
                }
            });
        }
        
        // Initialize the sidebar toggle
        $("#sidebarToggle, #sidebarToggleTop").on('click', function(e) {
            $("body").toggleClass("sidebar-toggled");
            $(".sidebar").toggleClass("toggled");
            if ($(".sidebar").hasClass("toggled")) {
                $('.sidebar .collapse').collapse('hide');
            };
        });
    });
</script>
@endsection
