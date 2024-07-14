<script>
    let ip_address = '<?php echo $_SERVER['REMOTE_ADDR']; ?>';
    let user_id = '{{ auth()->id() }}';
</script>


<script type="text/javascript" src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/popper/popper.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/fancybox/fancybox.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/front-custom.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/accessibility/asb.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/common_v1.min.js') }}"></script>

<script>
    $('#searchInput').on('input', function() {
        let search_data = $(this).val();
        if(search_data.length >= 3){
         console.log(search_data);
            $.ajax({

                url: "{{ url('get-search-results') }}",
                method: 'POST',
                data: {
                    search_data: search_data
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
               
                success: function(response) {
                    if(response.responseCode == 1){
                        $('#search_note').hide();
                        $('#searchResults').html(response.html);
                        if ($('#suggestion_search').text().trim() === '') {
                            $('#suggestion_search').css('margin-top', '-50px');
                            $('#suggestion_search').css('background-color', '#FFFFFF');
                            $('#suggestion_search').html("No data matched!");
                        }
                    }
                }
            });
        }
        if(search_data == ""){
            $('#search_note').show();
            $('#searchResults').html("");
        }
    });

    document.getElementById('closeSearch').addEventListener('click', function() {
        $('#searchInput').val("");
        $('#search_note').show();
        $('#searchResults').hide();
    });

    document.getElementById('closeSearch').addEventListener('click', function() {
        document.getElementById('suggestion_search').style.display = 'none';
        document.getElementById('searchInput').value = '';
    });

</script>

{{--Extending custom script--}}
@yield('script')
