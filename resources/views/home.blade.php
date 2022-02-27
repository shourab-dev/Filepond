@extends('layouts.app')

@section('content')
<div class="card col-4 mx-auto shadow">
    <div class="card-header">
        File Upload using file pond
    </div>
    <div class="card-body">
        <form action="{{ route('store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="file" name="photo" class="form-control">
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection

@section('custom_js')
<script>
    // Get a reference to the file input element
        const inputElement = document.querySelector('input[name="photo"]');
    
        // Create a FilePond instance
        const pond = FilePond.create(inputElement);
        FilePond.setOptions({
        server: {

            url: '/upload',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }



        });
</script>
@endsection