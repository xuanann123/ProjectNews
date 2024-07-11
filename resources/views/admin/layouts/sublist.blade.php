<tr>
    <th scope="row">
        <div class="form-check">
            <input class="form-check-input checkbox" type="checkbox" name="list_check[]" value="{{ $item->id }}">
        </div>
    </th>

    <td class="customer_name"><a href="{{ route('admin.categories.edit', $item->id) }}">{{ $level }}{{ $item->name }}</a>
    </td>
    <td class="email">{{ $item->description }}</td>

    <td class="phone">
        {!! $item->is_active
            ? '<span class="badge bg-danger text-uppercase">Hoạt động</span>'
            : '<span class="badge bg-info">Chờ duyệt</span>' !!}
    </td>
    <td class="date">{{ $item->updated_at }}</td>
    <td class="status">{{ $item->created_at }} </td>
    <td>
        @if (request()->status !== 'trash')
            <div class="d-flex gap-2">
                @can('category.edit')
                    <div class="edit">
                        <a href="{{ route('admin.categories.edit', $item->id) }}">
                            <span class="btn btn-sm btn-success edit-item-btn">Sửa
                            </span>
                        </a>
                    </div>
                @endcan
                @can('category.delete')
                    <div class="remove">
                        <a href="{{ route('admin.categories.destroy', $item->id) }}"
                            onclick="return confirm('Bạn có muốn xoá danh mục {{ $item->name }} không?')"
                            class="btn btn-sm btn-danger remove-item-btn">
                            Xoá</a>
                    </div>
                @endcan

            </div>
        @else
            <div class="d-flex gap-2">

                @can('category.delete')
                    <div class="remove">
                        <a onclick="return confirm('Bạn có muốn khôi phục {{ $item->name }} không?')"
                            href="{{ route('admin.categories.restore', $item->id) }}"
                            class="btn btn-sm btn-primary remove-item-btn">Khôi
                            phục</a>
                    </div>
                @endcan
                @can('category.delete')
                    <div class="remove">
                        <a onclick="return confirm('Bạn có muốn xoá vĩnh viễn {{ $item->name }} không?')"
                            href="{{ route('admin.categories.forceDelete', $item->id) }}"
                            class="btn btn-sm btn-danger remove-item-btn">Xoá vĩnh
                            viễn</a>
                    </div>
                @endcan
            </div>
        @endif
    </td>
</tr>
@if ($item->children->count() > 0)
    @php
        $level .= '-'   
    @endphp
    @foreach ($item->children as $child)
        @include('admin.layouts.sublist', [
            'item' => $child,
        ])
    @endforeach
@endif
