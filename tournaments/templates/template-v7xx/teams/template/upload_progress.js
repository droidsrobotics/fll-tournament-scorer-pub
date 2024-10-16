function upload_image() {
    //   var bar = $('#bar');
    var percent = $('#percent');
    $('#myForm').ajaxForm({
        beforeSubmit: function () {
            document.getElementById("progress_div").style.display = "block";
            var percentVal = '0%';
            // bar.width(percentVal)
            percent.html(percentVal);
        },

        uploadProgress: function (event, position, total, percentComplete) {
            var percentVal = percentComplete + '%';
            //   bar.width(percentVal)
            document.getElementById("bar").value = percentComplete;

            percent.html(percentVal);
            console.log("progress", position, total, percentComplete)
        },

        success: function () {
            var percentVal = '100%';
            document.getElementById("bar").value = 100;
            //   bar.width(percentVal)
            percent.html(percentVal);
            // if (confirm("Your file has been uploaded. Press OK to continue.")) window.location.reload();
        },

        complete: function (xhr) {
            if (xhr.responseText) {
                // document.getElementById("percent1").innerHTML = "Complete";
                // window.location.reload();
                document.getElementById("output_image").innerHTML = xhr.responseText.split("__ENDMSG__")[0];
                document.getElementById("curr_uploads").innerHTML = xhr.responseText.split("__ENDMSG__")[1];
            }
        }
    });
}