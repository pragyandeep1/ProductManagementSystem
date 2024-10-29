<h5 class="modal-title">Account Details</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
<form id="viewJob">
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="required"> Account Name </label>
                <input type="text" class="form-control" placeholder="Enter Account Name" name="description"
                    value="{{ $accountdata->description }}" readonly>
                <div class="error-messages" id="descriptionError"></div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="required" for="code"> Account Code </label>
                <input type="text" class="form-control" placeholder="Enter Account Code" name="code" id="code"
                    value="{{ $accountdata->code }}" readonly>
                <div class="error-messages" id="codeError"></div>
            </div>
        </div>
        <div class="error-messagess"></div>
    </div>
</form>
