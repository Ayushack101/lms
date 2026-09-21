@foreach ($boards as $board)
    <tr>
        <td>{{ $board->id }}</td>
        <td>{{ $board->board_name }}</td>
        <td>{{ $board->created_at->format('d M Y') }}</td>
        <td>
            <a href="{{ route('boards.edit', $board->id) }}"><button type="button" class='btn btn-primary edit-btn'> <i
                        class="fas fa-edit"></i></button></a>

            <button type="button" data-toggle="modal" data-target="#delete-board-modal" data-id="{{ $board->id }}"
                class='btn btn-danger mx-2 delete-btn'>
                <i class="fas fa-trash"></i>
            </button>
        </td>
    </tr>
@endforeach