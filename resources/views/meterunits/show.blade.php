<h5 class="modal-title">Record Details</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
<form id="viewJob">
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="required"> Name </label>
                <input type="text" class="form-control" placeholder="Enter Name" name="name"
                    value="{{ $meterdata->name }}" readonly>
                <div class="error-messages" id="nameError"></div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="required" for="symbol">Symbol </label>
                <input type="text" class="form-control" placeholder="Enter Symbol" name="symbol" id="symbol"
                    value="{{ $meterdata->symbol }}" readonly>
                <div class="error-messages" id="symbolError"></div>
            </div>
        </div>
        <div class="error-messagess"></div>
    </div>
</form>
