<div class="modal fade" id="modalImportIndikator" tabindex="-1" role="dialog" aria-labelledby="modalImportIndikatorLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-0 shadow">
            
            <div class="modal-header bg-white border-0 pt-4 px-4 pb-0">
                <h5 class="modal-title font-weight-normal text-dark" id="modalImportMateriLabel">Import Data Indikator</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="outline: none;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('indikator.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body px-4 py-3">
                    <div class="form-group row align-items-center mb-2">
                        <label for="fileImportIndikator" class="col-sm-3 col-form-label font-weight-bold text-dark">File Import</label>
                        <div class="col-sm-9">
                            <div class="custom-file">
                                <input type="file" name="file" class="custom-file-input" id="fileImportIndikator" required accept=".xlsx, .xls, .csv" onchange="updateFileName(this)">
                                <label class="custom-file-label" for="fileImportIndikator" id="fileImportIndikatorLabel">Pilih file Excel</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-white border-0 px-4 pb-4 pt-0 justify-content-end">
                    <button type="button" class="btn btn-outline-secondary px-4 mr-2" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Import</button>
                </div>
            </form>

        </div>
    </div>
</div>