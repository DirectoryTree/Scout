<div class="form-group">
    <label for="">{{ __('Connection Name') }}</label>
    <input type="text" class="form-control" id="" placeholder="Domain Name / Company">
</div>

<div class="form-group">
    <label for="">{{ __('Hosts / Controllers') }}</label>
    <input type="text" class="form-control" id="" placeholder="10.0.0.1,10.0.0.2">
    <small id="hostHelpBlock" class="form-text text-muted">
        Enter each host separated by a comma.
    </small>
</div>

<hr/>

<div class="alert alert-primary">
    <i class="fa fa-exclamation-circle"></i>

    {{ __('The username and password fields are encrypted using OpenSSL and the AES-256-CBC cipher. ') }}
</div>

<div class="form-row">
    <div class="col">
        <div class="form-group">
            <label for="">{{ __('Username') }}</label>
            <input type="text" class="form-control" id="" placeholder="admin">
        </div>
    </div>

    <div class="col">
        <div class="form-group">
            <label for="">{{ __('Password') }}</label>
            <input type="text" class="form-control" id="" placeholder="secret">
        </div>
    </div>
</div>

