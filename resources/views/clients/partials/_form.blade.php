@csrf

@if(isset($client))
    @method('PUT')
@endif

<div class="row">

    <div class="col-md-6 mb-3">
        <label class="form-label">Company Name <span class="text-danger">*</span></label>
        <input
            type="text"
            name="company_name"
            class="form-control @error('company_name') is-invalid @enderror"
            value="{{ old('company_name', $client->company_name ?? '') }}">

        @error('company_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Legal Name</label>
        <input
            type="text"
            name="legal_name"
            class="form-control @error('legal_name') is-invalid @enderror"
            value="{{ old('legal_name', $client->legal_name ?? '') }}">

        @error('legal_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Business Type</label>

        <select
            name="business_type"
            class="form-select @error('business_type') is-invalid @enderror">

            <option value="">Select Business Type</option>

            @foreach([
                'Proprietorship',
                'Partnership',
                'LLP',
                'Private Limited',
                'Public Limited',
                'OPC',
                'Trust',
                'Society',
                'NGO',
                'Government',
                'Other'
            ] as $type)

                <option
                    value="{{ $type }}"
                    @selected(old('business_type', $client->business_type ?? '') == $type)>
                    {{ $type }}
                </option>

            @endforeach

        </select>

        @error('business_type')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Constitution</label>

        <select
            name="constitution"
            class="form-select @error('constitution') is-invalid @enderror">

            <option value="">Select Constitution</option>

            @foreach([
                'Proprietorship',
                'Partnership',
                'LLP',
                'Private Limited',
                'Public Limited',
                'Trust',
                'Society',
                'NGO',
                'Other'
            ] as $constitution)

                <option
                    value="{{ $constitution }}"
                    @selected(old('constitution', $client->constitution ?? '') == $constitution)>
                    {{ $constitution }}
                </option>

            @endforeach

        </select>

        @error('constitution')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Status</label>

        <select
            name="status"
            class="form-select @error('status') is-invalid @enderror">

            @foreach([
                'Lead',
                'Prospect',
                'Active',
                'Inactive',
                'Suspended',
                'Closed'
            ] as $status)

                <option
                    value="{{ $status }}"
                    @selected(old('status', $client->status ?? '') == $status)>
                    {{ $status }}
                </option>

            @endforeach

        </select>

        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
    <label class="form-label">
        Priority
    </label>

    <select
        name="priority"
        class="form-select @error('priority') is-invalid @enderror">

        <option value="Low"
            @selected(old('priority', $client->priority ?? 'Medium') == 'Low')>
            Low
        </option>

        <option value="Medium"
            @selected(old('priority', $client->priority ?? 'Medium') == 'Medium')>
            Medium
        </option>

        <option value="High"
            @selected(old('priority', $client->priority ?? 'Medium') == 'High')>
            High
        </option>

        <option value="Critical"
            @selected(old('priority', $client->priority ?? 'Medium') == 'Critical')>
            Critical
        </option>

    </select>

    @error('priority')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Email</label>

        <input
            type="email"
            name="email"
            class="form-control"
            value="{{ old('email', $client->email ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Phone</label>

        <input
            type="text"
            name="phone"
            class="form-control"
            value="{{ old('phone', $client->phone ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Website</label>

        <input
            type="url"
            name="website"
            class="form-control"
            value="{{ old('website', $client->website ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Assigned To</label>

        <select name="assigned_to" class="form-select">

            <option value="">Select Employee</option>

            @foreach($users as $user)

                <option
                    value="{{ $user->id }}"
                    @selected(old('assigned_to', $client->assigned_to ?? '') == $user->id)>

                    {{ $user->name }}

                </option>

            @endforeach

        </select>
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">Notes</label>

        <textarea
            name="notes"
            rows="5"
            class="form-control">{{ old('notes', $client->notes ?? '') }}</textarea>
    </div>

    <div class="col-md-12">

        <div class="form-check form-switch">

            <input
                class="form-check-input"
                type="checkbox"
                name="is_active"
                value="1"
                @checked(old('is_active', $client->is_active ?? true))>

            <label class="form-check-label">
                Active Client
            </label>

        </div>

    </div>

</div>

<div class="mt-4">

    <button type="submit" class="btn btn-primary">
        <i class="mdi mdi-content-save me-1"></i>

        {{ isset($client) ? 'Update Client' : 'Create Client' }}
    </button>

    <a href="{{ route('clients.index') }}" class="btn btn-secondary">
        Cancel
    </a>

</div>