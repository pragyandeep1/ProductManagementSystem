<div class="modal fade" data-url="{{ route('category.add') }}" id="addjob" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content ">
            <!-- Modal body -->
            <div class="modal-body">
                <h5 class="modal-title">Add category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                        class="fa-solid fa-xmark"></i></button>
                <form id="add">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name"> Category Name </label>
                                <input type="text" class="form-control" placeholder="Enter category Name"
                                    name="name" id="name">
                                <div class="error-messages" id="nameError"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="type">Category Type</label>
                                <select class="form-select" aria-label="Default select example" name="type" id="type">
                                    <option value="">Select</option>
                                    <option value="facility">Facility</option>
                                    <option value="equipment">Equipment</option>
                                    <option value="tools">Tools</option>
                                    <option value="supply">Supply</option>
                                </select>
                                <div class="error-messages" id="typeError"></div>
                            </div>
                        </div>
                        <div class="error-messagess"></div>
                    </div>
                    <button type="button" class="btn btn-primary float-end mt-3" id="saveBtn">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
