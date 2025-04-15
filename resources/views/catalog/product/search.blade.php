<style>
    #searchResults {
        max-height: 200px;
        overflow-y: auto;
        background-color: #fff;
        position: absolute;
        z-index: 1200;
        width: 100%;
    }

    #searchResults div {
        padding: 8px;
        cursor: pointer;
    }

    #searchResults div:hover {
        background-color: #f1f1f1;
    }
</style>

<div class="h-100 d-flex align-items-center position-relative">
    <form class="w-100" id="searchForm" action="{{ route('catalog.product-all') }}" method="get">
        <div class="input-group">
            <input type="text" class="form-control p-2" id="searchInput" placeholder="Search.." aria-label="Search.." value="{{ $search ?? '' }}" name="search">
            <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i
                    class="fa fa-search"></i>
            </button>
        </div>
        <div id="searchResults"></div>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('#searchInput').on('keyup', function() {
            let query = $(this).val();
            if (query.length > 0) {
                $.ajax({
                    url: '{{ route("catalog.liveSearch") }}',
                    method: 'GET',
                    data: { query: query },
                    success: function(response) {
                        let resultsHtml = '';
                        if (response.length > 0) {
                            response.forEach(result => {
                                resultsHtml += `<div class="d-flex search-item ms-3" data-name="${result.product_name}">
                                        <img height="50" src="${result.image}" class="me-3">
                                        <p>${result.product_name}</p>
                                    </div>`;
                            });
                        } else {
                            resultsHtml = '<div>Product not found</div>';
                        }
                        $('#searchResults').html(resultsHtml);

                        // Add click event listener to search items
                        $('.search-item').on('click', function() {
                            const selectedName = $(this).data('name');
                            $('#searchInput').val(selectedName); // Set name to input box
                            $('#searchForm').submit();
                        });
                    },
                    error: function() {
                        $('#searchResults').html('<div>Error retrieving results</div>');
                    }
                });
            } else {
                $('#searchResults').html('');
            }
        });
    });


</script>