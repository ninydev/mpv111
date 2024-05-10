<h1>
    Upload 2 photo

</h1>

<form method="POST" enctype="multipart/form-data" action="{{route('store')}}">
    @csrf
    <div><label>Photo<input type="file" name="photo"></label></div>
    <div><label>Back<input type="file" name="back"></label></div>
    <div><input type="submit"></div>

</form>
