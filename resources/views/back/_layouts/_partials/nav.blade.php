<nav class="top-nav bg-white">
    <div class="container">
        <div class="row">
            <ul id="nav-main" class="nav-items">
                <li>
                    <a class="nav-item icon icon-feather" href="{{ route('chief.back.dashboard') }}"></a>
                </li>

                @include('chief::back._layouts._partials.nav-main')


                @if(\Illuminate\Support\Facades\Gate::check('update-page') || \Illuminate\Support\Facades\Gate::check('view-page') || \Illuminate\Support\Facades\Gate::check('view-squanto'))
                    <li>
                        <dropdown>
                            <span class="center-y nav-item {{ (isActiveUrl('admin/translations*') || isActiveUrl('admin/menu*')) ? 'active' : '' }}" slot="trigger" slot-scope="{ toggle, isActive }" @click="toggle">@lang('chief::nav.site')</span>
                            <div v-cloak class="dropdown-box inset-s">
                                @can('update-page')
                                    <a class="block squished --link-with-bg {{ isActiveUrl('admin/menus*') ? 'active' : '' }}" href="{{ route('chief.back.menus.index') }}">@lang('chief::nav.menu')</a>
                                @endcan
                                @can('view-page')
                                    <a class="block squished --link-with-bg {{ isActiveUrl('admin/modules*') ? 'active' : '' }}" href="{{ route('chief.back.modules.index') }}">@lang('chief::nav.modules')</a>
                                @endcan
                                @can('view-squanto')
                                    <a class="block squished --link-with-bg {{ isActiveUrl('admin/translations*') ? 'active' : '' }}" href="{{ route('squanto.index') }}">@lang('chief::nav.translations')</a>
                                @endcan
                            </div>
                        </dropdown>
                    </li>
                @endif
            </ul>

            <div class="column">
                <ul class="nav-items right">
                    @role('developer')
                        <li><a class="label label--primary squished-xs" target="_blank" href="/spirit">Spirit</a></li>
                    @endrole
                    @if(\Illuminate\Support\Facades\Gate::check('view-user') || \Illuminate\Support\Facades\Gate::check('view-role') || \Illuminate\Support\Facades\Gate::check('view-audit') || \Illuminate\Support\Facades\Gate::check('update-setting'))
                        <dropdown>
                            <span class="center-y nav-item {{ (isActiveUrl('admin/users*') || isActiveUrl('admin/settings*') || isActiveUrl('admin/audit*')) ? 'active' : '' }}" slot="trigger" slot-scope="{ toggle, isActive }" @click="toggle"><span class="icon icon-cog"></span></span>
                            <div v-cloak class="dropdown-box inset-s">
                                @can('view-user')
                                    <a class="block squished --link-with-bg {{ isActiveUrl('admin/users*') ? 'active' : '' }}" href="{{ route('chief.back.users.index') }}">@lang('chief::nav.users')</a>
                                @endcan
                                @can('view-role')
                                    <a class="block squished --link-with-bg {{ isActiveUrl('admin/roles*') ? 'active' : '' }}" href="{{ route('chief.back.roles.index') }}">@lang('chief::nav.roles')</a>
                                @endcan
                                @can('update-setting')
                                    <a class="block squished --link-with-bg {{ isActiveUrl('admin/settings*') ? 'active' : '' }}" href="{{ route('chief.back.settings.edit') }}">@lang('chief::nav.settings')</a>
                                @endcan
                                @can('view-audit')
                                    <a class="block squished --link-with-bg {{ isActiveUrl('admin/audit*') ? 'active' : '' }}" href="{{ route('chief.back.audit.index') }}">@lang('chief::nav.audit')</a>
                                @endcan
                            </div>
                        </dropdown>
                    @endif

                    <li>
                        <dropdown>
                            <span class="nav-item" slot="trigger" slot-scope="{ toggle, isActive }" @click="toggle">{{ chiefAdmin()->firstname }}</span>
                            <div v-cloak class="dropdown-box">
                                @can('update-you')
                                    <a class="block squished-s --link-with-bg" href="{{ route('chief.back.you.edit') }}">@lang('chief::nav.edit_profile')</a>
                                @endcan
                                <a class="block squished-s --link-with-bg" href="{{ route('chief.back.password.edit') }}">@lang('chief::nav.edit_password')</a>
                                <a class="block squished-s --link-with-bg" href="{{ route('chief.back.logout') }}">@lang('chief::nav.logout')</a>
                            </div>
                        </dropdown>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
