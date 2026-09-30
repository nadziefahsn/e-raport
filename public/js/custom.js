$(document).ready(function() {
    $('.nav-treeview .has-treeview > a').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        var $parent = $(this).parent();
        $parent.toggleClass('menu-open');
        $parent.children('.nav-treeview').slideToggle();
    });
});