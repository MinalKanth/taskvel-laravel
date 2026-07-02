@extends('layouts.app')

@section('title', 'Edit Client')

@section('content')

<div class="container-fluid">

    <!-- Page Header -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                Edit Client

            </h2>

            <p class="text-muted mb-0">

                Update client information.

            </p>

        </div>

        <div>

            <a href="{{ route('clients.show', $client) }}"
               class="btn btn-info me-2">

                <i class="mdi mdi-eye"></i>

                View

            </a>

            <a href="{{ route('clients.index') }}"
               class="btn btn-secondary">

                <i class="mdi mdi-arrow-left"></i>

                Back

            </a>

        </div>

    </div>

    @if ($errors->any())

        <div class="alert alert-danger">

            <strong>Please correct the following errors:</strong>

            <hr>

            <ul class="mb-0">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <form
        action="{{ route('clients.update', $client) }}"
        method="POST">

        @csrf

        @method('PUT')

        @include('clients.partials._form')

    </form>

    @can('delete', $client)

        <form
            id="delete-form"
            action="{{ route('clients.destroy', $client) }}"
            method="POST"
            class="d-none">

            @csrf

            @method('DELETE')

        </form>

    @endcan

</div>

@endsection

@push('scripts')

<script>

function deleteClient()
{
    if(confirm('Are you sure you want to delete this client?'))
    {
        document.getElementById('delete-form').submit();
    }
}

</script>

@endpush