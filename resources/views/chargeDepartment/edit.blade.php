<h5 class="modal-title">Edit Details</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
<form id="editJob" action="{{ route('charge.update', $chargedata->id) }}">
    <div class="row">
        <div class="col-sm-5">
            <div class="form-group">
                <label class="description"> Name </label>
                <input type="text" class="form-control" placeholder="Enter Name" name="description" id="description"
                    value="{{ $chargedata->description }}">
                <div class="error-messages" id="descriptionError"></div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="code"> Code</label>
                <input type="text" class="form-control" placeholder="Enter Code" name="code" id="code"
                    value="{{ $chargedata->code }}">
                <div class="error-messages" id="codeError"></div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-select" aria-label="Default select example" name="status" id="status">
                    <option value="1" {{ $chargedata->status == 1 ? 'selected' : '' }}>Active
                    </option>
                    <option value="0" {{ $chargedata->status == 0 ? 'selected' : '' }}>Disable
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
