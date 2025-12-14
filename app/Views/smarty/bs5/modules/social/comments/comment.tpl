<div class="card post mb-2">
    <div class="card-header">
        {lang("App.Comments")}
    </div>
    <div class="card-body p-2">
        <form action="/social/posts/view/{$pid}" class="" method="POST" accept-charset="utf-8">
            <input type="hidden" name="{csrf_token()}" value="{csrf_hash()}">
            <input type="hidden" name="action" value="comment-post">
            <div class=" p-2">
                <p>Esta publicación no posee opiniones, te invitamos a ser el primero en comentarla.</p>
                <div class="d-flex flex-row align-items-start">
                    <img class="rounded-circle" src="/themes/bs5/img/avatars/avatar-neutral.png" width="40">
                    <textarea id="content" name="content" class="form-control ml-1 shadow-none textarea"></textarea>
                </div>
                <div class="mt-2 text-right">
                    <input type="submit" class="btn btn-primary btn-sm shadow-none"
                           text="{lang("Social.Post-comment")}">
                </div>
            </div>
        </form>
    </div>
</div>