<link href="{cdn_url("/themes/bs5/css/app.css")}?v={date("H:i")}" rel="stylesheet">
{* Higgs *}
<!--<link href="{cdn_url("/themes/assets/css/breadcrumbs.css")}?v=1" rel="stylesheet" type="text/css"/>//-->
<link href="{cdn_url("/themes/assets/css/cards.css")}?v={date("H:i")}" rel="stylesheet" type="text/css"/>
<link href="{cdn_url("/themes/assets/css/colors.css")}?v={time()}" rel="stylesheet" type="text/css"/>
<link href="{cdn_url("/themes/assets/css/messenger/users.css")}?v={date("H:i")}" rel="stylesheet" type="text/css"/>
<link href="{cdn_url("/themes/assets/css/messenger/chat.css")}?v={time()}" rel="stylesheet" type="text/css"/>
<link href="{cdn_url("/themes/assets/css/posts.css")}?v=1" rel="stylesheet" type="text/css"/>
<link href="{cdn_url("/themes/assets/css/modals.css")}?v={date("H:i")}" rel="stylesheet" type="text/css"/>
<link href="{cdn_url("/themes/assets/css/forms.css")}?v={date("H:i")}" rel="stylesheet" type="text/css"/>
<!--<link href="{cdn_url("/themes/assets/css/texts.css")}?v=1" rel="stylesheet" type="text/css"/>//-->
<!--<link href="{cdn_url("/themes/assets/css/alerts.css")}?v=1" rel="stylesheet" type="text/css"/>//-->
<!--<link href="{cdn_url("/themes/assets/css/tables.css")}?v=1" rel="stylesheet" type="text/css"/>//-->
<!--<link href="{cdn_url("/themes/assets/css/cards.css")}?v=1" rel="stylesheet" type="text/css"/>//-->
<!--<link href="{cdn_url("/themes/assets/css/tabs.css")}?v=1" rel="stylesheet" type="text/css"/>//-->
<!--<link href="{cdn_url("/themes/assets/css/sidebar.css")}?v=1" rel="stylesheet" type="text/css"/>//-->
<!--<link href="{cdn_url("/themes/assets/css/masonry.css")}?v=1" rel="stylesheet" type="text/css"/>//-->
<link href="{cdn_url("/themes/assets/css/buttons.css")}?v={date("H:i")}" rel="stylesheet" type="text/css"/>
<link href="{base_url("/themes/assets/css/video.css")}?v={time()}" rel="stylesheet" type="text/css"/>
<link href="{base_url("/themes/assets/css/xetc.css")}?v={time()}" rel="stylesheet" type="text/css"/>
{* Dynamic *}
<link href="/styles/css/index" rel="stylesheet">

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        localStorage.setItem("token", "{csrf_token()}");
        localStorage.setItem("hash", "{csrf_hash()}");
    });
</script>