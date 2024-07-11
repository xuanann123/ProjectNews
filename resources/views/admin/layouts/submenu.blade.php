<option {{ isset($category->id) && $category->parent_id == $cat->id ? 'selected' : '' }}
    {{ isset($post->category) && $post->category->id == $cat->id ? 'selected' : '' }}
    value="{{ $cat->id }}">
    {{ $level }}{{ $cat->name }}</option>
@if ($cat->children->count() > 0)
    @php
        $level .= '-';
    @endphp
    @foreach ($cat->children as $child)
        @include('admin.layouts.submenu', [
            'cat' => $child,
        ]);
    @endforeach
@endif
