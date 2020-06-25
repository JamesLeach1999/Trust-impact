@extends("layouts.app")
<script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC6xrYHhT-_CeoktqgAwGjbOCNrmVUkXno&callback=initMap"
      defer
    ></script>
@section("content")

    <h2>Submit postcodes</h2>
    
    {!! Form::open(['action' => "PagesController@parseFile", "method" => "POST", "enctype"=> "multipart/form-data"]) !!}
    <div class="form-group">
    <div>
    {{Form::file("cover_image")}}
    </div>
    {{Form::submit("Submit", ['class' => "btn"])}}
    {!! Form::close() !!}
@endsection