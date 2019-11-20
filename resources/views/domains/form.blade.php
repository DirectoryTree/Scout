@inject('types', 'App\Http\Injectors\DomainTypeInjector')

<div class="form-row">
    <div class="col-md-6">
        <div class="form-group">
            {{ form()->label()->for('encryption')->text(__('Connection Encryption')) }}

            <div class="d-flex justify-content-start">
                <div class="mr-2">
                    {{
                        form()->radio()
                            ->id('none')
                            ->name('encryption')
                            ->label('No Encryption')
                            ->value('')
                            ->checked($domain->encryption == '')
                            ->data('target', 'form.input')
                    }}
                </div>

                <div class="mr-2">
                    {{
                        form()->radio()
                            ->id('radio-use-tls')
                            ->name('encryption')
                            ->label('Use TLS')
                            ->value('tls')
                            ->checked($domain->encryption == 'tls')
                            ->data('target', 'form.input')
                    }}
                </div>

                <div class="mr-2">
                    {{
                        form()->radio()
                            ->id('radio-use-ssl')
                            ->name('encryption')
                            ->label('Use SSL')
                            ->value('ssl')
                            ->checked($domain->encryption == 'ssl')
                            ->data('target', 'form.input')
                    }}
                </div>
            </div>

            {{ form()->error()->data('input', 'encryption')->data('target', 'form.error') }}

            <small class="form-text text-muted">
                <strong>Note:</strong> You must select TLS or SSL encryption to be able to perform all password related LDAP tasks.
            </small>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            {{ form()->label()->for('write_back')->text(__('Write-Back')) }}

            {{
                form()->checkbox()
                    ->id('checkbox-domain-write-back')
                    ->name('write_back')
                    ->value(true)
                    ->checked($domain->write_back)
                    ->label('Enable Domain Write Back')
            }}

            <small class="form-text text-muted">
                Domain write-back allows you to modify LDAP objects through Scout.
            </small>
        </div>
    </div>
</div>

<hr/>

<div class="form-row">
    <div class="col">
        <div class="form-group">
            {{ form()->label()->for('type')->text(__('Connection Type')) }}

            {{
                form()->select()
                    ->name('type')
                    ->options($types->get())
                    ->value($domain->type)
                    ->data('target', 'form.input')
                    ->data('action', 'change->form#clearError')
            }}

            {{ form()->error()->data('input', 'type')->data('target', 'form.error') }}
        </div>
    </div>

    <div class="col">
        <div class="form-group">
            {{ form()->label()->for('name')->text(__('Connection Name')) }}

            {{
                form()->input()
                    ->name('name')
                    ->value($domain->name)
                    ->required()
                    ->autofocus()
                    ->placeholder('Domain Name / Company')
                    ->data('target', 'form.input')
                    ->data('action', 'keyup->form#clearError')
            }}

            {{ form()->error()->data('input', 'name')->data('target', 'form.error') }}
        </div>
    </div>
</div>

<div class="form-row">
    <div class="col">
        <div class="form-group">
            {{ form()->label()->for('hosts')->text(__('Hosts / Controllers')) }}

            {{
                form()->input()
                    ->name('hosts')
                    ->value(implode(',', $domain->hosts ?? []))
                    ->required()
                    ->placeholder('10.0.0.1,10.0.0.2')
                    ->data('target', 'form.input')
                    ->data('action', 'keyup->form#clearError')
            }}

            {{ form()->error()->data('input', 'hosts')->data('target', 'form.error') }}

            <small class="form-text text-muted">
                Enter each host separated by a comma.
            </small>
        </div>
    </div>

    <div class="col">
        <div class="form-group">
            {{ form()->label()->for('port')->text(__('Port')) }}

            {{
                form()->number()
                    ->name('port')
                    ->value($domain->port ?? 389)
                    ->required()
                    ->placeholder('389')
                    ->data('target', 'form.input')
                    ->data('action', 'keyup->form#clearError')
            }}

            <small class="form-text text-muted">
                This is usually <strong>389</strong> or <strong>587</strong>.
            </small>

            {{ form()->error()->data('input', 'port')->data('target', 'form.error') }}
        </div>
    </div>

    <div class="col">
        <div class="form-group">
            {{ form()->label()->for('timeout')->text(__('Timeout')) }}

            {{
                form()->number()
                    ->name('timeout')
                    ->value($domain->timeout ?? 5)
                    ->required()
                    ->placeholder('5')
                    ->data('target', 'form.input')
                    ->data('action', 'keyup->form#clearError')
            }}

            <small class="form-text text-muted">
                The amount of <strong>seconds</strong> to wait for LDAP connectivity.
            </small>

            {{ form()->error()->data('input', 'timeout')->data('target', 'form.error') }}
        </div>
    </div>
</div>

<div class="form-row">
    <div class="col">
        <div class="form-group">
            {{ form()->label()->for('base_dn')->text(__('Search Base DN')) }}

            {{
                form()->input()
                    ->name('base_dn')
                    ->value($domain->base_dn)
                    ->required()
                    ->placeholder('dc=local,dc=com')
                    ->data('target', 'form.input')
                    ->data('action', 'keyup->form#clearError')
            }}

            {{ form()->error()->data('input', 'base_dn')->data('target', 'form.error') }}

            <small class="form-text text-muted">
                The <strong>Search Base DN</strong> is critical to scanning your directory.
            </small>
        </div>
    </div>

    <div class="col">
        <div class="form-group">
            {{ form()->label()->for('filter')->text(__('Global Search Filter')) }}

            {{
                form()->input()
                    ->name('filter')
                    ->value($domain->filter)
                    ->placeholder('(example=value)')
                    ->data('target', 'form.input')
                    ->data('action', 'keyup->form#clearError')
            }}

            {{ form()->error()->data('input', 'filter')->data('target', 'form.error') }}

            <small class="form-text text-muted">
                This filter is applied on <strong>every scan</strong> on your directory.
            </small>
        </div>
    </div>
</div>

<hr/>

<div class="alert alert-primary shadow-sm">
    <i class="fa fa-exclamation-circle"></i>

    {{ __('The username and password fields are encrypted using OpenSSL and the AES-256-CBC cipher. ') }}
</div>

<div class="form-row">
    <div class="col">
        <div class="form-group">
            {{ form()->label()->for('username')->text(__('Username')) }}

            {{
                form()->input()
                    ->name('username')
                    ->value($domain->username ? decrypt($domain->username) : null)
                    ->required()
                    ->placeholder('admin')
                    ->data('target', 'form.input')
                    ->data('action', 'keyup->form#clearError')
            }}

            <small class="form-text text-muted">
                This must be a full <strong>Distinguished Name</strong> or <strong>User Principal Name.</strong>
            </small>

            {{ form()->error()->data('input', 'username')->data('target', 'form.error') }}
        </div>
    </div>

    <div class="col">
        <div class="form-group">
            {{ form()->label()->for('password')->text(__('Password')) }}

            {{
                form()->password()
                    ->name('password')
                    ->required(!isset($domain->password))
                    ->placeholder('secret')
                    ->data('target', 'form.input')
                    ->data('action', 'keyup->form#clearError')
            }}

            @if($domain->exists)
                <small class="form-text text-muted">
                    Only enter a password if you would like the current changed.
                </small>
            @endif

            {{ form()->error()->data('input', 'password')->data('target', 'form.error') }}
        </div>
    </div>
</div>
