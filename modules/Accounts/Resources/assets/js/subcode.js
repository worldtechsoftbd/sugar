$(document).ready(function () {
    $(document).on("click", ".edit-SubCode", function () {
        var url = $(this).data("url");
        $.ajax({
            url: url,
            type: "GET",
            success: function (response) {
                $("#editSubCodeData").html(response);
                $("#edit-SubCode").modal("show");
            },
        });
        $(".select-basic-single").select2({
            width: "100%",
        });
    });
});
