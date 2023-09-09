<div class="sidebar__nav border-top border-left  ">
    <span class="bars d-none padding-0-18"></span>
    <a class="header__logo  d-none" href="https://webamooz.net"></a>

    <x-user-photo />

    <ul>
        @foreach (config('sidebarHome.items') as $item)
        @if ($item)
        @if ( !array_key_exists('permission',$item) ||
         auth()->user()->hasAnyPermission($item['permission']) ||
         auth()->user()->hasPermissionTo(\Yazdan\RolePermissions\Repositories\PermissionRepository::PERMISSION_SUPER_ADMIN))

            <li class="item-li {{$item['icon']}} {{ str_starts_with(request()->url(),$item['url']) ? 'is-active' : ''}}"><a href="{{$item['url']}}">{{$item['title']}}</a></li>

        @endif
    @endif
        @endforeach
    </ul>

</div>
