<div class="form-body">
    <h3 class="card-title">Site Info</h3>
    <hr>

    <div class="row p-t-20">

        {{-- Site Title --}}
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                <label class="control-label">Site Title</label>
                <input
                    type="text"
                    name="title"
                    id="title"
                    class="form-control"
                    placeholder="e.g Matrix Media"
                    required
                    value="{{ old('title', $setting->title ?? '') }}"
                >
                @error('title') <p class="error">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Tagline --}}
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('tagline') ? 'has-error' : '' }}">
                <label class="control-label">Site Tagline</label>
                <input
                    type="text"
                    name="tagline"
                    class="form-control"
                    placeholder="e.g step ahead"
                    value="{{ old('tagline', $setting->tagline ?? '') }}"
                >
                @error('tagline') <p class="error">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Email --}}
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('emails') ? 'has-error' : '' }}">
                <label class="control-label">Site Email</label>
                <input
                    type="email"
                    name="emails"
                    class="form-control"
                    placeholder="e.g info@sitename.com"
                    value="{{ old('emails', $setting->emails ?? '') }}"
                >
                @error('emails') <p class="error">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Dashboard Notification --}}
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('noti_dashboard') ? 'has-error' : '' }}">
                <label class="control-label">Dashboard Notification</label>
                <input
                    type="text"
                    name="noti_dashboard"
                    class="form-control"
                    value="{{ old('noti_dashboard', $setting->noti_dashboard ?? '') }}"
                >
                @error('noti_dashboard') <p class="error">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Total Team --}}
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('total_team') ? 'has-error' : '' }}">
                <label class="control-label">Total Team</label>
                <input
                    type="number"
                    name="total_team"
                    class="form-control"
                    value="{{ old('total_team', $setting->total_team ?? '') }}"
                >
                @error('total_team') <p class="error">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Total Active Team --}}
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('total_team_active') ? 'has-error' : '' }}">
                <label class="control-label">Total Team Active</label>
                <input
                    type="number"
                    name="total_team_active"
                    class="form-control"
                    value="{{ old('total_team_active', $setting->total_team_active ?? '') }}"
                >
                @error('total_team_active') <p class="error">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Time fields --}}
        @foreach ([
            'ads_start_time' => 'Ads Start Time',
            'ads_end_time' => 'Ads End Time',
            'withdraw_start_time' => 'Withdraw Start Time',
            'withdraw_end_time' => 'Withdraw End Time',
        ] as $field => $label)
            <div class="col-md-6">
                <div class="form-group {{ $errors->has($field) ? 'has-error' : '' }}">
                    <label class="control-label">{{ $label }}</label>
                    <input
                        type="text"
                        name="{{ $field }}"
                        class="form-control timepicker"
                        value="{{ old($field, $setting->$field ?? '') }}"
                    >
                    @error($field) <p class="error">{{ $message }}</p> @enderror
                </div>
            </div>
        @endforeach

        {{-- Withdraw Date --}}
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('date_withdrawl') ? 'has-error' : '' }}">
                <label class="control-label">Withdraw Date</label>
                <input
                    type="date"
                    name="date_withdrawl"
                    class="form-control"
                    value="{{ old('date_withdrawl', $setting->date_withdrawl ?? '') }}"
                >
                @error('date_withdrawl') <p class="error">{{ $message }}</p> @enderror
            </div>
        </div>

    </div>

    <h3 class="box-title m-t-40">Image</h3>
    <hr>

    <div class="row">

        {{-- Logo --}}
        <div class="col-md-4">
            <div class="form-group">
                <label>Logo</label>
                <img src="{{ asset('uploads/'.$setting->logo) }}" width="100">
                <input type="file" name="logo" class="form-control">
                @error('logo') <p class="error">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Favicon --}}
        <div class="col-md-4">
            <div class="form-group">
                <label>Fav Icon</label>
                <img src="{{ asset('uploads/'.$setting->favicon) }}" width="50">
                <input type="file" name="favicon" class="form-control">
                @error('favicon') <p class="error">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Scanner --}}
        <div class="col-md-4">
            <div class="form-group">
                <label>Scanner Image</label>
                <img src="{{ asset('uploads/'.$setting->scanner) }}" width="50">
                <input type="file" name="scanner" class="form-control">
                @error('scanner') <p class="error">{{ $message }}</p> @enderror
            </div>
        </div>

    </div>
    <hr>
</div>
