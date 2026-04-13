const viewUrlTemplate = window.GranteeListConfig.viewUrlTemplate;
const editUrlTemplate = window.GranteeListConfig.editUrlTemplate;
const updateUrlTemplate = window.GranteeListConfig.updateUrlTemplate;
const destroyUrlTemplate = window.GranteeListConfig.destroyUrlTemplate;
const printHeaderImage = window.GranteeListConfig.printHeaderImage || '';
const printPreviewUrl = window.GranteeListConfig.printPreviewUrl || '';

function buildUrl(template, id) {
    return template.replace('__ID__', id);
}

function getStatusBadge(statusText) {
    const status = (statusText || 'N/A').toUpperCase();
    let statusClass = 'secondary';

    if (status === 'ENROLLED') statusClass = 'success';
    else if (status === 'GRADUATED') statusClass = 'primary';
    else if (status === 'DROPPED') statusClass = 'danger';
    else if (status === 'DELISTED') statusClass = 'warning';

    return `<span class="badge badge-${statusClass} px-3 py-2">${status}</span>`;
}

function getPrintableStatusBadge(statusText) {
    const status = (statusText || 'N/A').toUpperCase();
    let badgeClass = 'status-default';

    if (status === 'ENROLLED') badgeClass = 'status-enrolled';
    else if (status === 'GRADUATED') badgeClass = 'status-graduated';
    else if (status === 'DROPPED') badgeClass = 'status-dropped';
    else if (status === 'DELISTED') badgeClass = 'status-delisted';

    return `<span class="status-badge ${badgeClass}">${status}</span>`;
}

function escapeHtml(value) {
    if (value === null || value === undefined) return 'N/A';
    return $('<div>').text(value).html();
}

function displayValue(value, fallback = 'N/A') {
    return value !== null && value !== undefined && value !== '' ? escapeHtml(value) : fallback;
}

function renderViewField(label, value, col = 'col-md-4') {
    return `
        <div class="${col} mb-3">
            <div class="view-card">
                <div class="view-label">${label}</div>
                <div class="view-value">${value}</div>
            </div>
        </div>
    `;
}

function updateDynamicHeader() {
    const batch = $('#batchFilter').val();
    const scholarship = $('#scholarshipFilter').val();

    let title = 'All Grantees List';
    let directory = 'Grantees Directory';
    let subtitle = 'View, filter, print, export, and import grantee records';

    if (batch && scholarship) {
        title = `${batch} - ${scholarship} Grantees List`;
        directory = `${batch} / ${scholarship} Directory`;
        subtitle = `Showing grantees under batch "${batch}" and scholarship "${scholarship}".`;
    } else if (batch) {
        title = `${batch} Grantees List`;
        directory = `${batch} Directory`;
        subtitle = `Showing grantees under batch "${batch}".`;
    } else if (scholarship) {
        title = `${scholarship} Grantees List`;
        directory = `${scholarship} Directory`;
        subtitle = `Showing grantees under scholarship "${scholarship}".`;
    }

    $('#pageMainTitle').text(title);
    $('#directoryTitle').html(`<i class="fas fa-list mr-1 text-warning"></i> ${directory}`);
    $('#pageSubTitle').text(subtitle);
}

function getCsrfToken() {
    return $('meta[name="csrf-token"]').attr('content') || '';
}

