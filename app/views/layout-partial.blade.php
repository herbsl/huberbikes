@if (isset($title))
<title>Bike Service Huber - {{{ $title }}}</title>
@else
<title>Bike Service Huber</title>
@endif
@if (isset($description))
<meta name="description" content="{{{ $description }}}">
@endif
<div id="singlepage-content">@yield('content')</div>
<script id="singlepage-javascript">@yield('javascript')</script>
