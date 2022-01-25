@forelse ($comments as $comment)
    <tr class="tbl__row">
        <td class="tbl__cell" role="cell">
            {{ $comment->id }}
        </td>

        <td class="tbl__cell" role="cell">
            <div class="flex items-center">
                <div class="line-height-xs">
                    @if ($comment->user_id)
                        {{ $comment->user->name }}<br>
                        <span class="text-sm color-contrast-medium">(id: {{ $comment->user->id }})</span>
                    @else
                        {{ $comment->username }}
                    @endif
                </div>
            </div>
        </td>

        <td class="tbl__cell" role="cell">
            @if ($comment->parent_id)
                {{ $comment->parent_id }}
            @else
                --
            @endif
        </td>

        <td class="tbl__cell" width="200px" role="cell">
            {{ Str::limit($comment->comment, 100) }}

        </td>

        <td class="tbl__cell" role="cell">
            {{ $comment->created_at }}
        </td>

        <td class="tbl__cell text-right" role="cell">

            <div class="flex flex-wrap gap-xs">
                <a class="btn btn--primary btn--sm"
                    href="{{ route('comments.edit', ['comment' => $comment->id]) }}">
                    Изменить
                </a>

                <form method="POST"
                        action="{{ route('comments.destroy', ['comment' => $comment->id]) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn--accent btn--sm">Удалить
                    </button>
                </form>

            </div>

        </td>
    </tr>
        @if (count($comment->replies))
            <x-admin.reply-comments-table-row :replies="$comment->replies">
            </x-admin.reply-comments-table-row>
        @endif
    @empty
    <tr>
        <td class="tbl__cell text-center text-md" colspan="6">Нет комментариев</td>
    </tr>
@endforelse