$(document).ready(function () {
    const actionsColumnIndex = 14;

    const table = $('#granteesTable').DataTable({
        paging: false,
        info: false,
        searching: true,
        ordering: true,
        autoWidth: false,
        colReorder: true,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'All_Grantees_List',
                exportOptions: {
                    columns: ':visible:not(:last-child)',
                    format: {
                        header: function (data) {
                            return $('<div>').html(data).text().trim();
                        },
                        body: function (data, row, column) {
                            if (column === 0) return row + 1;
                            return $('<div>').html(data).text().trim();
                        }
                    }
                }
            },
            {
                extend: 'csvHtml5',
                title: 'All_Grantees_List',
                exportOptions: {
                    columns: ':visible:not(:last-child)',
                    format: {
                        header: function (data) {
                            return $('<div>').html(data).text().trim();
                        },
                        body: function (data, row, column) {
                            if (column === 0) return row + 1;
                            return $('<div>').html(data).text().trim();
                        }
                    }
                }
            },
            {
                extend: 'colvis',
                columns: ':not(:first-child):not(:last-child)',
                text: 'Toggle Columns'
            }
        ],
        columnDefs: [
            { targets: 0, searchable: false, orderable: false },
            { targets: 14, searchable: false, orderable: false }
        ]
    });

    $('#globalSearch').on('keyup', function () {
        table.search(this.value).draw();
    });

    $('#batchFilter').on('change', function () {
        table.column(10).search(this.value).draw();
        updateDynamicHeader();
    });

    $('#scholarshipFilter').on('change', function () {
        table.column(11).search(this.value).draw();
        updateDynamicHeader();
    });

    $('#statusFilter').on('change', function () {
        table.column(12).search(this.value).draw();
    });

    $('#yearFilter').on('keyup change', function () {
        table.column(8).search(this.value).draw();
    });

    $('#resetFilters').on('click', function () {
        $('#globalSearch, #yearFilter').val('');
        $('#batchFilter, #scholarshipFilter, #statusFilter').val('');
        table.search('').columns().search('').draw();
        updateDynamicHeader();
    });

    $('#exportExcelBtn').on('click', function () {
        table.button('.buttons-excel').trigger();
    });

    $('#exportCsvBtn').on('click', function () {
        table.button('.buttons-csv').trigger();
    });

    $('#toggleColumnsBtn').on('click', function () {
        table.button('.buttons-colvis').trigger();
    });

    $('#printTableBtn').on('click', function () {
        if (!printPreviewUrl) {
            alert('Print preview URL is not configured.');
            return;
        }

        const csrfToken = getCsrfToken();

        if (!csrfToken) {
            alert('CSRF token not found. Please add <meta name="csrf-token" content="{{ csrf_token() }}"> in your layout head.');
            return;
        }

        const visibleColumnIndexes = [];

        table.columns(':visible').every(function (index) {
            if (index !== actionsColumnIndex) {
                visibleColumnIndexes.push(index);
            }
        });

        const headers = visibleColumnIndexes.map(function (index) {
            return $('<div>').html($(table.column(index).header()).html()).text().trim();
        });

        const rows = [];
        const filteredRows = table.rows({ search: 'applied', order: 'applied' }).nodes();

        $(filteredRows).each(function (rowIndex, rowNode) {
            const row = [];

            visibleColumnIndexes.forEach(function (colIndex) {
                let cellHtml = $(rowNode).find('td').eq(colIndex).html() || '';

                if (colIndex === 0) {
                    row.push(String(rowIndex + 1));
                    return;
                }

                const tempDiv = $('<div>').html(cellHtml);

                tempDiv.find('button').remove();
                tempDiv.find('.btn').remove();
                tempDiv.find('i').remove();
                tempDiv.find('.fas').remove();
                tempDiv.find('.far').remove();
                tempDiv.find('.fab').remove();

                const badge = tempDiv.find('.badge');

                if (badge.length) {
                    const badgeText = badge.text().trim().toUpperCase();
                    row.push(getPrintableStatusBadge(badgeText));
                } else {
                    row.push(tempDiv.text().trim());
                }
            });

            rows.push(row);
        });

        const form = $('<form>', {
            method: 'POST',
            action: printPreviewUrl,
            target: '_blank',
            style: 'display:none;'
        });

        form.append($('<input>', {
            type: 'hidden',
            name: '_token',
            value: csrfToken
        }));

        form.append($('<input>', {
            type: 'hidden',
            name: 'title',
            value: $('#pageMainTitle').text() || 'Grantees List'
        }));

        form.append($('<input>', {
            type: 'hidden',
            name: 'subtitle',
            value: $('#pageSubTitle').text() || 'List of grantees'
        }));

        form.append($('<input>', {
            type: 'hidden',
            name: 'header_image',
            value: printHeaderImage
        }));

        headers.forEach(function (header, index) {
            form.append($('<input>', {
                type: 'hidden',
                name: `headers[${index}]`,
                value: header
            }));
        });

        rows.forEach(function (row, rowIndex) {
            row.forEach(function (cell, cellIndex) {
                form.append($('<input>', {
                    type: 'hidden',
                    name: `rows[${rowIndex}][${cellIndex}]`,
                    value: cell
                }));
            });
        });

        $('body').append(form);
        form.trigger('submit');
        form.remove();
    });

    $(document).on('click', '.view-grantee-btn', function () {
        const id = $(this).data('id');

        $('#viewGranteeContent').html(`
            <div class="text-center py-4">
                <i class="fas fa-spinner fa-spin fa-2x text-muted"></i>
                <p class="mt-2 mb-0">Loading grantee details...</p>
            </div>
        `);

        $.ajax({
            url: buildUrl(viewUrlTemplate, id),
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                const scholarshipName =
                    (data.scholarship && data.scholarship.name)
                        ? data.scholarship.name
                        : ((data.batch && data.batch.scholarship && data.batch.scholarship.name)
                            ? data.batch.scholarship.name
                            : 'N/A');

                const mobileDisplay = data.mobile_number
                    ? `<a href="tel:${escapeHtml(data.mobile_number)}">${escapeHtml(data.mobile_number)}</a>`
                    : 'N/A';

                const emailDisplay = data.email
                    ? `<a href="mailto:${escapeHtml(data.email)}">${escapeHtml(data.email)}</a>`
                    : 'N/A';

                $('#viewGranteeContent').html(`
                    <div class="row">
                        ${renderViewField('Last Name', displayValue(data.last_name))}
                        ${renderViewField('First Name', displayValue(data.first_name))}
                        ${renderViewField('Middle Name', displayValue(data.middle_name))}
                        ${renderViewField('Extension Name', displayValue(data.extension_name, '—'))}
                        ${renderViewField('Mobile Number', mobileDisplay)}
                        ${renderViewField('Email Address', emailDisplay)}
                        ${renderViewField('Course / Program Enrolled', displayValue(data.course), 'col-md-6')}
                        ${renderViewField('Year', displayValue(data.year))}
                        ${renderViewField('Years of Stay', displayValue(data.years_of_stay))}
                        ${renderViewField('Batch', displayValue(data.batch ? data.batch.name : null))}
                        ${renderViewField('Scholarship', displayValue(scholarshipName))}
                        ${renderViewField('Status', getStatusBadge(data.status_of_student))}
                        ${renderViewField('Remarks', displayValue(data.remarks, '—'), 'col-md-12')}
                    </div>
                `);
            },
            error: function () {
                $('#viewGranteeContent').html(`
                    <div class="alert alert-danger mb-0">
                        Failed to load grantee details.
                    </div>
                `);
            }
        });
    });

    $(document).on('click', '.edit-grantee-btn', function () {
        const id = $(this).data('id');

        $('#editGranteeForm').attr('action', buildUrl(updateUrlTemplate, id));

        $.ajax({
            url: buildUrl(editUrlTemplate, id),
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                const scholarshipId = data.scholarship_id ?? (data.batch ? data.batch.scholarship_id : '');

                $('#edit_grantee_id').val(data.id ?? '');
                $('#edit_last_name').val(data.last_name ?? '');
                $('#edit_first_name').val(data.first_name ?? '');
                $('#edit_middle_name').val(data.middle_name ?? '');
                $('#edit_extension_name').val(data.extension_name ?? '');
                $('#edit_mobile_number').val(data.mobile_number ?? '');
                $('#edit_email').val(data.email ?? '');
                $('#edit_course').val(data.course ?? '');
                $('#edit_year').val(data.year ?? '');
                $('#edit_years_of_stay').val(data.years_of_stay ?? '');
                $('#edit_scholarship_id').val(scholarshipId);
                $('#edit_batch_name').val(data.batch ? data.batch.name : '');
                $('#edit_status').val(data.status_of_student ?? 'Enrolled');
                $('#edit_remarks').val(data.remarks ?? '');
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                alert('Failed to load grantee data.');
            }
        });
    });

    $(document).on('click', '.delete-grantee-btn', function () {
        const id = $(this).data('id');
        const name = $(this).data('name');

        $('#delete-grantee-name').text(name);
        $('#deleteGranteeForm').attr('action', buildUrl(destroyUrlTemplate, id));
    });

    updateDynamicHeader();
});