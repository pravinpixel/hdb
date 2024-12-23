            <!-- ========== Left Sidebar Start ========== -->

            <div class="left side-menu">
                <div class="sidebar-inner slimscrollleft">
                    <div class="user-details">
                        <div class="pull-left">
                            <img src="{{ asset('dark/assets/images/users/avatar-1.jpg')}} " alt="" class="thumb-md img-circle" style="pointer-events: none;">
                        </div>
                        <div class="user-info">
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">{{ucfirst(Sentinel::getUser()->first_name)}}<span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                      <li><a href="{{ route('user.edit-profile', Sentinel::getUser()->id) }}" class="dropdown-item"><i class="fa fa-user"></i> Profile </a></li>
                                    <li><a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i> Logout</a></li>
                                </ul>
                            </div>
                            <p class="text-muted m-0"></p>
                        </div>
                    </div>
                     <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    <!--- Divider -->
                    <div id="sidebar-menu">
                        <ul>
                            <li>
                            @if(Sentinel::inRole('admin'))
                                 <a href="{{ route('admin.dashboard') }}" class="waves-effect waves-light {{request()->is('dashboard*') ? 'active' : ''}}"><i class="fa fa-dashboard"></i><span> Dashboard </span></a>
                            @elseif(Sentinel::inRole('manager'))
                                <a href="{{ route('manager.dashboard') }}" class="waves-effect waves-light {{request()->is('manager/dashboard*') ? 'active' : ''}}"><i class="fa fa-dashboard"></i><span> Dashboard </span></a>
                            @elseif(Sentinel::inRole('employee'))
                                <a href="{{ route('employee.dashboard') }}" class="waves-effect waves-light {{request()->is('manager/dashboard*') ? 'active' : ''}}"><i class="fa fa-dashboard"></i><span> Dashboard </span></a>
                            @endif
                            </li>
                            @if(Sentinel::inRole('admin')  || Sentinel::hasAccess('category.index') ||Sentinel::hasAccess('subcategory.index') || Sentinel::hasAccess('genre.index') || Sentinel::hasAccess('type.index') || Sentinel::hasAccess('item.index'))
                                <li class="has_sub">
                                    <a href="" class="waves-effect waves-light {{request()->is('master*') ? 'active' : ''}}"><i class="fa fa-list"></i><span> Masters </span></a>
                                    <ul class="list-unstyled">
                                     <!--@if(Sentinel::inRole('admin') || Sentinel::hasAccess('category.index'))
                                        <li><a href="{{ route('category.index') }}" class =" {{request()->is('master/category*') ? 'sub-active' : ''}}"> @lang('menu.categories') </a></li>
                                    @endif-->
                                     <!--@if(Sentinel::inRole('admin') || Sentinel::hasAccess('subcategory.index'))
                                        <li><a href="{{ route('subcategory.index') }}" class =" {{request()->is('master/subcategory*') ? 'sub-active' : ''}}"> @lang('menu.subcategories') </a></li>
                                    @endif-->
                                     <!--@if(Sentinel::inRole('admin') || Sentinel::hasAccess('genre.index'))
                                        <li><a href="{{ route('genre.index') }}" class =" {{request()->is('master/genre*') ? 'sub-active' : ''}}">@lang('menu.genres') </a></li>
                                    @endif-->
                                     <!--@if(Sentinel::inRole('admin') || Sentinel::hasAccess('type.index'))
                                        <li><a href="{{ route('type.index') }}" class =" {{request()->is('master/type*') ? 'sub-active' : ''}}"> @lang('menu.types') </a></li>
                                    @endif-->
                                    @if(Sentinel::inRole('admin') || Sentinel::hasAccess('item.index'))
                                        <li><a href="{{ route('item.index') }}" class =" {{request()->is('master/item*') ? 'sub-active' : ''}}"> @lang('menu.items') </a></li>
                                    @endif
                                    </ul>
                                </li>
                             @endif

                            <!-- @if(Sentinel::inRole('admin') || Sentinel::hasAccess('approval-list.index'))
                                <li>
                                    <a href="{{ route('approval-list.index') }}" class="waves-effect waves-light {{request()->is('manager/approval*') ? 'active' : ''}}"><i class="fa fa-bullhorn"></i><span> @lang('menu.approval_list')   </span></a>
                                </li>
                            @endif-->

                             <!--@if(Sentinel::inRole('admin') || Sentinel::hasAccess('issue.index'))
                                <li>
                                    <a href="{{ route('issue.index') }}" class="waves-effect waves-light {{request()->is('issue*') ? 'active' : ''}}"><i class="glyphicon glyphicon-arrow-left"></i><span> @lang('menu.borrow')   </span></a>
                                </li>
                            @endif-->

                            <!-- @if(Sentinel::inRole('admin') || Sentinel::hasAccess('return.index'))
                                <li>
                                    <a href="{{ route('return.index') }}" class="waves-effect waves-light {{request()->is('return*') ? 'active' : ''}}"><i class="fa fa-reply"></i><span> @lang('menu.return') </span></a>
                                </li>
                            @endif-->

                            @if(Sentinel::inRole('admin') || Sentinel::hasAccess('notification.index'))
                                <li>
                                    <a href="{{ route('notification.index') }}" class="waves-effect waves-light {{request()->is('admin/notification*') ? 'active' : ''}}"><i class="fa fa-bell"></i><span> Notifications </span></a>
                                </li>
                            @endif
                            @if(Sentinel::hasAccess('inventory.index') || Sentinel::hasAccess('approve-request.index') || Sentinel::hasAccess('member-view-history.index') ||  Sentinel::hasAccess('book-view-history.index') ||  Sentinel::hasAccess('overdue-history.index') || 
                            Sentinel::hasAccess('member-history.index') ||
                            Sentinel::inRole('admin') )
                                <li class="has_sub">
                                    <a href="#" class="waves-effect waves-light {{request()->is('admin/report*') ? 'active' : ''}}"><i class="fa fa-bar-chart"></i><span> Reports </span></a>
                                    <ul class="list-unstyled">
                                        @if( Sentinel::inRole('admin') || Sentinel::hasAccess('inventory.index') )
                                            <li><a href="{{ route('inventory.index') }}" class =" {{request()->is('admin/report/inventory*') ? 'sub-active' : ''}}"> @lang('menu.​inventory_list') </a></li>
                                        @endif
                                        @if( Sentinel::inRole('admin') || Sentinel::hasAccess('approve-request.index') )
                                            <li><a href="{{ route('approve-request.index') }}" class =" {{request()->is('admin/report/approve-request-history*') ? 'sub-active' : ''}}"> @lang('menu.approve_request_history') </a></li>
                                        @endif
                                        @if( Sentinel::inRole('admin') || Sentinel::hasAccess('member-view-history.index') )
                                            <li><a href="{{ route('member-view-history.index') }}" class =" {{request()->is('admin/report/member-book-history*') ? 'sub-active' : ''}}"> @lang('menu.member_or_book_history') </a></li>
                                        @endif
                                        @if( Sentinel::inRole('admin') || Sentinel::hasAccess('book-view-history.index') )
                                            <li><a href="{{ route('book-view-history.index') }}" class =" {{request()->is('admin/report/book-view-history*') ? 'sub-active' : ''}}"> @lang('menu.book_wise_view_history') </a></li>
                                        @endif
                                        @if( Sentinel::inRole('admin') || Sentinel::hasAccess('member-history.index') )
                                            <li><a href="{{ route('member-history.index') }}" class =" {{request()->is('admin/report/memebr-view-history*') ? 'sub-active' : ''}}"> @lang('menu.member_wise_view_history') </a></li>
                                        @endif
                                        @if( Sentinel::inRole('admin') || Sentinel::hasAccess('overdue-history.index') )
                                            <li><a href="{{ route('overdue-history.index') }}" class =" {{request()->is('admin/report/overdue-history*') ? 'sub-active' : ''}}"> @lang('menu.overdue_history') </a></li>
                                        @endif
                                    </ul>
                                </li>
                            @endif

                            @if( Sentinel::inRole('admin') || Sentinel::hasAccess('user.index') || Sentinel::hasAccess('role.index') || Sentinel::hasAccess('permission.index') ||  Sentinel::hasAccess('config.index')  || Sentinel::hasAccess('email-config.edit'))
                                <li class="has_sub">
                                    <a href="" class="waves-effect waves-light {{request()->is('admin/setting/*') ? 'active' : ''}}"><i class="fa fa-cogs"></i><span> Settings </span></a>
                                    <ul class="list-unstyled">
                                         <!--@if(Sentinel::inRole('admin') || Sentinel::hasAccess('config.index'))
                                            <li><a href="{{ route('config.index') }}" class =" {{request()->is('admin/setting/config*') ? 'sub-active' : ''}}"> @lang('menu.config') </a></li>
                                        @endif-->
                                         <!--@if(Sentinel::inRole('admin') || Sentinel::hasAccess('email-config.edit'))
                                            <li><a href="{{ route('email-config.edit') }}" class =" {{request()->is('admin/setting/email-config/edit*') ? 'sub-active' : ''}}"> @lang('menu.email-config') </a></li>
                                        @endif-->
                                        @if(Sentinel::inRole('admin') || Sentinel::hasAccess('user.index'))
                                            <li><a href="{{ route('user.index') }}" class =" {{request()->is('admin/setting/user*') ? 'sub-active' : ''}}"> @lang('menu.users') </a></li>
                                        @endif
                                         <!--@if(Sentinel::inRole('admin') || Sentinel::hasAccess('role.index'))
                                            <li><a href="{{ route('role.index') }}" class =" {{request()->is('admin/setting/role*') ? 'sub-active' : ''}}">@lang('menu.roles') </a></li>
                                        @endif-->
                                         <!--@if(Sentinel::inRole('admin') || Sentinel::hasAccess('permission.index'))
                                            <li><a href="{{ route('permission.index') }}" class =" {{request()->is('admin/setting/permission*') ? 'sub-active' : ''}}">@lang('menu.permissions') </a></li>
                                        @endif-->
                                    </ul>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- Left Sidebar End --> 