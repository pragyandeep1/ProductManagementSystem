<div class="modal fade" data-url="{{ route('charge.add') }}" id="addjob" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content ">
            <!-- Modal body -->
            <div class="modal-body">
                <h5 class="modal-title">Add Charge</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                        class="fa-solid fa-xmark"></i></button>
                <form id="add">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="description"> Name </label>
                                <input type="text" class="form-control" placeholder="Enter Name" name="description"
                                    id="description">
                                <div class="error-messages" id="descriptionError"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="code"> Code</label>
                                <input type="text" class="form-control" placeholder="Enter Code" name="code"
                                    id="code">
                                <div class="error-messages" id="codeError"></div>
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
