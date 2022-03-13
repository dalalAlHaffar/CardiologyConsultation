
function fireSwal(url) {
console.log(url);
  
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: url,
        type: 'DELETE',
        data: { "_token": $('meta[name="csrf-token"]').attr('content')},
        success: function (result) {
          Swal.fire(
            'Deleted!',
            'Blog was deleted successfully.',
            'success'
          ).then(function() {
            location.reload();
        })
        }
      });

    }
  })
}