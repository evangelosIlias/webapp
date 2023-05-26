function clearCatTitle() {
    document.getElementById("cat_title").value = "";
    history.pushState(null, null, "admin_categories.php");
}

let div_box = "<div id='load-screen'><div id='loading'></div></div>";

$("body").prepend(div_box);
$("#load-screen").delay(700).fadeOut(600,  () => {
    $(this).remove();
});

