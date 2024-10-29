<h5 class="modal-title">Record Details</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
<form id="viewJob">
    <div class="row">
        <div class="col-sm-5">
            <div class="form-group">
                <label class="description"> Name </label>
                <input type="text" class="form-control" placeholder="Enter Name" name="name" id="name"
                    value="{{ $businessClassificationdata->name }}" readonly>
                <div class="error-messages" id="nameError"></div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="description"> Description</label>
                <textarea name="description" class="form-control" id="description" placeholder="Enter Description" cols="3" readonly>{!! $businessClassificationdata->description !!}</textarea>
                <div class="error-messages" id="descriptionError"></div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-select" aria-label="Default select example" name="status" id="status" disabled>
                    <option value="1" {{ $businessClassificationdata->status == 1 ? 'selected' : '' }}>Active
                    </option>
                    <option value="0" {{ $businessClassificationdata->status == 0 ? 'selected' : '' }}>Disable
                    </option>
                </select>
            </div>
        </div>
        <div class="error-messagess"></div>
    </div>
</form>
