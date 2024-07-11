@foreach ($comments as $comment)
    <hr>
    <style>
        .img {
            width: 50px !important;
        }
    </style>
    <div class="media d-block d-sm-flex mb-4 pb-4 mt-3" style="margin-left: {{ $comment->parent_id ? '20px' : '0' }}">
        {!! $comment->parent_id
            ? '<img class="mr-3 img" src="http://php3.test/theme/fontend/images/post/arrow.png" alt="">'
            : '' !!}
        <a class="d-inline-block mr-2 mb-3 mb-md-0" href="#">
            @php
                $comment_author_image = Storage::url($comment->user->image);
            @endphp
            @if ($comment->user->image)
                <img src="{{ $comment_author_image }}" class="mr-3 rounded-circle img"
                    alt="">
            @else
                <img src="{{ url('image/notimage.webp') }}" class="mr-3 rounded-circle img"
                    alt="">
            @endif

        </a>
        <div class="media-body">
            <a href="#!" class="h4 d-inline-block mb-3">{{ $comment->user->name }}</a>
            <p>{{ $comment->content }}</p>
            <span
                class="text-black-800 mr-3 font-weight-600">{{ date('d-m-Y H:i', strtotime($comment->created_at)) }}</span>
            <a class="text-primary font-weight-600" href="#!"
                onclick="toggleReplyForm({{ $comment->id }})">Reply</a>

            <div id="reply-form-{{ $comment->id }}" style="display:none;" class="mt-3">
                <form action="{{ route('post.comments.store', $post_id) }}" method="POST">
                    @csrf
                    {{-- Có một thẻ input chứ id của comment đó  --}}
                    {{-- Nếu trả lời câu hỏi thì parent_id sẽ bằng id_comment --}}
                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                    <div class="mb-3">
                        <label for="content-{{ $comment->id }}" class="form-label">Add a reply</label>
                        <textarea class="form-control" id="content-{{ $comment->id }}" name="content" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-secondary">Submit</button>
                </form>
            </div>
            @include('layouts.comments', ['comments' => $comment->replies, 'post_id' => $post_id])
        </div>
    </div>
@endforeach

<script>
    function toggleReplyForm(commentId) {
        var form = document.getElementById('reply-form-' + commentId);
        if (form.style.display === 'none') {
            form.style.display = 'block';
        } else {
            form.style.display = 'none';
        }
    }
</script>
