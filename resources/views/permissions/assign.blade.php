@extends('layouts.app')

@section('title', 'Assign Permissions')

@section('content')
<div class="container-fluid px-3 px-lg-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Assign Permissions</h2>
            <p class="text-muted mb-0">Assign permissions to users.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('permissions.assign') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="user_type" class="form-label">User Type</label>
                    <select name="user_type" id="user_type" class="form-control" required>
                        <option value="">Select User Type</option>
                        <option value="client">Client</option>
                        <!-- Add other user types as needed -->
                    </select>
                </div>
                <div class="mb-3">
                    <label for="user_id" class="form-label">User</label>
                    <select name="user_id" id="user_id" class="form-control" required>
                        <option value="">Select User</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Permissions</label>
                    @foreach($permissions as $permission)
                        <div class="form-check">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission-{{ $permission->id }}" class="form-check-input">
                            <label for="permission-{{ $permission->id }}" class="form-check-label">{{ $permission->name }}</label>
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-primary">Assign Permissions</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#user_type').on('change', function() {
            var userType = $(this).val();
            if (userType) {
                $.ajax({
                    url: '{{ route('users.by_type') }}',
                    type: 'GET',
                    data: { user_type: userType },
                    success: function(data) {
                        $('#user_id').html('<option value="">Select User</option>');
                        $.each(data, function(key, value) {
                            $('#user_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            } else {
                $('#user_id').html('<option value="">Select User</option>');
            }
        });
    });
</script>
@endpush