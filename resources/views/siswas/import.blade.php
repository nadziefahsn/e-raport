<div class="modal fade" id="modalImportSiswa" tabindex="-1" role="dialog" aria-labelledby="modalImportSiswaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalImportSiswaLabel">
                    Import Peserta Didik
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form action="{{ route('siswa.import') }}" method="POST" enctype="multipart/form-data" onsubmit="document.getElementById('btnSubmitImportSiswa').disabled = true;">
                @csrf
                <div class="modal-body py-4">
                    <div class="form-group row align-items-center mb-0">
                        <label for="file" class="col-sm-3 col-form-label font-weight-bold">
                            File Import
                        </label>
                        <div class="col-sm-9">
                            <div class="custom-file">
                                <input type="file" name="file" class="custom-file-input" id="customFileSiswa" accept=".xlsx, .xls" required>
                                <label class="custom-file-label" for="customFileSiswa" data-browse="Browse">Pilih file</label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" id="btnSubmitImportSiswa" class="btn btn-primary">
                        Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>