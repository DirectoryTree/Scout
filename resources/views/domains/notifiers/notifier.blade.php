<div class="list-group-item d-flex justify-content-between align-items-center">
    <div class="d-flex justify-content-start align-items-center">
        <div class="mr-2">
            {{
                form()->toggle()
                    ->id("notifier_$notifier->id")
                    ->name('enabled')
                    ->value(true)
                    ->checked($notifier->enabled)
                    ->label($notifier->name)
                    ->disabled($notifier->conditions_count === 0)
                    ->data('controller', 'toggle')
                    ->data('action', 'click->toggle#update')
                    ->data('toggle-message-enabled', 'Enabled notifier.')
                    ->data('toggle-message-disabled', 'Disabled notifier.')
                    ->data('toggle-url', route('api.notifier.toggle', $notifier))
            }}
        </div>

        @if($notifier->conditions_count === 0)
            <div class="badge badge-warning">
                <i class="fa fa-exclamation-circle"></i> Needs Conditions
            </div>
        @endif
    </div>

    <div class="dropdown dropleft">
        <button class="btn btn-sm btn-light rounded-pill border" type="button" id="btn-notifier-settings" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-ellipsis-v"></i>
        </button>

        <div class="dropdown-menu" aria-labelledby="btn-notifier-settings">
            <a href="{{ route('domains.notifiers.show', [$domain, $notifier]) }}" class="dropdown-item">
                <i class="fas fa-cogs"></i> Customize
            </a>

            <a href="{{ route('domains.notifiers.logs.index', [$domain, $notifier]) }}" class="dropdown-item">
                <i class="fas fa-clipboard-check"></i> Logs
            </a>

            @can('notifier.delete', $notifier)
                <a href="{{ route('domains.notifiers.conditions.edit', [$domain, $notifier]) }}" class="dropdown-item">
                    <i class="fa fa-check-double"></i> Conditions
                </a>

                <form
                    class="d-inline"
                    method="post"
                    action="{{ route('notifiers.destroy', $notifier) }}"
                    data-controller="form-confirmation"
                    data-form-confirmation-title="Delete Notifier?"
                    data-form-confirmation-message="This cannot be undone."
                >
                    @csrf
                    @method('delete')
                    <button type="submit" class="dropdown-item no-loading">
                        <i class="fa fa-trash-alt"></i> Delete
                    </button>
                </form>
            @endcan
        </div>
    </div>
</div>
