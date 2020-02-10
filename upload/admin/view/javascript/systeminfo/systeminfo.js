// Sidenav Menu	
$('#et-sidenav ul').idTabs('systemInfo',function(id,list,set){
   $("a",set).removeClass("selected").filter("a[href='"+id+"']").addClass("selected");
   for(i in list)$(list[i]).hide();
   $(id).fadeIn();
   return false;
});

// Sidenav Menu on Hover
$('#et-sidenav li a').hover(
   function () {$(this).stop().animate({ paddingRight: '25px' }, 200);}, 
   function () {$(this).stop().animate({ paddingRight: '15px' });}
);