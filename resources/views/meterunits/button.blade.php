{{-- <button type="button" class="btn btn-warning btn-sm edit-button" value="{{ $item['id'] }}" data-id="{{ $item['id'] }}"
    onclick="editForm('{{ route('meter.show', $item['id']) }}','view_modal_body')" data-bs-target="#view-modal"
    data-bs-toggle="modal">
    <i class="bi bi-eye"></i>
</button> --}}

<button type="button" class="link-primary" value="{{ $item['id'] }}" data-id="{{ $item['id'] }}"
    onclick="editForm('{{ route('meter.edit', $item['id']) }}','edit_modal_body')" data-bs-target="#editjob-modal"
    data-bs-toggle="modal">
    <i class="fa-regular fa-pen-to-square"></i>
</button>

{{-- <button type="button" class="link-danger" onclick="delete_entity('{{ route('meter.delete', $item['id']) }}')"
    data-id="{{ $item['id'] }}">
    <i class="fa-solid fa-trash-can"></i>
</button> --}}
