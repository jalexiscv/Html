<div id="{$id}" class="modal">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="conversation"
                 class="modal-body"
                 data-to="{$to}"
                 style="background-color:#111b21;background-image: url('/themes/assets/images/backgrounds/whatsaap.png');scrollbar-color: rgba(var(--white-rgb),.16) transparent;background-repeat: repeat;">

            </div>
            <div class="modal-footer">
                <div class="input-group">

                    <button id="conversation_file_sender" class="btn btn-primary" data-to="{$to}"
                            onclick="conversation_file_active(this);">
                        <i class="fa-regular fa-paperclip"></i>
                    </button>
                    <input id="conversation_message" type="text" class="form-control" placeholder="Mensaje"/>
                    <button id="conversation_sender" class="btn btn-primary" data-to="{$to}"
                            onclick="conversation_message_send(this);">
                        <i class="fas fa-paper-plane"></i>
                    </button>

                    <button
                            id="conversation_audio_record"
                            class="btn btn-secondary"
                            data-to="{$to}"
                            onclick="conversation_audio_send(this);">
                        <i class="fa-solid fa-microphone"></i>
                    </button>
                    <button
                            id="conversation_audio_stop"
                            class="btn btn-secondary d-none"
                            data-to="{$to}"
                            onclick="conversation_audio_stop(this);">
                        <i class="fa-regular fa-circle-stop"></i>
                    </button>

                    <input type="file" id="file-input" style="display:none;" multiple="false"
                           onchange="conversation_file_send(this)">
                </div>
            </div>
        </div>
    </div>
</div>
