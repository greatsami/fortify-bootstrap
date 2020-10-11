<div class="container pt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Two factor authentication</div>
                <div class="card-body">
                    @if(!auth()->user()->two_factor_secret)
                        {{-- Enable 2FA --}}
                        <form method="POST" action="{{ url('user/two-factor-authentication') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-block">
                                {{ __('Enable Two-Factor') }}
                            </button>
                        </form>
                    @else

                        @if(session('status') == 'two-factor-authentication-enabled')
                            {{-- Show SVG QR Code, After Enabling 2FA --}}
                            <div class="text-muted m-3">
                                {{ __('Two factor authentication is now enabled. Scan the following QR code using your phone\'s authenticator application.') }}
                            </div>

                            <div class="border border-primary rounded text-center mb-3 p-3">
                                {!! auth()->user()->twoFactorQrCodeSvg() !!}
                            </div>
                        @endif

                        {{-- Show 2FA Recovery Codes --}}
                        <div class="text-muted m-3">
                            {{ __('Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost.') }}
                        </div>

                        <div class="border border-primary rounded text-center mb-3">
                            @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
                                <div class="text-muted">{{ $code }}</div>
                            @endforeach
                        </div>

                            <a href="javescript:void(0);" class="btn btn-primary" onclick="document.getElementById('regenerate_two_factor_auth').submit();">{{ __('Regenerate Recovery Codes') }}</a>
                            <a href="javescript:void(0);" class="btn btn-danger" onclick="document.getElementById('delete_two_factor_auth').submit();">{{ __('Disable Two-Factor') }}</a>



                        {{-- Regenerate 2FA Recovery Codes --}}
                        <form method="POST" action="{{ url('user/two-factor-recovery-codes') }}" id="regenerate_two_factor_auth" style="display: none;">
                            @csrf
                        </form>
                        {{-- Disable 2FA --}}
                        <form method="POST" action="{{ url('user/two-factor-authentication') }}" id="delete_two_factor_auth" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
