@extends('index')
@section('content')
<div class="mb-4">
    <h5>Add Case / Profile Client</h5>
</div>
<form id="client_form">

    <div class="form-check">
        <input class="form-check-input" type="radio" name="client_type" id="flexRadioDefault1" value="existing">
        <label class="form-check-label" for="flexRadioDefault1">
            For An Existing Client
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="client_type" id="flexRadioDefault2" value="new" checked>
        <label class="form-check-label" for="flexRadioDefault2">
            For A New Client
        </label>
    </div>
    <div id="existing" hidden>
        <div class="mb-3">
            <label for="client_name" class="form-label">Client Name</label>
            <div class="input-group">
                <select class="form-select select2" id="client_name" name="client_name" aria-label="Default select example">
                </select>
            </div>
        </div>
    </div>
    <hr>
    <div class="mt-2" id="new">

        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <div class="input-group">
                <input type="text" class="form-control" id="first_name" name="first_name" aria-describedby="basic-addon3 basic-addon4">
            </div>
        </div>

        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <div class="input-group">
                <input type="text" class="form-control" id="last_name" name="last_name" aria-describedby="basic-addon3 basic-addon4">
            </div>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <div class="input-group">
                <input type="email" class="form-control" id="email" name="email" aria-describedby="basic-addon3 basic-addon4">
            </div>
        </div>

        <div class="mb-3">
            <label for="date_of_birth" class="form-label">Date of Birth</label>
            <div class="input-group">
                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" aria-describedby="basic-addon3 basic-addon4">
            </div>
        </div>

        <div class="mb-3">
            <label for="passport" class="form-label">Profile Image</label>
            <div class="input-group">
                <input type="file" class="form-control" id="passport" name="passport" aria-describedby="basic-addon3 basic-addon4">
            </div>
        </div>

        <div class="mb-3">
            <label for="date_profiled" class="form-label">Date Profiled</label>
            <div class="input-group">
                <input type="date" class="form-control" id="date_profiled" name="date_profiled" aria-describedby="basic-addon3 basic-addon4">
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label for="counsel" class="form-label">Primary Counsel</label>
        <div class="input-group">
            <select class="form-select select2" id="counsel" name="counsel" aria-label="Default select example">
                <option selected>Select Counsel</option>
                @foreach($counsels as $key => $counsel)
                <option value="{{ $key }}">{{ $counsel }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="mb-3">
        <label for="case_details" class="form-label">Case Details</label>
        <div class="input-group">
            <textarea class="form-control" id="case_details" name="case_details"></textarea>
        </div>
    </div>

    <button type="submit" class="submit btn btn-primary">Submit</button>
</form>
<script>
    $(document).ready(function() {
        $('.select2').select2();
        preselection();
        $('body').on('click', '#client_form .submit', function(e) {
            e.preventDefault();
            
            var url = "{{ route('create') }}";
            let client_type = $('input:radio[name=client_type]:checked').val();

            var formData = new FormData();
            formData.append('client_type', client_type);
            if (client_type == 'existing') {
                formData.append('client_id', $("#client_name").val());
            }
            formData.append('first_name', $("#first_name").val());
            formData.append('last_name', $("#last_name").val());
            formData.append('email', $("#email").val());
            formData.append('date_of_birth', $("#date_of_birth").val());
            if ($("#passport").val() != '') {
                formData.append('passport', $("#passport")[0].files[0]);
            }
            formData.append('date_profiled', $("#date_profiled").val());
            formData.append('counsel', $("#counsel").val());
            formData.append('case_details', $("#case_details").val());
            formData.append('_token', "{{ csrf_token() }}");

            $(this).attr('disabled', true)

            $.ajax({
                type: "POST",
                url: url,
                dataType: "json",
                processData: false,
                contentType: false,
                data: formData,
                success: function(response, textStatus, xhr) {
                    if (xhr.status == 200) {
                        $.bootstrapGrowl(response.message, {
                            type: 'success',
                            align: 'center',
                        });
                        $('#client_form .submit').removeAttr('disabled')
                    }
                },
                error: function(response) {
                    if (response.status == 422) {
                        var errors = $.parseJSON(response.responseText)['errors'];
                        $.each(errors, function(key, value) {
                            $.bootstrapGrowl(value[0], {
                                type: 'danger',
                                align: 'center',
                            });
                        });
                    } else {
                        $.bootstrapGrowl('An internal error occurred', {
                            type: 'danger',
                            align: 'center',
                        });
                    }
                    $('#client_form .submit').removeAttr('disabled')
                }
            });
        });

        $('#client_name').select2({
            placeholder: 'Select Client Name',
            ajax: {
                url: "{{route('search-client')}}",
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term,
                    };
                },
                processResults: function(data) {
                    var result = data.data
                    console.log(result)
                    return {
                        results: $.map(result, function(item, key) {
                            return {
                                text: item,
                                id: key
                            }
                        })
                    }
                },
                cache: true
            }
        });
    });

    $('#client_form input:radio').change(() => {
        preselection();
    });

    const preselection = () => {
        if ($('input:radio[name=client_type]:checked').val() == "existing") {
            $('#new').attr('hidden', true);
            $('#existing').removeAttr('hidden');
        } else {
            $('#existing').attr('hidden', true);
            $('#new').removeAttr('hidden');
        }
    }
</script>
@endsection