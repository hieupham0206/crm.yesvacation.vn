$(function() {
    const $app = $('#app')
    const tableDepartment = $('#table_departments').DataTable({
        'serverSide': true,
        'paging': true,
        'ajax': $.fn.dataTable.pipeline({
            url: route('departments.table'),
            data: function(q) {
                q.filters = JSON.stringify($('#departments_search_form').serializeArray())
            },
        }),
        conditionalPaging: true,
        info: true,
        lengthChange: true,
    })
    $app.on('click', '.btn-delete', function () {
        tableDepartment.actionDelete({btnDelete: $(this)})
    })
    $('#departments_search_form').on('submit', function() {
        tableDepartment.reload()
        return false
    })
    $('#btn_reset_filter').on('click', function() {
        $('#departments_search_form').resetForm()
        tableDepartment.reload()
    })

    //Export tools
    $('#btn_export_excel').on('click', function() {
        tableDepartment.exportExcel()
    })
    $('#btn_export_pdf').on('click', function() {
        tableDepartment.exportPdf()
    })
    //Quick actions
    $('#link_delete_selected_rows').on('click', function() {
        let ids = $(".m-checkbox--single > input[type='checkbox']:checked").getValues()

        if (ids.length > 0) {
            tableDepartment.actionDelete({btnDelete: $(this), params: {ids: ids}})
        }
    })
})