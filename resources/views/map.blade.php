@extends('layouts.app')

@section('content')
    <div class="container">
            <style>
                #map {
                    width: 100%;
                    height: 400px;
                }
            </style>

        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Map
                        <button  type="submit" id="btnAddMarker" class="btn btn-primary pull-right" style="margin-top:-6px;"
                        data-toggle="modal" data-target="#myMapModal">
                            <i class="fa fa-btn fa-plus-square"></i> Add Marker
                        </button>
                        <div id="myMapModal" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Add Marker</h4>
                                    </div>

                                    <form class="form-horizontal" id="addMarkerForm" role="form">
                                        {{ csrf_field() }}
                                        <div class="modal-body">
                                            <div class="form-group{{ $errors->has('palceName') ? ' has-error' : '' }}">
                                                <label for="palceName" class="col-md-4 control-label">Place Name</label>

                                                <div class="col-md-6">
                                                    <input id="palceName" type="text" class="form-control" name="palceName">

                                                    @if ($errors->has('palceName'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('palceName') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group{{ $errors->has('placeAddress') ? ' has-error' : '' }}">
                                                <label for="placeAddress" class="col-md-4 control-label">Address</label>

                                                <div class="col-md-6">
                                                    <input id="placeAddress" type="text" class="form-control" name="placeAddress">

                                                    @if ($errors->has('placeAddress'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('placeAddress') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group{{ $errors->has('latitude') ? ' has-error' : '' }}">
                                                <label for="latitude" class="col-md-4 control-label">Latitude</label>

                                                <div class="col-md-6">
                                                    <input id="latitude" type="number" class="form-control" name="latitude">

                                                    @if ($errors->has('latitude'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('latitude') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group{{ $errors->has('longitude') ? ' has-error' : '' }}">
                                                <label for="longitude" class="col-md-4 control-label">Latitude</label>

                                                <div class="col-md-6">
                                                    <input id="longitude" type="number" class="form-control" name="longitude">

                                                    @if ($errors->has('longitude'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('longitude') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="modal-footer">

                                                <button  type="submit" id="btnAddMarker" class="btn btn-primary">
                                                    <i class="fa fa-btn fa-plus-square"></i> Add
                                                </button>

                                            </div>

                                    </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                    <form>
                        {{ csrf_field() }}
                        <div id="map"></div>
                    </form>
                </div>
            </div>
        </div>

        <script>


        </script>

    </div>
@endsection

