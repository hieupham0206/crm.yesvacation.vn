$(function() {
    const $app = $('#app')
    const tableLead = $('#table_leads').DataTable({
        'serverSide': true,
        'paging': true,
        'ajax': $.fn.dataTable.pipeline({
            url: route('leads.table'),
            data: function(q) {
                q.filters = JSON.stringify($('#leads_search_form').serializeArray())
            },
        }),
        conditionalPaging: true,
        info: true,
        lengthChange: true,
    })
    $app.on('click', '.btn-delete', function () {
        tableLead.actionDelete({btnDelete: $(this)})
    })
    $('#leads_search_form').on('submit', function() {
        tableLead.reload()
        return false
    })
    $('#btn_reset_filter').on('click', function() {
        $('#leads_search_form').resetForm()
        tableLead.reload()
    })

    //Export tools
    $('#btn_export_excel').on('click', function() {
        tableLead.exportExcel()
    })
    $('#btn_export_pdf').on('click', function() {
        tableLead.exportPdf()
    })
    //Quick actions
    $('#link_delete_selected_rows').on('click', function() {
        let ids = $(".m-checkbox--single > input[type='checkbox']:checked").getValues()

        if (ids.length > 0) {
            tableLead.actionDelete({btnDelete: $(this), params: {ids: ids}})
        }
    })
})