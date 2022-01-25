@forelse($replies as $reply)
        <tr class="tbl__row bg-contrast-lower">
        <td class="tbl__cell" role="cell">
            &nbsp;{{ $reply->id }}
        </td>

        <td class="tbl__cell" role="cell">
            <div class="flex items-center">
                <div class="line-height-xs">
                    @if ($reply->user_id)
                        {{ $reply->user->name }}<br>
                        <span class="text-sm color-contrast-medium">(id: {{ $reply->user->id }})</span>
                    @else
                        {{ $reply->username }}
                    @endif
                </div>
            </div>
        </td>

        <td class="tbl__cell" role="cell">
            @if ($reply->parent_id)
                {{ $reply->parent_id }}
            @else
                --
            @endif
        </td>


        <td class="tbl__cell" width="200px" role="cell">
            {{ Str::limit($reply->comment, 100) }}

        </td>


        <td class="tbl__cell" role="cell">
            {{ $reply->created_at }}
        </td>

        <td class="tbl__cell text-right" role="cell">

            <div class="flex flex-wrap gap-xs">
                <a class="btn btn--primary btn--sm"
                    href="{{ route('comments.edit', ['comment' => $reply->id]) }}">
                    Изменить
                </a>

                <form method="POST"
                        action="{{ route('comments.destroy', ['comment' => $reply->id]) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn--accent btn--sm">Удалить
                    </button>
                </form>

            </div>

        </td>
    </tr>
        @if (count($reply->replies))
                <x-admin.reply-comments-table-row :replies="$reply->replies">
                </x-admin.reply-comments-table-row>
        @endif
    @empty
@endforelse