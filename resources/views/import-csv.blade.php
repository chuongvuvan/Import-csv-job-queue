<form action="{{ route('csv.import') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="csv_file">
    <button type="submit">Import</button>
</form>
@error('csv_file')
<div class="error">{{ $message }}</div>
@enderror
@if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif
