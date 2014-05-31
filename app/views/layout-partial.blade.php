@include('title')
@if (isset($description))
<meta name="description" content="{{{ $description }}}">
@endif
<div id="singlepage-content">@yield('content')</div>
<script id="singlepage-javascript">@yield('javascript')</script>
