@extends('welcome')

@section('content')

@if(session()->has('message'))
    <div class="alert alert-success mt-3">
        {{ session()->get('message') }}
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger mt-3">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{route('companyimport')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row mb-4">
        <label for="formFile" class="form-label">Move files as task condition. Please Upload you csv file.</label>
        <div class="col-11">
            <div class="mb-3">
                <input name="file" class="form-control" type="file" id="formFile">
              </div>
        </div>
        <div class="col-1">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>

  </form>




@stop

@push('scripts')
<script>

</script>
@endpush
