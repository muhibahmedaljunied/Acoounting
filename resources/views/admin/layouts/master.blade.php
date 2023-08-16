<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
	<meta name="Author" content="Spruko Technologies Private Limited">
	<meta name="Keywords" content="admin,admin dashboard,admin dashboard template,admin panel template,admin template,admin theme,bootstrap 4 admin template,bootstrap 4 dashboard,bootstrap admin,bootstrap admin dashboard,bootstrap admin panel,bootstrap admin template,bootstrap admin theme,bootstrap dashboard,bootstrap form template,bootstrap panel,bootstrap ui kit,dashboard bootstrap 4,dashboard design,dashboard html,dashboard template,dashboard ui kit,envato templates,flat ui,html,html and css templates,html dashboard template,html5,jquery html,premium,premium quality,sidebar bootstrap 4,template admin bootstrap 4" />
	<meta name="csrf-token" content="{{ csrf_token() }}">
	
	@include('admin.layouts.head')
</head>

<body class="main-body app sidebar-mini">
	<!-- Loader -->
	<div id="global-loader">
		<img src="{{URL::asset('assets/img/loader.svg')}}" class="loader-img" alt="Loader">
	</div>
	<!-- main-sidebar -->
	<div class="app-sidebar__overlay" data-toggle="sidebar"></div>


	<div id='app'>
		<main-sidebar></main-sidebar>
		<div class="main-content app-content">
			<main-header></main-header>
			<div class="container-fluid">
				<page-header></page-header>
				<router-view></router-view>
				<sidebar-section></sidebar-section>
			</div>
		</div>
		<footer-section></footer-section>
	</div>

	@include('admin.layouts.footer-scripts')
	<!-- this for multiple select  -->
	<script>
		$(document).ready(function() {

			var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
				removeItemButton: true,
				maxItemCount: 5,
				searchResultLimit: 5,
				renderChoiceLimit: 5
			});


		});
	</script>
	
</body>

</html>