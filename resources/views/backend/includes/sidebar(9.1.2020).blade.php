
@inject('request', 'Illuminate\Http\Request')

<div class="sidebar">
    <div class="userInfo text-center">
<img src="{{ $logged_in_user->picture }}" alt="{{ $logged_in_user->email }}" class="userPic"> 
<h4>{{ $logged_in_user->full_name }}</h4>
<span>Online</span>
</div>
    <nav class="sidebar-nav sidebar-offcanvas">
        <ul class="nav">
			<?php
                        $officeLocation = 1;
            if (isset($logged_in_user->id)) {
                $user = DB::table('user_details')->where('user_id', $logged_in_user->id)->select('office_id')->get();
                if (count($user) > 0) {
                    $location = DB::table('locations')->where('id', $user[0]->office_id)->select('parent_office_id')->get();
                                $officeLocation = $location[0]->parent_office_id;
                            }
                        }
                        ?>
            @if ($logged_in_user->isAdmin() || ($logged_in_user->is_admin == 1 && $officeLocation == 0))
                <!--Admin Features-->
			<li class="nav-title hdPanel">
				@lang('menus.backend.sidebar.adminhading')
            </li>
                <!--Master Management-->
            <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/auth*'), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/auth*')) }}"href="#"><i class="nav-icon icon-user"></i>@lang('menus.backend.sidebar.master')
                        @if ($pending_approval > 0)
                            <span class="badge badge-danger">{{ $pending_approval }}</span>
                        @endif
                    </a>
                    <ul class="nav-dropdown-items sub-menu" >
                         <li class="nav-item ">
                            <a class="nav-link {{ $request->segment(2) == 'year' ? 'active' : '' }}"
                                href="{{ route('admin.year.index') }}">
                                <i class="fa fa-calendar"></i>
                                <span class="title">@lang('menus.backend.sidebar.year.title')</span>
                            </a>
                        </li>
                           <li class="nav-item ">
                            <a class="nav-link {{ $request->segment(2) == 'track' ? 'active' : '' }}"
                               href="{{ route('admin.track.index') }}">
                               <i class="fa fa-road"></i>
                                <span class="title">@lang('menus.backend.sidebar.track.title')</span>
                            </a>
                        </li>
                         <li class="nav-item ">
                            <a class="nav-link {{ $request->segment(2) == 'venue' ? 'active' : '' }}"
                               href="{{ route('admin.venue.index') }}">
                             <i class="fa fa-map-marker"></i>
                                <span class="title">@lang('menus.backend.sidebar.venue.title')</span>
                            </a>
                        </li>

                        <li class="nav-item ">
                            <a class="nav-link {{ $request->segment(2) == 'ministry' ? 'active' : '' }}"
                                href="{{ route('admin.ministry.index') }}">
                               <i class="fa fa-building"></i>
                                <span class="title">@lang('menus.backend.sidebar.ministry.title')</span>
                            </a>
                        </li>
                         <li class="nav-item ">
                            <a class="nav-link {{ $request->segment(2) == 'section' ? 'active' : '' }}"
                               href="{{ route('admin.signing.index') }}">
                                <i class="fa fa-edit"></i>
                                <span class="title">@lang('menus.backend.sidebar.signing.title')</span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link {{ $request->segment(2) == 'departments' ? 'active' : '' }}"
                                href="{{ route('admin.departments.index') }}">
                               <i class="fa fa-bank"></i>
                                <span class="title">@lang('menus.backend.sidebar.departments.title')</span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link {{ $request->segment(2) == 'designations' ? 'active' : '' }}"
                               href="{{ route('admin.designations.index') }}">
                              <i class="fa fa-id-badge"></i>
                                <span class="title">@lang('menus.backend.sidebar.designations.title')</span>
                            </a>
                        </li> 
                        <li class="nav-item ">
                            <a class="nav-link {{ $request->segment(2) == 'states' ? 'active' : '' }}"
                               href="{{ route('admin.states.index') }}">
                            <i class="fa fa-fort-awesome"></i>
                                <span class="title">@lang('menus.backend.sidebar.states.title')</span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link {{ $request->segment(2) == 'cities' ? 'active' : '' }}"
                               href="{{ route('admin.cities.index') }}">
                               <i class="fa fa-institution"></i>
                                <span class="title">@lang('menus.backend.sidebar.cities.title')</span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link {{ $request->segment(2) == 'locations' ? 'active' : '' }}"
                               href="{{ route('admin.locations.index') }}">
                               <i class="fa fa-map-pin"></i>
                                <span class="title">@lang('menus.backend.sidebar.locations.title')</span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link {{ $request->segment(2) == 'institutes-industries' ? 'active' : '' }}"
                               href="{{ route('admin.institutes-industries.index') }}">
                                <i class="fa fa-industry"></i>
                                <span class="title">@lang('menus.backend.sidebar.institute-industry.title')</span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link {{ $request->segment(2) == 'newsflash' ? 'active' : '' }}"
                               href="{{ route('admin.newsflash.index') }}">
                               <i class="fa fa-film"></i>
                             <span class="title">@lang('menus.backend.sidebar.news.title')</span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link {{ $request->segment(2) == 'banners' ? 'active' : '' }}"
                               href="{{ route('admin.banners.index') }}">
                              <i class="fa fa-file-photo-o"></i>
                             <span class="title">@lang('menus.backend.sidebar.banner.title')</span>
                            </a>
                        </li>
						
						<li class="nav-item">
							<a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/role*')) }}"
								href="{{ route('admin.training_types.index') }}">
								<i class="nav-icon icon-key"></i>
								<span class="title">Training Type</span>
								
							</a>
						</li>
                        @can('category_access')
                        <li class="nav-item ">
                            <a class="nav-link {{ $request->segment(2) == 'categories' ? 'active' : '' }}"
                               href="{{ route('admin.categories.index') }}">
                                <i class="nav-icon icon-folder-alt"></i>
                                <span class="title">@lang('menus.backend.sidebar.categories.title')</span>
                            </a>
                        </li>
                         <li class="nav-item ">
                        </li>
                    @endcan
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/role*')) }}"
                        href="{{ route('admin.department_role.index') }}">
                            <i class="nav-icon icon-key"></i>
                            <span class="title">@lang('menus.backend.sidebar.department_role.title')</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/role*')) }}"
                        href="{{ route('admin.organization_departments.index') }}">
                            <i class="nav-icon icon-key"></i>
                            <span class="title">@lang('menus.backend.sidebar.organization_departments.title')</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/role*')) }}"
                           href="{{ route('admin.subject.index') }}">
                            <i class="nav-icon icon-key"></i>
                            <span class="title">@lang('menus.backend.sidebar.subject.title')</span>
                        </a>
                    </li>
                    </ul>
            </li>
                <!--Approvals-->
			<li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle {{ $request->segment(1) == 'recomdextresource' ? 'active' : '' }}" href="#">
                        <i class="icon fa fa-desktop fa-fw"></i> <span
                        class="title">@lang('menus.backend.sidebar.approvals.title')</span>
                    </a>
                    <ul class="nav-dropdown-items sub-menu">
                        <li class="nav-item ">
                            <a class="nav-link {{ $request->segment(1) == 'approvedapprovallist' ? 'active' : '' }}"
                               href="{{ route('admin.approvals.approvedapprovallist') }}">
                                <i class="icon fa fa-file-o fa-fw"></i> <span
                                        class="title">@lang('menus.backend.sidebar.approvals.approved')</span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link {{ $request->segment(1) == 'pendingapprovallist' ? 'active' : '' }}"
                               href="{{ route('admin.approvals.pendingapprovallist') }}">
                                <i class="icon fa fa-file-o fa-fw"></i> <span
                                        class="title">@lang('menus.backend.sidebar.approvals.pending')</span>
                            </a>
                        </li>
                       
                    </ul>
                </li>
                <!--Access-->
                <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/auth*'), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/auth*')) }}"
                       href="#">
                        <i class="nav-icon icon-user"></i> @lang('menus.backend.access.title')

                        @if ($pending_approval > 0)
                            <span class="badge badge-danger">{{ $pending_approval }}</span>
                        @endif
                    </a>

                    <ul class="nav-dropdown-items sub-menu">
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/user*')) }}"
                               href="{{ route('admin.auth.user.index') }}">
                               <i class="fa fa-street-view"></i>
                                @lang('labels.backend.access.users.management')

                                @if ($pending_approval > 0)

                                    <span class="badge badge-danger">{{ $pending_approval }}</span>
                                @endif
                            </a>
                        </li>
						@if ($logged_in_user->isAdmin() || $logged_in_user->is_admin == 1)
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/role*')) }}"
                               href="{{ route('admin.auth.role.index') }}">
                               <i class="fa fa-users"></i>
                                @lang('labels.backend.access.roles.management')
                            </a>
                        </li>
						@endif
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/role*')) }}"
                               href="{{ route('admin.faculty.index') }}">
                               <i class="fa fa-address-card"></i>
                                Faculty
                            </a>
                        </li>
                    </ul>
                </li>
				
				<li class="divider"></li>
                @if ($logged_in_user->isAdmin())
            <!-- Settings -->
                <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/*'), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/settings*')) }}"
                       href="#">
                        <i class="nav-icon icon-settings"></i> @lang('menus.backend.sidebar.settings.title')
                    </a>

                    <ul class="nav-dropdown-items sub-menu">
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/settings')) }}"
                               href="{{ route('admin.general-settings') }}"> <i class="fa fa-info-circle"></i>
                                @lang('menus.backend.sidebar.settings.general')

                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/log-viewer/logs*')) }}"
                               href="{{ route('admin.social-settings') }}"> <i class="fa fa-exclamation-circle"></i>
                                @lang('menus.backend.sidebar.settings.social-login')
                            </a>
                        </li>
						
						<li class="nav-item">

                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/log-viewer/logs*')) }}"
                               href="{{ route('admin.default-settings') }}">   <i class="fa fa-history"></i>
                                @lang('menus.backend.sidebar.settings.default-landing')
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
            <!-- Attendence -->
                <li class="nav-item ">
                    <a class="nav-link {{ $request->segment(1) == 'courses' ? 'active' : '' }}"
                       href="{{ route('admin.trainings.attendance') }}">
                        <i class="nav-icon icon-badge"></i> <span
                                class="title">@lang('menus.backend.sidebar.attendance.title')</span>
                    </a>
                </li>
            <!-- Office Order -->
				<li class="nav-item ">
					<a class="nav-link {{ $request->segment(2) == 'officeorder' ? 'active' : '' }}"
					   href="{{ route('admin.officeorder.create') }}">
						 <i class="nav-icon icon-puzzle"></i>
						<span class="title">@lang('menus.backend.sidebar.officeorder.title')</span>
					</a>
                </li>
            @endif
            @if ($logged_in_user->isAdmin() || $logged_in_user->is_admin == 1)
            <!-- Courses Management -->
<li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern(['user/courses*','user/lessons*','user/tests*','user/questions*']), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/*')) }}"
                       href="#">
                       <i class="nav-icon icon-layers"></i>
                         @lang('menus.backend.sidebar.courses.management')

                    </a>

                    <ul class="nav-dropdown-items sub-menu">
                        @can('course_access')
            
            
                       <li class="nav-item ">
                            <a class="nav-link {{ $request->segment(2) == 'section' ? 'active' : '' }}"
                               href="{{ route('admin.crt.index') }}">
                              <i class="fa fa-street-view"></i>
                                <span class="title">@lang('menus.backend.sidebar.crt.title')</span>
                            </a>
                        </li>
                        @endcan
                    @if ($logged_in_user->isAdmin() || ($logged_in_user->is_admin == 1 && $officeLocation == 0))
                            @can('course_access')
                            <li class="nav-item ">
                                <a class="nav-link {{ $request->segment(2) == 'courses' ? 'active' : '' }}"
                                   href="{{ route('admin.courses.index') }}">
                                   <i class="fa fa-users"></i>
                                    <span class="title">@lang('menus.backend.sidebar.courses.title')</span>
                                </a>
                            </li>
                        @endcan

                        @can('lesson_access')
                            <li class="nav-item ">
                                <a class="nav-link {{ $request->segment(2) == 'lessons' ? 'active' : '' }}"
                                   href="{{ route('admin.lessons.index') }}">
                                   <i class="fa fa-wpforms"></i>
                                    <span class="title">@lang('menus.backend.sidebar.lessons.title')</span>
                                </a>
                            </li>
                        @endcan

                        @can('test_access')
                            <li class="nav-item ">
                                <a class="nav-link {{ $request->segment(2) == 'tests' ? 'active' : '' }}"
                                   href="{{ route('admin.tests.index') }}">
                                   <i class="fa fa-leanpub"></i>
                                    <span class="title">@lang('menus.backend.sidebar.tests.title')</span>
                                </a>
                            </li>
                        @endcan


                        @can('question_access')
                            <li class="nav-item">
                                <a class="nav-link {{ $request->segment(2) == 'questions' ? 'active' : '' }}"
                                   href="{{ route('admin.questions.index') }}">
                                  <i class="fa fa-question-circle"></i>
                                    <span class="title">@lang('menus.backend.sidebar.questions.title')</span>
                                </a>
                            </li>
                        @endcan
                    @endif

                    </ul>
                </li>
			
            @endif
            @if ($logged_in_user->isAdmin() || $logged_in_user->is_admin == 1)
				@can('course_access')
					<li class="nav-item ">
						<a class="nav-link {{ $request->segment(2) == 'course_allotment' ? 'active' : '' }}"
						   href="{{ route('admin.course_allotment.index') }}">
							<span class="title">@lang('menus.backend.sidebar.course-allotment.title')</span>
						</a>
					</li>
				@endcan
				
            @endif

            
            @if($logged_in_user->hasRole('teacher') || $logged_in_user->isAdmin())

                
                @can('bundle_access')
                    <li class="nav-item ">
                        <a class="nav-link {{ $request->segment(2) == 'bundles' ? 'active' : '' }}"
                           href="{{ route('admin.bundles.index') }}">
                             <i class="fa fa-database"></i>
                            <span class="title">@lang('menus.backend.sidebar.bundles.title')</span>
                        </a>
                    </li>
                @endcan
                <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern(['user/reports*']), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/*')) }}"
                       href="#">
                        <i class="nav-icon icon-pie-chart"></i>@lang('menus.backend.sidebar.reports.title')

                    </a>
                    <ul class="nav-dropdown-items sub-menu">
                        <li class="nav-item ">
                            <a class="nav-link {{ $request->segment(1) == 'sales' ? 'active' : '' }}"
                               href="{{ route('admin.reports.sales') }}">
                               <i class="fa fa-shopping-cart"></i>
                                @lang('menus.backend.sidebar.reports.sales')
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link {{ $request->segment(1) == 'students' ? 'active' : '' }}"
                               href="{{ route('admin.reports.students') }}">
                               <i class="fa fa-graduation-cap"></i>
                               @lang('menus.backend.sidebar.reports.students')
                            </a>
                        </li>
                    </ul>
                </li>
            @endif




            @if ($logged_in_user->isAdmin() || $logged_in_user->hasAnyPermission(['blog_access','page_access','reason_access']))
                <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern(['user/contact','user/sponsors*','user/testimonials*','user/faqs*','user/footer*','user/blogs','user/sitemap*']), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/*')) }}"
                       href="#">
                        <i class="nav-icon icon-note"></i> @lang('menus.backend.sidebar.site-management.title')
                    </a>

                    <ul class="nav-dropdown-items sub-menu">
                        @can('page_access')
                            <li class="nav-item ">
                                <a class="nav-link {{ $request->segment(2) == 'pages' ? 'active' : '' }}"
                                   href="{{ route('admin.pages.index') }}">
                                   <i class="fa fa-file-text"></i>
                                    <span class="title">@lang('menus.backend.sidebar.pages.title')</span>
                                </a>
                            </li>
                        @endcan
                        @can('blog_access')
                            <li class="nav-item ">
                                <a class="nav-link {{ $request->segment(2) == 'blogs' ? 'active' : '' }}"
                                   href="{{ route('admin.blogs.index') }}">
                                   <i class="fa fa-file-o"></i>
                                    <span class="title">@lang('menus.backend.sidebar.blogs.title')</span>
                                </a>
                            </li>
                        @endcan
                        @can('reason_access')
                            <li class="nav-item">
                                <a class="nav-link {{ $request->segment(2) == 'reasons' ? 'active' : '' }}"
                                   href="{{ route('admin.reasons.index') }}">
                                   <i class="fa fa-question"></i>
                                    <span class="title">@lang('menus.backend.sidebar.reasons.title')</span>
                                </a>
                            </li>
                        @endcan
                        @if ($logged_in_user->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/menu-manager')) }}"
                                   href="{{ route('admin.menu-manager') }}">   <i class="fa fa-align-justify"></i> {{ __('menus.backend.sidebar.menu-manager.title') }}</a>

                            </li>


                            <li class="nav-item ">
                                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/sliders*')) }}"
                                   href="{{ route('admin.sliders.index') }}">
                                   <i class="fa fa-sliders"></i>
                                    <span class="title">@lang('menus.backend.sidebar.hero-slider.title')</span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link {{ $request->segment(2) == 'sponsors' ? 'active' : '' }}"
                                   href="{{ route('admin.sponsors.index') }}">
                                   <i class="fa fa-handshake-o"></i>
                                    <span class="title">@lang('menus.backend.sidebar.sponsors.title')</span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link {{ $request->segment(2) == 'testimonials' ? 'active' : '' }}"
                                   href="{{ route('admin.testimonials.index') }}">
                                   <i class="fa fa-comments-o"></i>
                                    <span class="title">@lang('menus.backend.sidebar.testimonials.title')</span>
                                </a>
                            </li>
                                <li class="nav-item ">
                                    <a class="nav-link {{ $request->segment(2) == 'forums-category' ? 'active' : '' }}"
                                       href="{{ route('admin.forums-category.index') }}">
                                      
                                       <i class="fa fa-th-large"></i>
                                        <span class="title">@lang('menus.backend.sidebar.forums-category.title')</span>
                                    </a>
                                </li>
                            <li class="nav-item ">
                                <a class="nav-link {{ $request->segment(2) == 'faqs' ? 'active' : '' }}"
                                   href="{{ route('admin.faqs.index') }}">
                                   <i class="fa fa-question"></i>
                                    <span class="title">@lang('menus.backend.sidebar.faqs.title')</span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link {{ $request->segment(2) == 'contact' ? 'active' : '' }}"
                                   href="{{ route('admin.contact-settings') }}">
                                   <i class="fa fa-phone"></i>
                                    <span class="title">@lang('menus.backend.sidebar.contact.title')</span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link {{ $request->segment(2) == 'newsletter' ? 'active' : '' }}"
                                   href="{{ route('admin.newsletter-settings') }}">
                                   <i class="fa fa-newspaper-o"></i>
                                    <span class="title">@lang('menus.backend.sidebar.newsletter-configuration.title')</span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link {{ $request->segment(2) == 'footer' ? 'active' : '' }}"
                                   href="{{ route('admin.footer-settings') }}">
                                    <i class="fa fa-list-ol"></i>
                                    <span class="title">@lang('menus.backend.sidebar.footer.title')</span>
                                </a>
                            </li>
                                <li class="nav-item ">
                                    <a class="nav-link {{ $request->segment(2) == 'sitemap' ? 'active' : '' }}"
                                       href="{{ route('admin.sitemap.index') }}">
                                       <i class="fa fa-sitemap"></i>
                                        <span class="title">@lang('menus.backend.sidebar.sitemap.title')</span>
                                    </a>
                                </li>
                        @endif

                    </ul>


                </li>
            @else
                @can('blog_access')
                    <li class="nav-item ">
                        <a class="nav-link {{ $request->segment(2) == 'blogs' ? 'active' : '' }}"
                           href="{{ route('admin.blogs.index') }}">
                            <i class="nav-icon icon-note"></i>
                            <span class="title">@lang('menus.backend.sidebar.blogs.title')</span>
                        </a>
                    </li>
                @endcan
                @can('reason_access')
                    <li class="nav-item">
                        <a class="nav-link {{ $request->segment(2) == 'reasons' ? 'active' : '' }}"
                           href="{{ route('admin.reasons.index') }}">
                            <i class="nav-icon icon-layers"></i>
                            <span class="title">@lang('menus.backend.sidebar.reasons.title')</span>
                        </a>
                    </li>
                @endcan
            @endif

			
			
			
            <li class="nav-title hdPanel">
                @lang('menus.backend.sidebar.general')
            </li>
                    

            <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/dashboard')) }}"
                   href="{{ route('admin.dashboard') }}">
                   <i class="fa fa-dashboard"></i>  @lang('menus.backend.sidebar.dashboard')
                </a>
            </li> 

   
            <!--=======================Custom menus===============================-->
            @can('order_access')
               <!-- <li class="nav-item ">
                    <a class="nav-link {{ $request->segment(1) == 'orders' ? 'active' : '' }}"
                       href="{{ route('admin.orders.index') }}">
                        <i class="nav-icon icon-bag"></i>
                        <span class="title">@lang('menus.backend.sidebar.orders.title')</span>
                    </a>
                </li>-->
            @endcan

   

            
           <!--  <li class="nav-item ">
                <a class="nav-link {{ $request->segment(1) == 'messages' ? 'active' : '' }}"
                   href="{{ route('admin.messages') }}">
                    <i class="nav-icon icon-envelope-open"></i> <span
                            class="title">@lang('menus.backend.sidebar.messages.title')</span>
                </a>
            </li> -->
            @if ($logged_in_user->hasRole('student'))
               <!--  <li class="nav-item ">
                    <a class="nav-link {{ $request->segment(1) == 'invoices' ? 'active' : '' }}"
                       href="{{ route('admin.invoices.index') }}">
                        <i class="nav-icon icon-notebook"></i> <span
                                class="title">@lang('menus.backend.sidebar.invoices.title')</span>
                    </a>
                </li> -->
               <!--  <li class="nav-item ">
                    <a class="nav-link {{ $request->segment(1) == 'certificates' ? 'active' : '' }}"
                       href="{{ route('admin.certificates.index') }}">
                        <i class="nav-icon icon-badge"></i> <span
                                class="title">@lang('menus.backend.sidebar.certificates.title')</span>
                    </a>
                </li> -->
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle {{ $request->segment(1) == 'recomdextresource' ? 'active' : '' }}"
                       href="#">
                        <i class="icon fa fa-desktop fa-fw"></i> @lang('menus.backend.sidebar.elearningcourses.title')
                    </a>
                    <ul class="nav-dropdown-items sub-menu">
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/mycourse')) }}"
                               href="{{ route('admin.mycourse.index') }}">
                                <i class="icon fa fa-book fa-fw "></i> @lang('menus.backend.sidebar.mycourse.title')
                            </a>
                         </li>
                         <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/mycourse')) }}"
                               href="{{ route('admin.learnings.selfenroll') }}">
                                <i class="icon fa fa-graduation-cap fa-fw"></i> @lang('menus.backend.sidebar.selfenroll.title')
                            </a>
                         </li>
                    <li class="nav-item ">
                    <a class="nav-link {{ $request->segment(1) == 'courses' ? 'active' : '' }}"
                       href="{{ route('admin.learnings.index') }}">
                        <i class="icon fa fa-graduation-cap fa-fw "></i> <span
                                class="title">@lang('menus.backend.sidebar.e_learnings.title')</span>
                    </a>
                     </li>
                    <li class="nav-item ">
                    <a class="nav-link {{ $request->segment(1) == 'peercompstatus' ? 'active' : '' }}"
                       href="{{ route('admin.peercompstatus.index') }}">
                        <i class="icon fa fa-check-square fa-fw"></i> <span
                                class="title">@lang('menus.backend.sidebar.peercompstatus.title')</span>
                    </a>
                    </li>
                <li class="nav-item ">
                    <a class="nav-link {{ $request->segment(1) == 'courserequest' ? 'active' : '' }}"
                       href="{{ route('admin.courserequest.index') }}">
                        <i class="icon fa fa-check-square fa-fw"></i> <span
                                class="title">@lang('menus.backend.sidebar.courserequest.title')</span>
                    </a>
                </li>
				<li class="nav-item ">
                    <a class="nav-link {{ $request->segment(1) == 'certificates' ? 'active' : '' }}"
                       href="{{ route('admin.certificates.index') }}">
                        <i class="nav-icon icon-badge"></i> <span
                                class="title">@lang('menus.backend.sidebar.certificates.title')</span>
                    </a>
                </li>
                
                      

              

                

                    </ul>
                </li>
				@if ($logged_in_user->isAdmin() || $logged_in_user->is_admin == 1 || $officeLocation == 0)
				<li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle {{ $request->segment(1) == 'recomdextresource' ? 'active' : '' }}" href="#">
                        <i class="icon fa fa-desktop fa-fw"></i> <span
                        class="title">@lang('menus.backend.sidebar.recomdextresource.title')</span>
                    </a>
                    <ul class="nav-dropdown-items sub-menu">
                        <li class="nav-item ">
							<a class="nav-link {{ $request->segment(1) == 'resourcelist' ? 'active' : '' }}"
							   href="{{ route('admin.resources.index') }}">
								<i class="icon fa fa-file-o fa-fw"></i> <span
										class="title">@lang('menus.backend.sidebar.resourcelist.title')</span>
							</a>
						</li>
						<li class="nav-item ">
							<a class="nav-link {{ $request->segment(1) == 'resource' ? 'active' : '' }}"
							   href="{{ route('admin.resources.submitsuggestion') }}">
								<i class="icon fa fa-file-o fa-fw"></i> <span
										class="title">@lang('menus.backend.sidebar.submitsuggestion.title')</span>
							</a>
						</li>
                       
                    </ul>
                </li>

                
				@endif

                 <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle {{ $request->segment(1) == 'crts' ? 'active' : '' }}"
                       href="#">
                        <i class="nav-icon icon-badge"></i> <span
                                class="title">@lang('menus.backend.sidebar.mytraining.title')</span>

                    </a>
                    <ul class="nav-dropdown-items sub-menu">
                        <li class="nav-item ">
                            <a class="nav-link {{ $request->segment(1) == 'sales' ? 'active' : '' }}"
                               href="{{ route('admin.trainings.index') }}">
                                @lang('menus.backend.sidebar.upcomming.title')
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link {{ $request->segment(1) == 'students' ? 'active' : '' }}"
                               href="{{ route('admin.trainings.attended') }}">
                               @lang('menus.backend.sidebar.attended.title')
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link {{ $request->segment(1) == 'students' ? 'active' : '' }}"
                               href="{{ route('admin.trainings.training_status') }}">
                               @lang('menus.backend.sidebar.request.title')
                           </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link {{ $request->segment(1) == 'students' ? 'active' : '' }}"
                               href="{{ route('admin.trainings.feedback') }}">
                               @lang('menus.backend.sidebar.feedback.title')
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle {{ $request->segment(1) == 'crts' ? 'active' : '' }}"
                       href="#">
                        <i class="nav-icon icon-badge"></i> <span
                                class="title">@lang('menus.backend.sidebar.subordinate.title')</span>

                    </a>
                    <ul class="nav-dropdown-items sub-menu">
                        <li class="nav-item ">
                            <a class="nav-link {{ $request->segment(1) == 'sales' ? 'active' : '' }}"
                               href="{{ route('admin.trainings.request_approvel') }}">
                                @lang('menus.backend.sidebar.approval.title')
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link {{ $request->segment(1) == 'students' ? 'active' : '' }}"
                               href="{{ route('admin.trainings.training_attended') }}">
                               @lang('menus.backend.sidebar.attended.title')
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link {{ $request->segment(1) == 'students' ? 'active' : '' }}"
                               href="{{ route('admin.trainings.approved_training') }}">
                                @lang('menus.backend.sidebar.nomination.title')
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link {{ $request->segment(1) == 'students' ? 'active' : '' }}"
                               href="{{ route('admin.trainings.rejected_training') }}">
                               @lang('menus.backend.sidebar.rejected.title')
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
            @if ($logged_in_user->hasRole('teacher'))
                <li class="nav-item ">
                    <a class="nav-link {{ $request->segment(1) == 'reviews' ? 'active' : '' }}"
                       href="{{ route('admin.reviews.index') }}">
                        <i class="nav-icon icon-speech"></i> <span
                                class="title">@lang('menus.backend.sidebar.reviews.title')</span>
                    </a>
                </li>
            @endif

            @if ($logged_in_user->isAdmin())
               <!--  <li class="nav-item ">
                    <a class="nav-link {{ $request->segment(1) == 'contact-requests' ? 'active' : '' }}"
                       href="{{ route('admin.contact-requests.index') }}">
                        <i class="nav-icon icon-envelope-letter"></i>
                        <span class="title">@lang('menus.backend.sidebar.contacts.title')</span>
                    </a>
                </li> -->
               <!--  <li class="nav-item ">
                    <a class="nav-link {{ $request->segment(1) == 'contact-requests' ? 'active' : '' }}"
                       href="{{ route('admin.coupons.index') }}">
                        <i class="nav-icon icon-star"></i>
                        <span class="title">@lang('menus.backend.sidebar.coupons.title')</span>
                    </a>
                </li> -->
               <!--  <li class="nav-item ">
                    <a class="nav-link {{ $request->segment(1) == 'contact-requests' ? 'active' : '' }}"
                       href="{{ route('admin.tax.index') }}">
                        <i class="nav-icon icon-credit-card"></i>
                        <span class="title">@lang('menus.backend.sidebar.tax.title')</span>
                    </a>
                </li> -->
            @endif
            <li class="nav-item ">
                <a class="nav-link {{ $request->segment(1) == 'account' ? 'active' : '' }}"
                   href="{{ route('admin.account') }}">
                    <i class="nav-icon icon-key"></i>
                    <span class="title">@lang('menus.backend.sidebar.account.title')</span>
                </a>
            </li>
						
            @if ($logged_in_user->isAdmin() || $logged_in_user->is_admin == 1 || $officeLocation == 0)


                <!--==================================================================-->
                				
             <!--    <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/log-viewer*'), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/log-viewer*')) }}"
                       href="#">
                        <i class="nav-icon icon-list"></i> @lang('menus.backend.sidebar.debug-site.title')
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/log-viewer')) }}"
                               href="{{ route('log-viewer::dashboard') }}">
                                @lang('menus.backend.log-viewer.dashboard')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/log-viewer/logs*')) }}"
                               href="{{ route('log-viewer::logs.list') }}">
                                @lang('menus.backend.log-viewer.logs')
                            </a>
                        </li>
                    </ul>
                </li> -->

                <!-- <li class="nav-item ">
                    <a class="nav-link {{ $request->segment(1) == 'translation-manager' ? 'active' : '' }}"
                       href="{{ asset('user/translations') }}">
                        <i class="nav-icon icon-docs"></i>
                        <span class="title">@lang('menus.backend.sidebar.translations.title')</span>
                    </a>
                </li> -->

               <!--  <li class="nav-item ">
                    <a class="nav-link {{ $request->segment(1) == 'backup' ? 'active' : '' }}"
                       href="{{ route('admin.backup') }}">
                        <i class="nav-icon icon-shield"></i>
                        <span class="title">@lang('menus.backend.sidebar.backup.title')</span>
                    </a>
                </li> -->
                <!-- <li class="nav-item ">
                    <a class="nav-link {{ $request->segment(1) == 'update-theme' ? 'active' : '' }}"
                       href="{{ route('admin.update-theme') }}">
                        <i class="nav-icon icon-refresh"></i>
                        <span class="title">@lang('menus.backend.sidebar.update.title')</span>
                    </a>
                </li> -->
            @endif

			<li class="divider"></li>

                <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/*'), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/settings*')) }}"
                       href="#">
                        <i class="nav-icon icon-settings"></i> @lang('menus.backend.sidebar.settings.support')
                    </a>

                    <ul class="nav-dropdown-items sub-menu">
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/usermanual')) }}"
                               href="{{ route('admin.usermanual') }}"> <i class="fa fa-info-circle"></i>
                                @lang('menus.backend.sidebar.settings.usernamual')

                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/contactus')) }}"
                               href="{{ route('admin.contactus') }}"> <i class="fa fa-info-circle"></i>
                                @lang('menus.backend.sidebar.settings.contact')

                            </a>
                        </li>
                    </ul>
                </li>
        </ul>
    </nav>

   
</div><!--sidebar-->
