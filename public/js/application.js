(function () {
    function baseUrl(path) {
        const base = (window.APP_URL || '').replace(/\/$/, '');
        return base + path;
    }

    $(document).ready(function () {

        // EDIT
        $(document).on('click', '.edit-app-btn', function () {
            const appId = $(this).data('id');

            $.ajax({
                url: baseUrl('/applications/' + appId + '/edit'),
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    $('#edit_app_id').val(data.id);

                    // STUDENT
                    $('#edit_student_id').val(data.student_id ?? '');
                    $('#edit_sex').val(data.sex ?? '');
                    $('#edit_birthdate').val(data.birthdate ?? '');

                    $('#edit_last_name').val(data.last_name ?? '');
                    $('#edit_given_name').val(data.given_name ?? '');
                    $('#edit_middle_name').val(data.middle_name ?? '');

                    
                    $('#edit_ext_name').val(data.ext_name ?? '');

                    
                    $('#edit_program_name').val(data.program_name ?? '');
                    $('#edit_year_level').val(data.year_level ?? '');

                
                    $('#edit_contact_number').val(data.contact_number ?? '');
                    $('#edit_email').val(data.email ?? '');
                    $('#edit_street_barangay').val(data.street_barangay ?? '');
                    $('#edit_zipcode').val(data.zipcode ?? '');

                    // FATHER
                    $('#edit_father_last_name').val(data.father_last_name ?? '');
                    $('#edit_father_given_name').val(data.father_given_name ?? '');
                    $('#edit_father_middle_name').val(data.father_middle_name ?? '');

                    // MOTHER
                    $('#edit_mother_last_name').val(data.mother_last_name ?? '');
                    $('#edit_mother_given_name').val(data.mother_given_name ?? '');
                    $('#edit_mother_middle_name').val(data.mother_middle_name ?? '');


                    $('#edit_disability').val(data.disability ?? '');
                    $('#edit_indigenous_group').val(data.indigenous_group ?? '');
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                    alert('Error loading application data');
                }
            });
        });

        // VIEW:
        $(document).on('click', '.view-app-btn', function () {
            const appId = $(this).data('id');

            $('#view-app-content').html('<p class="text-center text-muted">Loading...</p>');

            $.ajax({
                url: baseUrl('/applications/' + appId + '/show'),
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    const html = `
                        <div class="row">
                            <div class="col-md-6">
                                <h6><b>Student Info</b></h6>
                                <p><strong>Student ID:</strong> ${data.student_id ?? 'N/A'}</p>
                                <p><strong>Name:</strong> ${data.given_name ?? ''} ${data.middle_name ?? ''} ${data.last_name ?? ''} ${data.ext_name ?? ''}</p>
                                <p><strong>Sex:</strong> ${data.sex ?? 'N/A'}</p>
                                <p><strong>Birthdate:</strong> ${data.birthdate ?? 'N/A'}</p>
                                <p><strong>Program:</strong> ${data.program_name ?? 'N/A'}</p>
                                <p><strong>Year Level:</strong> ${data.year_level ?? 'N/A'}</p>
                            </div>

                            <div class="col-md-6">
                                <h6><b>Contact & Address</b></h6>
                                <p><strong>Contact Number:</strong> ${data.contact_number ?? 'N/A'}</p>
                                <p><strong>Email:</strong> ${data.email ?? 'N/A'}</p>
                                <p><strong>Street/Barangay:</strong> ${data.street_barangay ?? 'N/A'}</p>
                                <p><strong>Zip Code:</strong> ${data.zipcode ?? 'N/A'}</p>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <h6><b>Father</b></h6>
                                <p><strong>Last Name:</strong> ${data.father_last_name ?? 'N/A'}</p>
                                <p><strong>Given Name:</strong> ${data.father_given_name ?? 'N/A'}</p>
                                <p><strong>Middle Name:</strong> ${data.father_middle_name ?? 'N/A'}</p>
                            </div>

                            <div class="col-md-6">
                                <h6><b>Mother</b></h6>
                                <p><strong>Last Name:</strong> ${data.mother_last_name ?? 'N/A'}</p>
                                <p><strong>Given Name:</strong> ${data.mother_given_name ?? 'N/A'}</p>
                                <p><strong>Middle Name:</strong> ${data.mother_middle_name ?? 'N/A'}</p>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-12">
                                <h6><b>Other</b></h6>
                                <p><strong>Disability:</strong> ${data.disability ?? 'N/A'}</p>
                                <p><strong>Indigenous Group:</strong> ${data.indigenous_group ?? 'N/A'}</p>
                            </div>
                        </div>
                    `;

                    $('#view-app-content').html(html);
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                    $('#view-app-content').html('<p class="text-danger">Error loading data</p>');
                }
            });
        });

        // DELETE:
        $(document).on('click', '.delete-app-btn', function () {
            $('#delete_app_id').val($(this).data('id'));
            $('#delete-app-name').text($(this).data('name'));
        });

    });
})();
