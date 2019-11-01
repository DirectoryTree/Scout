<div class="form-row">
    <div class="col">
        <div class="form-group">
            {{ Form::scoutLabel('encryption', __('Connection Encryption')) }}

            <div class="d-flex justify-content-start">
                <div class="mr-2">
                    {{
                        Form::scoutRadio('encryption', '', $domain->encryption == '', [
                            'id' => 'none',
                            'label' => 'No Encryption',
                            'data-target' => 'form.input',
                        ])
                    }}
                </div>

                <div class="mr-2">
                    {{
                        Form::scoutRadio('encryption', 'tls', $domain->encryption == 'tls', [
                            'id' => 'radio-use-tls',
                            'label' => 'Use TLS',
                            'data-target' => 'form.input',
                        ])
                    }}
                </div>

                <div class="mr-2">
                    {{
                        Form::scoutRadio('encryption', 'ssl', $domain->encryption == 'ssl', [
                            'id' => 'radio-use-ssl',
                            'label' => 'Use SSL',
                            'data-target' => 'form.input',
                        ])
                    }}
                </div>
            </div>

            {{
                Form::scoutError([
                    'data-input' => 'encryption',
                    'data-target' => 'form.error',
                ])
            }}

            <small class="form-text text-muted">
                <strong>Note:</strong> You must select TLS or SSL encryption to be able to perform all password related LDAP tasks.
            </small>
        </div>
    </div>

    <div class="col">
        <div class="form-group">
            {{ Form::scoutLabel('write_back', __('Write-Back')) }}

            {{
                Form::scoutCheckbox('write_back', 'Domain Write Back', $domain->write_back, [
                    'id' => 'checkbox-domain-write-back',
                    'label' => 'Enable Domain Write Back',
                ])
            }}

            <small class="form-text text-muted">
                Domain write-back allows you to modify LDAP objects through Scout.
            </small>
        </div>
    </div>
</div>

<div class="form-row">
    <div class="col">
        <div class="form-group">
            {{ Form::scoutLabel('type', __('Connection Type')) }}

            {{
                Form::scoutSelect('type', $types, $domain->type, [
                    'required',
                    'data-target' => 'form.input',
                    'data-action' => 'keyup->form#clearError',
                ])
            }}

            {{
                Form::scoutError([
                    'data-input' => 'type',
                    'data-target' => 'form.error',
                ])
            }}
        </div>
    </div>

    <div class="col">
        <div class="form-group">
            {{ Form::scoutLabel('name', __('Connection Name')) }}

            {{
                Form::scoutText('name', $domain->name, [
                    'required',
                    'autofocus',
                    'data-target' => 'form.input',
                    'data-action' => 'keyup->form#clearError',
                    'placeholder' => 'Domain Name / Company',
                ])
            }}

            {{
                Form::scoutError([
                    'data-input' => 'name',
                    'data-target' => 'form.error',
                ])
            }}
        </div>
    </div>
</div>

<div class="form-row">
    <div class="col">
        <div class="form-group">
            {{ Form::scoutLabel('hosts', __('Hosts / Controllers')) }}

            {{
                Form::scoutText('hosts', implode(',', $domain->hosts ?? []), [
                    'required',
                    'autofocus',
                    'data-target' => 'form.input',
                    'data-action' => 'keyup->form#clearError',
                    'placeholder' => '10.0.0.1,10.0.0.2',
                ])
            }}

            {{
                Form::scoutError([
                    'data-input' => 'hosts',
                    'data-target' => 'form.error',
                ])
            }}

            <small class="form-text text-muted">
                Enter each host separated by a comma.
            </small>
        </div>
    </div>

    <div class="col">
        <div class="form-group">
            {{ Form::scoutLabel('port', __('Port')) }}

            {{
                Form::scoutNumber('port', $domain->port ?? 389, [
                    'required',
                    'data-target' => 'form.input',
                    'data-action' => 'keyup->form#clearError',
                    'placeholder' => '389',
                ])
            }}

            <small class="form-text text-muted">
                This is usually <strong>389</strong> or <strong>587</strong>.
            </small>

            {{
                Form::scoutError([
                    'data-input' => 'port',
                    'data-target' => 'form.error',
                ])
            }}
        </div>
    </div>

    <div class="col">
        <div class="form-group">
            {{ Form::scoutLabel('timeout', __('Timeout')) }}

            {{
                Form::scoutNumber('timeout', $domain->timeout ?? 5, [
                    'required',
                    'data-target' => 'form.input',
                    'data-action' => 'keyup->form#clearError',
                    'placeholder' => '5',
                ])
            }}

            <small class="form-text text-muted">
                The amount of <strong>seconds</strong> to wait for LDAP connectivity.
            </small>

            {{
                Form::scoutError([
                    'data-input' => 'timeout',
                    'data-target' => 'form.error',
                ])
            }}
        </div>
    </div>
</div>

<div class="form-row">
    <div class="col">
        <div class="form-group">
            {{ Form::scoutLabel('base_dn', __('Search Base DN')) }}

            {{
                Form::scoutText('base_dn', $domain->base_dn, [
                    'required',
                    'data-target' => 'form.input',
                    'data-action' => 'keyup->form#clearError',
                    'placeholder' => 'dc=local,dc=com',
                ])
            }}

            {{
                Form::scoutError([
                    'data-input' => 'base_dn',
                    'data-target' => 'form.error',
                ])
            }}

            <small class="form-text text-muted">
                The <strong>Search Base DN</strong> is critical to scanning your directory.
            </small>
        </div>
    </div>

    <div class="col">
        <div class="form-group">
            {{ Form::scoutLabel('filter', __('Global Search Filter')) }}

            {{
                Form::scoutText('filter', $domain->filter, [
                    'data-target' => 'form.input',
                    'data-action' => 'keyup->form#clearError',
                    'placeholder' => '(example=value)',
                ])
            }}

            {{
                Form::scoutError([
                    'data-input' => 'filter',
                    'data-target' => 'form.error',
                ])
            }}

            <small class="form-text text-muted">
                This filter is applied on <strong>every scan</strong> on your directory.
            </small>
        </div>
    </div>
</div>

<hr/>

<div class="alert alert-primary">
    <i class="fa fa-exclamation-circle"></i>

    {{ __('The username and password fields are encrypted using OpenSSL and the AES-256-CBC cipher. ') }}
</div>

<div class="form-row">
    <div class="col">
        <div class="form-group">
            {{ Form::scoutLabel('username', __('Username')) }}

            {{
                Form::scoutText('username', $domain->username ? decrypt($domain->username) : null, [
                    'data-target' => 'form.input',
                    'data-action' => 'keyup->form#clearError',
                    'placeholder' => 'admin',
                ])
            }}

            <small class="form-text text-muted">
                This must be a full <strong>Distinguished Name</strong> or <strong>User Principal Name.</strong>
            </small>

            {{
                Form::scoutError([
                    'data-input' => 'username',
                    'data-target' => 'form.error',
                ])
            }}
        </div>
    </div>

    <div class="col">
        <div class="form-group">
            {{ Form::scoutLabel('password', __('Password')) }}

            {{
                Form::scoutPassword('password', [
                    'data-target' => 'form.input',
                    'data-action' => 'keyup->form#clearError',
                    'placeholder' => 'secret',
                ])
            }}

            {{
                Form::scoutError([
                    'data-input' => 'password',
                    'data-target' => 'form.error',
                ])
            }}
        </div>
    </div>
</div>
