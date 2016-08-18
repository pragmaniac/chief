 <div class="col-md-9">
        <div class="tab-block mb25">
            <ul class="nav tabs-left tabs-border tabbed-nav">
                @foreach($job->getAvailableLocales() as $locale)
                    <li class="{{ 'nl'==$locale?'active':'' }}">
                        <a href="#tab_{{  $locale }}" data-toggle="tab">{{ ucfirst($locale) }}</a>
                    </li>
                @endforeach
            </ul>

            <div class="tab-content">
                @foreach($job->getAvailableLocales() as $locale)
                    <div id="tab_{{ $locale }}" class="tab-pane{{ 'nl'==$locale?' active':'' }}">
                        @include('admin.jobs._form',['locale' => $locale])
                    </div>
                @endforeach
                <div class="clearfix"></div>
            </div>
            <!--end tab content -->
        </div>
        <!-- end tab block -->
    </div><!-- end first column -->
