@extends('layouts.app')

@section('content')
<nav class="navbar navbar-expand-lg navbar-bg">
	<div class="navbar-brand">
		<a href="{{route('home')}}" class="text-light">
			<img src="{{asset('logo.png')}}" class="img-fluid" style="width:40px !important;" alt="">
			{{setting('app.name')}}
		</a>
	</div>

	<div class="d-md-none ml-auto mt-2 mt-lg-0">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
			<i class="material-icons text-light">supervisor_account</i>
		</button>
		<button class="navbar-toggler sidebar-mobile-main-toggle" type="button" id="menu-toggle">
			<i class="material-icons text-light">menu</i>
		</button>
	</div>

	<div class="collapse navbar-collapse" id="navbar-mobile">
		<ul class="navbar-nav ml-auto mt-2 mt-lg-0">
			<li class="nav-item dropdown">
				<a href="#" class="navbar-nav-link dropdown-toggle text-light" data-toggle="dropdown">
					<img src="{{Auth::user()->image->path ?? null}}" class="img-fluid" style="width:40px !important;" alt="">
					{{Auth::user()->name}}
				</a>
				<div class="dropdown-menu dropdown-menu-right">
					<a href="{{route('account.index')}}" class="dropdown-item">
						<i class="material-icons md-22">supervisor_account</i> {{__('Account Settings')}}
					</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="material-icons">exit_to_app</i> {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
				</div>
			</li>
		</ul>
	</div>
</nav>

<div class="d-flex" id="wrapper">
	<!-- Sidebar -->
	<div class="sidebar border-right" id="sidebar-wrapper">
		<div class="list-group list-group-flush">
			<a href="{{route('dashboard')}}" class="list-group-item list-group-item-action"><i class="material-icons">home</i> {{__('Dashboard')}}</a>

			<a href="{{route('statistics.index')}}" class="list-group-item list-group-item-action"><i class="material-icons">assessment</i> {{__('Statistics')}}</a>
			
			@can('customers_access')
				<a href="{{route('customers.index')}}" class="list-group-item list-group-item-action"><i class="material-icons">perm_contact_calendar</i> {{__('Customers')}}</a>
			@endcan
			@can('categories_access')
				<a href="{{route('categories.index')}}" class="list-group-item list-group-item-action"><i class="fas fa-list-ol"></i> {{__('Categories')}}</a>
			@endcan
			@can('products_access')
				<a href="{{route('categories.index')}}" class="list-group-item list-group-item-action"><i class="fas fa-utensils"></i> {{__('Products')}}</a>
			@endcan
			@can('answers_access')
				<a href="{{route('answers.index')}}" class="list-group-item list-group-item-action"><i class="material-icons">question_answer</i> {{__('answers')}}</a>
			@endcan
			@can('chatlogs_access')
				<a href="{{route('chatlogs.index')}}" class="list-group-item list-group-item-action"><i class="material-icons">message</i> {{__('chatlogs')}}</a>
			@endcan
			@can('bots_access')
				<a href="{{route('bots.index')}}" class="list-group-item list-group-item-action"><i class="material-icons">bubble_chart</i> {{__('bots')}}</a>
			@endcan

			<a href="#submenu1" class="list-group-item list-group-item-action pb-1" data-toggle="collapse">
				<i class="material-icons">apps</i>
				{{__('Gestion Utilisateur')}}
				<i class="bi bi-chevron-down float-right" style="font-size: 10px;"></i>
			</a>
			<div class="collapse list-group-submenu" id="submenu1">
				
				@can('users_access')
					<a href="{{route('users.index')}}" data-parent="#submenu1" class="list-group-item list-group-item-action"><i class="material-icons">supervisor_account</i> {{__('Users')}}</a>
				@endcan

				@can('activitylog_access')
					<a href="{{route('activitylog.index')}}" data-parent="#submenu1" class="list-group-item list-group-item-action"><i class="material-icons">list</i> {{__('Activity Log')}}</a>
				@endcan
	
				@can('roles_access')
					<a href="{{route('roles.index')}}" data-parent="#submenu1" class="list-group-item list-group-item-action"><i class="material-icons">perm_data_setting</i> {{__('Roles')}}</a>
				@endcan
	
				@can('permissions_access')	
					<a href="{{route('permissions.index')}}" data-parent="#submenu1" class="list-group-item list-group-item-action"><i class="material-icons">lock_open</i> {{__('Permissions')}}</a>
				@endcan

				@role('admin')	
					<a href="{{route('settings.app')}}" data-parent="#submenu1" class="list-group-item list-group-item-action"><i class="material-icons">settings</i> {{__('Settings')}}</a>
				@endrole
			</div>

		</div>
	</div>
	<!-- /#sidebar-wrapper -->

	<!-- Page Content -->
	<div id="page-content-wrapper">
		@yield('sub_content')
	</div>
	<!-- /#page-content-wrapper -->
</div>


{{-- <script>
	/* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
	var dropdown = document.getElementsByClassName("dropdown-btn");
	var i;
	
	for (i = 0; i < dropdown.length; i++) {
	  dropdown[i].addEventListener("click", function() {
		this.classList.toggle("active");
		var dropdownContent = this.nextElementSibling;
		if (dropdownContent.style.display === "flex") {
			dropdownContent.style.display = "none";
		} else {
			dropdownContent.style.display = "flex";
		}
	  });
	}
</script> --}}

<script>
	$(document).ready(function() {
		
		$('div[class="collapse list-group-submenu"] a[href*="'+window.location.href.split('/')[3]+'"]').parent().toggle();
		$('div a[href*="'+window.location.href.split('/')[3]+'"]:first').toggleClass('active', 1);

		// $('div[class="collapse list-group-submenu"] a[href$="'+window.location.href.split('/')[3]+'"]').parent().toggle();
		// $('div a[href$="'+window.location.href.split('/')[3]+'"]:first').toggleClass('active', 1);
	});
</script>

@endsection