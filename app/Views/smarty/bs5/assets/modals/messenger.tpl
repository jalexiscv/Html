<!-- Full Height Modal Right -->
<div class="modal fade right " id="modal-messenger-chat" tabindex="-1" role="dialog"
     aria-labelledby="modal-messenger-chat"
     aria-hidden="true">
    <div class="modal-dialog modal-full-height modal-right modal-dialog-scrollable " role="document">
        <!--Content-->
        <div class="modal-content">
            <!--Header-->
            <div class="modal-header ">
                <h5 class="modal-title " id="modal-messenger-chat-title">user</h5>
                <button type="button" onclick="messenger_modal_close();" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <!--Body-->
            <div id="messenger-conversation" class="modal-body ">

            </div>
            <!--Footer-->
            <div class="card-footer text-muted d-flex justify-content-start align-items-center p-3 ">
                <img src="{safe_get_user_avatar()}" alt="avatar 3" class="avatar">
                <input type="text" class="form-control form-control-lg form-control-message" id="mensseger_message"
                       placeholder="Mensaje">
                <a class="ms-1 text-muted" href="#!"><i class="fas fa-paperclip"></i></a>
                <a class="ms-3 text-muted" href="#!"><i class="fas fa-smile"></i></a>
                <a id="btn-mensseger-message-sender" class="ms-3" href="#!" onclick="mensseger_message_send(this);"><i
                            class="fas fa-paper-plane"></i></a>
            </div>
        </div>
        <!--/.Content-->
    </div>
</div>
<!-- Full Height Modal Right -->