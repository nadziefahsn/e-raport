@foreach($karakters as $item)
@php
    $slugId = Str::slug($item->id);
    $isThisModalError = $errors->any() && old('old_id') == $item->id;
@endphp
<div class="modal fade edit-modal" id="editModal{{ $slugId }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 550px;">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold">Edit Data Karakter</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="{{ route('karakter.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <input type="hidden" name="old_id" value="{{ $item->id }}">

                <div class="modal-body p-4">
                    @if($isThisModalError)
                        <div class="alert alert-danger py-2 mb-3">
                            <small><i class="fas fa-ban mr-1"></i> {{ $errors->first('id') }}</small>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label fw-bold">Kode Karakter</label>
                        <input type="text" name="id" class="form-control rounded-3 @error('id') is-invalid @enderror" value="{{ $isThisModalError ? old('id') : $item->id }}" maxlength="10" required>
                        <small class="text-muted">Maksimal 10 karakter (contoh: 1.1)</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Karakter</label>
                        <input type="text" name="karakter" class="form-control rounded-3 @error('karakter') is-invalid @enderror" value="{{ $isThisModalError ? old('karakter') : $item->karakter }}" required>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Kembali
                    </button>
                    <button type="submit" class="btn btn-dark">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach