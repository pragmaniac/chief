<section class="row formgroup gutter-xs">
    <div class="column-5">
        <h2 class="formgroup-label">@lang('chief::system.site_title')</h2>
        <p class="caption">@lang('chief::system.site_title')</p>
    </div>
    <div class="column-7">
        <input type="text" name="settings[seo-title]" id="site-name" class="input inset-s" placeholder="@lang('chief::system.site_title')">
    </div>
</section>
<section class="row formgroup gutter-xs">
    <div class="column-5">
        <h2 class="formgroup-label">@lang('chief::system.short')</h2>
        <p class="caption">@lang('chief::system.short_description')</p>
    </div>
    <div class="column-7">
        <textarea class="redactor inset-s" name="settings[seo-description]" id="description" cols="10" rows="5"></textarea>
    </div>
</section>
<section class="row formgroup gutter-xs">
    <div class="column-5">
        <h2 class="formgroup-label">@lang('chief::system.homepage')</h2>
        <p class="caption">@lang('chief::system.homepage_description')</p>
    </div>
    <div class="column-7">
        <chief-multiselect name="settings[homepage]" :options="['Home', 'Diensten', 'Artikels']">
        </chief-multiselect>
    </div>
</section>
