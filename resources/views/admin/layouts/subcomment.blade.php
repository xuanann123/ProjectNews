 <tr>
     <th scope="row">
         <div class="form-check">
             <input class="form-check-input checkbox" type="checkbox" name="list_check[]" value="{{ $item->id }}">
         </div>
     </th>
     <td class="stt">{{ $t }}</td>

     <td class="customer_name"><a
             href="{{ route('post.detail', ['id' => $item->post->id, 'slug' => $item->post->slug]) }}">{{ $level }}{{ $item->content }}</a>
     </td>
     <td>
         @php
             $url = Storage::url($item->user->image);
         @endphp
         <a href="{{ route('admin.users.detail', $item->user->id) }}">
             <div class="d-flex gap-2 align-items-center">
                 <div class="flex-shrink-0">
                     @if ($item->user->image)
                         <img src="{{ $url }}" alt="" class="avatar-xs rounded-circle" />
                     @else
                         <img src="{{ url('image/notimage.webp') }}" alt="" class="avatar-xs rounded-circle" />
                     @endif

                 </div>
                 <div class="flex-grow-1">
                     {{ $item->user->name }}
                 </div>
             </div>
         </a>
     </td>
     <td class="phone">
         {{ $item->post->title }}
     </td>
     <td>
         <div class="d-flex gap-2">
             @can('slide.delete')
                 <div class="remove">

                     <a onclick="return confirm('Bạn có muốn xoá bình luận không?')"
                         href="{{ route('admin.comments.destroy', $item->id) }}"
                         class="btn btn-sm btn-danger remove-item-btn">Xoá</a>
                 </div>
             @endcan
         </div>
     </td>
 </tr>
 @if ($item->replies->count() > 0)
     @php
         $level .= '-';
     @endphp
     @foreach ($item->replies as $replies)
         @include('admin.layouts.subcomment', ['item' => $replies])
     @endforeach
 @endif
