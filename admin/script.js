jQuery(document).ready(function () {
    /*
     jQuery(document).keypress(function(event) {
     if (event.keyCode==27) {
     alert(event.keyCode);
     event.preventDefault();
     }
     //alert(event.wich);
     });
     */
    //var windowWidth = screen.width - Math.round(screen.width / 8);
    //var windowHeight = screen.height - (Math.round(1.5 * screen.height / 10));

    jQuery('#editBlock').on('click', '#deleteProgram',
        function (event) {
            if (confirm('Удалить программу?')) {
                $('#formAction').val('delete');
                return true;
            }
            return false;
        }
    );
});