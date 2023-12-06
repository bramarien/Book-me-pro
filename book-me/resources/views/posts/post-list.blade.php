@foreach ($posts as $post)
    @include('posts.post-card')
@endforeach
<div class="m-3">
    {{ $posts->links() }}
</div>
