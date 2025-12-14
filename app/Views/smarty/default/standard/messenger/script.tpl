<script src="/themes/assets/javascripts/messenger.js?time={pk()}" type="text/javascript" async></script>
<script type="text/javascript">
    $(document).ready(function () {
        var token = '{csrf_token()}';
        var hash = '{csrf_hash()}';
        messenger_ping(token, hash);

        $(function () {
            $("#addClass").click(function () {
                $('#qnimate').addClass('popup-box-on');
            });
            $("#removeClass").click(function () {
                $('#qnimate').removeClass('popup-box-on');
            });


        });


    });
</script>