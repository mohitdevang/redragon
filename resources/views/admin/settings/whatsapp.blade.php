@extends('layouts.main')
@section('title', 'WhatsApp Settings')
@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">WhatsApp (Meta Cloud API)</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                @component('elements.admin.components.flash') @endcomponent
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <form action="{{ route('admin.whatsapp.settings.update') }}" method="POST" id="whatsapp-settings-form">
                    @csrf
                    @method('PATCH')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Mode</label>
                                <select name="mode" class="form-control" id="wa-mode">
                                    <option value="sandbox" {{ $setting->mode === 'sandbox' ? 'selected' : '' }}>Sandbox</option>
                                    <option value="live" {{ $setting->mode === 'live' ? 'selected' : '' }}>Live</option>
                                </select>
                                <p class="help-block">Sandbox returns OTP in API response for QA. Live sends via WhatsApp only.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Graph API Version</label>
                                <input type="text" name="graph_api_version" class="form-control" value="{{ old('graph_api_version', $setting->graph_api_version) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Enabled</label>
                                <select name="enabled" class="form-control">
                                    <option value="0" {{ !$setting->enabled ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ $setting->enabled ? 'selected' : '' }}>Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Phone Number ID</label>
                                <input type="text" name="phone_number_id" class="form-control" value="{{ old('phone_number_id', $setting->phone_number_id) }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Access Token</label>
                                <input type="password" name="access_token" class="form-control" placeholder="{{ $setting->access_token ? '•••••••• (leave blank to keep)' : '' }}">
                                @if($setting->access_token)<p class="text-success">Access token is set.</p>@endif
                            </div>
                        </div>
                        <div class="col-md-6" id="sandbox-otp-wrap">
                            <div class="form-group">
                                <label>Default OTP (Sandbox)</label>
                                <input type="text" name="sandbox_default_otp" class="form-control" value="{{ old('sandbox_default_otp', $setting->sandbox_default_otp) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>OTP Resend Cooldown (seconds)</label>
                                <input type="number" name="otp_resend_cooldown_seconds" class="form-control" min="30" max="600" value="{{ old('otp_resend_cooldown_seconds', $setting->otp_resend_cooldown_seconds ?? 120) }}">
                            </div>
                        </div>
                    </div>

                    <h4 class="m-t-20">OTP Template</h4>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>OTP Template Name</label>
                                <input type="text" name="otp_template_name" class="form-control" value="{{ old('otp_template_name', $setting->otp_template_name) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>OTP Template Language</label>
                                <input type="text" name="otp_template_language" class="form-control" value="{{ old('otp_template_language', $setting->otp_template_language) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>OTP Template Body Variables Count</label>
                                <select name="otp_template_body_variables" class="form-control">
                                    <option value="0" {{ (int)$setting->otp_template_body_variables === 0 ? 'selected' : '' }}>0 (no body placeholders)</option>
                                    @for($i=1;$i<=20;$i++)
                                    <option value="{{ $i }}" {{ (int)$setting->otp_template_body_variables === $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                                <p class="help-block text-muted">Optional legacy hint. Sending auto-detects placeholder count from Meta (or from API error) — only mapped positions are filled; others stay empty.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>OTP Expiry (minutes)</label>
                                <input type="number" name="otp_expiry_minutes" class="form-control" min="1" max="60" value="{{ old('otp_expiry_minutes', $setting->otp_expiry_minutes) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>OTP Max Attempts</label>
                                <input type="number" name="otp_max_attempts" class="form-control" min="1" max="10" value="{{ old('otp_max_attempts', $setting->otp_max_attempts) }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#otpVarModal">
                                <i class="fa fa-info-circle"></i> OTP variable guide
                            </button>
                            <p class="help-block m-t-5 m-b-0">Used for registration OTP and address-update OTP messages.</p>
                        </div>
                    </div>

                    <h4 class="m-t-20">Welcome Template</h4>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><input type="checkbox" name="welcome_enabled" value="1" {{ $setting->welcome_enabled ? 'checked' : '' }}> Send Welcome Message on Registration</label>
                                <p class="help-block">Sent after successful registration when enabled and template name is set.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Welcome Template Name</label>
                                <input type="text" name="welcome_template_name" class="form-control" value="{{ old('welcome_template_name', $setting->welcome_template_name) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Welcome Template Language</label>
                                <input type="text" name="welcome_template_language" class="form-control" value="{{ old('welcome_template_language', $setting->welcome_template_language) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Welcome Template Body Variables Count</label>
                                <select name="welcome_template_body_variables" class="form-control">
                                    @for($i=1;$i<=50;$i++)
                                    <option value="{{ $i }}" {{ (int)($setting->welcome_template_body_variables ?? 10) === $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                                <p class="help-block text-muted">Optional legacy hint. Welcome messages auto-match template placeholder count; only mapped fields (see guide) are filled.</p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#welcomeVarModal">
                                <i class="fa fa-info-circle"></i> Welcome variable guide
                            </button>
                            <p class="help-block m-t-5 m-b-0">Maps member profile fields to template placeholders in order.</p>
                        </div>
                    </div>

                    <div class="row m-t-10">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-primary" id="btn-test-connection">Test connection</button>
                            <div id="wa-test-alert" class="alert" style="display:none; margin-top:12px; margin-bottom:0;" role="alert"></div>
                        </div>
                        <div class="col-md-6 m-t-10">
                            <div class="form-group">
                                <label><input type="checkbox" name="require_otp_address_update" value="1" {{ $setting->require_otp_address_update ? 'checked' : '' }}> Require OTP for Address Update</label>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-info">Save WhatsApp Settings</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="otpVarModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">OTP template variable guide</h4>
            </div>
            <div class="modal-body">
                <p>Meta replaces body placeholders <strong>in order</strong> when sending OTP templates (registration + wallet address update).</p>
                <p>The system reads how many placeholders your Meta template uses and sends only that many. <strong>{{1}}</strong> = OTP code, <strong>{{2}}</strong> = expiry minutes; any extra slots in the template are left empty unless you map them.</p>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Placeholder</th>
                            <th>Sent value</th>
                            <th>Example</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>@{{1}}</code></td>
                            <td>6-digit OTP code</td>
                            <td><code>123456</code></td>
                        </tr>
                        <tr>
                            <td><code>@{{2}}</code></td>
                            <td>OTP expiry (minutes)</td>
                            <td><code>5</code></td>
                        </tr>
                        <tr>
                            <td><code>@{{3}}</code>+</td>
                            <td>Empty (only if your template includes more body placeholders)</td>
                            <td>—</td>
                        </tr>
                    </tbody>
                </table>
                <p class="text-muted"><strong>Example Meta template body:</strong><br>
                    @verbatim
                    <em>Your verification code is {{1}}. Valid for {{2}} minutes. Do not share this code.</em>
                    @endverbatim
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="welcomeVarModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Welcome template variable guide</h4>
            </div>
            <div class="modal-body">
                <p>After a member registers successfully, the system sends a WhatsApp welcome template (if enabled) to their registered mobile number.</p>
                <p>Welcome messages use the same auto-sizing: only as many parameters as the template defines. Mapped positions below are filled from the new member; any other placeholder in the template is sent empty.</p>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Placeholder</th>
                            <th>User field</th>
                            <th>Description</th>
                            <th>Example</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Services\WhatsApp\WelcomeTemplateParams::definitions() as $var)
                        <tr>
                            <td><code>{!! '&#123;&#123;' . $var['position'] . '&#125;&#125;' !!}</code></td>
                            <td><code>{{ $var['key'] }}</code></td>
                            <td>{{ $var['label'] }}</td>
                            <td>{{ $var['example'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <p class="text-warning"><strong>Note:</strong> Placeholder count is detected automatically from your Meta template. Extra template slots are sent empty; only mapped rows above are filled.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('custom-js')
<script src="{{ url('/') }}/public/admin/assets/js/redragon-json.js"></script>
<script>
(function(){
    var csrf = $('meta[name="csrf-token"]').attr('content');
    var $alert = $('#wa-test-alert');

    function toggleSandbox(){ $('#sandbox-otp-wrap').toggle($('#wa-mode').val()==='sandbox'); }
    $('#wa-mode').on('change', toggleSandbox);
    toggleSandbox();

    $('#btn-test-connection').on('click', function(){
        var btn = $(this);
        btn.prop('disabled', true);
        $alert.removeClass('alert-success alert-danger alert-info').hide().html('');
        $alert.addClass('alert-info').show().html('<strong>Testing...</strong> Please wait.');

        $.ajax({
            url: '{{ route('admin.whatsapp.test_connection') }}',
            method: 'POST',
            dataType: 'text',
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            data: {
                _token: csrf,
                phone_number_id: $('input[name=phone_number_id]').val(),
                access_token: $('input[name=access_token]').val(),
                graph_api_version: $('input[name=graph_api_version]').val()
            }
        }).done(function(text, status, xhr){
            var res = RedragonJson.parse(xhr) || RedragonJson.parse(text);
            if (res && res.success) {
                $alert.removeClass('alert-info alert-danger').addClass('alert-success')
                    .html('<strong>Success:</strong> ' + (res.message || 'Connected to Meta API.'));
            } else {
                $alert.removeClass('alert-info alert-success').addClass('alert-danger')
                    .html('<strong>Failed:</strong> ' + ((res && res.message) ? res.message : 'Could not connect.'));
            }
        }).fail(function(xhr){
            var res = RedragonJson.parse(xhr);
            var msg = (res && res.message) ? res.message : 'Request failed. Check Phone Number ID and Access Token.';
            $alert.removeClass('alert-info alert-success').addClass('alert-danger')
                .html('<strong>Failed:</strong> ' + msg);
        }).always(function(){ btn.prop('disabled', false); });
    });
})();
</script>
@endpush
