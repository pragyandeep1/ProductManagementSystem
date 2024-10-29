<h5 class="modal-title">Category Details</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
<form id="viewJob">
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="required"> Category Name </label>
                <input type="text" class="form-control" placeholder="Enter Category Name" name="name"
                    value="{{ $categorydata->name }}" readonly>
                <div class="error-messages" id="nameError"></div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="required"> Category Type </label>
                <input type="text" class="form-control" placeholder="Enter Map Address" name="type"
                    value="{{ $categorydata->type }}" readonly>
                <div class="error-messages" id="typeError"></div>
            </div>
        </div>
        <div class="error-messagess"></div>
    </div>
</form>
