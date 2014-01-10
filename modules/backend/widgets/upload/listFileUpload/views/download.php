<!-- The template to display files available for download -->
<script id="<?php echo $this->downloadTemplate; ?>" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}

    <tr class="template-download fade">
        {% if (file.error) { %}
            <td></td>
            <td class="name"><span>{%=file.name%}</span></td>
            <td class="size"><span>{%=(file.readebleFileSize ? file.readebleFileSize : o.formatFileSize(file.size))%}</span></td>
            <td class="error" colspan="2"><span class="label label-danger">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
        {% } else { %}
            <td class="preview">{% if (file.thumbnail_url) { %}
                <a href="{%=file.url%}" title="{%=file.name%}" rel="gallery" download="{%=file.name%}"><img src="{%=file.thumbnail_url%}"></a>
            {% } %}</td>
            <td class="name">
                <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}">{%=file.name%}</a>
            </td>
            <td class="size"><span>{%=(file.readebleFileSize ? file.readebleFileSize : o.formatFileSize(file.size))%}</span></td>
            <td colspan="2"></td>
        {% } %}
        <td>
            <button type="button" class="btn btn-danger delete" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}" data-fileid="{%=file.fileId?file.fileId:''%}">
                <i class="glyphicon glyphicon-trash icon-white"></i>
                <span>{%=locale.fileupload.destroy%}</span>
            </button>
            <input type="hidden" name="delete" value="1">
        </td>
    </tr>
{% } %}
</script>
