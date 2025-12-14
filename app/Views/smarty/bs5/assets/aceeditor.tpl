{* [aceeEditor] *}
{if isset($plugin_ace)}
    {if $plugin_ace===true}
        <script type="text/javascript" src="{base_url("themes/assets/libraries/ace/src-noconflict/ace.js")}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const codeElements = document.querySelectorAll('.code');
                codeElements.forEach((element) => {
                    const editor = ace.edit(element);
                    editor.setTheme("ace/theme/tomorrow");
                    editor.getSession().setMode("ace/mode/php");
                    editor.setOption("minLines", 5);
                    editor.setOption("maxLines", 1000);
                });

                const codeSshElements = document.querySelectorAll('.code-ssh');
                codeSshElements.forEach((element) => {
                    const acephp = ace.edit(element);
                    acephp.setTheme("ace/theme/tomorrow");
                    acephp.getSession().setMode("ace/mode/sh");
                    acephp.setOption("minLines", 5);
                    acephp.setOption("maxLines", 1000);
                });

                const codePhpElements = document.querySelectorAll('.code-php');
                codePhpElements.forEach((element) => {
                    const acephp = ace.edit(element);
                    acephp.setTheme("ace/theme/tomorrow");
                    acephp.session.setUseWrapMode(true);
                    acephp.getSession().setMode("ace/mode/php");
                    acephp.setOption("minLines", 5);
                    acephp.setOption("maxLines", 1000);
                });

                const codeSQLElements = document.querySelectorAll('.code-sql');
                codeSQLElements.forEach((element) => {
                    const acephp = ace.edit(element);
                    acephp.setTheme("ace/theme/tomorrow");
                    acephp.session.setUseWrapMode(true);
                    acephp.getSession().setMode("ace/mode/sql");
                    acephp.setOption("minLines", 5);
                    acephp.setOption("maxLines", 1000);
                });

                const codeHtmlElements = document.querySelectorAll('.code-html');
                codeHtmlElements.forEach((element) => {
                    const acehtml = ace.edit(element);
                    acehtml.setTheme("ace/theme/tomorrow");
                    acehtml.getSession().setMode("ace/mode/html");
                    acehtml.setOption("minLines", 5);
                    acehtml.setOption("maxLines", 1000);
                });

                const codeCssElements = document.querySelectorAll('.code-css');
                codeCssElements.forEach((element) => {
                    const acecss = ace.edit(element);
                    acecss.setTheme("ace/theme/tomorrow");
                    acecss.getSession().setMode("ace/mode/css");
                    acecss.setOption("minLines", 5);
                    acecss.setOption("maxLines", 1000);
                });
                const codeJsElements = document.querySelectorAll('.code-js');
                codeJsElements.forEach((element) => {
                    const acejs = ace.edit(element);
                    acejs.setTheme("ace/theme/tomorrow");
                    acejs.getSession().setMode("ace/mode/js");
                    acejs.setOption("minLines", 5);
                    acejs.setOption("maxLines", 1000);
                });
            });
        </script>
    {/if}
{/if}
{* [/aceeEditor] *}