{*
    | Este archivo corresponde a lo implementado conforme al cliente que se encuentre activo
    | Color por defecto de la App, sistemas de publicidad, parametros de redes sociales segun el cliente
    | y similares.
*}

{if isset($theme_color)}
    <style>
        {$theme_color}
        }
    </style>
{/if}


{if isset($ads)}

{/if}


{if isset($ads)}
    {if $ads===true}
<script data-ad-client="ca-pub-1567513595638732" async
        src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js">
    {/if}
    {/if}

    {if isset($schema)}
    {$schema}
{/if}