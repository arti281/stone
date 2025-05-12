<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .note-editor.note-frame {
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
        }
        .note-editor.note-frame .note-toolbar {
            background-color: #ddd;
        }
        .note-editor.note-frame .note-editing-area {
            background-color: #ffffff;
        }
    </style>
    <meta charset="UTF-8">
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> --}}
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ URL::asset('pstone-logo.png'); }}" type="image/png">
    <link rel="icon" href="{{ URL::asset('pstone-logo.ico'); }}" type="image/x-icon">
    <title>@stack('setTitle')</title>
    <link rel="stylesheet" href="{{ URL::asset('css/admin/admin-style.css'); }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Data Table -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.css" />
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
    <!-- summernote -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.js"></script>
    <!-- Select Multilevel -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.default.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/js/standalone/selectize.min.js"></script>   
    <!-- Sweet alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Add style -->
    @stack('addStyle')
</head>
<body>
    @yield('content')

     <!-- Sweet alert -->
    <script src="{{ URL::asset('js/admin/sweet-alert.js')}}"></script>
    
    <script>
 
        $(document).ready(function() {
            $('#myTable').DataTable();
        });

        // for tooltip
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

        // start summernote 
        $(document).ready(function() {
            $('#summernote').summernote({
            height: 300,
            toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                styleTags: ['p', 'blockquote', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
                fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Helvetica Neue', 'Helvetica', 'Impact', 'Lucida Grande', 'Tahoma', 'Times New Roman', 'Verdana'],
                fontNamesIgnoreCheck: ['Helvetica Neue', 'Helvetica', 'Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Impact', 'Lucida Grande', 'Tahoma', 'Times New Roman', 'Verdana'],
                callbacks: {
                    onImageUpload: function(files) {
                        console.log('Image upload:', files);
                    }
                }
            });
        });

        $(document).ready(function() {
            $('.summernote').summernote();
            var noteBar = $('.note-toolbar');
            noteBar.find('[data-toggle]').each(function() {
                $(this).attr('data-bs-toggle', $(this).attr('data-toggle')).removeAttr('data-toggle');
            });
        });
        // end summernote

       // Select Multilevel 
       $(document).ready(function(){
            $("#category-dropdown").selectize({
                plugins: ['remove_button'],
                delimiter: ',',
                persist: false,
                create: function(input){
                    return{
                        value: input,
                        text: input
                    };
                }
            });
        });
        // end Select Multilevel 
    </script>

    @stack('addScript')
</body>
</html>