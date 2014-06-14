@section('js-localization.head')
    <script type="text/javascript" src="{{ action('JsLocalizationController@createJsMessages') }}"></script>
@stop