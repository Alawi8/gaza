document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('insert-snippet').addEventListener('click', function() {
        var snippet = document.getElementById('html-snippets').value;
        if (snippet) {
            tinymce.get('code_editor').execCommand('mceInsertContent', false, snippet);
        }
    });
});
