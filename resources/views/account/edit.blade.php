<h5 class="modal-title">Edit Account Details</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
<form id="editJob" action="{{ route('account.update', $accountdata->id) }}">
    <div class="row">
        <div class="col-sm-5">
            <div class="form-group">
                <label class="description"> Account Name </label>
                <input type="text" class="form-control" placeholder="Enter Account Name" name="description"
                    id="description" value="{{ $accountdata->description }}">
                <div class="error-messages" id="descriptionError"></div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="code">Account Code</label>
                <input type="text" class="form-control" placeholder="Enter Account Code" name="code"
                    id="code" value="{{ $accountdata->code }}">
                <div class="error-messages" id="codeError"></div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-select" aria-label="Default select example" name="status" id="status">
                    <option value="1" {{ $accountdata->status == 1 ? 'selected' : '' }}>Active
                    </option>
                    <option value="0" {{ $accountdata->status == 0 ? 'selected' : '' }}>Disable
                    </option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="jobUpdateBtn">Update</button>
        </div>
        <div class="error-messagess"></div>
    </div>
</form>
