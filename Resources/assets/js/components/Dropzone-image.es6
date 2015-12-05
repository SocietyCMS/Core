export default {

    template: require('./Dropzone-image.html'),

    props: ['url', 'init', 'destroy'],

    ready() {
        var vueInstance = this;

        Dropzone.options.societyDropzoneimage = {

            url: this.url,
            paramName: "file",
            maxFilesize: 10,
            maxFiles: 5,
            thumbnailWidth: null,
            thumbnailHeight: 163,
            parallelUploads: 5,
            addRemoveLinks: true,

            acceptedFiles: 'image/*',

            dictMaxFilesExceeded: "You can only upload upto 5 images",
            dictRemoveFile: 'Delete',
            dictCancelUploadConfirmation: "Are you sure to cancel upload?",

            init: function (){
                var thisDropzone = this;
                $.getJSON(vueInstance.init, function(data) {

                    $.each(data.data, function(index, val) {
                        var mockFile = { id: val.id, name: val.name, size: val.size, thumbnail: val.thumbnail};
                        thisDropzone.emit("addedfile", mockFile);
                        thisDropzone.emit("thumbnail", mockFile, mockFile.thumbnail.medium);
                        thisDropzone.emit("complete", mockFile);

                        thisDropzone.options.maxFiles = thisDropzone.options.maxFiles - 1;
                    });
                });
            },
            removedfile: function(file) {
                $.ajax({
                    type: 'DELETE',
                    url:(vueInstance.destroy).toString().replace("%5B%241%5D", file.id),
                    dataType: 'json'
                });

                var _ref;

                return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;

            }
        };
    }

}