<section class="row formgroup gutter-xs">
    <div class="column-4">
        <h2 class="formgroup-label">@lang('chief::system.company')</h2>
    </div>
    <div class="formgroup-input column-8">
        <input type="text" name="company-name" id="company-name" class="input inset-s" placeholder="@lang('chief::system.company')">
    </div>
</section>
<section class="row formgroup gutter-xs">
    <div class="column-4">
        <h2 class="formgroup-label">@lang('chief::system.address')</h2>
    </div>
    <div class="formgroup-input column-8">
        <div class="row gutter">
            <div class="column-8">
                <label for="company-street">@lang('chief::system.street')</label>
                <input type="text" name="company-street" id="company-street" class="input inset-s" placeholder="@lang('chief::system.street')">
            </div>
            <div class="column-4">
                <label for="company-housenumber">@lang('chief::system.number')</label>
                <input type="text" name="company-housenumber" id="company-housenumber" class="input inset-s" placeholder="@lang('chief::system.number')">
            </div>
        </div>
        <div class="stack-s">
            <div class="row gutter">
                <div class="column-8">
                    <div class="stack-xs">
                        <label for="company-township">@lang('chief::system.city')</label>
                        <input type="text" name="company-township" id="company-township" class="input inset-s" placeholder="@lang('chief::system.city')">
                    </div>
                </div>
                <div class="column-4">
                    <div class="stack-xs">
                        <label for="company-postalcode">@lang('chief::system.postalcode')</label>
                        <input type="text" name="company-postalcode" id="company-postalcode" class="input inset-s" placeholder="@lang('chief::system.postalcode')">
                    </div>
                </div>
            </div>
        </div>
        <div class="stack-s">
            <div class="row gutter">
                <div class="column">
                    <label for="company-country">@lang('chief::system.country')</label>
                    <chief-multiselect name="company-country" selected="België" :options="['België','Nederland', 'Frankrijk','Duitsland']">
                    </chief-multiselect>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="row formgroup gutter-xs">
    <div class="column-4">
        <h2 class="formgroup-label">@lang('chief::system.phone')</h2>
    </div>
    <div class="formgroup-input column-8">
        <input type="text" name="company-telephone" id="company-telephone" class="input inset-s" placeholder="@lang('chief::system.phone')">
    </div>
</section>
<section class="row formgroup gutter-xs">
    <div class="column-4">
        <h2 class="formgroup-label">@lang('chief::system.cellphone')</h2>
    </div>
    <div class="formgroup-input column-8">
        <input type="text" name="company-cellphone" id="company-cellphone" class="input inset-s" placeholder="@lang('chief::system.cellphone')">
    </div>
</section>
<section class="row formgroup gutter-xs">
    <div class="column-4">
        <h2 class="formgroup-label">@lang('chief::system.email')</h2>
    </div>
    <div class="formgroup-input column-8">
        <input type="text" name="company-mail" id="company-mail" class="input inset-s" placeholder="@lang('chief::system.email')">
    </div>
</section>

<section class="row formgroup gutter-xs">
    <div class="column-4">
        <h2 class="formgroup-label">@lang('chief::system.vat')</h2>
    </div>
    <div class="formgroup-input column-8">
        <input type="text" name="company-vat" id="company-vat" class="input inset-s" placeholder="@lang('chief::system.vat')">
    </div>
</section>
