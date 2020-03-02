var headerh = $('header').height();
var $table = $('.fixedthead');
$table.floatThead({
    responsiveContainer: function($table){
        return $table.closest('.tablefixedheader');
    },
    top:headerh,
    zIndex:2
}); 