<h1> All Posts </h1>

<ul>
@foreach ($posts as $post)
    <img src="{{ $post->image_url  }}" />
    <li>This is user {{ $post->title }}</li>
@endforeach
</ul>
