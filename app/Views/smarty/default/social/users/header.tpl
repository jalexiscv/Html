<style>
    .profile-cover {
        background-image: url(https://bootdey.com/img/Content/bg1.jpg);
    }


    .author-info-img {
    {if !empty($author_photo)} background-image: url('{$author_photo}');
    {else} background-image: url('/themes/assets/images/avatar.jpg');
    {/if}
    }


    .profile-display {
        width: 100%;
        position: relative;
        box-shadow: 0 1px 12px rgba(0, 0, 0, 0.1);
        height: 340px;
        background-color: #fff;
        border-radius: 0.25rem;
        overflow: hidden;
    }


    .profile-cover {
        height: 210px;
        position: absolute;
        top: 0px;
        right: 0px;
        left: 0px;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
        background-position: center center;
    }

    .author-info {
        background-color: #f5f5f5;
        padding: 10px;
        position: absolute;
        top: 40px;
        left: 15px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        width: 240px;
    }

    .author-info .author-info-img {
        width: 100%;
        height: 220px;
        width: 220px;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
        background-position: center center;
        margin-bottom: 3px;
        position: relative;
    }

    .author-meta {
        display: inline-block;
        vertical-align: bottom;
    }

    .author-username {
        font-size: 26px;
        margin: 5px 0 0 0;
    }
</style>
<div class="row mb-2 rounded-2">
    <div class="col-md-12">
        <div class="profile-display">
            <div class="profile-cover"></div>
            <div class="author-info">
                <div class="author-info-img">

                </div>
                <div class="author-meta">
                    <h2 class="author-username">@{$alias}</h2>
                </div>
            </div>
        </div>
    </div>
</div>