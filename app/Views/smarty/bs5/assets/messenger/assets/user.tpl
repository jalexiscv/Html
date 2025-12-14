{* Este diseño corresponde a la visualización de un solo usuario en el listados de usuarios  *}
<li class="feeds-item ">
    <a href="#" onclick="messenger_chat('{$csrf_token}','{$csrf_hash}','{$user['user']}','{$user['alias']}');">
        <div class="data-container clickable small js_chat-start"
             data-user="{$user['user']}"
             data-name="{$user['alias']}"
        >
            <div class="data-avatar"><img src="/themes/assets/images/avatar.jpg" alt="Katerine Arenas"></div>
            <div class="data-content">
                <div class="name">
                    {if isset($user['name'])}
                        <strong>{$user['name']}</strong>
                        <br>
                    {else}
                        <strong>Sin nombre</strong>
                        <br>
                    {/if}
                </div>
                <div class="moment">
                    Ultima vez visto hace 3 meses
                </div>
            </div>
        </div>
    </a>
</li>