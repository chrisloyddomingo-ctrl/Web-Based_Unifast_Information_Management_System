(function () {
    function baseUrl(path) {
        const base = (window.APP_URL || '').replace(/\/$/, '');
        return base + path;
    }

    function safe(value) {
        return value ?? '';
    }

    function safeText(value) {
        return value ?? 'N/A';
    }

    function incomeLabel(value) {
        const labels = {
            below_5000: 'Below ₱5,000',
            '5000_10000': '₱5,000 – ₱10,000',
            '10000_20000': '₱10,000 – ₱20,000',
            '20000_40000': '₱20,000 – ₱40,000',
            above_40000: 'Above ₱40,000'
        };

        return labels[value] ?? 'N/A';
    }

    function firstGenLabel(value) {
        return String(value) === '1' ? 'Yes' : 'No';
    }

    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        /* =========================
           EDIT APPLICATION
        ========================= */
        $(document).on('click', '.edit-app-btn', function () {
            const appId = $(this).data('id');

            $.ajax({
                url: baseUrl('/applications/' + appId + '/edit'),
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    $('#edit_app_id').val(data.id);

                    $('#edit_student_id').val(safe(data.student_id));
                    $('#edit_sex').val(safe(data.sex));
                    $('#edit_birth_date').val(safe(data.birthdate));

                    $('#edit_last_name').val(safe(data.last_name));
                    $('#edit_given_name').val(safe(data.given_name));
                    $('#edit_middle_name').val(safe(data.middle_name));
                    $('#edit_ext_name').val(safe(data.ext_name));

                    $('#edit_program_name').val(safe(data.program_name));
                    $('#edit_year_level').val(safe(data.year_level));

                    $('#edit_first_generation').val(safe(data.first_generation));
                    $('#edit_parents_monthly_income').val(safe(data.parents_monthly_income));

                    $('#edit_contact_number').val(safe(data.contact_number));
                    $('#edit_email').val(safe(data.email));
                    $('#edit_street_barangay').val(safe(data.street_barangay));
                    $('#edit_zipcode').val(safe(data.zipcode));

                    $('#edit_father_last_name').val(safe(data.father_last_name));
                    $('#edit_father_given_name').val(safe(data.father_given_name));
                    $('#edit_father_middle_name').val(safe(data.father_middle_name));

                    $('#edit_mother_last_name').val(safe(data.mother_last_name));
                    $('#edit_mother_given_name').val(safe(data.mother_given_name));
                    $('#edit_mother_middle_name').val(safe(data.mother_middle_name));

                    $('#edit_disability').val(safe(data.disability));
                    $('#edit_indigenous_group').val(safe(data.indigenous_group));
                },
                error: function () {
                    alert('Error loading application data.');
                }
            });
        });

        /* =========================
           VIEW APPLICATION
        ========================= */
        $(document).on('click', '.view-app-btn', function () {
            const appId = $(this).data('id');

            $('#view-app-content').html('<p class="text-center">Loading...</p>');

            $.ajax({
                url: baseUrl('/applications/' + appId + '/show'),
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    const status = data.status ?? 'pending';
                    const badgeClass =
                        status === 'approved'
                            ? 'success'
                            : status === 'rejected'
                            ? 'danger'
                            : 'warning';

                    const html = `
                        <table class="table table-bordered table-striped">
                            <tr class="bg-info text-white">
                                <th colspan="2">Student Information</th>
                            </tr>
                            <tr>
                                <th width="30%">Student ID</th>
                                <td>${safeText(data.student_id)}</td>
                            </tr>
                            <tr>
                                <th>Last Name</th>
                                <td>${safeText(data.last_name)}</td>
                            </tr>
                            <tr>
                                <th>Given Name</th>
                                <td>${safeText(data.given_name)}</td>
                            </tr>
                            <tr>
                                <th>Middle Name</th>
                                <td>${safeText(data.middle_name)}</td>
                            </tr>
                            <tr>
                                <th>Ext Name</th>
                                <td>${safeText(data.ext_name)}</td>
                            </tr>
                            <tr>
                                <th>Sex</th>
                                <td>${safeText(data.sex)}</td>
                            </tr>
                            <tr>
                                <th>Birthdate</th>
                                <td>${safeText(data.birthdate)}</td>
                            </tr>
                            <tr>
                                <th>Program</th>
                                <td>${safeText(data.program_name)}</td>
                            </tr>
                            <tr>
                                <th>Year Level</th>
                                <td>${safeText(data.year_level)}</td>
                            </tr>
                            <tr>
                                <th>First Generation</th>
                                <td>${firstGenLabel(data.first_generation)}</td>
                            </tr>
                            <tr>
                                <th>Parents Monthly Income</th>
                                <td>${incomeLabel(data.parents_monthly_income)}</td>
                            </tr>

                            <tr class="bg-secondary text-white">
                                <th colspan="2">Contact Information</th>
                            </tr>
                            <tr>
                                <th>Contact Number</th>
                                <td>${safeText(data.contact_number)}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>${safeText(data.email)}</td>
                            </tr>
                            <tr>
                                <th>Street / Barangay</th>
                                <td>${safeText(data.street_barangay)}</td>
                            </tr>
                            <tr>
                                <th>Zip Code</th>
                                <td>${safeText(data.zipcode)}</td>
                            </tr>

                            <tr class="bg-warning">
                                <th colspan="2">Father Information</th>
                            </tr>
                            <tr>
                                <th>Father Last Name</th>
                                <td>${safeText(data.father_last_name)}</td>
                            </tr>
                            <tr>
                                <th>Father Given Name</th>
                                <td>${safeText(data.father_given_name)}</td>
                            </tr>
                            <tr>
                                <th>Father Middle Name</th>
                                <td>${safeText(data.father_middle_name)}</td>
                            </tr>

                            <tr class="bg-warning">
                                <th colspan="2">Mother Information</th>
                            </tr>
                            <tr>
                                <th>Mother Last Name</th>
                                <td>${safeText(data.mother_last_name)}</td>
                            </tr>
                            <tr>
                                <th>Mother Given Name</th>
                                <td>${safeText(data.mother_given_name)}</td>
                            </tr>
                            <tr>
                                <th>Mother Middle Name</th>
                                <td>${safeText(data.mother_middle_name)}</td>
                            </tr>

                            <tr class="bg-success text-white">
                                <th colspan="2">Other Details</th>
                            </tr>
                            <tr>
                                <th>Disability</th>
                                <td>${safeText(data.disability)}</td>
                            </tr>
                            <tr>
                                <th>Indigenous Group</th>
                                <td>${safeText(data.indigenous_group)}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <span class="badge badge-${badgeClass}">
                                        ${status.toUpperCase()}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    `;

                    $('#view-app-content').html(html);
                },
                error: function () {
                    $('#view-app-content').html(
                        '<p class="text-danger text-center">Error loading application.</p>'
                    );
                }
            });
        });

        /* =========================
           DELETE
        ========================= */
        $(document).on('click', '.delete-app-btn', function () {
            $('#delete_app_id').val($(this).data('id'));
            $('#delete-app-name').text($(this).data('name'));
        });

        /* =========================
           REJECT APPLICATION
        ========================= */
        $(document).on('click', '.reject-app-btn', function () {
            const id = $(this).data('id');
            $('#reject_app_id').val(id);
        });

        /* =========================
           APPROVE APPLICATION
        ========================= */
        $(document).on('click', '.approve-app-btn', function () {
            const id = $(this).data('id');
            const name = $(this).data('name');

            $('#approve_app_id').val(id);
            $('#approve-app-name').text(name);
        });
    });
})();