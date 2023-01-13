$(document).ready(function () {
    $("body").on("classChange", function () {
        if ($("body").hasClass("dark-mode")) {
            $("#theme-value").val("light");
            $("#theme-change-form").submit();
        } else {
            $("#theme-value").val("dark");
            $("#theme-change-form").submit();
        }
    });
});
