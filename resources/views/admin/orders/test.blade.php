<head>

    <link rel="stylesheet" href="{{ asset('css/persian-datepicker.min.css') }}"/>

    <script src="/plugins/jquery/jquery.min.js"></script>

    <script src="{{ asset('js/persian-date.min.js') }}"></script>

    <script src="{{ asset('js/persian-datepicker.min.js') }}"></script>

</head>

<input type="text" class="example1" />

<script type="text/javascript">
    $(document).ready(function() {
        $(".example1").pDatepicker();
    });
</script>


