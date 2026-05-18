@if(Session::has('success')) 
    <div id="information" class="alert alert-success">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<i class="fa fa-check-circle" aria-hidden="true"></i> <strong>Success : </strong><span>{{ Session::get('success') }}</span>
</div>
@endif
@if(Session::has('info'))
    <div id="information" class="alert alert-info">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<i class="fa fa-info-circle"></i> <strong>Notice : </strong><span>{{ Session::get('info') }}</span>
</div>
@endif
@if(Session::has('warning'))
    <div id="information" class="alert alert-warning">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <strong>Warning : </strong><span>{{ Session::get('warning') }}</span>
</div>
@endif
@if(Session::has('danger'))
    <div id="information" class="alert alert-danger">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<span class="glyphicon glyphicon-remove-sign"></span> <strong>Error : </strong><span>{{ Session::get('danger') }}</span>
</div>
@endif