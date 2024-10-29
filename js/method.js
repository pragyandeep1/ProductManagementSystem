$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('click', '#saveBtn', function (e) {
        e.preventDefault();
        $('#saveBtn').attr('disabled', true);
        var data = $('#add')[0];
        var url = $('#addjob').data('url');
        $('.error-messages').html('');
        var form = new FormData(data);
        //console.log(form);
        $.ajax({
            url: url,
            method: 'post',
            processData: false,
            contentType: false,
            data: form,
            success: function (response) {
                successRes(response, 'add', 'saveBtn', 'addjob');
            },
            error: function (xhr) {
                var errors = xhr.responseJSON.errors;
                displayErrors(errors, 'saveBtn', xhr.status);
            }
        });
    });

    $(document).on('click', '#jobUpdateBtn', function (e) {

        e.preventDefault();
        $('#updateBtn').attr('disabled', true);
        var form = $('#editJob')[0];
        var formData = new FormData(form);

        $.ajax({
            type: 'POST',
            url: form.action,
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                successRes(response, 'editJob', 'jobUpdateBtn', 'editjob-modal');

            },
            error: function (xhr) {
                var errors = xhr.responseJSON.errors;
                displayErrors(errors, 'jobUpdateBtn', xhr.status);
                   
            }
        });
    });

   
});  ///  end of document. ready function

// used to render data for view and edit modal
function editForm(url_name, target_id, method = "GET") {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            //console.log(this.responseText);
            $('#' + target_id).html(this.responseText);
        }
    };

    xhttp.open(method, url_name, true);
    xhttp.send();
}

 function successRes(response, formid, submitBtnId, modalId) {
    $('.text-danger').html('');
        swal("Success", response.success, "success");
        // $('#'+formid)[0].reset();
        $('#' + formid).trigger('reset');
        $('#' + submitBtnId).attr('disabled', false);
        $('#imagePreview img').remove(); // Set image preview to blank
        $('.datatable').DataTable().ajax.reload();
        $('#' + modalId).modal('hide');
        return true;
    };

    function displayErrors(errors, submitBtnId, resStatusCode) {
        $('.error-messages').html('');
        if (resStatusCode == 422) {
            $.each(errors, function (key, value) {
                //console.log(key+"====="+value);
                // Update the error container next to the corresponding input field
                $('#' + key + 'Error').html('<span class="text-danger">' + value + '</span>');
            });
        } else {
            $('.error-messagess').html('<span class="text-danger">' + errors + '.</span>');
        }
    //    console.log(submitBtnId);

        $('#' + submitBtnId).attr('disabled', false);
    };



// Function to preview image
function previewImage() {
    const fileInput = document.getElementById("image");
    const file = fileInput.files[0];
    const reader = new FileReader();

    reader.onload = function (event) {
        const imageUrl = event.target.result;
        //$('#imagePreview').attr('src', imageUrl);

        const imageElement = document.createElement("img");
        imageElement.src = imageUrl;
        imageElement.alt = "Image Preview";
        imageElement.style.maxWidth = "100px"; // Set maximum width
        imageElement.style.maxHeight = "100px"; // Set maximum height
        imagePreview.innerHTML = "";
        imagePreview.appendChild(imageElement);
    };

    if (file) {
        reader.readAsDataURL(file);
    }
}

function delete_entity(url, targetId)
{
    if (confirm("Are you sure to Permanently Delete?")) {
        $.ajax({
            url: url,
            type: 'DELETE',
           
            success: function(response) {
                swal("Success", response.success, "success");
                $('.datatable').DataTable().ajax.reload();
            },
            error: function(xhr, status, error) {
                swal("Error!", error, "error");
            }
        });
    }
}

function changeStatus(url, targetId) {
    if (confirm("Are you sure to Change Status?")) {
        $.ajax({
            url: url,
            type: 'GET',
            success: function (response) {
                // Handle the response here, e.g., update button text or styles
                $('#' + targetId).html(response);
                $('#employee-table').DataTable().ajax.reload();
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
}