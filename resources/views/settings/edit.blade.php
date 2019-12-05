@extends('settings.layout')

@section('title', __('Application Settings'))

@section('page')
    @inject('timezones', 'App\Http\Injectors\TimezoneInjector')

    <form method="post" action="{{ route('settings.update') }}" data-controller="form" class="mb-4">
        @csrf
        @method('patch')

        <div class="card shadow-sm">
            <div class="card-header border-bottom">
                <h6 class="mb-0 text-muted font-weight-bold">{{ __('Application Settings') }}</h6>
            </div>

            <div class="card-body">
                <div class="form-group">
                    {{ form()->label()->for('timezone')->text('Timezone') }}

                    {{
                        form()->select()
                            ->name('timezone')
                            ->options($timezones->get())
                            ->required()
                            ->value(setting('app.timezone', env('APP_TIMEZONE')))
                            ->data('target', 'form.input')
                            ->data('action', 'form->change#clearError')
                    }}
                </div>

                <div class="form-group">
                    {{ form()->label()->for('frequency')->text('Scan Frequency') }}

                    <div class="input-group">
                        {{
                            form()->number()
                                ->name('frequency')
                                ->required()
                                ->value(setting('app.scan.frequency', '15'))
                                ->data('target', 'form.input')
                                ->data('action', 'change->form#clearError')
                        }}

                        <div class="input-group-append">
                            <span class="input-group-text">minutes</span>
                        </div>
                    </div>

                    {{ form()->error()->data('input', 'frequency')->data('target', 'form.error') }}

                    <small class="text-muted">
                        This setting controls how frequently domains are scanned in minutes. (Allowed: 5-59)
                    </small>
                </div>
            </div>

            <div class="card-header border-bottom">
                <h6 class="mb-0 text-muted font-weight-bold">{{ __('Feature Settings') }}</h6>
            </div>

            <div class="card-body">
                <div class="form-group">
                    {{
                        form()->checkbox()
                            ->name('pinning')
                            ->value(true)
                            ->checked(setting('app.pinning', true))
                            ->id('pinning')
                            ->label(__('Enable pinning objects to dashboard'))
                            ->data('target', 'form.input')
                    }}

                    <small class="text-muted">
                        Disabling pinning will only hide the pin buttons and remove the pinning section from all user dashboards.
                    </small>
                </div>

                <div class="form-group">
                    {{
                        form()->checkbox()
                            ->name('calendar')
                            ->value(true)
                            ->checked(setting('app.calendar', true))
                            ->id('calendar')
                            ->label(__('Enable dashboard change calendar'))
                            ->data('target', 'form.input')
                    }}

                    <small class="text-muted">
                        Disabling this option will remove the change calendar from all user dashboards.
                    </small>
                </div>
            </div>

            <div class="card-footer bg-light d-flex justify-content-center">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> Save
                </button>
            </div>
        </div>
    </form>

    @if($os == 'Windows')
    <div class="card shadow-sm">
        <div class="card-header border-bottom">
            <h6 class="mb-0 text-muted font-weight-bold">{{ __('Setup Task Scheduling & Queue (Windows Only)') }}</h6>
        </div>

        <div class="card-body">
            <h5 class="font-weight-bold text-muted">Setting up the schedule and queue workers in Windows</h5>

            <p>
                To easily get Scout up and running with automated scanning, you must created scheduled tasks on your Windows server.
            </p>

            <p>
                Scout provides the automated generation of <a href="https://docs.microsoft.com/en-us/windows/win32/taskschd/daily-trigger-example--xml-">Scheduled Task XML files</a>
                that you can import into your server with a single command so the entire setup is done for you.
            </p>

            <p>
                Click the <strong>Generate</strong> buttons below and then run the command (<strong>as an administrator</strong>) that is shown to import the generated XML files into the task scheduler. Once you've imported both XML files, Scout will automatically scan your domains at your configured frequency.
            </p>

            <p>
                <strong>Note:</strong> If you ever change the directory of the Scout application, you will need to regenerate and re-run these commands.
            </p>

            <hr/>

            <form method="post" action="{{ route('settings.generate.scheduler') }}" data-controller="form" class="mb-2">
                @csrf
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-redo"></i>
                    {{ $tasks['scheduler']->exists() ? 'Regenerate' : 'Generate' }}
                    Scheduler Task XML
                </button>
            </form>

            @if($tasks['scheduler']->exists())
                <pre class="bg-dark text-white rounded p-2 shadow-sm"><code>{{ $tasks['scheduler']->command() }}
</code></pre>
            @endif

            <hr/>

            <form method="post" action="{{ route('settings.generate.queue') }}" data-controller="form" class="mb-2">
                @csrf
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-redo"></i>
                    {{ $tasks['queue']->exists() ? 'Regenerate' : 'Generate' }}
                    Queue Runner Task XML
                </button>
            </form>

            @if($tasks['queue']->exists())
                <pre class="bg-dark text-white rounded p-2 shadow-sm"><code>{{ $tasks['queue']->command() }}
</code></pre>
            @endif
        </div>
    </div>
    @endif
@endsection
