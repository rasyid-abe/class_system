
// jQuery(document).ready(function () {

//     if (att_id != '') {
//         view_content(att_id)
//         $('.tab_topic').removeClass('active')
//         $('.content_topic').removeClass('active')
//         $('.content_topic').removeClass('show')

//         $('#tab_attachment').addClass('show')
//         $('#tab_attachment').addClass('active')
//         $('#tab_topic_attachment').addClass('active')
//     }


//     if (file_id != '') {
//         view_content(file_id)
//         $('#kt_accordion_2_item_1').removeClass('show')
//         $('#kt_accordion_2_item_2').addClass('show')
//     }


// })

// $('.delete').on('click', function (e) {
//     const id = $(this).data('id');
//     const url = $(this).data('url');

//     Swal.fire({
//         html: `Apakah anda ingin menghapus data?`,
//         icon: "info",
//         buttonsStyling: false,
//         showCancelButton: true,
//         confirmButtonText: "Ya",
//         cancelButtonText: 'Tidak',
//         customClass: {
//             confirmButton: "btn btn-sm btn-primary",
//             cancelButton: 'btn btn-sm btn-danger'
//         }
//     }).then(function (confirm) {
//         if (confirm.isConfirmed) {
//             $.ajax({
//                 url: url + '?' + $.param({
//                     id: id
//                 }),
//                 method: 'delete',
//                 dataType: 'json',
//                 success: function (e) {
//                     location.reload();
//                     $.toast({
//                         heading: 'Success',
//                         text: 'Data berhasil di' + e.msg,
//                         showHideTransition: 'fade',
//                         position: 'top-right',
//                         icon: 'success'
//                     })
//                 }
//             })
//         }
//     });
// })