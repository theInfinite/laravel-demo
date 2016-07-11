@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Upload Image</div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                <div class="panel-body">
                                    <form class="form-horizontal" role="form" enctype="multipart/form-data">
                                        {{ csrf_field() }}

                                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                                            <div class="col-md-6">

                                                <input type="file" id="file" class="form-control" name="file"
                                                       accept=".jpg, .png, .jpeg">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-6 col-md-offset-4">

                                                <button onclick="uploadImage(event);" type="submit" id="btnUploadImage" class="btn btn-success" value="alert">
                                                    <i class="fa fa-btn  fa-wrench"></i> Upload
                                                </button>
                                                <button id="btnCancel" class="btn btn-primary">
                                                    <i class="fa fa-btn  fa-ban"></i> Cancel
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Image Gallery</div>
                    <div class="panel-body">
                        <div id="imageListing">
                            @foreach($images as $image)

                                <div id="lightboxOverlay" class="lightboxOverlay"></div>
                                <div id="lightbox" class="lightbox">
                                    <div class="lb-dataContainer">
                                        <div class="lb-data">
                                            <div class="lb-details">
                                                <span class="lb-caption"></span>
                                                <span class="lb-number"></span>
                                            </div>
                                            <div class="lb-closeContainer">
                                                <a class="lb-close"></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3" style="height:150px; margin-bottom: 50px;">
                                    <img src="{{ asset('image/close_icon.jpg')}}" style="height:18px;margin-top:4px;margin-left: 197px; cursor: hand" onclick="closeImage(event,'<?php echo $image['id']?>');">
                                    <img id="pic" src="{{ asset('uploads/'.$image['file']) }}" alt="<?php echo $image['file']?>" title="<?php echo $image['file']?>">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

