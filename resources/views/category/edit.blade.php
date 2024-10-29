<h5 class="modal-title">Edit Category Details</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
<form id="editJob" action="{{ route('category.update', $categorydata->id) }}">
    <div class="row">
        <div class="col-sm-5">
            <div class="form-group">
                <label class="name"> Category Name </label>
                <input type="text" class="form-control" placeholder="Enter Category Name" name="name"
                    id="name" value="{{ $categorydata->name }}">
                <div class="error-messages" id="nameError"></div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="type">Category Type</label>
                <select class="form-select" aria-label="Default select example" name="type" id="type">
                    <option value="">Select</option>
                    <option value="facility" {{ $categorydata->type == 'facility' ? 'selected' : '' }}>Facility</option>
                    <option value="equipment" {{ $categorydata->type == 'equipment' ? 'selected' : '' }}>Equipment
                    </option>
                    <option value="tools" {{ $categorydata->type == 'tools' ? 'selected' : '' }}>Tools</option>
                    <option value="supply" {{ $categorydata->type == 'supply' ? 'selected' : '' }}>Supply</option>
                </select>
                <div class="error-messages" id="typeError"></div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-select" aria-label="Default select example" name="status" id="status">
                    <option value="1" {{ $categorydata->status == 1 ? 'selected' : '' }}>Active
                    </option>
                    <option value="0" {{ $categorydata->status == 0 ? 'selected' : '' }}>Disable
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
