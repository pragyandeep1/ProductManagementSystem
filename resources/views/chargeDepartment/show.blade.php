<h5 class="modal-title">Record Details</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
<form id="viewJob">
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="required"> Name </label>
                <input type="text" class="form-control" placeholder="Enter Name" name="description"
                    value="{{ $chargedata->description }}" readonly>
                <div class="error-messages" id="descriptionError"></div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="required" for="code">Code </label>
                <input type="text" class="form-control" placeholder="Enter Code" name="code" id="code"
                    value="{{ $chargedata->code }}" readonly>
                <div class="error-messages" id="codeError"></div>
            </div>
        </div>
        <div class="error-messagess"></div>
    </div>
</form>
