 // confirm box
 let deleteButton = document.querySelectorAll('.deleteRow');
 deleteButton.forEach(element => {
     element.addEventListener('click', function(e) {
         e.preventDefault(); // Prevent the default action
         let url = element.getAttribute('data-href')
         let name = element.getAttribute('data-name')
         let rowName = element.getAttribute('data-row-name')
         Swal.fire({
             title: 'Are you sure?',
             html: `Do you want delete this ${rowName}  <br><strong>${name}</strong>` ,
             icon: 'warning',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             cancelButtonText: 'No',
             confirmButtonText: 'Yes'
         }).then((result) => {
             if (result.isConfirmed) {
                 // Redirect to the deletion URL
                 window.location.href = url;
             }
         });
     });
 });