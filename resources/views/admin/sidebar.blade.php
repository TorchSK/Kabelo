@include('includes/filterbar')

@if (Request::segment(1)=='admin')
	@include('modals/newcategory')
@endif

