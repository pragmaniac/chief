<section class="row formgroup gutter-l">
    <div class="column-5">
        <h2 class="formgroup-label">Systeem e-mail</h2>
        <p>
            Dit e-mail adres wordt door het systeem gebruikt voor bv. auto-replies, wachtwoord-reset mails, ...
        </p>
    </div>
    <div class="formgroup-input column-7">
        <input type="text" name="settings[system-mail]" id="mail-system" class="input inset-s" placeholder="E-mailadres">
    </div>
</section>
<section class="row formgroup gutter-l">
    <div class="column-5">
        <h2 class="formgroup-label">@lang('chief::system.mail_sender')</h2>
        <p>
                @lang('chief::system.mail_description')
        </p>
    </div>
    <div class="formgroup-input column-7">
        <input type="text" name="settings[sender-name]" id="mail-sender" class="input inset-s" placeholder="@lang('chief::system.mail_sender')">
    </div>
</section>
{{-- <section class="row formgroup gutter-l border-primary">
    <div class="column-5 center-y">
        <div class="text-primary">
            <h2 class="formgroup-label text-primary">Test e-mail</h2>
            Om bovenstaande gegevens te testen kan je een test-mail versturen naar een opgegeven e-mail.
            Geef een e-mail adres op en klik vervolgens op de knop verstuur.
        </div>
    </div>
    <div class="formgroup-input column-5 center-y">
        <input type="text" name="mail-test" id="mail-test" class="input inset-s" placeholder="E-mailadres">
    </div>
    <div class="formgroup-label column-2 center-y">
        <a class="btn btn-o-primary btn-icon">
            <span>Verstuur</span>
            <icon class="icon icon-mail"></icon>
        </a>
    </div>
</section> --}}
